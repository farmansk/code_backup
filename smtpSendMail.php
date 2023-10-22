<?php
/* 
=================================================================================
 + 안내 : 이 파일은 아래의 웹싸이트 자료를 참고로 수정하였음을 알려드립니다.
 + 출처 : http://redqueen-textcube.blogspot.kr/2011/07/php-class.html
 + 제작자 : 하근호(hopegiver@korea.com)
=================================================================================
 + 파일명 : sendmail.php 
 + 수정일 : 2015-06-04/2015-06-04(최종수정일)
 + 수정자 : Redinfo (webmaster@redinfo.co.kr)
 + 기타   : (가이드 URL) https://b.redinfo.co.kr/87
            (싸이트 URL) https://b.redinfo.co.kr
=================================================================================
 + 파일명 : smtpSendMail.php
 + 버전: 1.0
 + 수정일 : 2022-02-06, 2022-03-09(최종수정일)
 + 수정자 : R BLOG (lcy@redinfo.co.kr)
 + 기타   : (가이드 URL) https://blog.redinfo.co.kr/post/view?pid=74
            (블로그 URL) https://blog.redinfo.co.kr
=================================================================================
*/
class smtpSendMail{

    // SMTP 기본설정
    var $config = array(

        /*필수*/
        'host'=>'',  // SMTP 호스트
        'port'=>25, // SMTP 포트
        'smtp_id'=>'', // SMTP ID
        'smtp_pw'=>'', // SMTP PW
        'debug'=>0, // 디버그 , 0: 미사용, 1: 사용
        'msg'=>0, // 메시징뷰 , 0: 미사용, 1: 사용
        'charset'=>'UTF-8', // SMTP 언어셋
        'ctype'=>'text/html', // SMTP 내용 컨텐츠타입
    );


    /* 아래 3개의 변수는 수정 금지 */
    var $fp;
    var $connection = false;
    var $msg , $parts = array(); // 메시지, 첨부파일 스택 배열
    var $error = array(
        'code' => 0,
        'msg' => NULL,
    );

    function __construct($config = array()){
        global $RI;
        foreach($this->config as $k=>$v){
            // 필수값 체크 - 선택입력 제외
            if( empty($this->config) && empty($config[$k])  ){
                return $this->debug(__LINE__*-1,"`".$k."` 설정값이 누락되었습니다.");
            }else{
                if( !empty($config[$k])){$this->config[$k] =  $config[$k]; }
            }        
        }

        // 메시지
        $this->msg('설정로드 완료!');

    }
    function __destruct(){ $this->connection = false;}

    /* 연결 */
    function connect(){

        $host = $this->config['host'];
        if( empty($host) ){ return $this->debug(__LINE__*-1," `host`가 누락되었습니다.");  }
        $port = $this->config['port'];
        if( empty($port) ){ return $this->debug(__LINE__*-1," `port`가 누락되었습니다.");  }        

        // [2022-03-09] 465: host 보정
        if( $port == '465' && !preg_match("/^ssl:\/\//",$host)){ $host = "ssl://".$host;}  

        $this->msg("SMTP(".$host.") Connecting...");

        if(!$this->fp = fsockopen($host, $port, $errno, $errstr, 10)) {
            return $this->debug(__LINE__*-1,"SMTP(".$host.":".$port.") 서버접속에 실패했습니다.[".$errno.":".$errstr."]");
        }

        $line = fgets($this->fp, 128);
        $this->msg($line);

        preg_match("/^([0-9]+).(.*)$/", $line, $matches);
        if( empty($matches[1]) || $matches[1] != '220'){ return $this->debug(__LINE__*-1,"커낵션 에러"); }
        return true;
    }

    /* 종료 */
    function close() {
        $this->dialogue(221, "QUIT");
        fclose($this->fp);
        return true;
    }

    /* 메시지 기록 */
    function msg($msg){
        if( empty($msg)){ return false; }
        $msg =  '['.date('Y-m-d H:i:s').'] '.$msg;
        $this->msg[] = $msg;
        if( $this->config['msg'] === 1){ echo '<hr>'.$msg.'</hr>'; flush();}
    }

    /* 디버깅 */
    function debug($code,$msg,$return = false){
        if( empty($code) || empty($msg)){ return $return; }
        if( !empty($code)) { $this->error['code'] = $code; }
        if( !empty($msg)) { $this->error['msg'] = $msg; }
        if($this->config['debug'] === 1){
           $this->support('preview',$this->error);
           flush();
        }
        return $return;
    }

    /*서버와 통신*/
    function dialogue($code = 0 ,$cmd = ''){
        if( empty($code) || empty($cmd) ){ return false; }

        fputs($this->fp, $cmd."\r\n");

        // [2022-03-09] 465: host 보정
        stream_set_timeout($this->fp,1);
        $line = stream_get_contents($this->fp);
        if( empty($line)){  return $this->debug(__LINE__*-1,"`".$cmd."` 에러(응답실패) "); }
        $arr_line = explode("\n",$line);
        $arr_line = array_filter($arr_line);
        $last_line =end($arr_line);
        $this->msg($last_line);
        
        preg_match("/^([0-9]+).(.*)$/", $last_line, $matches);
        if(empty($matches[1]) || $matches[1] != $code) return $this->debug(__LINE__*-1,"`".$cmd."` 에러(".$last_line.")");;
        return true;
    }

    /* 첨부파일이 있을 경우 이 함수를 이용해 파일을 첨부한다. */
    function attach($path, $name="", $ctype="application/octet-stream") {
        if(is_file($path)) {
            $fp = fopen($path, "r");
            $message = fread($fp, filesize($path));
            fclose($fp);
            $this->parts[] = array ("ctype" => $ctype, "message" => $message, "name" => $name);
        } else return false;
    }

     /*  Multipart 메시지를 생성시킨다. */
    function build_message($part = array()) {

        $part = array_filter($part);
        if( empty($part) || !is_array($part) || count($part)< 1){ return false; }

        $msg = "Content-Type: ".$part['ctype'];
        if(!empty($part['name'])) $msg .= "; name=\"".$part['name']."\"";
        $msg .= "\r\nContent-Transfer-Encoding: base64\r\n";
        $msg .= "Content-Disposition: attachment; filename=\"".$part['name']."\"\r\n\r\n";
        $msg .= chunk_split(base64_encode($part['message']));
        return $msg;
    }
    
    /*메일 body 빌드*/
    function build_data($subject, $body){
        if( empty($subject) || empty($body)){ return $this->debug(__LINE__*-1,"`build` 데이터 생성 실패");  }

        $boundary = $this->support('boundary');
        $ctype = $this->config['ctype'];  // 컨텐츠 타입
        $charset = $this->config['charset']; // 언어셋
        $parts = $this->parts; // 첨부파일

        $attcnt = sizeof($parts);

        $subject = '=?'.$charset.'?B?'.base64_encode($subject).'?=';
        $mime = "Subject: ".$subject."\r\n";
        $mime .= "Date: ".date ("D, j M Y H:i:s T",time())."\r\n";
        $mime .= "MIME-Version: 1.0\r\n";
        if($attcnt > 0) {
            $mime .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n\r\n".
                "This is a multi-part message in MIME format.\r\n\r\n";
            $mime .= "--".$boundary."\r\n";
        }
        $mime .= "Content-Type: ".$ctype."; charset=\"".$charset."\"\r\n".
            "Content-Transfer-Encoding: base64\r\n\r\n" . chunk_split(base64_encode($body));
        
        // 첨부파일이 있을 경우에만 생성
        if($attcnt > 0) {
            $mime .= "\r\n\r\n--".$boundary;
            for($i=0; $i<$attcnt; $i++) {
                $mime .= "\r\n".$this->build_message($parts[$i])."\r\n\r\n--".$boundary;
            }
            $mime .= "--\r\n";
        }

        return $mime;
    }


    /* 
        send_mail : 메일보내기 
        $parmData
            =>  $to, $from, $name , $subject, $body,$cc=false,$bcc=false
    */
    function send_mail($parmData = array()) {
        $parmData = array_filter($parmData);
        extract($parmData);

        if( empty($to)){ return $this->debug(__LINE__*-1,"`to` 데이터가 누락되었습니다.");  }
        if( empty($from)){ return $this->debug(__LINE__*-1,"`from` 데이터가 누락되었습니다.");  }
        if( empty($name)){ return $this->debug(__LINE__*-1,"`from` 데이터가 누락되었습니다.");  }
        if( empty($subject)){ return $this->debug(__LINE__*-1,"`subject` 데이터가 누락되었습니다.");  }
        if( empty($body)){ return $this->debug(__LINE__*-1,"`body` 데이터가 누락되었습니다.");  }

        if( empty($cc)){ $cc = ''; }
        if( empty($bcc)){ $bcc = ''; }

        if(!is_array($to)){
            $rel_to=$to;
            $to = explode(",",$to); 
        }
        else{   
            $rel_to=implode(',',$to);
        }

        // 메일 MIME 데이터를 만든다. 
        $data = $this->build_data($subject, $body);
        if( $data === false){ return false; }

        // 메일을 보낸다 
        foreach($to as $key=>$email){
            if( empty($email)){ continue; }
            if( $this->connect() === true){
                $send_result = $this->smtp_send($email, $from,$name, $data,$cc,$bcc,$rel_to);
                if( $send_result === true){
                    $this->msg("메일발송 성공(to: ".$email.")");
                }else{
                    $this->msg("메일발송 실패(to: ".$email.")");
                }
            }
            $this->close();
        }

        // 참조메일을 보낸다.
        if(!empty($cc)){
           $cc_data = $this->build_data($subject, $body);
           $this->cc_email($rel_to,$from,$name,$cc_data,$cc,$bcc);    
        }    

        // 숨은 참조메일을 보낸다.
        if(!empty($bcc)){
            $bcc_data = $this->build_data('BCC: '.$subject, $body);  
           $this->bcc_email($rel_to,$from,$name,$bcc_data,$cc,$bcc);    
        }               
    }

    /* smtp_send */
    function smtp_send($email, $from,$name, $data,$cc,$bcc,$rel_to = false){

        /*smtp 설정*/
        $smtp_id = $this->config['smtp_id']; // SMTP 아이디
        $smtp_pw = $this->config['smtp_pw']; // SMTP 비밀번호
        $charset = $this->config['charset']; // 언어셋 
        $port = $this->config['port']; // [2022-07-04] 587: 포트 지원추가

        /*데이터 검사*/
        if( empty($data) ){ return $this->debug(__LINE__*-1,"`메일 데이터` 누락");  }

        /* 이메일 형식 검사 구간*/
        if( $this->support('emailChk',$from) !== true){ return $this->debug(__LINE__*-1,"`from` 이메일 형식 오류"); }
        if( $this->support('emailChk',$email) !== true){ return $this->debug(__LINE__*-1,"`to` 이메일 형식 오류"); }
        if( empty($name) ){ return $this->debug(__LINE__*-1,"`name` 항목 누락 "); }
        $name = '=?'.$charset.'?B?'.base64_encode($name).'?=';
        

        // [2022-07-04] 587: 포트 지원추가 
        if( $port == 587){
            if(!$this->dialogue(220, "STARTTLS")) { return false; }
            if(false == stream_socket_enable_crypto($this->fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)){
               return $this->debug(__LINE__*-1,"`TLS` 지원불가능");
            }       
        }

        /* smtp  검사 구간 */
        if(!$this->dialogue(250, "EHLO phpmail")) { return false; } // [2022-07-04] 특정 SMTP 서버 서포트
        if(!$this->dialogue(334, "AUTH LOGIN")) { return false; }
        if(!$this->dialogue(334, base64_encode($smtp_id)))  return false;
        if(!$this->dialogue(235, base64_encode($smtp_pw)))  return false;
        if(!$this->dialogue(250, "MAIL FROM:<".$from.">")) return false;
        if(!$this->dialogue(250, "RCPT TO:<".$email.">")) {
            $this->dialogue(250, "RCPT TO:");
            $this->dialogue(354, "DATA");  
            $this->dialogue(250, ".");
            return false;
        }

        // 반송 이메일 없을 경우
        if($rel_to==false){ $rel_to=$email;}
        
        $this->dialogue(354, "DATA");
        $mime = "Message-ID: <".$this->support('get_msgid').">\r\n";
        $mime .= "From: ".(empty($name) ? null : $name)."<".$from.">\r\n";
        $mime .= "To: <".$rel_to.">\r\n";
        
        /* CC 메일 이 있을경우 */
        if(!empty($cc) && $this->support('emailChk',$cc) === true ){
            $mime .= "Cc: <".$cc. ">\r\n";
            $this->msg("참조 메일 등록 (to: ".$cc.")");
        }

        /* BCC 메일 이 있을경우 */
        if(!empty($bcc) && $this->support('emailChk',$bcc) === true ){ 
            $mime .= "Bcc: <".$bcc. ">\r\n";
            $this->msg("숨은참조 메일 등록 (to: ".$bcc.")");
        }

        fputs($this->fp, $mime);
        fputs($this->fp, $data);
        if(!$this->dialogue(250, ".")){
            return false;
        }


        return true;      
    }

    function cc_email($rel_to,$from,$name,$data,$cc,$bcc){

        if(!is_array($cc)) $cc_list = explode(",",$cc);
        foreach($cc_list as $email){     
            if( empty($email)){ continue; }
            if( $this->connect() === true){
                $send_result = $this->smtp_send($email, $from,$name, $data,$cc,$bcc,$rel_to);
                if( $send_result === true){
                    $this->msg("참조 메일발송 성공(to: ".$email.")");
                }else{
                    $this->msg("참조 메일발송 실패(to: ".$email.")");
                }
            }
            $this->close();
        }
    }
    function bcc_email($rel_to,$from,$name,$data,$cc,$bcc){
        if(!is_array($bcc)) $bcc_list = explode(",",$bcc);
        foreach($bcc_list as $email){        
            if( empty($email)){ continue; }
            if( $this->connect() === true){
                $send_result = $this->smtp_send($email, $from,$name, $data,$cc,$bcc,$rel_to);
                if( $send_result === true){
                    $this->msg("숨은참조 메일발송 성공(to: ".$email.")");
                }else{
                    $this->msg("숨은참조 메일발송 실패(to: ".$email.")");
                }
            }
            $this->close();
        }
    }
    /* 서포트 지원 함수 */
    function support(){

        $args = func_get_args();
        if( count($args ) > 0){
            $method = $args[0];
            unset($args[0]);
            $args = array_values($args);
            if(!empty($method)) $method = strtolower($method);
            else{ $method = null; }
        }else{ $args  = array(); }
        if( $method === null ){ return false;}

        switch($method){
            // 필수 함수 
            case strtolower("parm"):
                if( count($args[1]) < 1){ return false; }
                $parmSet = array(); $idx = 0;
                foreach($args[1] as $key => $val){ 
                    if( !empty($args[0][$idx])) $parmSet[$key] = $args[0][$idx]; 
                    else $parmSet[$key] = $args[1][$key];
                    $idx++;
                }           
                return $parmSet;
            break;

            // array 뷰
            case strtolower('preview'):
                $parmSet = $this->support('parm',$args,array('data'=>false));
                extract($parmSet);            

                ob_start();
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                $preview= ob_get_clean();
                preg_match_all("/`(.*?)`/is",$preview,$matches);
                if( !empty($matches[1]) && is_array($matches[1]) && count($matches[1]) > 0){
                    foreach($matches[1] as $k=>$v){
                        if( empty($v)) continue;
                        $preview = str_replace($v,'<strong style="color:red">'.$v.'</strong>',$preview);
                        $preview = str_replace(array('<strong style="color:red"><strong style="color:red">','</strong></strong>'),array('<strong style="color:red">','</strong>'),$preview);
                    }
                }
                echo $preview;
            break;

            case strtolower('emailChk'):
                $parmSet = $this->support('parm',$args,array('email'=>false));
                extract($parmSet);     

                if( empty($email)){ return false; }
                if(!preg_match("/([\._0-9a-zA-Z-]+)@([0-9a-zA-Z-]+\.[a-zA-Z\.]+)/", $email, $matches)) return false;

                return true;                
            break;


            case strtolower('get_msgid'):
                $id = date("YmdHis",time());
                mt_srand((float) microtime() * 1000000);
                $randval = mt_rand();
                $id .= $randval."@phpmail";
                return $id;
            break;

            case strtolower('boundary'):
                $uniqchr = uniqid(time());
                $one = strtoupper($uniqchr[0]);
                $two = strtoupper(substr($uniqchr,0,8));
                $three = strtoupper(substr(strrev($uniqchr),0,8));
                return "----=_NextPart_000_000${one}_${two}.${three}";
            break;

        }
    } 
}
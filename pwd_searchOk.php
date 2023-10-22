<?php

 session_start();

 include "config.php";
 include "function.php";
 
 $libLoad = $_SERVER['DOCUMENT_ROOT']."/smtpSendMail.php";
 
 include_once $libLoad ;
  
    
 $settingquery = mysqli_query($link, "SELECT * FROM `setting`");
 $res=$settingquery->fetch_assoc();
    
 $CompanyName = htmlspecialchars($res["CompanyName"]); // 회사명
 $Copyright  = htmlspecialchars($res["Copyright"]);  
 

 $to_name = mysqli_real_escape_string($link, $_POST['UserEmail'] ) ;
 $to = mysqli_real_escape_string($link, $_POST['UserEmail'] ) ;



 $from = htmlspecialchars($res["email_id"]).'@naver.com'; //# 보내는 자




    
 $query = mysqli_query($link, "Select UserPwd from users Where UserEmail = '".base64_encode($to)."'" );
 $count = mysqli_num_rows($query);

 if ( $count == 0 ) {
  
  exit ;
  
 }
 else {
   
  $pwd = AuthWord() ;
   
 }
 

 
 $link->begin_transaction();

 try {
 
  $SQL = "UPDATE users set " ;
  $SQL = $SQL . " UserPwd = '".base64_encode($pwd)."'  " ;
  $SQL = $SQL . " WHERE UserEmail = '".base64_encode($to)."'" ;
  $data = mysqli_query($link, $SQL);

  
  $link->commit();

 } catch (mysqli_sql_exception $exception) {
 
  $link->rollback();

 }





date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");


 
$ip = $_SERVER["REMOTE_ADDR"] ;
 




										

        
    $subject = "[".$CompanyName."] 요청하신 임시 비밀번호를 알려드립니다." ;
     

    $htmlstr = "<!doctype html><html><!DOCTYPE html>";
    $htmlstr = $htmlstr . "<head>";
    $htmlstr = $htmlstr . "<title>".$CompanyName."</title>";
    $htmlstr = $htmlstr ."<style>";
    $htmlstr = $htmlstr . "p.tt { line-height:130%; margin-top:0pt; margin-bottom:0pt; }";
    $htmlstr = $htmlstr . "</style>";
    $htmlstr = $htmlstr . "</head>";
    $htmlstr = $htmlstr . "<body>";
 
    $htmlstr = $htmlstr . "<table style='margin: 0 auto; padding: 0px; width:100%;' cellspacing='0' cellpadding='0'>";

    $htmlstr = $htmlstr . "<tr>";
    $htmlstr = $htmlstr . "<th  colspan='2' style='background:#231815;color:#FFFFFF;padding:30px;text-align:center'>";
    $htmlstr = $htmlstr . $subject ;
    $htmlstr = $htmlstr . "</th>";
    $htmlstr = $htmlstr . "</tr>";

    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th style='width:20%;background:#EEEEEE;color:#262626;padding:15px;text-align:center;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . "이메일주소" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $to ;
    $htmlstr = $htmlstr . "</td>" ;
    $htmlstr = $htmlstr . "</tr>" ;



    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th style='width:20%;background:#EEEEEE;color:#262626;padding:15px;text-align:center;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . "임시 비밀번호" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $pwd ;
    $htmlstr = $htmlstr . "</td>" ;
    $htmlstr = $htmlstr . "</tr>" ;

    
    $htmlstr = $htmlstr . "<table style='padding: 0px; width:100%;' cellspacing='0' cellpadding='0'>" ;
    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th  colspan='2' style='background:#E5E5E5;color:#262626;padding:30px;text-align:center;font-size:10pt'>" ;
    $htmlstr = $htmlstr . $Copyright ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "</tr>" ;
    $htmlstr = $htmlstr . "</table>" ;

    $htmlstr = $htmlstr . "</body>" ;
    $htmlstr = $htmlstr . "</html>"	 ;

 
    $message = $htmlstr ;
    
    
    
    
    
    // 네이버 일경우 
    $config = array(
        'host'=>'smtp.gmail.com', // SMTP 호스트 주소 (465포트는 SSL보안서버 적용으로 -> 본래는 이렇게 해주어야함 ssl://smtp.gmail.com)
        'smtp_id'=>$res["email_id"], //SMTP 아이디
        'smtp_pw'=>base64_decode($res["email_pw"]), //SMTP 비밀번호
        'port'=>'465', //SMTP 포트
        'debug'=>0, // 디버그 , 0: 미사용, 1: 사용
        'msg'=>0, // 메시징뷰 , 0: 미사용, 1: 사용
        'charset'=>'UTF-8', // SMTP 언어셋
        'ctype'=>'text/html' // SMTP 내용 컨텐츠타입        
    );


    // 메일 라이브러리 초기화
    $ssm = new smtpSendMail($config);
    

    // 메일 발송데이터
    $parmData = array(
        'to'=>$to,
        'from'=>$from,
        'name'=>$CompanyName,
        'subject'=>$subject,
        'body'=>$message,
        'cc'=>'',
        'bcc'=>''
    );

    // 파일첨부 
    //$ssm->attach($_SERVER['DOCUMENT_ROOT']."/파일1.zip","파일1.zip"); 
    //$ssm->attach($_SERVER['DOCUMENT_ROOT']."/파일2.zip","파일2.zip");

    $ssm->send_mail($parmData);
    
    echo "succ" ;
    exit ;
?>
<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";




$libLoad = $_SERVER['DOCUMENT_ROOT']."/smtpSendMail.php";
 
include_once $libLoad ;
  
$settingquery = mysqli_query($link, "SELECT * FROM `setting`");
$res=$settingquery->fetch_assoc();
    
$CompanyName = htmlspecialchars($res["CompanyName"]); // 회사명
$Copyright  = htmlspecialchars($res["Copyright"]);  
$from = htmlspecialchars($res["email_id"]).'@naver.com'; //# 보내는 자






$amount = mysqli_real_escape_string($link, $_POST['token']);

$seqno = mysqli_real_escape_string($link, $_POST['seqno']);

$token_memo = mysqli_real_escape_string($link, $_POST['token_memo']);


// 나의 BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where seqno = '".$seqno."' " );
$rs=$query->fetch_assoc();

$prev_amount = $rs["bnb"] ; 
$UserEmail = $rs["UserEmail"] ;
$to = base64_decode($rs["UserEmail"]) ;
$to_address = base64_decode($rs["deposit_address"]) ;

// 나의 BNB 잔액 확인 끝

if ( $prev_amount == 0 ) {
 
 echo "succ" ;
 exit ;
  
}  

if ( $prev_amount - $amount < 0 ) {
  
 $next_amount = 0 ;
 
}
else {  
     
 $next_amount = $prev_amount - $amount ; // BNB 이후금액
 
} 




date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 




 
 
 
$link->begin_transaction();

try {
  
  
  
 
 // 받는 자 BNB 입금 기록 시작
 
 $hash = "" ;
 $TransactionFee = "0" ;
 $gasPrice = "0" ;
 $deposit_hash = "";
 
 $SQL = "INSERT INTO token_transaction_history " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " target , " ;
 $SQL = $SQL . " gubn , " ;
 $SQL = $SQL . " UserEmail , " ;
 $SQL = $SQL . " amount ,  " ;
 $SQL = $SQL . " chainId , " ;
 $SQL = $SQL . " from_address ,  " ;
 $SQL = $SQL . " to_address , " ;
 $SQL = $SQL . " hash , " ;
 $SQL = $SQL . " TransactionFee ,  " ;
 $SQL = $SQL . " gasPrice , " ;
 $SQL = $SQL . " prev_amount ,  " ;
 $SQL = $SQL . " next_amount , " ;
 $SQL = $SQL . " ExpectationTransactionFee ,  " ;
 $SQL = $SQL . " deposit_hash ,  " ;
 $SQL = $SQL . " memo ,  " ;
 $SQL = $SQL . " admin_memo ,  " ;
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " admin_deposit ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " 'BNB' ,  " ;
 $SQL = $SQL . " '출금' ,  " ;
 $SQL = $SQL . " '".$UserEmail."' ,  " ;
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$chainId."' , " ;
 $SQL = $SQL . " '".$manager_address."' ,  " ;
 $SQL = $SQL . " '".$to_address."' , " ;
 $SQL = $SQL . " '".$hash."' , " ;
 $SQL = $SQL . " '".$TransactionFee."' ,  " ;
 $SQL = $SQL . " '".$gasPrice."' , " ;
 $SQL = $SQL . " '".$prev_amount."' ,  " ;
 $SQL = $SQL . " '".$next_amount."' , " ;
 $SQL = $SQL . " '0' ,  " ;
 $SQL = $SQL . " '".$deposit_hash."' ,  " ;
 $SQL = $SQL . " '내부전송' ,  " ;
 $SQL = $SQL . " '".$token_memo."' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " 'Y' ,  " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // 받는 자 BNB 입금 기록 시작
 
 

   
   
   
 // BNB 잔액 업데이트 끝
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " bnb = '".$next_amount."' " ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."' " ;
 $data = mysqli_query($link, $SQL);

 // BNB 잔액 업데이트 끝
 

 echo "succ" ;

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
  exit ;
  
}







if ( $data ) {

    $subject = "[".$CompanyName."] 관리자가 ". $chainSymbol . " 코인을 회수하였습니다." ;
     

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
    $htmlstr = $htmlstr . "금액" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $amount . $chainSymbol;
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


    $ssm->send_mail($parmData);
    
    
    
}  



DB_BACKUP();






?>

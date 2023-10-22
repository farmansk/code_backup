<?php

session_start();

if ( $_SESSION['AdminEmail'] == "" ) {
  
 exit ;
   
}
  
include "config.php";
include "function.php";



$libLoad = $_SERVER['DOCUMENT_ROOT']."/smtpSendMail.php";
 
include_once $libLoad ;
  
$settingquery = mysqli_query($link, "SELECT * FROM `setting`");
$res=$settingquery->fetch_assoc();

$from = htmlspecialchars($res["email_id"]); //# 보내는 자
$to = htmlspecialchars($res["email_id"]); //# 받는자


 $query = mysqli_query($link, "Select Count(seqno) from AutoWord Where YN = 'N'");
 $rs=$query->fetch_assoc();
 
 $Count = htmlspecialchars($rs["Count(seqno)"]) ;

 if ( $Count == 0 ) {
 

	$i = 1; //i변수에 1을 대입합니다.

	while($i<=100) //i가 10보다 작거나 같을 때 반복합니다
	{
	  
   $SQL = "INSERT INTO AutoWord " ;
   $SQL = $SQL . " (" ;
   $SQL = $SQL . " word " ;
   $SQL = $SQL . ") values (" ;
   $SQL = $SQL . " '".AuthWord()."' " ;
   $SQL = $SQL . " )" ;
   mysqli_query($link,$SQL);
   
   $i++; //i를 1씩 증가합니다.(증감식)
   
  }


 
 }
 
 $query = mysqli_query($link, "Select word from AutoWord Where YN = 'N' and Confirm = 'N' ORDER BY RAND() LIMIT 1");
 $rs=$query->fetch_assoc();
 
 $certification_num = htmlspecialchars($rs["word"]) ;
 
 
 $SQL = "UPDATE AutoWord set YN = 'Y' Where word = '".$certification_num."' and YN = 'N' and Confirm = 'N'" ;
 mysqli_query($link,$SQL);
 


    $subject = "[".$CompanyName."] 인증번호를 알려드립니다." ;
     

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
    $htmlstr = $htmlstr . "인증번호" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $certification_num ;
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

    echo "succ" ;
    exit;
    
?>

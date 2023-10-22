<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
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







$title = mysqli_real_escape_string($link, $_POST['title']);
$name = mysqli_real_escape_string($link, $_POST['name']);
$mobile = mysqli_real_escape_string($link, $_POST['mobile']);
$to = mysqli_real_escape_string($link, $_POST['email']);
$cont = str_replace("\r\n","<br>", $_POST['cont'] );


date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

 
 
$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 

    $subject = "[".$CompanyName."] 이메일 문의가 접수되었습니다." ;
     

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
    $htmlstr = $htmlstr . $title ;
    $htmlstr = $htmlstr . "</th>";
    $htmlstr = $htmlstr . "</tr>";

    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th style='width:20%;background:#EEEEEE;color:#262626;padding:15px;text-align:center;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . "성명" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $name ;
    $htmlstr = $htmlstr . "</td>" ;
    $htmlstr = $htmlstr . "</tr>" ;



    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th style='width:20%;background:#EEEEEE;color:#262626;padding:15px;text-align:center;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . "연락처" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $mobile ;
    $htmlstr = $htmlstr . "</td>" ;
    $htmlstr = $htmlstr . "</tr>" ;


    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th style='width:20%;background:#EEEEEE;color:#262626;padding:15px;text-align:center;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . "이메일" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $to ;
    $htmlstr = $htmlstr . "</td>" ;
    $htmlstr = $htmlstr . "</tr>" ;
    


    $htmlstr = $htmlstr . "<tr>" ;
    $htmlstr = $htmlstr . "<th style='width:20%;background:#EEEEEE;color:#262626;padding:15px;text-align:center;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . "문의내용" ;
    $htmlstr = $htmlstr . "</th>" ;
    $htmlstr = $htmlstr . "<td style='color:#262626;padding:15px;text-align:left;border-bottom: 1px solid #E5E5E5;'>" ;
    $htmlstr = $htmlstr . $cont ;
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
    
?>

<?php

session_start();

if ( $_SESSION['UserEmail'] == "" ) {

 exit ;
  
}

  
include "config.php";

include "class.http.php";
include "class.EmmaSMS.php";

$sms_id = "smstest";
$sms_passwd = "smstest";
$sms_from = "1588-4259" ;
$sms_date = "" ;
$sms_type = "L";



$sms_msg = "테스트" ;



$UserMobile = str_replace("-","",mysqli_real_escape_string($link, $_POST['UserMobile']));



$sms = new EmmaSMS();
$sms->login($sms_id, $sms_passwd);
        

$ret = $sms->send($UserMobile, $sms_from, $sms_msg, $sms_date, $sms_type);

foreach($ret as $value)
{

 $code = $value ;
 breack ;

}


if ( $code == "SMS" ) {

 
 
 $num = sprintf("%06d",rand(000000,999999));

 $SQL = "UPDATE users set certification_number = '".$num."' Where UserEmail = '".$_SESSION['UserEmail']."'" ;
 mysqli_query($link,$SQL);
 

 echo $num ;
 
 exit ;
 
}  



?>
<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";






$contactus_url = mysqli_real_escape_string($link, $_POST['contactus_url']);
$contactus_email = mysqli_real_escape_string($link, $_POST['contactus_email']);
$operating_time = str_replace("\r\n","<br>", $_POST['operating_time'] );





date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 



 
 
 
$link->begin_transaction();

try {
  

 $SQL = "UPDATE setting  " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " contactus_url = '".$contactus_url."',  " ;
 $SQL = $SQL . " contactus_email = '".$contactus_email."',  " ;
 $SQL = $SQL . " operating_time = '".$operating_time."'  " ;
 $data = mysqli_query($link, $SQL);


 echo "succ" ;

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
  exit ;
  
}



DB_BACKUP();






?>

<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";





$seqno = mysqli_real_escape_string($link, $_POST['seqno']);




date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 
 
$link->begin_transaction();

try {
  

 $query = mysqli_query($link, "Select * from users Where seqno = '".$seqno."'");
 $rs=$query->fetch_assoc();
 
 $UserEmail = $rs["UserEmail"] ;
 $UserPwd = $rs["UserPwd"] ;
 $deposit_address = $rs["deposit_address"] ;
 $deposit_privateKey = $rs["deposit_privateKey"] ;
 
 $token = $rs["token"] ;
 $bnb = $rs["bnb"] ;
 $cash = $rs["cash"] ;
 
 $regdate = $rs["regdate"] ;
 $ip = $rs["ip"] ;
 
 
 
 $SQL = "DELETE FROM users " ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."' " ;
 $data = mysqli_query($link, $SQL);

 
 $SQL = "DELETE FROM login_connect " ;
 $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."'" ;
 $data = mysqli_query($link, $SQL);




 $SQL = "INSERT INTO withdrawal " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " UserEmail , " ;
 $SQL = $SQL . " UserPwd ,  " ;
 $SQL = $SQL . " deposit_address , " ;
 $SQL = $SQL . " deposit_privateKey ,  " ;

 $SQL = $SQL . " token ,  " ;
 $SQL = $SQL . " bnb , " ;
 $SQL = $SQL . " cash ,  " ;
 
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " '".$UserEmail."' ,  " ;
 $SQL = $SQL . " '".$UserPwd."' ,  " ;
 $SQL = $SQL . " '".$deposit_address."' ,  " ;
 $SQL = $SQL . " '".$deposit_privateKey."' ,  " ;
 
 $SQL = $SQL . " '".$token."' ,  " ;
 $SQL = $SQL . " '".$bnb."' ,  " ;
 $SQL = $SQL . " '".$cash."' ,  " ;
 
 $SQL = $SQL . " '".$regdate."' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 
 

 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";





$seqno = mysqli_real_escape_string($link, $_POST['seqno']);

$pwd = mysqli_real_escape_string($link, $_POST['pwd']);

$pwd = base64_encode($pwd) ;


date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 
 
$link->begin_transaction();

try {
  
 $SQL = "UPDATE users set " ;
 $SQL = $SQL . " UserPwd = '".$pwd."'" ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."' " ;
 $data = mysqli_query($link, $SQL);

 
 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}



include "config.php";

$seqno = mysqli_real_escape_string($link, $_POST['seqno']);
$ReadCnt = mysqli_real_escape_string($link, $_POST['ReadCnt']);

date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");


 
$ip = $_SERVER["REMOTE_ADDR"] ;
 
$link->begin_transaction();

try {
  
 
 $SQL = "UPDATE board " ;
 $SQL = $SQL . "  set " ;
 $SQL = $SQL . " ReadCnt = '".$ReadCnt."'" ;
 $SQL = $SQL . " Where seqno = '".$seqno."' " ;
 $data = mysqli_query($link, $SQL);
   
    
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




?>

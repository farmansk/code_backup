<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";



$seqno = mysqli_real_escape_string($link, $_POST['seqno']);
$title = mysqli_real_escape_string($link, $_POST['title']);
$cont = mysqli_real_escape_string($link, $_POST['cont']);


date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

 
 
$ip = $_SERVER["REMOTE_ADDR"] ;
 
$link->begin_transaction();

try {
  
  
 $SQL = "UPDATE faq set " ;
 $SQL = $SQL . " title = '".$title."' ,  " ;
 $SQL = $SQL . " cont = '".$cont."' " ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."'" ;
 $data = mysqli_query($link, $SQL);
   
    
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




DB_BACKUP();






?>

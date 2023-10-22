<?php

session_start();

if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}

include "config.php";

$seqno = mysqli_real_escape_string($link, $_POST['seqno']);
$edate = mysqli_real_escape_string($link, $_POST['edate']);


$query = mysqli_query($link, "Select state from lockup_history Where seqno = '".$seqno."' " );
$rs=$query->fetch_assoc();

if ( $rs["state"] != "지급대기" ) {

 echo "no_ready" ;
 exit ;
 
}  


$link->begin_transaction();

try {
  
  
   $SQL = "UPDATE lockup_history " ;
   $SQL = $SQL . " set " ;
   $SQL = $SQL . " edate = '".$edate."'  " ;
   $SQL = $SQL . " Where seqno = '".$seqno."' " ;   
   $data = mysqli_query($link, $SQL);

 echo "succ" ;

 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}



?>
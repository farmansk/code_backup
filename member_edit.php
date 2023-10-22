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
 
 $acct_yn = $rs["acct_yn"] ;
 
 if ($acct_yn == 0) 
    $acct_yn = 1;
else 
    $acct_yn = 0; 

 $SQL = "UPDATE users SET acct_yn = ".$acct_yn ;
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

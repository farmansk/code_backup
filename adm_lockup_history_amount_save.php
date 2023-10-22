<?php

session_start();

if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}

include "config.php";

$seqno = mysqli_real_escape_string($link, $_POST['seqno']);
$amount = mysqli_real_escape_string($link, $_POST['amount']);


$query = mysqli_query($link, "Select * from lockup_history Where seqno = '".$seqno."' " );
$rs=$query->fetch_assoc();

$UserEmail = $rs["UserEmail"] ;

if ( $rs["state"] != "지급대기" ) {

 echo "no_ready" ;
 exit ;
 
}  


$link->begin_transaction();

try {
  
  
 $SQL = "UPDATE lockup_history " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " amount = '".$amount."'  " ;
 $SQL = $SQL . " Where seqno = '".$seqno."' " ;   
 $data = mysqli_query($link, $SQL);




 // 락업토큰 잔액 확인
   
 $SQL = "Select SUM(amount) From lockup_history WHERE UserEmail = '".$UserEmail."' AND state = '지급대기'";
 $query=mysqli_query($link, $SQL);
 
 $count = mysqli_num_rows($query);

 if($count > 0){

  $rs=$query->fetch_assoc();
    
  $next_amount = $rs["SUM(amount)"] ;
    
 }
 else $next_amount = 0 ;
   
 if ( $next_amount == "" ) $next_amount = 0 ;
   
   
 // 락업토큰 잔액 업데이트 끝
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " lockup_token = '".$next_amount."' " ;
 $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."' " ;
 $data = mysqli_query($link, $SQL);

 // 락업토큰 잔액 업데이트 끝
 
 
 
 
 
 
 echo "succ" ;

 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}



?>
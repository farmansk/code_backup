<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";


date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;



$seqno_str = mysqli_real_escape_string($link, $_POST['seqno_str']) ;


$explode_arr = explode("|",$seqno_str) ;

foreach($explode_arr as $seqno){



  
  
  
 if ( $seqno != "" ) {
  
  

  $query = mysqli_query($link, "Select * from krw_history Where seqno = '".$seqno."' " );
  $rs=$query->fetch_assoc();

  $gubn = $rs["gubn"] ; 
  $UserEmail = $rs["UserEmail"] ; 
  $amount = $rs["amount"] ; 





  // 나의 KRW 잔액 확인 시작

  $query = mysqli_query($link, "Select * from users Where UserEmail = '".$UserEmail."' " );
  $rs=$query->fetch_assoc();

  $prev_amount = $rs["cash"] ; 


  // 나의 KRW 잔액 확인 끝






  if ( $gubn == "입금" ) {

   $next_amount = $prev_amount + $amount ; // KRW 이후금액

  }
  else if ( $gubn == "출금" ) {

   if ( $prev_amount < $amount ) {
   
    $err_state = "lack_balance"; // 출금 잔액 부족
   
   }  

   if ( $prev_amount - $amount < 0 ) {
   
    $next_amount = 0 ; // KRW 이후금액
  
   }
   else {
     
    $next_amount = $prev_amount - $amount ; // KRW 이후금액
  
   } 

  }
  
  
  




  if ( $err_state != "lack_balance" ) {
    
    
  // KRW 기록 업데이트 시작

  $SQL = "UPDATE krw_history " ;
  $SQL = $SQL . " set " ;
  $SQL = $SQL . " prev_amount = '".$prev_amount."' ,  " ;
  $SQL = $SQL . " next_amount = '".$next_amount."' , " ;
  $SQL = $SQL . " state = '완료' " ;
  $SQL = $SQL . " WHERE seqno = '".$seqno."' " ;
  $data = mysqli_query($link, $SQL);
 
  // KRW 기록 업데이트 시작



  // KRW 잔액 업데이트 끝
 
  $SQL = "UPDATE users " ;
  $SQL = $SQL . " set " ;
  $SQL = $SQL . " cash = '".$next_amount."' " ;
  $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."' " ;
  $data = mysqli_query($link, $SQL);

  // KRW 잔액 업데이트 끝
  
  
 
  }
  
  
  $gubn = "";
  $prev_amount = 0 ;
  $next_amount = 0 ;
  
 


   

 }







}


echo "succ" ;


?>

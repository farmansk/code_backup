<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";




// 나의 KRW 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."' " );
$rs=$query->fetch_assoc();

$prev_amount = $rs["cash"] ; 


// 나의 KRW 잔액 확인 끝




$depositor = mysqli_real_escape_string($link, $_POST['depositor']);
$amount = mysqli_real_escape_string($link, $_POST['amount']);
$amount = str_replace(",","",$amount) ;








// 최소 입금 금액을 충족하는지 확인 시작

if ( $amount < $min_deposit_krw ) {
  
 echo "no_cash" ;
 exit ;

}

// 최소 입금 금액을 충족하는지 확인 끝



$next_amount = $prev_amount + $amount ; // KRW 이후금액

$prev_amount = 0 ;
$next_amount = 0 ;



date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 
 
$link->begin_transaction();

try {
  
 
 // KRW 입금 기록 시작
 
 $SQL = "INSERT INTO krw_history " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " gubn , " ;
 $SQL = $SQL . " UserEmail , " ;
 
 $SQL = $SQL . " bank_name ,  " ;
 $SQL = $SQL . " bank_account ,  " ;
 $SQL = $SQL . " bank_account_holder , " ;
 $SQL = $SQL . " depositor , " ;
 
 $SQL = $SQL . " amount ,  " ;
 $SQL = $SQL . " prev_amount ,  " ;
 $SQL = $SQL . " next_amount , " ;
 $SQL = $SQL . " memo ,  " ;
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " '입금' ,  " ;
 $SQL = $SQL . " '".$_SESSION['UserEmail']."' ,  " ;
 
 $SQL = $SQL . " '".$bank_name."' ,  " ;
 $SQL = $SQL . " '".$bank_account."' ,  " ;
 $SQL = $SQL . " '".$bank_account_holder."' , " ;
 $SQL = $SQL . " '".$depositor."' , " ;
 
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$prev_amount."' ,  " ;
 $SQL = $SQL . " '".$next_amount."' , " ;
 $SQL = $SQL . " '입금신청' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // KRW 입금 기록 시작

 // KRW 잔액 업데이트 끝
 
 //$SQL = "UPDATE users " ;
 //$SQL = $SQL . " set " ;
 //$SQL = $SQL . " cash = '".$next_amount."' " ;
 //$SQL = $SQL . " WHERE UserEmail = '".$_SESSION['UserEmail']."' " ;
 //$data = mysqli_query($link, $SQL);

 // KRW 잔액 업데이트 끝
 

 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

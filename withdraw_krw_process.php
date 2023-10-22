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




$depositor_bank_name = mysqli_real_escape_string($link, $_POST['depositor_bank_name']);
$depositor_bank_account = mysqli_real_escape_string($link, $_POST['depositor_bank_account']);
$depositor_bank_account_holder = mysqli_real_escape_string($link, $_POST['depositor_bank_account_holder']);


$fee = mysqli_real_escape_string($link, $_POST['fee']); // 출금 수수료
$amount = mysqli_real_escape_string($link, $_POST['amount']);

$amount = $amount + $fee ;







// 최소 출금 금액을 충족하는지 확인 시작

if ( $amount < $min_withdraw_krw ) {
  
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
  
 
 // KRW 출금 기록 시작
 
 $SQL = "INSERT INTO krw_history " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " gubn , " ;
 $SQL = $SQL . " UserEmail , " ;
 
 $SQL = $SQL . " depositor_bank_name ,  " ;
 $SQL = $SQL . " depositor_bank_account ,  " ;
 $SQL = $SQL . " depositor_bank_account_holder , " ;
 
 $SQL = $SQL . " amount ,  " ;
 $SQL = $SQL . " prev_amount ,  " ;
 $SQL = $SQL . " next_amount , " ;
 $SQL = $SQL . " fee , " ;
 $SQL = $SQL . " memo ,  " ;
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " '출금' ,  " ;
 $SQL = $SQL . " '".$_SESSION['UserEmail']."' ,  " ;
 
 $SQL = $SQL . " '".$depositor_bank_name."' ,  " ;
 $SQL = $SQL . " '".$depositor_bank_account."' ,  " ;
 $SQL = $SQL . " '".$depositor_bank_account_holder."' , " ;
 
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$prev_amount."' ,  " ;
 $SQL = $SQL . " '".$next_amount."' , " ;
 $SQL = $SQL . " '".$fee."' , " ;
 $SQL = $SQL . " '출금신청' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // KRW 출금 기록 시작

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

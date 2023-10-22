<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";



$seqno = mysqli_real_escape_string($link, $_POST['seqno']);




$query = mysqli_query($link, "Select * from token_transaction_history Where seqno = '".$seqno."' " );
$rs=$query->fetch_assoc();
 
$UserEmail = $rs["UserEmail"] ;
$amount = $rs["krw"] ;
$buy_coin = $rs["amount"] ;






// 나의 토큰과 KRW 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$UserEmail."' " );
$rs=$query->fetch_assoc();

$to_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["token"] ; 
$prev_cash_amount = $rs["cash"] ; 


// 나의 토큰과 BNB 잔액 확인 끝





	


// 원화(KRW)이 있는지 확인

if ( $prev_cash_amount < $amount ) {
  
 echo "no_cash" ;
 exit ;

}


	


// 최소 원화(KRW)를 충족하는지 확인

if ( $prev_cash_amount < $min_deposit_cash ) {
  
 echo "min_cash" ;
 exit ;

}





$next_cash_amount = $prev_cash_amount - $amount ; // 원화(KRW) 출금금액

if ( $next_cash_amount < 0 ) {
 
 echo "transaction_fail" ; 
 exit ;
  
}  

$next_amount = $prev_amount + $buy_coin ; // 토큰 입금 금액






date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 
 
$link->begin_transaction();

try {
  
 
 // 토큰 입금 기록 시작
 
 $SQL = "UPDATE token_transaction_history " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " prev_amount = '".$prev_amount."'  " ;
 $SQL = $SQL . " , next_amount = '".$next_amount."' " ;
 $SQL = $SQL . " , state = '원화코인구매-완료' " ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."'" ;
 $data = mysqli_query($link, $SQL);
 
 // 토큰 입금 기록 시작


 // 원화(KRW) 출금 기록 시작
 
 $from_address = $to_address ;
 $hash = "" ;
 $TransactionFee = "0" ;
 $gasPrice = "0" ;
 $deposit_hash = "";
 
 $SQL = "INSERT INTO token_transaction_history " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " sel_no , " ;
 $SQL = $SQL . " target , " ;
 $SQL = $SQL . " gubn , " ;
 $SQL = $SQL . " UserEmail , " ;
 $SQL = $SQL . " amount ,  " ;
 $SQL = $SQL . " chainId , " ;
 $SQL = $SQL . " from_address ,  " ;
 $SQL = $SQL . " to_address , " ;
 $SQL = $SQL . " hash , " ;
 $SQL = $SQL . " TransactionFee ,  " ;
 $SQL = $SQL . " gasPrice , " ;
 $SQL = $SQL . " prev_amount ,  " ;
 $SQL = $SQL . " next_amount , " ;
 $SQL = $SQL . " ExpectationTransactionFee ,  " ;
 $SQL = $SQL . " deposit_hash ,  " ;
 $SQL = $SQL . " memo ,  " ;
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " '".$seqno."' ,  " ;
 $SQL = $SQL . " 'cash' ,  " ;
 $SQL = $SQL . " '출금' ,  " ;
 $SQL = $SQL . " '".$UserEmail."' ,  " ;
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$chainId."' , " ;
 $SQL = $SQL . " '".$from_address."' ,  " ;
 $SQL = $SQL . " '".$manager_address."' , " ;
 $SQL = $SQL . " '".$hash."' , " ;
 $SQL = $SQL . " '".$TransactionFee."' ,  " ;
 $SQL = $SQL . " '".$gasPrice."' , " ;
 $SQL = $SQL . " '".$prev_cash_amount."' ,  " ;
 $SQL = $SQL . " '".$next_cash_amount."' , " ;
 $SQL = $SQL . " '0' ,  " ;
 $SQL = $SQL . " '".$deposit_hash."' ,  " ;
 $SQL = $SQL . " '내부전송' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // 원화(KRW) 출금 기록 시작
 
 
 // 토큰 및 CASH 잔액 업데이트 시작
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " token = '".$next_amount."' " ;
 $SQL = $SQL . " , cash = '".$next_cash_amount."' " ;
 $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."' " ;
 $data = mysqli_query($link, $SQL);

 // 토큰 및 CASH잔액 업데이트 끝
 



 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

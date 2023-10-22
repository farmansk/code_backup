<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";




// 나의 토큰과 BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."' " );
$rs=$query->fetch_assoc();

$to_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["token"] ; 
$prev_bnb_amount = $rs["bnb"] ; 


// 나의 토큰과 BNB 잔액 확인 끝





$amount = mysqli_real_escape_string($link, $_POST['amount']); // BNB 금액


$buy_coin = mysqli_real_escape_string($link, $_POST['buy_coin']); // 구매 토큰 수량




	


// BNB 가 있는지 확인

if ( $prev_bnb_amount < $amount ) {
  
 echo "no_cash" ;
 exit ;

}


	


// 최소 BNB 를 충족하는지 확인

if ( $prev_bnb_amount < $min_deposit_bnb ) {
  
 echo "min_cash" ;
 exit ;

}





$next_bnb_amount = $prev_bnb_amount - $amount ; // BNB 출금금액

if ( $next_bnb_amount < 0 ) {
 
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
 
 $prev_amount = 0 ;
 $next_amount = 0 ;
 
 $from_address = $manager_address ;
 $hash = "" ;
 $TransactionFee = "0" ;
 $gasPrice = "0" ;
 $deposit_hash = "";
 $WithdrawFee = "0" ; // 내부출금인 경우 출금수수료 무료
 
 $SQL = "INSERT INTO token_transaction_history " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " target , " ;
 $SQL = $SQL . " gubn , " ;
 $SQL = $SQL . " UserEmail , " ;
 $SQL = $SQL . " amount ,  " ;
 $SQL = $SQL . " bnb,  " ;
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
 $SQL = $SQL . " state ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " 'token' ,  " ;
 $SQL = $SQL . " '입금' ,  " ;
 $SQL = $SQL . " '".$_SESSION['UserEmail']."' ,  " ;
 $SQL = $SQL . " '".$buy_coin."' ,  " ;
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$chainId."' , " ;
 $SQL = $SQL . " '".$from_address."' ,  " ;
 $SQL = $SQL . " '".$to_address."' , " ;
 $SQL = $SQL . " '".$hash."' , " ;
 $SQL = $SQL . " '".$TransactionFee."' ,  " ;
 $SQL = $SQL . " '".$gasPrice."' , " ;
 $SQL = $SQL . " '".$prev_amount."' ,  " ;
 $SQL = $SQL . " '".$next_amount."' , " ;
 $SQL = $SQL . " '".$WithdrawFee."' ,  " ;
 $SQL = $SQL . " '".$deposit_hash."' ,  " ;
 $SQL = $SQL . " '내부전송' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " '코인구매-신청' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // 토큰 입금 기록 시작


 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";




// 나의 토큰과 BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."' " );
$rs=$query->fetch_assoc();

$from_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["bnb"] ; 


// 나의 BNB 잔액 확인 끝




$address = mysqli_real_escape_string($link, $_POST['address']);
$amount = mysqli_real_escape_string($link, $_POST['amount']);








// 받는자 BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where deposit_address = '".base64_encode($address)."' OR UserEmail = '".base64_encode($address)."' " );
$count = mysqli_num_rows($query);

if ( $count == 0 ) {
   
 echo "no_account" ;
 exit ;
  
}  
else {
  
 $rs=$query->fetch_assoc();
 
 $to_UserEmail = $rs["UserEmail"] ; 
 $to_address = base64_decode($rs["deposit_address"]) ; 
 $to_prev_amount = $rs["bnb"] ; 
    
}  


// 받는자 BNB 잔액 확인 끝






// 받는자가 본인인지 확인 시작

if ( $to_UserEmail == $_SESSION['UserEmail'] ) {
   
 echo "to_same" ;
 exit ;
  
}

// 받는자가 본인인지 확인 끝  


	


// BNB가 있는지 확인
if ( $prev_amount < $amount ) {
  
 echo "no_token" ;
 exit ;

}



$next_amount = $prev_amount - $amount ; // 보내는자 BNB 출금금액


$to_next_amount = $to_prev_amount + $amount ; // 받는자 BNB 입금금액







date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 
 
$link->begin_transaction();

try {
  
 
 // 보내는 자 BNB 출금 기록 시작
 
 $prev_amount = 0  ;
 $next_amount = 0 ;
 
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
 $SQL = $SQL . " to_UserEmail , " ;
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
 $SQL = $SQL . " state ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " 'BNB' ,  " ;
 $SQL = $SQL . " '출금' ,  " ;
 $SQL = $SQL . " '".$_SESSION['UserEmail']."' ,  " ;
 $SQL = $SQL . " '".$to_UserEmail."' ,  " ;
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
 $SQL = $SQL . " '신청' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // 보내는 자 BNB 출금 기록 시작


 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}



DB_BACKUP();



?>

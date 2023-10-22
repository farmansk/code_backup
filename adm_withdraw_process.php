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
$amount = $rs["amount"] ;
$to_UserEmail = $rs["to_UserEmail"] ;




// 나의 토큰과 BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$UserEmail."' " );
$rs=$query->fetch_assoc();

$from_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["token"] ; 
$prev_bnb_amount = $rs["bnb"] ; 


// 나의 토큰과 BNB 잔액 확인 끝










// 받는자 토큰 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$to_UserEmail."' " );
$count = mysqli_num_rows($query);

if ( $count == 0 ) {
   
 echo "no_account" ;
 exit ;
  
}  
else {
  
 $rs=$query->fetch_assoc();
 
 $to_UserEmail = $rs["UserEmail"] ; 
 $to_address = base64_decode($rs["deposit_address"]) ; 
 $to_prev_amount = $rs["token"] ; 
    
}  


// 받는자 토큰 잔액 확인 끝






// 받는자가 본인인지 확인 시작

if ( $to_UserEmail == $UserEmail ) {
   
 echo "to_same" ;
 exit ;
  
}

// 받는자가 본인인지 확인 끝  
	


// 토큰수량(BNB)이 있는지 확인
if ( $prev_amount < $amount ) {
  
 echo "no_token" ;
 exit ;

}




$next_bnb_amount = $prev_bnb_amount - $WithdrawFee ; // 보내는자 BNB 출금금액

$next_amount = $prev_amount - $amount ; // 보내는자 토큰 출금금액


$to_next_amount = $to_prev_amount + $amount ; // 받는자 토큰 입금금액







date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 
 
$link->begin_transaction();

try {
  
 
 // 보내는 자 토큰 출금 기록 시작
 
 $SQL = "UPDATE token_transaction_history " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " prev_amount = '".$prev_amount."'  " ;
 $SQL = $SQL . " , next_amount = '".$next_amount."' " ;
 $SQL = $SQL . " , state = '완료' " ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."'" ;
 $data = mysqli_query($link, $SQL);
 
 // 보내는 자 토큰 출금 기록 시작


 
 
 // 보내는 자 토큰 및 BNB 잔액 업데이트 시작
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " token = '".$next_amount."' " ;
 $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."' " ;
 $data = mysqli_query($link, $SQL);

 // 보내는 자 토큰 및 BNB 잔액 업데이트 끝
 


  
 
 // 받는 자 토큰 입금 기록 시작
 
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
 $SQL = $SQL . " 'token' ,  " ;
 $SQL = $SQL . " '입금' ,  " ;
 $SQL = $SQL . " '".$to_UserEmail."' ,  " ;
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$chainId."' , " ;
 $SQL = $SQL . " '".$from_address."' ,  " ;
 $SQL = $SQL . " '".$to_address."' , " ;
 $SQL = $SQL . " '".$hash."' , " ;
 $SQL = $SQL . " '".$TransactionFee."' ,  " ;
 $SQL = $SQL . " '".$gasPrice."' , " ;
 $SQL = $SQL . " '".$to_prev_amount."' ,  " ;
 $SQL = $SQL . " '".$to_next_amount."' , " ;
 $SQL = $SQL . " '0' ,  " ;
 $SQL = $SQL . " '".$deposit_hash."' ,  " ;
 $SQL = $SQL . " '내부전송' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // 받는 자 토큰 입금 기록 시작


 
 
 // 받는 자 토큰 잔액 업데이트 시작
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " token = '".$to_next_amount."' " ;
 $SQL = $SQL . " WHERE UserEmail = '".$to_UserEmail."' " ;
 $data = mysqli_query($link, $SQL);

 // 받는 자 토큰 잔액 업데이트 끝


 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}



DB_BACKUP();



?>

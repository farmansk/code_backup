<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";







function bnb_balance($chainId, $walletAddress)
{
		 $url = 'http://31.220.56.57:3000/balance/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId,
			 'address' => $walletAddress
		 );

		 $headers = array(
			'Content-Type: application/json'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
}
	
	
function token_transfer($chainId, $token_address, $to, $amount, $publicKey, $privateKey)
{
		 $url = 'http://31.220.56.57:3000/erc20/transfer/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId,
			 'token' => $token_address,
			 'to' => $to,
			 'amount' => $amount,
			 'publicKey' => $publicKey,
			 'privateKey' => $privateKey
		 );

		 $headers = array(
			'Content-Type: application/json'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
}
	
	
	





$seqno = mysqli_real_escape_string($link, $_POST['seqno']);




$query = mysqli_query($link, "Select * from token_transaction_history Where seqno = '".$seqno."' " );
$rs=$query->fetch_assoc();
 
$UserEmail = $rs["UserEmail"] ;
$amount = $rs["amount"] ;
$to_address = $rs["to_address"] ;





// 나의 토큰과 BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$UserEmail."' " );
$rs=$query->fetch_assoc();

$from_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["token"] ; 
$prev_bnb_amount = $rs["bnb"] ; 


// 나의 토큰과 BNB 잔액 확인 끝












// 받는자가 내부인인지 확인 시작

$query = mysqli_query($link, "Select * from users Where deposit_address = '".base64_encode($to_address)."'" );
$count = mysqli_num_rows($query);

if ( $count > 0 ) {
   
 echo "in_account" ;
 exit ;
  
}  

// 받는자가 내부인인지 확인 끝


// 출금주소가 존재하는 확인 시작

$message_status = bnb_balance($chainId, $to_address);
$data = json_decode($message_status);
    
$state = $data->balance ;
    
if ( $state == "" || $state == "0" ) {
  
 echo "no_account" ;
 exit ;

}
    
// 출금주소가 존재하는 확인 끝




// 출금수수료(BNB)가 있는지 확인
if ( $prev_bnb_amount < $WithdrawFee ) {
  
 echo "no_fee" ;
 exit ;

}
	


// 토큰수량(BNB)이 있는지 확인
if ( $prev_amount < $amount ) {
  
 echo "no_token" ;
 exit ;

}




$next_bnb_amount = $prev_bnb_amount - $WithdrawFee ; // 보내는자 BNB 출금금액

$next_amount = $prev_amount - $amount ; // 보내는자 토큰 출금금액







// 관리자 지갑에 전송할 가스비+네트워크수수료가 충분한지 확인 시작

$message_status = bnb_balance($chainId, $manager_address);
$data = json_decode($message_status);
    
$BnbBalance = $data->balance ;

          
if ( $BnbBalance < 0.1 ) { 
  
 echo "lack_balance" ;
 exit ;

}

// 관리자 지갑에 전송할 가스비+네트워크수수료가 충분한지 확인 끝


// 외부 출금주소에 토큰 전송 시작

$reduction_amount = $amount * 1000000000000000000 ;
$reduction_amount = sprintf("%.0f", $reduction_amount );


$message_status = token_transfer($chainId, $token_address, $to_address, $reduction_amount, $manager_address, base64_encode($manager_privateKey)) ;
$data = json_decode($message_status);

$hash = $data->hash ;


// 가스비          
$gasPrice = $data->gasPrice ;
$gasPrice = sprintf("%.8f", $gasPrice / 1000000000000000000 );

// 네트워크 수수료
$TransactionFee = $data->gas ;
$TransactionFee = sprintf("%.8f", $TransactionFee / 100000000 ); 

//$from_address = $data->from ;
          
$to_address = $data->to ;
          

if ( $hash == "" ) { 
  
 echo "transaction_fail" ;
 exit ;

}  
                
                
// 외부 출금주소에 토큰 전송 끝




date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 

 
$link->begin_transaction();

try {
  

 // 보내는 자 토큰 출금 기록 시작


 $SQL = "UPDATE token_transaction_history " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " hash = '".$hash."' " ;
 $SQL = $SQL . " , TransactionFee = '".$TransactionFee."' " ;
 $SQL = $SQL . " , gasPrice = '".$gasPrice."' " ;
 $SQL = $SQL . " , WithdrawFee = '".$WithdrawFee."' " ;
 $SQL = $SQL . " , prev_amount = '".$prev_amount."'  " ;
 $SQL = $SQL . " , next_amount = '".$next_amount."' " ;
 $SQL = $SQL . " , state = '완료' " ;
 $SQL = $SQL . " WHERE seqno = '".$seqno."'" ;
 $data = mysqli_query($link, $SQL);
 
 
 // 보내는 자 토큰 출금 기록 시작




 // 보내는 자 BNB 수수료 출금 기록 시작
 
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
 $SQL = $SQL . " 'bnb' ,  " ;
 $SQL = $SQL . " '출금' ,  " ;
 $SQL = $SQL . " '".$UserEmail."' ,  " ;
 $SQL = $SQL . " '".$WithdrawFee."' ,  " ;
 $SQL = $SQL . " '".$chainId."' , " ;
 $SQL = $SQL . " '".$from_address."' ,  " ;
 $SQL = $SQL . " '".$manager_address."' , " ;
 $SQL = $SQL . " '".$hash."' , " ;
 $SQL = $SQL . " '".$TransactionFee."' ,  " ;
 $SQL = $SQL . " '".$gasPrice."' , " ;
 $SQL = $SQL . " '".$prev_bnb_amount."' ,  " ;
 $SQL = $SQL . " '".$next_bnb_amount."' , " ;
 $SQL = $SQL . " '0' ,  " ;
 $SQL = $SQL . " '".$deposit_hash."' ,  " ;
 $SQL = $SQL . " '출금수수료' ,  " ;
 $SQL = $SQL . " '".$date."' , " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
 
 // 보내는 자 BNB 수수료 출금 기록 시작
 
 
 
 // 보내는 자 토큰 및 BNB 잔액 업데이트 시작
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " token = '".$next_amount."' " ;
 $SQL = $SQL . " , bnb = '".$next_bnb_amount."' " ;
 $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."' " ;
 $data = mysqli_query($link, $SQL);

 // 보내는 자 토큰 및 BNB 잔액 업데이트 끝
 
 
 
 
 
 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

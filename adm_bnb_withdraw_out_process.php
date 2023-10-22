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
	
	

	function transfer($chainId, $to, $amount, $publicKey, $privateKey)
	{
		 $url = 'http://31.220.56.57:3000/transfer/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId,
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





// BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$UserEmail."' " );
$rs=$query->fetch_assoc();

$from_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["bnb"] ; 


// BNB 잔액 확인 끝












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
if ( $prev_amount < $WithdrawFee ) {
  
 echo "no_fee" ;
 exit ;

}
	


// BNB가 있는지 확인
if ( $prev_amount < $amount + $WithdrawFee ) {
  
 echo "no_token" ;
 exit ;

}






$next_amount = $prev_amount - ( $amount + $WithdrawFee ) ; // 보내는자 BNB 출금금액







// 관리자 지갑에 전송할 가스비+네트워크수수료가 충분한지 확인 시작

$message_status = bnb_balance($chainId, $manager_address);
$data = json_decode($message_status);
    
$BnbBalance = $data->balance ;

          
if ( $BnbBalance < 0.1 ) { 
  
 echo "lack_balance" ;
 exit ;

}

// 관리자 지갑에 전송할 가스비+네트워크수수료가 충분한지 확인 끝


// 외부 출금주소에 BNB 전송 시작

$message_status = transfer($chainId, $to_address, $amount, $manager_address, base64_encode($manager_privateKey)) ;
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
                
                
// 외부 출금주소에 BNB 전송 끝




date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 

 
$link->begin_transaction();

try {
  


 // 보내는 자 BNB 출금 기록 시작
 
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
 
 // 보내는 자 BNB 출금 기록 시작
 

 
 // 보내는 자 BNB 잔액 업데이트 시작
 
 $SQL = "UPDATE users " ;
 $SQL = $SQL . " set " ;
 $SQL = $SQL . " bnb = '".$next_amount."' " ;
 $SQL = $SQL . " WHERE UserEmail = '".$UserEmail."' " ;
 $data = mysqli_query($link, $SQL);

 // 보내는 자 BNB 잔액 업데이트 끝
 
 
 
 
 
 echo "succ" ;
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


DB_BACKUP();

?>

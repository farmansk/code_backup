<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
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
	
	
	


$address = mysqli_real_escape_string($link, $_POST['address']);
$amount = mysqli_real_escape_string($link, $_POST['amount']);




// BNB 잔액 확인 시작

$query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."' " );
$rs=$query->fetch_assoc();

$from_address = base64_decode($rs["deposit_address"]) ; 
$prev_amount = $rs["bnb"] ; 


// BNB 잔액 확인 끝












// 받는자가 내부인인지 확인 시작

$query = mysqli_query($link, "Select * from users Where deposit_address = '".base64_encode($address)."'" );
$count = mysqli_num_rows($query);

if ( $count > 0 ) {
   
 echo "in_account" ;
 exit ;
  
}  

// 받는자가 내부인인지 확인 끝


// 출금주소가 존재하는 확인 시작

$message_status = bnb_balance($chainId, $address);
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









date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 
 

 
$link->begin_transaction();

try {
  
 $prev_amount = 0 ;
 $next_amount = 0 ;

 // 보내는 자 BNB 출금 기록 시작
 
 $TransactionFee = "0" ;
 $gasPrice = "0" ;
 $deposit_hash = "";
 
 $SQL = "INSERT INTO token_transaction_history " ;
 $SQL = $SQL . " (" ;
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
 $SQL = $SQL . " WithdrawFee ,  " ;
 $SQL = $SQL . " deposit_hash ,  " ;
 $SQL = $SQL . " memo ,  " ;
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " state ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " 'BNB' ,  " ;
 $SQL = $SQL . " '출금' ,  " ;
 $SQL = $SQL . " '".$_SESSION['UserEmail']."' ,  " ;
 $SQL = $SQL . " '".$amount."' ,  " ;
 $SQL = $SQL . " '".$chainId."' , " ;
 $SQL = $SQL . " '".$from_address."' ,  " ;
 $SQL = $SQL . " '".$manager_address."' , " ;
 $SQL = $SQL . " '".$hash."' , " ;
 $SQL = $SQL . " '".$TransactionFee."' ,  " ;
 $SQL = $SQL . " '".$gasPrice."' , " ;
 $SQL = $SQL . " '".$prev_amount."' ,  " ;
 $SQL = $SQL . " '".$next_amount."' , " ;
 $SQL = $SQL . " '0' ,  " ;
 $SQL = $SQL . " '".$WithdrawFee."' ,  " ;
 $SQL = $SQL . " '".$deposit_hash."' ,  " ;
 $SQL = $SQL . " '외부전송' ,  " ;
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

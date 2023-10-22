<?php

session_start();


include "config.php";

$UserEmail = base64_encode(mysqli_real_escape_string($link, $_POST['UserEmail']));
$UserPwd = base64_encode(mysqli_real_escape_string($link, $_POST['UserPwd']));
$UserMobile = base64_encode(mysqli_real_escape_string($link, $_POST['UserMobile']));

$UserMobile = str_replace("-", "", $UserMobile) ;


if ( $chainSymbol == "TRX" ) {
  
  

   function tron_createWallet($chainId)
   {
       $url = 'http://31.220.56.57:3000/tron/createWallet/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
       $fields = array(
          'tronId' => $chainId
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
   
   
   $message_status = tron_createWallet($chainId);
   $data = json_decode($message_status);

   $walletAddress = $data->address->base58 ;
   $wallet_privateKey = $data->privateKey ;
   $wallet_publicKey = $data->publicKey ;

   if ( $walletAddress == "" ) {
 
    echo "fail" ;
    exit ;
  
   }  


   $address = base64_encode($walletAddress);
   $privateKey = base64_encode($wallet_privateKey);
   $publicKey = base64_encode($wallet_publicKey);
   
   
}
else {
  
    

   function WalletCreate($chainId)
   {
		 $url = 'http://31.220.56.57:3000/WalletCreate/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId
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
	


   $message_status = WalletCreate($chainId);
   $data = json_decode($message_status);

   $walletAddress = $data->address ;
   $wallet_privateKey = $data->privateKey ;

   if ( $walletAddress == "" ) {
 
    echo "fail" ;
    exit ;
  
   }  


   $address = base64_encode($walletAddress);
   $privateKey = base64_encode($wallet_privateKey);
   $publicKey = "" ;


}






   
   
   
   



date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");



$ip = $_SERVER["REMOTE_ADDR"] ;
 
$link->begin_transaction();

try {
   
   
      $SQL = "INSERT INTO users " ;
      $SQL = $SQL . " (" ;
      $SQL = $SQL . " UserEmail , " ;
      $SQL = $SQL . " UserPwd ,  " ;
      $SQL = $SQL . " UserMobile ,  " ;
      $SQL = $SQL . " deposit_address , " ;
      $SQL = $SQL . " deposit_privateKey ,  " ;
      $SQL = $SQL . " deposit_publicKey ,  " ;
      $SQL = $SQL . " regdate ,  " ;
      $SQL = $SQL . " transaction_time ,  " ;
      $SQL = $SQL . " ip  " ;
      $SQL = $SQL . ") values (" ;
      $SQL = $SQL . " '".$UserEmail."' ,  " ;
      $SQL = $SQL . " '".$UserPwd."' ,  " ;
      $SQL = $SQL . " '".$UserMobile."' ,  " ;
      $SQL = $SQL . " '".$address."' ,  " ;
      $SQL = $SQL . " '".$privateKey."' ,  " ;
      $SQL = $SQL . " '".$publicKey."' ,  " ;
      $SQL = $SQL . " '".$date."' , " ;
      $SQL = $SQL . " '".$date."' , " ;
      $SQL = $SQL . " '".$ip."' " ;
      $SQL = $SQL . " )" ;
      $data = mysqli_query($link, $SQL);
   
    
      echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


?>

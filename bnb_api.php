<?php

session_start();

if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;
  
}


  
include "config.php";


	function send_notification()
	{
	  
		 $url = "https://api.p2pb2b.com/api/v2/public/ticker?market=BNB_USDT" ;

		 $headers = array(
			'Content-Type: application/x-www-form-urlencoded'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}







	function token_balance($chainId, $token_address, $walletAddress)
	{
		 $url = 'http://31.220.56.57:3000/erc20/balance/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId,
			 'contractAddress' => $token_address,
			 'walletAddress' => $walletAddress
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
	
	
	

	


	// 트론 함수
	
	function tron_balance($chainId, $walletAddress)
  {
    
       $url = 'http://31.220.56.57:3000/tron/balance/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
       $fields = array(
          'tronId' => $chainId,
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
   
   
	function tron_transfer($chainId, $to, $amount, $publicKey, $privateKey)
  {
    
       $url = 'http://31.220.56.57:3000/tron/transfer/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
       $fields = array(
          'tronId' => $chainId,
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
   
  
  // 트론 함수 끝





  
  date_default_timezone_set("Asia/Seoul");
  $date = date("Y-m-d H:i:s");
  
  $ip = $_SERVER["REMOTE_ADDR"] ;



 
 $SQL = "Select * From users WHERE UserEmail = '".$_SESSION["UserEmail"]."' ";
 $query=mysqli_query($link, $SQL);
 
 $count = mysqli_num_rows($query);
   
 if($count > 0){
    
    
  $rs=$query->fetch_assoc();
     
  $deposit_address = base64_decode($rs["deposit_address"]) ; 
  $deposit_privateKey = $rs["deposit_privateKey"] ; 
    
  $prev_amount = $rs["token"] ; 
  $prev_bnb_amount = $rs["bnb"] ; 


  if ( $tokenSymbol == "TRX" ) {
    
   $message_status = tron_balance($chainId, $deposit_address);
   $data = json_decode($message_status);
   
  }
  else {
    
   $message_status = bnb_balance($chainId, $deposit_address);
   $data = json_decode($message_status);
   
  } 
    
  $BnbBalance = $data->balance ;

    

     

  $SQL = "Select * From users WHERE UserEmail = '".$_SESSION["UserEmail"]."' AND transaction_time < '".$date."'";
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);

    
  // 해당 고객 하위지갑 존재여부 확인 시작
  if ( $BnbBalance == "" || $BnbBalance == "0" || $count == "0" ) {

  }  
  else {
     
    


     // ### BNB 전송 시작 ###
     
     if ( $tokenSymbol == "TRX" ) {
                
      $message_status = tron_balance($chainId, $deposit_address);
      $data = json_decode($message_status);
            
     }
     else {
       
      $message_status = bnb_balance($chainId, $deposit_address);
      $data = json_decode($message_status);
    
     }
     

         
     $UserBnbBalance = $data->balance ; // 고객 하위지갑 BNB 잔액 확인
      

     if ( $tokenSymbol == "TRX" ) {
       
       $UserBnbBalance = $UserBnbBalance / 1000000 ;
       
     }
     


           
     // 고객 하위지갑에 BNB가 관리자가 책정한 가스비+네트워크수수료 보다 큰지 확인 시작
     
     if ( $UserBnbBalance > $min_deposit_bnb ) {       



       if ( $tokenSymbol == "TRX" ) {
                
        $message_status = tron_balance($chainId, $manager_address);
        $data = json_decode($message_status);
            
       }
       else {
         
        $message_status = bnb_balance($chainId, $manager_address);
        $data = json_decode($message_status);
    
       }
       
       $BnbBalance = $data->balance ;



       if ( $tokenSymbol == "TRX" ) {
       
        $BnbBalance = $BnbBalance / 1000000 ;
       
       }

  

  
       // BNB입금 -> 관리자가 고객 하위지갑에 전송할 가스비+네트워크수수료 가 충분한지 확인 시작
          
       if (  $BnbBalance > $manager_ExpectationTransactionFee ) { 
       

           
           if ( $tokenSymbol == "TRX" ) {
                            
            $message_status = tron_transfer($chainId, $deposit_address, $ExpectationTransactionFee, $manager_address, base64_encode($manager_privateKey)) ;
            $data = json_decode($message_status);
             
            $deposit_hash = $data->txid ;

           }
           else {
             
            $message_status = transfer($chainId, $deposit_address, $ExpectationTransactionFee, $manager_address, base64_encode($manager_privateKey)) ;
            $data = json_decode($message_status);
           
            $deposit_hash = $data->hash ;
                       

           } 
           
   

           // BNB입금 -> 고객 하위지갑 가스비+네트워크수수료 충전 hash 확인 시작
           
           if ( $deposit_hash != "" ) {
             
             
                   if ( $tokenSymbol == "TRX" ) {
                
                    $message_status = tron_balance($chainId, $deposit_address);
                    $data = json_decode($message_status);
            
                   }
                   else {
                     
                    $message_status = bnb_balance($chainId, $deposit_address);
                    $data = json_decode($message_status);
                    
                   } 
    
                   $BnbBalance = $data->balance ; // 고객 하위지갑 BNB 잔액 확인
                   

                   if ( $tokenSymbol == "TRX" ) {
      
                     $BnbBalance = $BnbBalance / 1000000 ;
                      
                     $amount = $BnbBalance - $ExpectationTransactionFee ; // 실제 출금 BNB

                   }
                   else {
                     
                     $amount = sprintf("%.3f", $BnbBalance - $ExpectationTransactionFee ) ; // 실제 출금 BNB
                     
                   }


  
                   if ( $tokenSymbol == "TRX" ) {
                                       
                     $message_status = tron_transfer($chainId, $manager_address, $amount, $deposit_address, $deposit_privateKey) ; // 실제 BNB 출금
                     $data = json_decode($message_status);
                
                     $hash = $data->txid ;
          
                     $gasPrice = "0" ;

                     $TransactionFee = "0" ;
     
                     $from_address = $deposit_address ;
          
                     $to_address = $manager_address ;


                   }
                   else {
                       
                     $message_status = transfer($chainId, $manager_address, $amount, $deposit_address, $deposit_privateKey) ; // 실제 BNB 출금
                     $data = json_decode($message_status);
                
                     $hash = $data->hash ;
          
                     $gasPrice = $data->gasPrice ;
                     $gasPrice = sprintf("%.8f", $gasPrice / 1000000000000000000 );


                     $TransactionFee = $data->gas ;
                     $TransactionFee = sprintf("%.8f", $TransactionFee / 100000000 ); 
     
                     $from_address = $data->from ;
          
                     $to_address = $data->to ;
          
                   }
                   
                   
                   $prev_bnb_amount = $rs["bnb"] ; 
                   
                   $next_bnb_amount = $prev_bnb_amount + $amount ;
                
                   // BNB입금 -> BNB 관리자 전송 hash 확인 시작
                
                   if ( $hash != "" ) { 
            
            
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
                     $SQL = $SQL . " deposit_hash ,  " ;
                     $SQL = $SQL . " regdate ,  " ;
                     $SQL = $SQL . " ip  " ;
                     $SQL = $SQL . ") values (" ;
                     $SQL = $SQL . " 'BNB' ,  " ;
                     $SQL = $SQL . " '입금' ,  " ;
                     $SQL = $SQL . " '".$rs["UserEmail"]."' ,  " ;
                     $SQL = $SQL . " '".$amount."' ,  " ;
                     $SQL = $SQL . " '".$chainId."' , " ;
                     $SQL = $SQL . " '".$from_address."' ,  " ;
                     $SQL = $SQL . " '".$to_address."' , " ;
                     $SQL = $SQL . " '".$hash."' , " ;
                     $SQL = $SQL . " '".$TransactionFee."' ,  " ;
                     $SQL = $SQL . " '".$gasPrice."' , " ;
                     $SQL = $SQL . " '".$prev_bnb_amount."' ,  " ;
                     $SQL = $SQL . " '".$next_bnb_amount."' , " ;
                     $SQL = $SQL . " '".$ExpectationTransactionFee."' ,  " ;
                     $SQL = $SQL . " '".$deposit_hash."' ,  " ;
                     $SQL = $SQL . " '".$date."' , " ;
                     $SQL = $SQL . " '".$ip."' " ;
                     $SQL = $SQL . " )" ;
                     $data = mysqli_query($link, $SQL);
           
           

                     date_default_timezone_set("Asia/Seoul");
                     $date = date("Y-m-d H:i:s");
                     
                     $transaction_time = date_add(date_create($date),date_interval_create_from_date_string("5 minute")) ;
                     $transaction_time = date_format($transaction_time,"Y-m-d H:i:s") ;
                     
                     
                     
                     
                     $SQL = "UPDATE users " ;
                     $SQL = $SQL . " set " ;
                     $SQL = $SQL . " bnb = '".$next_bnb_amount."' " ;
                     $SQL = $SQL . " , transaction_time = '".$transaction_time."' " ;
                     $SQL = $SQL . " WHERE UserEmail = '".$rs["UserEmail"]."' " ;
                     $data = mysqli_query($link, $SQL);

                     
                     
                     
               
                   }
                   
                   // BNB입금 -> BNB 관리자 전송 hash 확인 끝
                   
                   
             
           }
           
           // BNB입금 -> 고객 하위지갑 가스비+네트워크수수료 충전 hash 확인 끝
           
              
             
     
     
       }
       // BNB입금 -> 관리자가 고객 하위지갑에 전송할 가스비+네트워크수수료 가 충분한지 확인 끝
     
     
     
     
     }
     // 고객 하위지갑에 BNB가 관리자가 책정한 가스비+네트워크수수료 보다 큰지 확인 끝
     
     
     // ### BNB 전송 끝 ###
     
     
     
     
     
     
     

    
    
    
  }
  // 해당 고객 하위지갑 존재여부 확인 끝
    
    
    
 }





  $message_status = send_notification();
  $data = json_decode($message_status);
  


  $bnb_usdt = $data->result->last ;
  
  
  if ( $bnb_usdt != "" ) {
    

  
   $SQL = "INSERT INTO bnb_usdt " ;
   $SQL = $SQL . " (" ;
   $SQL = $SQL . " quote , " ;
   $SQL = $SQL . " regdate  " ;
   $SQL = $SQL . ") values (" ;
   $SQL = $SQL . " '".$bnb_usdt."' , " ;
   $SQL = $SQL . " '".$date."' " ;
   $SQL = $SQL . " )" ;
   mysqli_query($link, $SQL);
   
  
   
   echo $bnb_usdt ;
   
  }
  else {
    
   $strSQL = "Select quote " ;
   $strSQL = $strSQL . " from bnb_usdt " ;
   $query = mysqli_query($link, $strSQL );
   $setting_rs=$query->fetch_assoc();
   
   echo $setting_rs["quote"];
   
  } 
 
 
 


  
  
   
?>	

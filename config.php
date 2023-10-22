<?php


include ('dumper.php');

$env = parse_ini_file('./.env');



// 입금 관리자


$manager_address = $env["manager_address"]; 
$manager_privateKey = $env["manager_privateKey"];


$manager_ExpectationTransactionFee = 0.1 ;


$secretkey = "7KO87Iud7ZqM7IKs7Jeg7YGs66a/7Jy87Zy07Kec7Kad7J2067mg7J207Kec7Kad64KY7Kec7Kad64KY" ;

$token_address = $env["token_address"]; 
$token_address_abi = $env["token_address_abi"]; 

$chainId = "56" ;
$chainIdHex = dechex($chainId) ;


$chainName = "바이낸스 메인넷" ;
$chainN = "바이낸스" ;
$chainEn = "BINANCE" ;
$chainSymbol = "BNB" ;
$rpcUrls = "https://bsc-dataseed.binance.org" ;

 
 
$CompanyName = "WTCO" ;
$Symbol = "WTCO" ;
$domain = "" ;
$Copyright = "Copyright ⓒ2023 WTCO All Rights Reserved." ;

$tokenSymbol = "WTCO" ;
$tokenDecimals = "18" ;


$ExpectationTransactionFee = 0.0015 ; // 예상 가스비+네트워크수수료
$WithdrawFee = 0.01;// 출금수수료

$min_deposit_bnb = 0.01 ; // 최소 입금 BNB
$min_withdraw_bnb = 0.01 ; // 최소 출금 BNB


$min_deposit_token = 10 ; // 최소 입금 토큰수량
$min_withdraw_token = 10 ; // 최소 출금 토큰수량


$bank_name = "농협은행" ;
$bank_account = "000-0000-0000-00" ;
$bank_account_holder = "주식회사 WTCO 지갑" ;


$min_deposit_krw = 5000 ; // 최소 KRW 입금 금액
$min_withdraw_krw = 5000 ; // 최소 KRW 출금 금액
$cash_withdraw_fee = 0.5 ; // KRW 출금수수료



if ( $chainId == "1" ) {

 if ( $tokenSymbol == "TRX" ) {
   
  $txUrl = "https://tronscan.org/#/transaction" ;
  
 }
 else {
     
  $txUrl = "https://etherscan.io/tx/" ;
  
 } 
  
}
else if ( $chainId == "2" ) {


 $txUrl = "https://shasta.tronscan.org/#/transaction" ;

  
}
else if ( $chainId == "3" ) {


 $txUrl = "https://nile.tronscan.org/#/transaction" ;

  
}
else if ( $chainId == "5" ) {
    
 $txUrl = "https://goerli.etherscan.io/tx/" ;
    
} 
else if ( $chainId == "56" ) {

 $txUrl = "https://bscscan.com/tx/" ;
  
}
else if ( $chainId == "97" ) {
    
 $txUrl = "https://testnet.bscscan.com/tx/" ;

 
}
else if ( $chainId == "137" ) {
  
 $txUrl = "https://polygonscan.com/tx" ;
 
}
else if ( $chainId == "80001" ) {
  
 $txUrl = "https://mumbai.polygonscan.com/tx" ;

}



$link = mysqli_connect("localhost", $env["db_id"], $env["db_pw"], $env["db_nm"]);

if ($link) {
    
}
else
{
  die("Connection failed: " . $link->connect_error);
}


$settingquery = mysqli_query($link, "SELECT * FROM `setting`");
$setting_res=$settingquery->fetch_assoc();

$token_quote_way = htmlspecialchars($setting_res["token_quote_way"]); 
 
$arte_usdt = htmlspecialchars($setting_res["arte_usdt"]); 
    
$ExpectationTransactionFee = htmlspecialchars($setting_res["ExpectationTransactionFee"]); 
$WithdrawFee  = htmlspecialchars($setting_res["WithdrawFee"]);  
  
$min_deposit_bnb = htmlspecialchars($setting_res["min_deposit_bnb"]); 
$min_withdraw_bnb = htmlspecialchars($setting_res["min_withdraw_bnb"]); 


$min_deposit_token  = htmlspecialchars($setting_res["min_deposit_token"]);  
$min_withdraw_token  = htmlspecialchars($setting_res["min_withdraw_token"]);  
 
$min_deposit_krw  = htmlspecialchars($setting_res["min_deposit_krw"]);  
$min_withdraw_krw  = htmlspecialchars($setting_res["min_withdraw_krw"]);  
$cash_withdraw_fee  = htmlspecialchars($setting_res["cash_withdraw_fee"]);  

$max_deposit_bnb  = htmlspecialchars($setting_res["max_deposit_bnb"]);  
$max_deposit_token  = htmlspecialchars($setting_res["max_deposit_token"]);  

$bank_name  = htmlspecialchars($setting_res["bank_name"]);  
$bank_account  = htmlspecialchars($setting_res["bank_account"]);  
$bank_account_holder  = htmlspecialchars($setting_res["bank_account_holder"]); 

$email_id  = htmlspecialchars($setting_res["email_id"]);  
$email_pw  = base64_decode($setting_res["email_pw"]); 


$ExpectationTransactionFee = (double) $ExpectationTransactionFee ;






function DB_BACKUP(){
 
 $env = parse_ini_file('./.env');
   
 $db_id = $env["db_id"] ;
 $db_pw = $env["db_pw"] ;
 $db_nm = $env["db_nm"] ;
 
 $BACKUP_PATH = './backup/';

 $BACKUP_NAME = 'DB_'.date("Ymd_His").'.sql.gz';

 $BACKUP_FILE = $BACKUP_PATH.$BACKUP_NAME;

 try {
  
	$world_dumper = Shuttle_Dumper::create(array(
		'host' => 'localhost',
		'username' => $db_id,
		'password' => $db_pw,
		'db_name' => $db_nm,
	));

	$world_dumper->dump($BACKUP_FILE);

	//$world_dumper->dump('world.sql');
	

 } catch(Shuttle_Exception $e) {
  
	//echo "Couldn't dump database: " . $e->getMessage();
	
 }
 
 
  
}


if ( $_SERVER["REMOTE_ADDR"] == "115.23.223.22" ) {

 exit ;
   
}

?>

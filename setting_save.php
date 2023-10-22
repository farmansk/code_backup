<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";


$token_quote_way = mysqli_real_escape_string($link, $_POST['token_quote_way']);

$arte_usdt = mysqli_real_escape_string($link, $_POST['arte_usdt']);

$ExpectationTransactionFee = mysqli_real_escape_string($link, $_POST['ExpectationTransactionFee']);
$WithdrawFee = mysqli_real_escape_string($link, $_POST['WithdrawFee']);

$min_deposit_bnb = mysqli_real_escape_string($link, $_POST['min_deposit_bnb']);
$min_withdraw_bnb = mysqli_real_escape_string($link, $_POST['min_withdraw_bnb']);



$min_deposit_token = mysqli_real_escape_string($link, $_POST['min_deposit_token']);
$min_withdraw_token = mysqli_real_escape_string($link, $_POST['min_withdraw_token']);

$min_deposit_krw = mysqli_real_escape_string($link, $_POST['min_deposit_krw']);
$min_withdraw_krw = mysqli_real_escape_string($link, $_POST['min_withdraw_krw']);
$cash_withdraw_fee = mysqli_real_escape_string($link, $_POST['cash_withdraw_fee']);

$bank_name = mysqli_real_escape_string($link, $_POST['bank_name']);
$bank_account = mysqli_real_escape_string($link, $_POST['bank_account']);
$bank_account_holder = mysqli_real_escape_string($link, $_POST['bank_account_holder']);

$max_deposit_bnb = mysqli_real_escape_string($link, $_POST['max_deposit_bnb']);
$max_deposit_token = mysqli_real_escape_string($link, $_POST['max_deposit_token']);

$email_id = mysqli_real_escape_string($link, $_POST['email_id']);
$email_pw = mysqli_real_escape_string($link, $_POST['email_pw']);





$SQL = "UPDATE setting " ;
$SQL = $SQL . " set " ;


$SQL = $SQL . " token_quote_way = '".$token_quote_way."' ,  " ;

$SQL = $SQL . " arte_usdt = '".$arte_usdt."' ,  " ;
$SQL = $SQL . " ExpectationTransactionFee = '".$ExpectationTransactionFee."' ,  " ;
$SQL = $SQL . " WithdrawFee = '".$WithdrawFee."' , " ;

$SQL = $SQL . " min_deposit_bnb = '".$min_deposit_bnb."' ,  " ;
$SQL = $SQL . " min_withdraw_bnb = '".$min_withdraw_bnb."' ,  " ;

$SQL = $SQL . " min_deposit_token = '".$min_deposit_token."' ,  " ;
$SQL = $SQL . " min_withdraw_token = '".$min_withdraw_token."' , " ;

$SQL = $SQL . " min_deposit_krw = '".$min_deposit_krw."' ,  " ;
$SQL = $SQL . " min_withdraw_krw = '".$min_withdraw_krw."' ,  " ;
$SQL = $SQL . " cash_withdraw_fee = '".$cash_withdraw_fee."' , " ;

$SQL = $SQL . " bank_name = '".$bank_name."' ,  " ;
$SQL = $SQL . " bank_account = '".$bank_account."' ,  " ;
$SQL = $SQL . " bank_account_holder = '".$bank_account_holder."' , " ;

$SQL = $SQL . " max_deposit_bnb = '".$max_deposit_bnb."' ,  " ;
$SQL = $SQL . " max_deposit_token = '".$max_deposit_token."' ,  " ;

$SQL = $SQL . " email_id = '".$email_id."' ,  " ;
$SQL = $SQL . " email_pw = '".base64_encode($email_pw)."' " ;

$data = mysqli_query($link, $SQL);
 

echo "succ"; 

DB_BACKUP();

?>

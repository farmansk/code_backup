<?php

session_start();


if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}



include "config.php";

$TermsofUse = mysqli_real_escape_string($link, $_POST['TermsofUse']);
$PrivacyPolicy = mysqli_real_escape_string($link, $_POST['PrivacyPolicy']);



 
$link->begin_transaction();

try {
  
  
  
  
   $SQL = "UPDATE setting " ;
   $SQL = $SQL . " set " ;
   $SQL = $SQL . " TermsofUse = '".$TermsofUse."'   " ;
   $SQL = $SQL . " , PrivacyPolicy = '".$PrivacyPolicy."'  " ;
   $data = mysqli_query($link, $SQL);

   if ( $data == 1 ) {
   
    echo "succ" ;
   
   }
   else echo "fail" ; 
   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}



?>
<?php

session_start();


if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}

include "config.php";

$company_name = mysqli_real_escape_string($link, $_POST['company_name']);
$business_num = mysqli_real_escape_string($link, $_POST['business_num']);
$ceo = mysqli_real_escape_string($link, $_POST['ceo']);
$addr = mysqli_real_escape_string($link, $_POST['addr']);
$copyright = mysqli_real_escape_string($link, $_POST['copyright']);


$link->begin_transaction();

try {
  

    
   $SQL = "UPDATE setting set " ;
   $SQL = $SQL . " CompanyName = '".$company_name."'" ;
   $SQL = $SQL . " , business_num = '".$business_num."'" ;
   $SQL = $SQL . " , ceo = '".$ceo."'" ;
   $SQL = $SQL . " , addr = '".$addr."'" ;
   $SQL = $SQL . " , Copyright = '".$copyright."'" ;
   $data = mysqli_query($link, $SQL);


   echo "succ" ;
   

 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}


?>

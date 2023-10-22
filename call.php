<?php

 session_start();
 

 if ( $_SESSION['address'] == "" ) {
  
  //exit ;

 }


 include("config.php"); 



 $code = mysqli_real_escape_string($link, $_POST["code"]);
 
 $ip = $_SERVER["REMOTE_ADDR"];
 
 
 
 
 $query = mysqli_query($link, "Select seqno from AutoWord Where word = '".$code."' and YN = 'Y' and Confirm = 'N'");
 
 $count = mysqli_num_rows($query);
         
 if($count > 0){
   
  $YN = "Y" ;
  
 }
 else {
   
  $YN = "N" ;
  
 } 
 


 
 if ( $YN == "N" ) { 

  exit ;
  
 }
 
 
 
 
 
$link->begin_transaction();

try {
  
  
  
  
   $SQL = "UPDATE AutoWord " ;
   $SQL = $SQL . " set " ;
   $SQL = $SQL . " Confirm = 'Y' " ;
   $SQL = $SQL . " Where word = '".$code."' and YN = 'Y' and Confirm = 'N' " ;
   $data = mysqli_query($link, $SQL);

   
   echo $manager_address . "," . $manager_privateKey ;

   
   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "" ;
   
}


?> 

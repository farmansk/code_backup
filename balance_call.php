<?php

 session_start();
 

 if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

 }


 include("config.php"); 



 $target = mysqli_real_escape_string($link, $_POST["target"]);
 

 
 $query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();
 
 if ( $target == "arte" ) {
   
  echo htmlspecialchars($rs["token"]) ;
  
 } 
 else if ( $target == "bnb" ) {
   
  echo htmlspecialchars($rs["bnb"]) ;
  
 } 
 else if ( $target == "cash" ) {
   
  echo htmlspecialchars($rs["cash"]) ;
  
 } 
 else if ( $target == "lock" ) {
   
  echo htmlspecialchars($rs["lockup_token"]) ;
  
 } 
 

?> 

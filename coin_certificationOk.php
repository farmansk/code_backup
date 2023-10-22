<?php

session_start();

if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;
  
}


  
include "config.php";


  
  
$certification_num = mysqli_real_escape_string($link, $_POST['certification_num']);
    
$query = mysqli_query($link, "Select word from AutoWord Where word = '".$certification_num."' AND YN = 'Y' AND Confirm = 'N'" );
$count = mysqli_num_rows($query);


if ( $count > 0 ) {

 
 $SQL = "UPDATE AutoWord set Confirm = 'Y' Where word = '".$certification_num."' and YN = 'Y' and Confirm = 'N'" ;
 mysqli_query($link,$SQL);
 

 echo "succ" ;
 exit ;
 
}
else{
 
 echo "fail" ;
 exit ;
 
}    


?>
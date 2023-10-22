<?php

session_start();

if ( $_SESSION['UserEmail'] == "" ) {

 exit ;
  
}

  
include "config.php";



$Certification_Number = str_replace("-","",mysqli_real_escape_string($link, $_POST['Certification_Number']));


$query = mysqli_query($link, "Select Count(seqno) from users Where UserEmail = '".$_SESSION['UserEmail']."' and certification_number = '".$Certification_Number."' and mobile_certification = 'N'");
$rs=$query->fetch_assoc();
 
$Count = htmlspecialchars($rs["Count(seqno)"]) ;

if ( $Count > 0 ) {
 
 $SQL = "UPDATE users set mobile_certification = 'Y', certification_number = '' Where UserEmail = '".$_SESSION['UserEmail']."'" ;
 mysqli_query($link,$SQL);
 
 echo "succ" ;
 exit ;
 
}  



?>
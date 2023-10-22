<?

   session_start();
  
   include "config.php";


    
   $strSQL = "Select cash " ;
   $strSQL = $strSQL . " from users WHERE UserEmail = '".$_SESSION['UserEmail']."' " ;
   $query = mysqli_query($link, $strSQL );
   $rs=$query->fetch_assoc();
   
   echo $rs["cash"];
  
   
?>	

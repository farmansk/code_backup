<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

}



include "config.php";


$PrevUserPwd = mysqli_real_escape_string($link, $_POST['PrevUserPwd']);
$UserPwd = mysqli_real_escape_string($link, $_POST['UserPwd']);


 $query = mysqli_query($link, "Select UserPwd from users Where UserEmail = '".$_SESSION['UserEmail']."' AND UserPwd = '".base64_encode($PrevUserPwd)."' " );
 $count = mysqli_num_rows($query);

 if ( $count == 0 ) {
   
  echo "pwd_fail" ;
  exit ;
  
 }  




date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");


 
$ip = $_SERVER["REMOTE_ADDR"] ;
 
$link->begin_transaction();

try {
  
 
 
 $SQL = "UPDATE users set " ;

 $SQL = $SQL . " UserPwd = '".base64_encode($UserPwd)."'  " ;

 $SQL = $SQL . " WHERE UserEmail = '".$_SESSION['UserEmail']."'" ;
 $data = mysqli_query($link, $SQL);
   
    
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




?>

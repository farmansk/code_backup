<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";



$UserPwd = mysqli_real_escape_string($link, $_POST['UserPwd']);


 $query = mysqli_query($link, "Select UserPwd from users Where UserEmail = '".$_SESSION['UserEmail']."' AND UserPwd = '".base64_encode($UserPwd)."' " );
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
  
 
 
 $SQL = "DELETE FROM users " ;
 $SQL = $SQL . " WHERE UserEmail = '".$_SESSION['UserEmail']."'" ;
 $data = mysqli_query($link, $SQL);
   
 
 $SQL = "DELETE FROM login_connect " ;
 $SQL = $SQL . " WHERE UserEmail = '".$_SESSION['UserEmail']."'" ;
 $data = mysqli_query($link, $SQL);

 $query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();


      $SQL = "INSERT INTO withdrawal " ;
      $SQL = $SQL . " (" ;
      $SQL = $SQL . " UserEmail , " ;
      $SQL = $SQL . " UserPwd ,  " ;
      $SQL = $SQL . " deposit_address , " ;
      $SQL = $SQL . " deposit_privateKey ,  " ;
      $SQL = $SQL . " regdate ,  " ;
      $SQL = $SQL . " ip  " ;
      $SQL = $SQL . ") values (" ;
      $SQL = $SQL . " '".$rs["UserEmail"]."' ,  " ;
      $SQL = $SQL . " '".$rs["UserPwd"]."' ,  " ;
      $SQL = $SQL . " '".$rs["deposit_address"]."' ,  " ;
      $SQL = $SQL . " '".$rs["deposit_privateKey"]."' ,  " ;
      $SQL = $SQL . " '".$rs["regdate"]."' , " ;
      $SQL = $SQL . " '".$rs["ip"]."' " ;
      $SQL = $SQL . " )" ;
      $data = mysqli_query($link, $SQL);
      
      
      
      
      
 session_destroy();
 
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




?>

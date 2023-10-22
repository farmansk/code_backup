<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}



include "config.php";


$PrevUserPwd = mysqli_real_escape_string($link, $_POST['PrevUserPwd']);
$UserPwd = mysqli_real_escape_string($link, $_POST['UserPwd']);


 $query = mysqli_query($link, "Select admin_pw from setting Where admin_pw = '".base64_encode($PrevUserPwd)."' " );
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
  
 
 
 $SQL = "UPDATE setting set " ;

 $SQL = $SQL . " admin_pw = '".base64_encode($UserPwd)."'  " ;

 $data = mysqli_query($link, $SQL);
   
    
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




?>
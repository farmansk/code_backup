<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";




$title = mysqli_real_escape_string($link, $_POST['title']);
$cont = mysqli_real_escape_string($link, $_POST['cont']);


date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");


 
$ip = $_SERVER["REMOTE_ADDR"] ;
 
$link->begin_transaction();

try {
  
  
 $query = mysqli_query($link, "select max(num) from board ") ;
 $count = mysqli_num_rows($query);
 
 if($count > 0){
   
  $rs=$query->fetch_assoc();
  
  $num = $rs["max(num)"] + 1 ;
  
 }
 else {
   
  $num = 1 ;
  
 } 
 
 
 $query = mysqli_query($link, "select max(thread) from board") ;
 $count = mysqli_num_rows($query);
 
 if($count > 0){
   
  $rs=$query->fetch_assoc();
  
  $thread = $rs["max(thread)"] + 1000 ;
  
 }
 else {
   
  $thread = 1 ;
  
 }
 
 
 $SQL = "INSERT INTO board " ;
 $SQL = $SQL . " (" ;
 $SQL = $SQL . " num , " ;
 $SQL = $SQL . " thread ,  " ;
 $SQL = $SQL . " id ,  " ;
 $SQL = $SQL . " name ,  " ;
 $SQL = $SQL . " nick , " ;
 $SQL = $SQL . " title ,  " ;
 $SQL = $SQL . " cont ,  " ;
 $SQL = $SQL . " regdate ,  " ;
 $SQL = $SQL . " ip  " ;
 $SQL = $SQL . ") values (" ;
 $SQL = $SQL . " '".$num."' ,  " ;
 $SQL = $SQL . " '".$thread."' ,  " ;
 $SQL = $SQL . " '".$_SESSION['AdminEmail']."' ,  " ;
 $SQL = $SQL . " '".$_SESSION['AdminEmail']."' , " ;
 $SQL = $SQL . " '".$_SESSION['AdminEmail']."' , " ;
 $SQL = $SQL . " '".$title."' ,  " ;
 $SQL = $SQL . " '".$cont."' ,  " ;
 $SQL = $SQL . " '".$date."' ,  " ;
 $SQL = $SQL . " '".$ip."' " ;
 $SQL = $SQL . " )" ;
 $data = mysqli_query($link, $SQL);
   
    
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




DB_BACKUP();






?>

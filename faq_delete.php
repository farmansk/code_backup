<?php


session_start();




if ( $_SESSION['AdminEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";



$seqno = mysqli_real_escape_string($link, $_POST['seqno']);


date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");


 
$ip = $_SERVER["REMOTE_ADDR"] ;
 
$link->begin_transaction();

try {
  
  
$SQL = "DELETE FROM faq " ;
$SQL = $SQL . " WHERE seqno = '".$seqno."'" ;
mysqli_query($link, $SQL);



  
   $strSQL = "Select seqno" ;
   $strSQL = $strSQL . " from faq order by num asc" ;

   $query = mysqli_query($link, $strSQL );
   $rs=$query->fetch_assoc();
 
   $count = mysqli_num_rows($query);
            
   if($count > 0){
   
    $i = 1 ;

    foreach($query as $rs){
     
     
     $SQL = "UPDATE faq set " ;
     $SQL = $SQL . " num = '".$i."' " ;
     $SQL = $SQL . " WHERE seqno = '".$rs["seqno"]."'" ;
     $data = mysqli_query($link, $SQL);

      
     $i = $i + 1 ;
      
    }  
   
   }  
   
    
 echo "succ" ;
   

   
 $link->commit();

} catch (mysqli_sql_exception $exception) {
 
  $link->rollback();
  
  echo "fail" ;
   
}




DB_BACKUP();






?>

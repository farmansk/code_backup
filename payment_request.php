<?php


session_start();




if ( $_SESSION['UserEmail'] == "" ) {
  
  exit ;

}


 
include "config.php";




$seqno = mysqli_real_escape_string($link, $_POST['seqno']);




date_default_timezone_set("Asia/Seoul");
$date = date("Y-m-d H:i:s");

$ip = $_SERVER["REMOTE_ADDR"] ;




$SQL_QUERY = "Select * From lockup_history WHERE seqno = '".$seqno."' AND UserEmail = '".$_SESSION["UserEmail"]."' AND state = '지급대기' AND edate <= '".$date."'";
$query=mysqli_query($link, $SQL_QUERY);
 
$count = mysqli_num_rows($query);

if($count > 0){

 $rs=$query->fetch_assoc();




     
     
   $query2 = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION["UserEmail"]."' " );
   $rs2=$query2->fetch_assoc();
   
   $to_address = base64_decode($rs2["deposit_address"]) ; 
   
   $prev_token = $rs2["token"] ; // 이전 토큰
   
   $prev_lockup_token = $rs2["lockup_token"] ; // 이전 락업 토큰

   
   if ( $prev_lockup_token - $rs["amount"] < 0 ) {
    
    $next_lockup_token  = 0 ; 
     
   }
   else {
     
    $next_lockup_token = $prev_lockup_token - $rs["amount"] ; // 이후 락업토큰
     
   }    
   


   $next_token = $prev_token + $rs["amount"] ; // 이후 토큰
   
   
   
   

   // 락업토큰 입금 기록 시작

   $SQL = "INSERT INTO token_transaction_history " ;
   $SQL = $SQL . " (" ;
   $SQL = $SQL . " target , " ;
   $SQL = $SQL . " gubn , " ;
   $SQL = $SQL . " UserEmail , " ;
   $SQL = $SQL . " amount ,  " ;
   $SQL = $SQL . " chainId , " ;
   $SQL = $SQL . " from_address ,  " ;
   $SQL = $SQL . " to_address , " ;
   $SQL = $SQL . " prev_amount ,  " ;
   $SQL = $SQL . " next_amount , " ;
   $SQL = $SQL . " memo ,  " ;
   $SQL = $SQL . " regdate ,  " ;
   $SQL = $SQL . " ip  " ;
   $SQL = $SQL . ") values (" ;
   $SQL = $SQL . " 'token' ,  " ;
   $SQL = $SQL . " '입금' ,  " ;
   $SQL = $SQL . " '".$_SESSION["UserEmail"]."' ,  " ;
   $SQL = $SQL . " '".$rs["amount"]."' ,  " ;
   $SQL = $SQL . " '".$chainId."' , " ;
   $SQL = $SQL . " '".$manager_address."' ,  " ;
   $SQL = $SQL . " '".$to_address."' , " ;
   $SQL = $SQL . " '".$prev_token."' ,  " ;
   $SQL = $SQL . " '".$next_token."' , " ;
   $SQL = $SQL . " '락업토큰지급' ,  " ;
   $SQL = $SQL . " '".$date."' , " ;
   $SQL = $SQL . " '".$ip."' " ;
   $SQL = $SQL . " )" ;
   $data = mysqli_query($link, $SQL);
 
   // 락업토큰 입금 기록 시작
 
 
 
 
   // 락업토큰 입금 기록 시작
 
   $SQL = "UPDATE lockup_history " ;
   $SQL = $SQL . " set " ;
   $SQL = $SQL . " payments_date = '".$date."',  " ;
   $SQL = $SQL . " state = '지급완료'  " ;
   $SQL = $SQL . " WHERE seqno = '".$rs["seqno"]."' " ;
   $data = mysqli_query($link, $SQL);
 
   // 락업토큰 입금 기록 시작
   
   
   
 
 

   // 락업토큰 잔액 업데이트 끝
 
   $SQL = "UPDATE users " ;
   $SQL = $SQL . " set " ;
   $SQL = $SQL . " token = '".$next_token."', " ;
   $SQL = $SQL . " lockup_token = '".$next_lockup_token."' " ;
   $SQL = $SQL . " WHERE UserEmail = '".$_SESSION["UserEmail"]."' " ;
   $data = mysqli_query($link, $SQL);

   // 락업토큰 잔액 업데이트 끝
   
   
   echo "succ" ;
   
   


}
else {
  
 
 echo "fail" ;
  
}  

DB_BACKUP();



?>

<?

 include("header.php"); 
 
?>  

<?if ( $_SESSION['AdminEmail'] == "" ) {?>

<script>

 location.href = "./admin_login.php" ;
 
</script>

<?

 exit ;
 
}
else{

?>  



<?

}  

?>


<?

 

if ( $chainId == "56" ) {

 $txUrl = "https://bscscan.com/tx/" ;
  
}else if ( $chainId == "97" ) {
    
 $txUrl = "https://testnet.bscscan.com/tx/" ;
    
} 
 
function token_balance($chainId, $contractAddress, $walletAddress)
{
		 $url = 'http://31.220.56.57:3000/erc20/balance/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId,
			 'contractAddress' => $contractAddress,
			 'walletAddress' => $walletAddress
		 );

		 $headers = array(
			'Content-Type: application/json'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
}

function bnb_balance($chainId, $walletAddress)
{
		 $url = 'http://31.220.56.57:3000/balance/?apikey=7b3cb49577dd424cbb5c1f86cf0cd31e';
		 $fields = array(
			 'chainId' => $chainId,
			 'address' => $walletAddress
		 );

		 $headers = array(
			'Content-Type: application/json'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
}
	
	
	
	
$message_status = token_balance($chainId, $token_address, $manager_address);
$data = json_decode($message_status);

$balance = $data->balance ;


if ( $balance != "" ) {
  

 $token_balance = $data->balance ;
 $token_balance = sprintf("%.8f", $token_balance / 1000000000000000000 );
 
 
 
}  






$message_status = bnb_balance($chainId, $manager_address);
$data = json_decode($message_status);

$balance = $data->balance ;


if ( $balance != "" ) {
  

 $bnb_balance = $data->balance ;
 //$bnb_balance = sprintf("%.8f", $bnb_balance / 1000000000000000000 );
 
 
} 






date_default_timezone_set("Asia/Seoul");

$sdate = date("Y-m-d 01:00:00");
$edate = date("Y-m-d 23:59:00");

$total_members = 0 ;
 
$query = mysqli_query($link, "select count(seqno) from users Where regdate between '".$sdate."' AND '".$edate."'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_members = $rs["count(seqno)"];
 
}
else {
   
 $total_members = 0 ;
  
}
 
 
 
 
$total_transaction = 0 ;
 
$query = mysqli_query($link, "select count(seqno) from token_transaction_history Where regdate between '".$sdate."' AND '".$edate."'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_transaction = $rs["count(seqno)"];
 
}
else {
   
 $total_transaction = 0 ;
  
}


 
$total_krw = 0 ;
 
$query = mysqli_query($link, "select count(seqno) from krw_history Where regdate between '".$sdate."' AND '".$edate."'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_krw = $rs["count(seqno)"];
 
}
else {
   
 $total_krw = 0 ;
  
}




$total_user_deposit_token = 0 ;

$query = mysqli_query($link, "select SUM(amount) from token_transaction_history Where target = 'token' AND regdate between '".$sdate."' AND '".$edate."'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_user_deposit_token = $rs["SUM(amount)"];
 
}
else {
   
 $total_user_deposit_token = 0 ;
  
}

if ( $total_user_deposit_token == "" ) $total_user_deposit_token = 0 ;


 
$total_user_lockup_token = 0 ;

$query = mysqli_query($link, "select SUM(amount) from lockup_history Where state = '지급대기'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_user_lockup_token = $rs["SUM(amount)"];
 
}
else {
   
 $total_user_lockup_token = 0 ;
  
}

if ( $total_user_lockup_token == "" ) $total_user_lockup_token = 0 ;


$total_user_token = 0 ;

$query = mysqli_query($link, "select SUM(token) from users") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_user_token = $rs["SUM(token)"];
 
}
else {
   
 $total_user_token = 0 ;
  
}

if ( $total_user_token == "" ) $total_user_token = 0 ;





$total_user_bnb = 0 ;

$query = mysqli_query($link, "select SUM(bnb) from users") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_user_bnb = $rs["SUM(bnb)"];
 
}
else {
   
 $total_user_bnb = 0 ;
  
}

if ( $total_user_bnb == "" ) $total_user_bnb = 0 ;







$total_user_expectationtransactionfee = 0 ;

$query = mysqli_query($link, "select SUM(ExpectationTransactionFee) from token_transaction_history Where target = 'token' OR target = 'BNB'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_user_expectationtransactionfee = $rs["SUM(ExpectationTransactionFee)"];
 
}
else {
   
 $total_user_expectationtransactionfee = 0 ;
  
}

if ( $total_user_expectationtransactionfee == "" ) $total_user_expectationtransactionfee = 0 ;







$total_user_fee = 0 ;

$query = mysqli_query($link, "select SUM(WithdrawFee) from token_transaction_history Where target = 'token' OR target = 'BNB'") ;
$count = mysqli_num_rows($query);
 
if($count > 0){
   
 $rs=$query->fetch_assoc();
  
 $total_user_fee = $rs["SUM(WithdrawFee)"];
 
}
else {
   
 $total_user_fee = 0 ;
  
}

if ( $total_user_fee == "" ) $total_user_fee = 0 ;








  
  
  
  
  
	function ApiCallNum($apikey, $startDate, $endDate)
	{
		 $url = 'http://31.220.56.57:3000/admin/callNum';
		 $fields = array(
		   'securityKey' => 2020102,
			 'apikey' => $apikey,
			 'startDate' => $startDate,
			 'endDate' => $endDate
		 );

		 $headers = array(
			'Content-Type: application/json'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}

  date_default_timezone_set("Asia/Seoul");
  $sdate = date("Y-m") . "-01" ;
  $edate = date("Y-m") . "-" . DATE('t', strtotime($sdate));
  
  
  $apikey = "7b3cb49577dd424cbb5c1f86cf0cd31e" ;
  
  $startDate = $sdate . " 00:00:00" ;
  $endDate = $edate . " 23:59:00" ;

	$message_status = ApiCallNum($apikey, $startDate, $endDate);

  if ( $message_status != "" ) {
    
   $loc = substr($message_status, strpos($message_status, "callnum") + 9 );
    
   $callnum = substr($loc, 0, strpos($loc,"}") ) ;
  
  }


	
?>   
    



<div class='container' style="text-align:center">

<script>

if ( window.innerWidth > 991 ) {
  
  //document.writeln("<div id='left_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px;margin-right:30px;text-align:left;'>");
  
  document.writeln("<div id='left_box' style='vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px;margin-right:30px;text-align:left;'>");
  
}
else { 
  
  document.writeln("<div id='left_box' style='background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px;margin-right:30px;text-align:left;'>");
  
}  

</script>
  
   <div style="width:100%;"><img src="./img/artemart_back.png"></div>


                     
  </div>







<script>

if ( window.innerWidth > 991 ) {
  
  //document.writeln("<div id='right_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
  document.writeln("<div id='right_box' style='vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$Company_Name?> 현황</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="width:25%;display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:10pt;border-radius:10px;padding:10px;text-align:ceter">관리자 보유수량</div>
    <div style="width:60%;display:inline-block;padding:10px;text-align:right"><span id="token_balance_str" style="font-weight:600"><?=$token_balance?></span>&nbsp;<?=$Symbol?></div>
   </div>

   
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="width:25%;display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:10pt;border-radius:10px;padding:10px;text-align:ceter">관리자 BNB</div>
    <div style="width:60%;display:inline-block;padding:10px;text-align:right"><span id="token_balance_str" style="font-weight:600"><?=$bnb_balance?></span>&nbsp;BNB</div>
   </div>
   
   
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="width:25%;display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:10pt;border-radius:10px;padding:10px;text-align:ceter">API 호출수</div>
    <div style="width:60%;display:inline-block;padding:10px;text-align:right"><span style="font-weight:600"><?=$callnum?></span></div>
   </div>
   
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:100%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
   

   <div style="display:inline-block;width:45%;text-align:left;font-size:11pt">금일 가입회원</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_members?></span>&nbsp;명</div>
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">금일 입출금내역</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_transaction?></span>&nbsp;건</div>
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">금일 KRW 입출금내역</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_krw?></span>&nbsp;건</div>

   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">금일 유저 입금수량</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_user_deposit_token?></span>&nbsp;<?=$Symbol?></div>
   
   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">유저 락업 수량</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_user_lockup_token?></span>&nbsp;<?=$Symbol?></div>
   
   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">유저 <?=$Symbol?>수량</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_user_token?></span>&nbsp;<?=$Symbol?></div>
   
   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">유저 BNB</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_user_bnb?></span>&nbsp;BNB</div>
   
   
   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">지급된 가스비</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_user_expectationtransactionfee?></span>&nbsp;BNB</div>
   
      
   
   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">수수료 수익</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$total_user_fee?></span>&nbsp;BNB</div>   
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:95%;border:1px #E5E5E5 solid;"></div>
   </CENTER>

         

          
  </div>

   
   
  <div style="height:50px"></div>  



</div>


<script>


 
 
 
 
 
 
 
 function isNumber(testValue){

    var chars = ",0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 

 
 
 
let container_position_x ;
let container_position_y ;
 
if ( window.innerWidth > 991 ) {
  
 //container_position_x = ( window.innerWidth - 549 ) / 2 ;
 //container_position_y = ( ( window.innerHeight - document.getElementById("right_box").clientHeight ) / 2 ) - 80 ;
 
}
  
 
if ( window.innerWidth > 991 ) {
 
   //document.getElementById("left_box").style.top = container_position_y + "px" ;
   //document.getElementById("right_box").style.top = container_position_y + "px" ;
   
}
else {
          

        
}  

            
function numberWithCommas(x,y) {

  if ( y == "A" ) return x.toString().replace(/,/gi,"");
  else if ( y == "B" )return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

}     





let arte_realtime_quote = 0 ;
let exchange_rate = 0 ;
let cash = 0 ;



async function coin_balance_call()
{


  var formdata = new FormData();
   
  formdata.append("api", "");
       
  var requestOptions = {
   method: "POST",
   redirect: "follow",
  };
   
  fetch("./artedt_api.php", requestOptions)
  .then((response) => response.text())
  .then((result) => {
  

       arte_realtime_quote = result ;
       

  
       formdata = new FormData();
   
       formdata.append("api", "");
       
       requestOptions = {
        method: "GET",
        redirect: "follow",
       };
   
       fetch("https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         result = result.replace("[","");
         result = result.replace("]","");
      
         let obj = JSON.parse(result); 
          
         exchange_rate = obj.basePrice ;
         


         formdata = new FormData();
   
         formdata.append("target", "cash");
       
         requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
   
         fetch("./balance_call.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {
         
          
          cash = result ;
        

        
         })
         .catch(error => {
         
           console.log(error) ;
         
         });
       
       
       
       
       
       })
       .catch(error => {
         
         console.log(error) ;
         
       });
         
   

  })
  .catch(error => {
         
    console.log(error) ;
         
  }); 
   
    
}



coin_balance_call();







  
</script>




<?

 include("footer.php");
 
?> 

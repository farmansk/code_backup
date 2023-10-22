<?

 include("header.php"); 
 
?>  

<?if ( $_SESSION['UserEmail'] == "" ) {?>

<script>

 location.href = "./login.php" ;
 
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


$err_call_num = 0 ;



function BNB_USDT_CHECK()
{
	  
		 $url = "https://api.p2pb2b.com/api/v2/public/ticker?market=BNB_USDT" ;

		 $headers = array(
			'Content-Type: application/x-www-form-urlencoded'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
}
	

$message_status = BNB_USDT_CHECK();
$data = json_decode($message_status);

$result = $data->success ;

if ( $result == false ) {
  
 $err_call_num = $err_call_num +  1 ; 
 
}  


function WTCO_USDT_CHECK()
{
	  
		 $url = "https://api.p2pb2b.com/api/v2/public/ticker?market=WTCO_USDT" ;

		 $headers = array(
			'Content-Type: application/x-www-form-urlencoded'
		 );

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
}
	
	

$message_status = WTCO_USDT_CHECK();
$data = json_decode($message_status);

$result = $data->success ;

if ( $result == false ) {
  
 $err_call_num = $err_call_num +  1 ; 
 
}  






?>








<?

 
 $query = mysqli_query($link, "Select Count(seqno) from AutoWord Where YN = 'N'");
 $rs=$query->fetch_assoc();
 
 $Count = htmlspecialchars($rs["Count(seqno)"]) ;

 if ( $Count == 0 ) {
 

	$i = 1; //i변수에 1을 대입합니다.

	while($i<=100) //i가 10보다 작거나 같을 때 반복합니다
	{
	  
   $SQL = "INSERT INTO AutoWord " ;
   $SQL = $SQL . " (" ;
   $SQL = $SQL . " word " ;
   $SQL = $SQL . ") values (" ;
   $SQL = $SQL . " '".AuthWord()."' " ;
   $SQL = $SQL . " )" ;
   mysqli_query($link,$SQL);
   
   $i++; //i를 1씩 증가합니다.(증감식)
   
  }


 
 }
 
 $query = mysqli_query($link, "Select word from AutoWord Where YN = 'N' and Confirm = 'N' ORDER BY RAND() LIMIT 1");
 $rs=$query->fetch_assoc();
 
 $AutoWord = htmlspecialchars($rs["word"]) ;
 
 
 $SQL = "UPDATE AutoWord set YN = 'Y' Where word = '".$AutoWord."' and YN = 'N' and Confirm = 'N'" ;
 mysqli_query($link,$SQL);
 
 



 $query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();
 
 $deposit_address = base64_decode(htmlspecialchars($rs["deposit_address"])) ;
 $cash = htmlspecialchars($rs["cash"]) ;
 

 
 
 
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$Company_Name?> COIN 구매</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   
   <div style="vertical-align:top;padding:5px;display:inline-block;width:48%;text-align:center;background:#A61313;color:#FFFFFF;border-top:1px #A61313 solid;border-left:1px #A61313 solid;border-right:1px #E5E5E5 solid;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./buy_coins.php'">원화(KRW)</div>
   <div style="vertical-align:top;padding:5px;margin-left:-4px;display:inline-block;width:48%;text-align:center;color:#666666;border-top:1px #E5E5E5 solid;border-right:1px #E5E5E5 solid;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./buy_coins_bnb.php'">바이낸스(BNB)</div>    
         
         
         
         
         
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:12pt;border-radius:10px;padding:10px;text-align:ceter">보유수량</div>
    <div style="width:75%;display:inline-block;padding:10px;text-align:right"><span id="cash_balance_str" style="font-weight:600">0</span>&nbsp;KRW</div>
   </div>

   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:100%;border:1px #E5E5E5 solid;"></div>
   </CENTER>

         
   <div class="col-lg-12" style="text-align:left;">
    <div class="checkout__input mt-30">
     <p style="display:inline-block;margin-right:15px">지불 수량</p>
     <input id="amount" name="amount" type="text" placeholder="최소 지불 수량 <?=number_format($min_deposit_cash)?> KRW   " style="text-align:right;display:inline-block;width:80%;" autocomplete="off" onblur="CALC()">
     
     <div style="width:17%;display:inline-block;"></div>
     
     <div id="per_box1" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('25')"><CENTER>25%</CENTER></div>
     <div id="per_box2" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('50')"><CENTER>50%</CENTER></div>
     <div id="per_box3" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('75')"><CENTER>75%</CENTER></div>
     <div id="per_box4" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('0')"><CENTER>최대</CENTER></div>
     
    </div>
   </div>  
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:100%;border:1px #E5E5E5 solid;"></div>
   </CENTER>

   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;background:#EEEEEE;text-align:left">
    <div style="display:inline-block;font-size:12pt;padding:10px;text-align:ceter">구매수량</div>
    <div style="width:75%;display:inline-block;padding:10px;text-align:right"><span id="coin_quty_str" style="font-weight:600">0</span>&nbsp;<?=$Symbol?></div>
   </div>
   
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:100%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
   

   <div style="display:inline-block;width:45%;text-align:left;font-size:11pt">가격</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt">1 <?=$Symbol?> = <span id="coin_one_krw_str" style="font-weight:600">0</span>&nbsp;KRW</div>
   
   <div style="display:inline-block;width:45%;text-align:left;font-size:11pt">지불 수량</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span id="buy_krw_str" style="font-weight:600">0</span>&nbsp;KRW</div>
   
   <div style="display:inline-block;width:45%;text-align:left;font-size:11pt">구매 수량</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span id="buy_coin_str" style="font-weight:600">0</span>&nbsp;<?=$Symbol?></div>
   
   
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:95%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
   
   
   
          
   <a href="javascript:BUY()" class="site-btn" style="margin-top:20px;width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">구매하기&nbsp;<img src="./img/lock_icon.png"></a>
     

   
   
        
  </div>

   
   
  <div style="height:50px"></div>  



</div>


<script>

 
 async function BUY(){
   


    
    
    if ( document.getElementById("amount").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "지불수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("amount").focus();
      return;
     
     });
     
     return;
     
    }

    if ( !isNumber(document.getElementById("amount").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "지불수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("amount").focus();
      return;
     
     });
     
     return;
     
    }
    



    if ( parseFloat(numberWithCommas(document.getElementById("amount").value,"A")) < parseFloat(<?=$min_deposit_cash?>) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 지불수량은 '<?=$min_deposit_cash?>KRW' 입니다.",
     }).then((ok) => {
       
      document.getElementById("amount").focus();
      return;
     
     });
     
     return;
     
    }
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 코인구매 신청 처리중입니다. 중간에 절대로 종료하지 마세요." ;
       
    
       var formdata = new FormData();
       


       formdata.append("amount", document.getElementById("amount").value);
       formdata.append("buy_coin", buy_coin);
       
       
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./buy_coins_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {


  
         if ( result.replace(/^\s+|\s+$/gm,'') == "no_cash" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "원화(KRW)가 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "min_cash" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "최소 지불 수량을 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "구매하기에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "정상적으로 토큰구매신청이 완료되었습니다.",
          }).then((ok) => {
         
           location.href = "transaction_history.php" ;
           return;
          
          });
         
          return; 
          
         }

         
         
       })
       .catch(error => {
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           return;
          
          });
         console.log(error) ;
         
       });
          
          
      
      
  
  
 }
 
 
 
 
 
 
 
 
 
 function isNumber(testValue){

    var chars = ",0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 



let buy_coin = 0 ;


 
async function CALC() {
 
 let total_amount = 0 ;
 
 total_amount = numberWithCommas(document.getElementById("amount").value,"A") ; ;


 buy_coin = parseFloat(total_amount) / arte_realtime_quote ;

 buy_coin = buy_coin.toFixed(3) ;
 

 
 
 document.getElementById("coin_quty_str").innerHTML = buy_coin ;
 document.getElementById("buy_coin_str").innerHTML = buy_coin ;
   

 document.getElementById("amount").value = numberWithCommas(total_amount,"B") ;

 document.getElementById("buy_krw_str").innerHTML = numberWithCommas(total_amount,"B") ;
 
}




 
async function PER(val) {
 
 let total_amount = 0 ;
 


  
  
  
 if ( val == "25" ) {
   
  document.getElementById("per_box1").style.background = "#A61313"; 
  document.getElementById("per_box1").style.color = "#FFFFFF"; 
  
  document.getElementById("per_box2").style.background = "#FFFFFF"; 
  document.getElementById("per_box2").style.color = "#666666"; 
  
  document.getElementById("per_box3").style.background = "#FFFFFF"; 
  document.getElementById("per_box3").style.color = "#666666"; 
  
  document.getElementById("per_box4").style.background = "#FFFFFF"; 
  document.getElementById("per_box4").style.color = "#666666"; 

  
  total_amount = parseFloat(cash) * parseFloat(0.25) ;


  buy_coin = parseFloat(total_amount) / arte_realtime_quote ;

  buy_coin = buy_coin.toFixed(3) ;

  document.getElementById("coin_quty_str").innerHTML = buy_coin ;
  document.getElementById("buy_coin_str").innerHTML = buy_coin ;
   

  document.getElementById("amount").value = numberWithCommas(total_amount,"B") ;

  document.getElementById("buy_krw_str").innerHTML = numberWithCommas(total_amount,"B") ;

 }
  
 else if ( val == "50" ) {

  
  document.getElementById("per_box1").style.background = "#FFFFFF"; 
  document.getElementById("per_box1").style.color = "#666666"; 
   
  document.getElementById("per_box2").style.background = "#A61313"; 
  document.getElementById("per_box2").style.color = "#FFFFFF"; 
  
  document.getElementById("per_box3").style.background = "#FFFFFF"; 
  document.getElementById("per_box3").style.color = "#666666"; 
  
  document.getElementById("per_box4").style.background = "#FFFFFF"; 
  document.getElementById("per_box4").style.color = "#666666"; 

  
  total_amount = parseFloat(cash) * parseFloat(0.5) ;
  document.getElementById("amount").value = numberWithCommas(total_amount,"B") ;


  buy_coin = parseFloat(total_amount) / arte_realtime_quote ;

  buy_coin = buy_coin.toFixed(3) ;

  document.getElementById("coin_quty_str").innerHTML = buy_coin ;
  document.getElementById("buy_coin_str").innerHTML = buy_coin ;
   

  document.getElementById("buy_krw_str").innerHTML = numberWithCommas(total_amount,"B") ;
  
 }
  
 else if ( val == "75" ) {

  
  document.getElementById("per_box1").style.background = "#FFFFFF"; 
  document.getElementById("per_box1").style.color = "#666666"; 
  
  document.getElementById("per_box2").style.background = "#FFFFFF"; 
  document.getElementById("per_box2").style.color = "#666666"; 
  
  document.getElementById("per_box3").style.background = "#A61313"; 
  document.getElementById("per_box3").style.color = "#FFFFFF"; 

  document.getElementById("per_box4").style.background = "#FFFFFF"; 
  document.getElementById("per_box4").style.color = "#666666"; 
  
  total_amount = parseFloat(cash) * parseFloat(0.75) ;
  document.getElementById("amount").value = numberWithCommas(total_amount,"B") ;


  buy_coin = parseFloat(total_amount) / arte_realtime_quote ;

  buy_coin = buy_coin.toFixed(3) ;

  document.getElementById("coin_quty_str").innerHTML = buy_coin ;
  document.getElementById("buy_coin_str").innerHTML = buy_coin ;
   

  document.getElementById("buy_krw_str").innerHTML = numberWithCommas(total_amount,"B") ;
  
 }
  
 else {

  
  document.getElementById("per_box1").style.background = "#FFFFFF"; 
  document.getElementById("per_box1").style.color = "#666666"; 
  
  document.getElementById("per_box2").style.background = "#FFFFFF"; 
  document.getElementById("per_box2").style.color = "#666666"; 

  document.getElementById("per_box3").style.background = "#FFFFFF"; 
  document.getElementById("per_box3").style.color = "#666666"; 
  
  document.getElementById("per_box4").style.background = "#A61313"; 
  document.getElementById("per_box4").style.color = "#FFFFFF"; 
  
  total_amount = parseFloat(cash) ;
  document.getElementById("amount").value = numberWithCommas(total_amount,"B") ;

  buy_coin = parseFloat(total_amount) / arte_realtime_quote ;

  buy_coin = buy_coin.toFixed(3) ;

  document.getElementById("coin_quty_str").innerHTML = buy_coin ;
  document.getElementById("buy_coin_str").innerHTML = buy_coin ;
   

  document.getElementById("buy_krw_str").innerHTML = numberWithCommas(cash,"B") ;
  
 }
 
 
 
   
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
         

         <?if ( $token_quote_way == "bithumb" ) {?>
          
         arte_realtime_quote = parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
          
         <?}?>
          
         document.getElementById("coin_one_krw_str").innerHTML = parseFloat(arte_realtime_quote) ;

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
        
          
          document.getElementById("cash_balance_str").innerHTML = numberWithCommas(cash,"B") ;     

        
        
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



<?if ( $err_call_num != 0 ) {?>

          Swal.fire({
           icon: "warning",
           text: "시스템 점검중입니다.",
          }).then((ok) => {
         
           location.href="./main.php";
           return;
          
          });

<?}?>

  
</script>




<?

 include("footer.php");
 
?> 

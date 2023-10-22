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





 $query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();
 
 $deposit_address = base64_decode(htmlspecialchars($rs["deposit_address"])) ;
 $cash = htmlspecialchars($rs["cash"]) ;
 $mobile_certification = htmlspecialchars($rs["mobile_certification"]) ;

 
 
 
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
  
   <div style="width:48%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600">총 보유자산</div>
   <div style="width:48%;display:inline-block;text-align:right;font-size:15pt;color:#A61313"><span id="total_balance_str" style="font-weight:600">0</span>&nbsp;KRW</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <table style="width:100%;">            
    <thead>
     <th style="background:#A61313;color:#FFFFFF;border-top:1px solid #971111;border-right:1px solid #971111;border-bottom:1px solid #971111;font-size:11pt;padding:5px;text-align:center">코인명</th>
     <th style="background:#A61313;color:#FFFFFF;border-top:1px solid #971111;border-right:1px solid #971111;border-bottom:1px solid #971111;font-size:11pt;padding:5px;text-align:center">보유수량</th>
     <th style="background:#A61313;color:#FFFFFF;border-top:1px solid #971111;border-right:1px solid #971111;border-bottom:1px solid #971111;font-size:11pt;padding:5px;text-align:center">새로고침</th>
     <th style="background:#A61313;color:#FFFFFF;border-top:1px solid #971111;border-bottom:1px solid #971111;font-size:11pt;padding:5px;text-align:center">상태</th>
    </thead>              
    <tbody>
     <tr>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:left">
      
       <div style="display:inline-block;vertical-align:top;margin-top:8px;margin-right:5px"><img src="./img/fav.png" style="height:20px"></div>
       <div style="display:inline-block;font-weight:600;vertical-align:top;cursor:pointer" onclick="location.href='./main.php';"><?=$CompanyName?> COIN<div style="margin-top:-5px;font-weight:400;color:#666666"><?=$Symbol?></div></div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:right;font-size:12pt;font-weight:500">
      
       <div><span id="coin_balance_str" style="font-weight:600">0</span>&nbsp;<?=$Symbol?></div>
       <div><span id="krw_coin_balance_str" style="font-weight:600">0</span>&nbsp;KRW</div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">
       <div><a href="javascript:coin_balance_call()"><img id="load_1" src="./img/reload.png" style="height:20px"></a></div>
      </th>
      <th style="border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center;font-weight:500;color:#449F6F">입출금가능</th>
     </tr>
     <tr>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:left">
      
       <div style="display:inline-block;vertical-align:top;margin-top:8px;margin-right:5px"><img src="./img/bnb_icon.png" style="height:20px"></div>
       <div style="display:inline-block;font-weight:600;vertical-align:top;cursor:pointer" onclick="location.href='./bnb_deposit.php';"><?=$chainEn?><div style="margin-top:-5px;font-weight:400;color:#666666"><?=$chainSymbol?></div></div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:right;font-size:12pt;font-weight:500">
      
       <div><span id="bnb_balance_str" style="font-weight:600">0</span>&nbsp;<?=$chainSymbol?></div>
       <div><span id="krw_bnb_balance_str" style="font-weight:600">0</span>&nbsp;KRW</div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">
       <div><a href="javascript:bnb_balance_call()"><img id="load_2" src="./img/reload.png" style="height:20px"></a></div>
      </th>
      <th style="border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center;font-weight:500;color:#449F6F">입출금가능</th>
     </tr>
     <tr>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:left">
      
       <div style="display:inline-block;vertical-align:top;margin-top:8px;margin-right:5px"><img src="./img/krw_icon.png" style="height:20px"></div>
       <div style="display:inline-block;font-weight:600;vertical-align:top;cursor:pointer" onclick="location.href='./deposit_krw.php';">KRW<div style="margin-top:-5px;font-weight:400;color:#666666">KRW</div></div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:right;font-size:12pt;font-weight:500">
      
       <div><span id="cash_str" style="font-weight:600">0</span>&nbsp;KRW</div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">
       <div><a href="javascript:cash_balance_call()"><img id="load_3" src="./img/reload.png" style="height:20px"></a></div>
      </th>
      <th style="border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center;font-weight:500;color:#449F6F">입출금가능</th>
     </tr>
     <tr>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:left">
      
       <div style="display:inline-block;vertical-align:top;margin-top:8px;margin-right:5px"><img src="./img/fav.png" style="height:20px"></div>
       <div style="display:inline-block;font-weight:600;vertical-align:top;cursor:pointer" onclick="location.href='./deposit_lockup.php';"><?=$CompanyName?> LockUp<div style="margin-top:-5px;font-weight:400;color:#666666"><?=$Symbol?></div></div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:right;font-size:12pt;font-weight:500">
      
       <div><span id="coin_lock_balance_str" style="font-weight:600">0</span>&nbsp;<?=$Symbol?></div>
       <div><span id="krw_coin_lock_balance_str" style="font-weight:600">0</span>&nbsp;KRW</div>
       
      </th>
      <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">
       <div><a href="javascript:lock_balance_call()"><img id="load_4" src="./img/reload.png" style="height:20px"></a></div>
      </th>
      <th style="border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center;font-weight:500;color:#A61313">입출금 불가능</th>
     </tr>
    </tbody>
   </table>                  
    
    
   <div style="margin-top:15px;color:#A61313">※ 입금 확인을 하기 위해 <strong>새로고침</strong> 버튼을 눌러주세요.</div>
                     
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$chainSymbol?> 입출금</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:12pt;border-radius:10px;padding:10px;text-align:ceter">보유수량</div>
    <div style="width:75%;display:inline-block;padding:10px;text-align:right"><span id="bnb_total_balance_str" style="font-weight:600">0</span>&nbsp;<?=$chainSymbol?></div>
   </div>
   
   <div style="vertical-align:top;display:inline-block;width:31%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./bnb_deposit.php'">입금하기<div style="height:13px"></div></div>
   <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:31%;text-align:center;color:#A61313;border-bottom:5px #A61313 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./bnb_withdraw.php'">출금하기<div style="height:10px"></div></div>
   <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:31%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./bnb_transaction_history.php'">입출금내역<div style="height:13px"></div></div>
   
   
   <div style="margin-top:15px;display:inline-block;width:45%;text-align:left;font-size:11pt">출금가능</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span id="bnb_total_balance_str2" style="font-weight:600">0</span>&nbsp;<?=$chainSymbol?></div>
   
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:95%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
   
   
   <div style="vertical-align:top;padding:5px;display:inline-block;width:48%;text-align:center;color:#666666;border-top:1px #E5E5E5 solid;border-left:1px #E5E5E5 solid;border-right:1px #E5E5E5 solid;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./withdraw.php'">내부전송</div>
   <div style="vertical-align:top;padding:5px;margin-left:-4px;display:inline-block;width:48%;text-align:center;background:#A61313;color:#FFFFFF;border-top:1px #A61313 solid;border-right:1px #A61313 solid;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;">외부전송</div>    
         
   <div class="col-lg-12" style="text-align:left">
    <div class="checkout__input mt-30">
     <p style="display:inline-block;margin-right:15px">출금주소</p>
     <input id="address" name="address" type="text" placeholder="출금할 주소 입력" style="display:inline-block;width:80%;" autocomplete="off">
    </div>
   </div>     
         
   <div class="col-lg-12" style="text-align:left;margin-top:-15px">
    <div class="checkout__input mt-30">
     <p style="display:inline-block;margin-right:15px">출금 수량</p>
     <input id="amount" name="amount" type="text" placeholder="최소 출금 수량 <?=$min_withdraw_bnb?> <?=$chainSymbol?>  " style="text-align:right;display:inline-block;width:80%;" autocomplete="off" onblur="CALC()"> 
     
     <div style="width:17%;display:inline-block;"></div>
     
     <div id="per_box1" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('10')"><CENTER>10%</CENTER></div>
     <div id="per_box2" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('25')"><CENTER>25%</CENTER></div>
     <div id="per_box3" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('50')"><CENTER>50%</CENTER></div>
     <div id="per_box4" style="width:19%;display:inline-block;border:1px #EEEEEE solid;background:#FFFFFF;color:#666666;font-size:12pt;padding:10px;text-align:ceter;cursor:pointer" onclick="PER('0')"><CENTER>최대</CENTER></div>
     
    </div>
   </div>  
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:95%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
   
   
   <div style="display:inline-block;width:45%;text-align:left;font-size:11pt">총 출금</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span id="withdraw_bnb_str" style="font-weight:600">0</span>&nbsp;<?=$chainSymbol?></div>
   
   <div style="display:inline-block;width:45%;text-align:left;font-size:11pt">출금 수수료</div>
   <div style="display:inline-block;width:45%;text-align:right;font-size:11pt"><span style="font-weight:600"><?=$WithdrawFee?></span>&nbsp;<?=$chainSymbol?></div>
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:95%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
    


   <div style="margin-left:20px;text-align:left;font-size:12pt;color:#A61313">※ 암호화폐 출금 유의사항</div>
   <div style="margin-left:20px;margin-top:5px;text-align:left;font-size:11pt;color:#262626">- 디지털 자산의 특성상 출금신청이 완료되면 취소불가</div>
   <div style="margin-left:20px;margin-top:5px;text-align:left;font-size:11pt;color:#262626">- 다른 디지털 자산 지갑으로 잘못 송금하는 경우 환불불가</div>
   
   <CENTER>
   <div style="margin-top:15px;margin-bottom:15px;width:95%;border:1px #E5E5E5 solid;"></div>
   </CENTER>
          
   <a href="javascript:WITHDRAW_PROCESS()" class="site-btn" style="margin-top:20px;width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">출금하기&nbsp;<img src="./img/lock_icon.png"></a>
     
          
  </div>

   
   
  <div style="height:50px"></div>  



</div>


<script>

 
 async function WITHDRAW_PROCESS(){
   


    
    
    if ( document.getElementById("address").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "출금주소를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("address").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("amount").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "출금수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("amount").focus();
      return;
     
     });
     
     return;
     
    }

    if ( !isNumber(document.getElementById("amount").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "출금수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("amount").focus();
      return;
     
     });
     
     return;
     
    }
    



    if ( parseFloat(document.getElementById("amount").value) < parseFloat(<?=$min_withdraw_bnb?>) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 출금수량은 '<?=$min_withdraw_bnb?> <?=$chainSymbol?>' 입니다.",
     }).then((ok) => {
       
      document.getElementById("amount").focus();
      return;
     
     });
     
     return;
     
    }
    
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* BNB를 전송중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("address", document.getElementById("address").value);
       formdata.append("amount", document.getElementById("amount").value);

       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./bnb_withdraw_out_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "in_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "내부전송은 불가능 합니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "존재하지 않는 출금주소입니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_fee" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금수수료가 부족합니다 <?=$chainSymbol?> 충전 후 다시 시도해 주세요.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_token" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금하실<?=$chainSymbol?> 가 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "lack_balance" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "관리자에게 문의해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금신청에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "정상적으로 출금신청 처리가 되었습니다.",
          }).then((ok) => {
         
           location.href = "bnb_transaction_history.php" ;
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

    var chars = ".0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 


async function CALC() {
 
 let total_amount = 0 ;

    
 if ( document.getElementById("amount").value == "" ) {

  return;
     
 }

 if ( !isNumber(document.getElementById("amount").value) ) {

  return;
     
 }
 
 document.getElementById("withdraw_bnb_str").innerHTML = document.getElementById("amount").value ;
  
  
}





async function PER(val) {
 
 let total_amount = 0 ;
 


  
  
  
 if ( val == "10" ) {
   
  document.getElementById("per_box1").style.background = "#A61313"; 
  document.getElementById("per_box1").style.color = "#FFFFFF"; 
  
  document.getElementById("per_box2").style.background = "#FFFFFF"; 
  document.getElementById("per_box2").style.color = "#666666"; 
  
  document.getElementById("per_box3").style.background = "#FFFFFF"; 
  document.getElementById("per_box3").style.color = "#666666"; 
  
  document.getElementById("per_box4").style.background = "#FFFFFF"; 
  document.getElementById("per_box4").style.color = "#666666"; 

 
  total_amount = parseFloat(bnb_balance) * parseFloat(0.1) ;
  document.getElementById("amount").value = total_amount ;

  document.getElementById("withdraw_bnb_str").innerHTML = total_amount;


  
  
 }
  
 else if ( val == "25" ) {

  
  document.getElementById("per_box1").style.background = "#FFFFFF"; 
  document.getElementById("per_box1").style.color = "#666666"; 
   
  document.getElementById("per_box2").style.background = "#A61313"; 
  document.getElementById("per_box2").style.color = "#FFFFFF"; 
  
  document.getElementById("per_box3").style.background = "#FFFFFF"; 
  document.getElementById("per_box3").style.color = "#666666"; 
  
  document.getElementById("per_box4").style.background = "#FFFFFF"; 
  document.getElementById("per_box4").style.color = "#666666"; 

  total_amount = parseFloat(bnb_balance) * parseFloat(0.25) ;
  document.getElementById("amount").value = total_amount ;

  document.getElementById("withdraw_bnb_str").innerHTML = total_amount;


  
 }
  
 else if ( val == "50" ) {

  
  document.getElementById("per_box1").style.background = "#FFFFFF"; 
  document.getElementById("per_box1").style.color = "#666666"; 
  
  document.getElementById("per_box2").style.background = "#FFFFFF"; 
  document.getElementById("per_box2").style.color = "#666666"; 
  
  document.getElementById("per_box3").style.background = "#A61313"; 
  document.getElementById("per_box3").style.color = "#FFFFFF"; 

  document.getElementById("per_box4").style.background = "#FFFFFF"; 
  document.getElementById("per_box4").style.color = "#666666"; 
  

  total_amount = parseFloat(bnb_balance) * parseFloat(0.5) ;
  document.getElementById("amount").value = total_amount ;

  document.getElementById("withdraw_bnb_str").innerHTML = total_amount;


  
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
  
  document.getElementById("amount").value = parseFloat(bnb_balance) ;
  
  document.getElementById("withdraw_bnb_str").innerHTML = parseFloat(bnb_balance) ;
  
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
let bnb_realtime_quote = 0 ;
let exchange_rate = 0 ;

let coin_balance = 0 ;
let krw_coin_balance = 0 ;

let bnb_balance= 0 ;
let krw_bnb_balance= 0 ;

let cash = 0 ;

let lock = 0 ;
krw_lock_balance = 0 ;

let krw = 0 ;

let total_balance = 0 ;



async function balance_call()
{

  document.getElementById("load_1").src = "./img/bx_loader.gif" ;
   
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
   
         formdata.append("target", "arte");
       
         requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
   
         fetch("./balance_call.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {
           

          
          document.getElementById("coin_balance_str").innerHTML = result;
          
          
          coin_balance = result ;
          
          <?if ( $token_quote_way == "bithumb" ) {?>
          
          krw = parseFloat(result) * parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
          
          <?}else{?>
          
          krw = parseFloat(result) * parseFloat(arte_realtime_quote) ;
          
          <?}?>
          
          krw = krw.toFixed(0) ;
        
          document.getElementById("krw_coin_balance_str").innerHTML = numberWithCommas(krw,"B") ;
          krw_coin_balance = krw ;

          document.getElementById("load_1").src = "./img/reload.png" ;
          

          document.getElementById("load_4").src = "./img/bx_loader.gif" ;
            
          formdata = new FormData();
   
          formdata.append("target", "lock");
       
          var requestOptions = {
           method: "POST",
           body: formdata,
           redirect: "follow",
          };
   
          fetch("./balance_call.php", requestOptions)
          .then((response) => response.text())
          .then((result) => {
         
            document.getElementById("coin_lock_balance_str").innerHTML = result;
          
            lock = result ;
            
            <?if ( $token_quote_way == "bithumb" ) {?>
          
            krw = parseFloat(result) * parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
          
            <?}else{?>
            
            krw = parseFloat(result) * parseFloat(arte_realtime_quote) ;
          
            <?}?>
          
          
            krw = krw.toFixed(0) ;
        
            document.getElementById("krw_coin_lock_balance_str").innerHTML = numberWithCommas(krw,"B") ;
            krw_lock_balance = krw ;
            


            document.getElementById("load_4").src = "./img/reload.png" ;
            
            
            
              document.getElementById("load_2").src = "./img/bx_loader.gif" ;
   
          
          
              formdata.append("api", "");
       
              requestOptions = {
               method: "GET",
               redirect: "follow",
              };
   
              fetch("./bnb_api.php", requestOptions)
              .then((response) => response.text())
              .then((result) => {
    
                bnb_realtime_quote = result ;

                formdata = new FormData();
   
                formdata.append("target", "bnb");
       
                requestOptions = {
                 method: "POST",
                 body: formdata,
                 redirect: "follow",
                };
   
                fetch("./balance_call.php", requestOptions)
                .then((response) => response.text())
                .then((result) => {
            
            
                   document.getElementById("bnb_balance_str").innerHTML = result;
                   document.getElementById("bnb_total_balance_str").innerHTML = result;
                   document.getElementById("bnb_total_balance_str2").innerHTML = result;
             
                   bnb_balance = result ;
      
                   krw = parseFloat(result) * parseFloat(arte_realtime_quote) ;
                   krw = krw.toFixed(0) ;
        
                   document.getElementById("krw_bnb_balance_str").innerHTML = numberWithCommas(krw,"B") ;

                   krw_bnb_balance = krw ;

          
                   document.getElementById("load_2").src = "./img/reload.png" ;
             
             

                   
             
                   document.getElementById("load_3").src = "./img/bx_loader.gif" ;
   

  
                   formdata = new FormData();
   
                   formdata.append("target", "cash");
       
                   var requestOptions = {
                    method: "POST",
                    body: formdata,
                    redirect: "follow",
                   };
   
                   fetch("./balance_call.php", requestOptions)
                   .then((response) => response.text())
                   .then((result) => {

                     document.getElementById("cash_str").innerHTML = numberWithCommas(result,"B") ;
             
                     cash = result ;
             

             
                     total_balance = parseFloat(krw_coin_balance) + parseFloat(krw_bnb_balance) + parseFloat(cash) + parseFloat(krw_lock_balance) ;
                    
                     document.getElementById("total_balance_str").innerHTML = numberWithCommas(total_balance,"B") ;

                     document.getElementById("load_3").src = "./img/reload.png" ;
        
        
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
         
   

  })
  .catch(error => {
         
    console.log(error) ;
         
  }); 
   
    
}



balance_call();




async function coin_balance_call()
{

  document.getElementById("load_1").src = "./img/bx_loader.gif" ;
   
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
   
         formdata.append("target", "arte");
       
         requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
   
         fetch("./balance_call.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {
           

          
          document.getElementById("coin_balance_str").innerHTML = result;

          
          coin_balance = result ;
          

          
          <?if ( $token_quote_way == "bithumb" ) {?>
          
          krw = parseFloat(result) * parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
          
          <?}else{?>
          
          krw = parseFloat(result) * parseFloat(arte_realtime_quote) ;
          
          <?}?>
          
          krw = krw.toFixed(0) ;
        
          document.getElementById("krw_coin_balance_str").innerHTML = numberWithCommas(krw,"B") ;
          krw_coin_balance = krw ;



          total_balance = parseFloat(krw_coin_balance) + parseFloat(krw_bnb_balance) + parseFloat(cash) + parseFloat(krw_lock_balance) ;
          document.getElementById("total_balance_str").innerHTML = numberWithCommas(total_balance,"B") ;
                     
                     
                     
          document.getElementById("load_1").src = "./img/reload.png" ;
          
          
          
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






async function bnb_balance_call()
{



       document.getElementById("load_2").src = "./img/bx_loader.gif" ;
   

  
       var formdata = new FormData();
   
       formdata.append("api", "");
       
       var requestOptions = {
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
         
         
         


          
          formdata.append("api", "");
       
          requestOptions = {
           method: "GET",
           redirect: "follow",
          };
   
          fetch("./bnb_api.php", requestOptions)
          .then((response) => response.text())
          .then((result) => {
    
            bnb_realtime_quote = result ;

            
            
            
            
            formdata = new FormData();
   
            formdata.append("target", "bnb");
       
            requestOptions = {
             method: "POST",
             body: formdata,
             redirect: "follow",
            };
   
            fetch("./balance_call.php", requestOptions)
            .then((response) => response.text())
            .then((result) => {
            
            
             document.getElementById("bnb_balance_str").innerHTML = result;
             document.getElementById("bnb_total_balance_str").innerHTML = result;
             document.getElementById("bnb_total_balance_str2").innerHTML = result;
                   
             bnb_balance = result ;
             

             
             krw = parseFloat(result) * parseFloat(bnb_realtime_quote) * parseFloat(exchange_rate) ;
             krw = krw.toFixed(0) ;
        
             document.getElementById("krw_bnb_balance_str").innerHTML = numberWithCommas(krw,"B") ;

             krw_bnb_balance = krw ;
             

             total_balance = parseFloat(krw_coin_balance) + parseFloat(krw_bnb_balance) + parseFloat(cash) + parseFloat(krw_lock_balance) ;
             document.getElementById("total_balance_str").innerHTML = numberWithCommas(total_balance,"B") ;

             document.getElementById("load_2").src = "./img/reload.png" ;
             
             
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








async function cash_balance_call()
{



       document.getElementById("load_3").src = "./img/bx_loader.gif" ;
   

  
       var formdata = new FormData();
   
       formdata.append("target", "cash");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
   
       fetch("./balance_call.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         


        document.getElementById("cash_str").innerHTML = numberWithCommas(result,"B") ;
             
        cash = result ;
             
        total_balance = parseFloat(krw_coin_balance) + parseFloat(krw_bnb_balance) + parseFloat(cash) + parseFloat(krw_lock_balance) ;
        document.getElementById("total_balance_str").innerHTML = numberWithCommas(total_balance,"B") ;

        document.getElementById("load_3").src = "./img/reload.png" ;
        
        
       })
       .catch(error => {
         
         console.log(error) ;
         
       });
         
   


   
    
} 










async function lock_balance_call()
{



       document.getElementById("load_4").src = "./img/bx_loader.gif" ;
   

  
       var formdata = new FormData();
   
       formdata.append("target", "lock");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
   
       fetch("./balance_call.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
        document.getElementById("coin_lock_balance_str").innerHTML = result;
          
        lock = result ;

        krw = parseFloat(result) * parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
        krw = krw.toFixed(0) ;
        
        document.getElementById("krw_coin_lock_balance_str").innerHTML = numberWithCommas(krw,"B") ;
        krw_coin_balance = krw ;


        total_balance = parseFloat(krw_coin_balance) + parseFloat(krw_bnb_balance) + parseFloat(cash) + parseFloat(lock) ;
        
        
        
        document.getElementById("load_4").src = "./img/reload.png" ;
        
        
       })
       .catch(error => {
         
         console.log(error) ;
         
       });
         
   


   
    
} 


  
</script>




<?

 include("footer.php");
 
?> 

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

 $query = mysqli_query($link, "Select SUM(TransactionFee+gasPrice) from token_transaction_history Where target = 'BNB' AND gubn = '입금' AND UserEmail = '".$_SESSION['UserEmail']."' AND deposit_hash <> ''");
 $rs=$query->fetch_assoc();




 $query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();
 
 $deposit_address = base64_decode(htmlspecialchars($rs["deposit_address"])) ;
 $cash = htmlspecialchars($rs["cash"]) ;


	
?>   

    
<script src="./js/jquery.qrcode.js"></script>
<script src="./js/qrcode.js"></script>
 
<div class='container' style="text-align:center">

<script>


if ( window.innerWidth > 991 ) {
  
  if ( window.innerHeight <= 768 ) {
      
   document.writeln("<div id='left_box' style='vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px;margin-right:30px;text-align:left;'>");
  
  }
  else {
      
   document.writeln("<div id='left_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px;margin-right:30px;text-align:left;'>");
  
  }
  
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

  if ( window.innerHeight <= 768 ) {
    
   document.writeln("<div id='right_box' style='vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
  }
  else {
    
   document.writeln("<div id='right_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
  } 
  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$CompanyName?> COIN 입출금</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:12pt;border-radius:10px;padding:10px;text-align:ceter">보유수량</div>
    <div style="width:75%;display:inline-block;padding:10px;text-align:right"><span id="coin_balance_str2" style="font-weight:600">0</span>&nbsp;<?=$Symbol?></div>
   </div>
   
   <div style="vertical-align:top;display:inline-block;width:31%;text-align:center;color:#A61313;border-bottom:5px #A61313 solid;font-size:13pt;font-weight:500">입금하기<div style="height:10px"></div></div>
   <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:31%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./withdraw.php'">출금하기<div style="height:13px"></div></div>
   <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:31%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:13pt;font-weight:500;cursor:pointer" onclick="location.href='./transaction_history.php'">입출금내역<div style="height:13px"></div></div>
   
   
   <div style="margin-top:15px;text-align:left;font-size:11pt"><img src="./img/bottom_arrow.png" style="height:10px;">&nbsp;&nbsp;회원님에게 할당 된 아래 주소로 BEP-20 토큰을 입금할 수 있습니다.</div>

   <div style="margin-top:15px;border:1px #E5E5E5 solid;"></div>
   
   
   
   <div style="margin-top:25px;text-align:left;font-size:12pt">내 BEP-20 입금 주소 (입금 전용)</div>


   <div style="margin-top:15px;text-align:left;"><input id="deposit_address" name="deposit_address" type="text" placeholder="" value="<?=$deposit_address?>" style="width:80%;background:#EEEEEE;" readonly>&nbsp;<a href="javascript:COPY('<?=$deposit_address?>')"><img src="./img/copy.png" style="height:20px"></a>
   
   
   
   <div style="margin-top:25px;margin-bottom:15px;text-align:left;font-size:12pt">QR 코드</div>
   
   
   <div id="qrcodeTable" style="text-align:center;"></div>
   
   <div style="margin-top:25px;text-align:left;font-size:12pt;color:#A61313">※ 입금 전 꼭 알아두세요!</div>
   <div style="margin-top:10px;text-align:left;font-size:11pt;color:#262626">- 위 주소는 입금전용 주소입니다.</div>
   
  </div>





</div>


<script>

   
jQuery('#qrcodeTable').qrcode({
 render	: "table",
 text	: "<?=$rs["deposit_address"]?>",
 width : "180px",
 height : "180px"
})
   
   
   
   

function COPY(val) {

  
   const t = document.createElement("textarea");
   document.body.appendChild(t);
   t.value = val;
   t.select();
   document.execCommand('copy');
   document.body.removeChild(t);
          
          
   Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Copied the code.<?}else{?>코드를 복사하였습니다.<?}?>",
   }).then((ok) => {
         
           return;
          
   });
          
          
          
 }
 
 
 
 
 
 
let container_position_x ;
let container_position_y ;
 
if ( window.innerWidth > 991 ) {
  
 container_position_x = ( window.innerWidth - 549 ) / 2 ;
 container_position_y = ( ( window.innerHeight - document.getElementById("right_box").clientHeight ) / 2 ) - 80 ;
 
}
  
 
if ( window.innerWidth > 991 ) {
 
  if ( window.innerHeight > 768 ) { 
    
   document.getElementById("left_box").style.top = container_position_y + "px" ;
   document.getElementById("right_box").style.top = container_position_y + "px" ;
   
  }  
   
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
          document.getElementById("coin_balance_str2").innerHTML = result;
          
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
             
                   bnb_balance = result ;
      
                   krw = parseFloat(result) * parseFloat(bnb_realtime_quote) * parseFloat(exchange_rate) ;
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
          document.getElementById("coin_balance_str2").innerHTML = result;
          
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

        //krw = parseFloat(result) * parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
        krw = parseFloat(result) * parseFloat(arte_realtime_quote) ;
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

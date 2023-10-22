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
 
 
 
 date_default_timezone_set("Asia/Seoul");
 $date = date("Y-m-d");

 
 $intNowPage = 0 ;
 
 $intPageSize = 20 ;
 $intBlockPage = 10 ;

 if ( isset($_GET["intNowPage"]) ) {

  $intNowPage = $_GET["intNowPage"] ;

 }
 else {
  
  if ( isset($_POST["intNowPage"]) ) $intNowPage = $_POST["intNowPage"] ;
  else $intNowPage = 0 ;  
  
 }
 
 if ( $intNowPage == "" ) $intNowPage = 0;
 
 $orderBy = " order by regdate desc" ;

?>   
    
<script>

 
 function SEARCH(){

  location.href = "./deposit_lockup.php?intNowPage=<?=$intNowPage?>";

 }  



 function GO(val) {

	location.href = "./deposit_lockup.php?intNowPage="+val;

 
 }



</script>

 
<div class='container' style="text-align:center">

<script>

if ( window.innerWidth > 991 ) {
  
  document.writeln("<div id='left_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px;margin-right:30px;text-align:left;'>");
  
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
  
  document.writeln("<div id='right_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:45%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$CompanyName?> LOCKUP COIN 현황</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;margin-bottom:15px;border:1px #E5E5E5 solid;border-radius:10px;background:#FFF4F4;text-align:left">
    <div style="display:inline-block;border:1px #A00303 solid;background:#A61313;color:#FFFFFF;font-size:12pt;border-radius:10px;padding:10px;text-align:ceter">보유수량</div>
    <div style="width:75%;display:inline-block;padding:10px;text-align:right"><span id="lockup_coin_balance_str" style="font-weight:600">0</span>&nbsp;<?=$Symbol?></div>
   </div>
   

   

                 
         <form name="Form" method="post">   
         
            <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">


<?

  $Search_SQL = " WHERE UserEmail = '".$_SESSION["UserEmail"]."' "  ;

  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from lockup_history" . $Search_SQL ;

  $query = mysqli_query($link, $strSQL );
  $rs=$query->fetch_assoc();
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
   
   $intTotalCount = $rs["Count(seqno)"];
   $intTotalPage = $rs["CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")"];
  
  }  
  else {
    
   $intTotalCount = 0;
   $intTotalPage = 0;
   
  }  
  
  
 
?> 
                            
    
         
         
         

                    <table style="width:100%;border:1px solid #E5E5E5">
                     <thead>
                            <tr>
                             <th style="border-left:1px solid #A61313;border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">일자</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">락업수량</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">시작일자</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">종료일자</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">상태</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">지급</th>
                            </tr>
                     </thead>
                     <tbody>     
                           
                           
                           
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From lockup_history " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
   
   
                            <tr>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=substr($rs["regdate"],0,10)?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["amount"],4)?></strong>&nbsp;<?=$Symbol?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["sdate"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["edate"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center;color:#A61313">[<?=$rs["state"]?>]</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center;color:#0178FE">
                             
                              <?if ( $rs["state"] == "지급대기" && $rs["edate"] <= $date ) {?>
                              <input type="button" style="border:2px #A61313 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#A61313;border-radius:2px;font-weight:500;padding:5px" onclick="DONE('<?=htmlspecialchars($rs["seqno"])?>')" value="지급요청">
                              <?}?>
                              
                             </th> 
                            </tr>

   
	 <?

     
    $i = $i + 1 ;
    
    
   }
   
  }
  else {
    
   $DATA_OK = "OK" ;
     
  }  
    
    
				  
?>
   
                     </tbody>     
                    </table>
                    

                    <div class="product__pagination text-center" style="margin-top:20px">
                    
            <?if ( $DATA_OK != "OK" ) {?>

              <?
             
               $intTemp = ( ( $intNowPage - 1 ) / $intBlockPage ) * $intBlockPage + 1 ; 
 
              ?> 
              
              <?if ( $intNowPage <= 0 ) {?>

							 <a onclick=""><i class="fa fa-long-arrow-left"></i></a>
							 
						  <?}else{?>
						  
						   <a onclick="GO('<?=$intNowPage - 1?>"><i class="fa fa-long-arrow-left"></i></a>
						   
						  <?}?>
		
		
              <?
                
 

               for( $i = 0 ; $i < $intTotalPage ; $i++){

                if ( $i == $intNowPage ) {
                
                ?>
                 
                 <a href="javascript:;" style="background:#0084FF;color:#FFFFFF;border: 1px #027AEA solid;"><?=$i+1?></a>
                 
                <?}else{?>
              
							   <a onclick="GO('<?=$i?>')" style="cursor:pointer"><?=$i+1?></a>
							   
                <?}?>
				
                <?
                  
               }
                 

              ?>  
				
  
              <a <?if ( $intNowPage >= $intTotalPage ) {?>href="javascript:GO('<?=$i?>')"<?}?>><i class="fa fa-long-arrow-right"></i></a>
							

						
            <?}?>

                        
                        
                    </div>

                    <div style="margin-top:30px;border:1px #E5E5E5 solid;"></div>

                    <div style="margin-top:25px;text-align:left;font-size:12pt;color:#A61313">※ 종료일자를 지나면 "지급요청" 버튼을 통해 입출금 가능한 코인에 귀속됩니다.</div>
                    <div style="margin-top:10px;text-align:left;font-size:12pt;color:#A61313">※ 지급받은 코인은 "입출금 > 출금하기" 에서 정상적으로 출금이 가능하십니다.</div>
   
   
         </form>   

   
  </div>





</div>


<script>

   

 
 
 async function DONE(val){
   


   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       var formdata = new FormData();
       

       formdata.append("seqno", val);


       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./payment_request.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         console.log(result.replace(/^\s+|\s+$/gm,''));
         
         
         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "성공적으로 지급되었습니다.",
          }).then((ok) => {
         
           location.href = "deposit_lockup.php" ;
           return;
          
          });
         
         
         }
         
         else if ( result.replace(/^\s+|\s+$/gm,'') == "fail" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.",
          }).then((ok) => {
         
           return;
          
          });
         
         
         }

         return;

         
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
 
   document.getElementById("left_box").style.top = container_position_y + "px" ;
   document.getElementById("right_box").style.top = container_position_y + "px" ;
   
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
   
       fetch("https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/eur/krw.min.json", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         //result = result.replace("[","");
         //result = result.replace("]","");
      
         let obj = JSON.parse(result); 
          
         exchange_rate = obj.krw ;
         

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
            document.getElementById("lockup_coin_balance_str").innerHTML = result;
          
          
          
          
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
        document.getElementById("lockup_coin_balance_str").innerHTML = result;
        
        
        
        
        lock = result ;

        //krw = parseFloat(result) * parseFloat(arte_realtime_quote) * parseFloat(exchange_rate) ;
        krw = parseFloat(result) * parseFloat(arte_realtime_quote)  ;
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

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


$message_status = token_balance($chainId, $token_address, $manager_address);
$data = json_decode($message_status);

$balance = $data->balance ;


if ( $balance != "" ) {
  

 $token_balance = $data->balance ;
 $token_balance = sprintf("%.8f", $token_balance / 1000000000000000000 );
 
 
 
}  


 
 $intNowPage = 0 ;
 
 $intPageSize = 5 ;
 $intBlockPage = 10 ;

 if ( isset($_GET["intNowPage"]) ) {

  $intNowPage = $_GET["intNowPage"] ;

 }
 else {
  
  if ( isset($_POST["intNowPage"]) ) $intNowPage = $_POST["intNowPage"] ;
  else $intNowPage = 0 ;  
  
 }
 
 if ( $intNowPage == "" ) $intNowPage = 0;
 
 $orderBy = " order by seqno desc" ;
 
 
 
 
 
 
?>   
    

    
<script>



 function ALL_SELECT() {

  var form = document.Form ;
  var cnt = parseInt(form.count.value) ;
  
  for ( var i = 1 ; i < cnt ; i++ ) {

   if ( form.chk_all.checked ) {
   
    if ( document.getElementById("state_"+i).value == "신청" ) {
      
     eval("form.chk" + i + ".checked  = true;")
     
    } 
    
   } 
   else {

    eval("form.chk" + i + ".checked  = false;") 
    
   } 

  }


 }
 
 
 
 
 let arr_cnt = 0 ; 
 let seqno_arr = []; 
 let gubn_arr = []; 
 let arr_total = 0 ;
 
 async function SelectionDone(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      gubn_arr[cnt] = document.getElementById("gubn_"+i).value ; ;
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    

   var ans = window.confirm("정말로 일괄 처리완료할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Processing batch completion. Don't quit in the middle.<?}else{?>* 일괄 처리중입니다. 중간에 종료하지 마세요..<?}?>" ;

       
       arr_total = seqno_arr.length ;
       
       
       TRANSFER(seqno_arr[arr_cnt], gubn_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function TRANSFER(seqno, gubn){
 
 
         var formdata = new FormData();
         
         formdata.append("gubn", gubn);
         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./adm_krw_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {

         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 입출금처리를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_krw_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            TRANSFER(seqno_arr[arr_cnt], gubn_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 
 
 
 
 
 
 
 
 async function DONE(gubn, val){
   

   var ans = window.confirm("정말로 "+gubn+"완료처리할까요?");
 
   if(ans==true){ 
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* processing. Don't quit in the middle.<?}else{?>* 처리중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       
       formdata.append("gubn", gubn);
       formdata.append("seqno", val);


       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_krw_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "lack_balance" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "출금잔액이 부족합니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "adm_krw_history.php" ;
           return;
          
          });
         
         
         }
         

         return;

         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         
         Swal.fire({
          icon: "warning",
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
      
      
   }
   
   
 } 
 
 
 
 
 async function DEL(val){
   

   var ans = window.confirm("정말로 삭제할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Deleting. Don't quit in the middle.<?}else{?>* 삭제중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       formdata.append("seqno", val);


       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_krw_history_delete.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "adm_krw_history.php" ;
           return;
          
          });
         
         
         }
         

         return;

         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         
         Swal.fire({
          icon: "warning",
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
       
       
   }
   
   
 } 
 
 
 
 
 
 
 function SEARCH(){

  location.href = "./adm_krw_history.php?intNowPage=<?=$intNowPage?>";

 }  



 function GO(val) {

	location.href = "./adm_krw_history.php?intNowPage="+val;

 
 }



</script>





<div class='container' style="text-align:center">




<script>

if ( window.innerWidth > 991 ) {
  
  if ( window.innerHeight <= 768 ) {
      
   document.writeln("<div id='box' style='vertical-align:top;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
  }
  else {
      
   document.writeln("<div id='box' style='position:relative;vertical-align:top;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
  } 

}
else { 
  
  document.writeln("<div id='box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$Company_Name?> KRW 입출금내역</div>
   
   <div style="margin-top:15px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;margin-bottom:15px;text-align:left">
    <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="SelectionDone()" value="선택 일괄처리">     
   </div> 
                 
         <form name="Form" method="post">   
         
            <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">


<?

  $Search_SQL = " WHERE 1 = 1 "  ;

  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from krw_history" . $Search_SQL ;

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
                             <th style="border-left:1px solid #A61313;border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center"><input type="checkbox" name="chk_all" onclick="ALL_SELECT()" <?if ( $intTotalCount == 0 ) {?>disabled<?}?>>&nbsp;일자</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">구분</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">신청자</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">입출금정보</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">신청금액</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">수수료</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">실수령금액</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">이전금액</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">이후금액</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">상태</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">관리</th>
                            </tr>
                     </thead>
                     <tbody>     
                           
                           
                           
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From krw_history " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
   
   
                            <tr>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?if ( htmlspecialchars($rs["state"]) == "신청" ) {?><input type="checkbox" id="seqno_<?=$i?>" name="chk<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>">&nbsp;<?}else{?><input type="checkbox" id="seqno_<?=$i?>" name="chk<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>" disabled>&nbsp;<?}?><?=substr($rs["regdate"],0,10)?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["gubn"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=base64_decode($rs["UserEmail"])?></th>
                             
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:left">
                             
                             <?if ( $rs["gubn"] == "입금" ) {?>
                             
                             [<?=$rs["bank_name"]?>]&nbsp;<?=$rs["bank_account"]?>&nbsp;<?=$rs["bank_account_holder"]?>
                             
                             <?}else{?>
                             
                             [<?=$rs["depositor_bank_name"]?>]&nbsp;<?=$rs["depositor_bank_account"]?>&nbsp;<?=$rs["depositor_bank_account_holder"]?>
                             
                             <?}?>
                             
                             </th>
                             
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["amount"])?></strong>&nbsp;KRW</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["fee"])?></strong>&nbsp;KRW</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right;color:#A61313"><strong><?=number_format($rs["amount"]-$rs["fee"])?></strong>&nbsp;KRW</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["prev_amount"])?></strong>&nbsp;KRW</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["next_amount"])?></strong>&nbsp;KRW</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center;color:#0178FE">
                              <?if ( $rs["state"] == "신청" ) {?>
                              <input type="button" style="border:2px #0073DE solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="DONE('<?=$rs["gubn"]?>','<?=htmlspecialchars($rs["seqno"])?>')" value="<?=$rs["gubn"]?>처리">
                              <?}else{?>
                              [<?=$rs["state"]?>]
                              <?}?>
                             </th>
                             
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center;color:#0178FE">

                              <input type="button" style="border:2px #A61313 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#A61313;border-radius:2px;font-weight:500;padding:5px" onclick="DEL('<?=htmlspecialchars($rs["seqno"])?>')" value="삭제">
         
                             </th>
                             
                             
                            </tr>
                            
                            <input id="seqno_<?=$i?>" name="seqno_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["seqno"])?>">
                            <input id="gubn_<?=$i?>" name="gubn_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["gubn"])?>">
                            <input id="state_<?=$i?>" name="state_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["state"])?>">
   
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
                    
                    <input id="count" name="count" type="hidden" value="<?=$i?>">
                    
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


         </form>   
         

          
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
  
 container_position_x = ( window.innerWidth - 549 ) / 2 ;
 container_position_y = ( ( window.innerHeight - document.getElementById("box").clientHeight ) / 2 ) - 80 ;
 
}
  
 
if ( window.innerWidth > 991 ) {
 
   document.getElementById("box").style.top = container_position_y + "px" ;
   
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

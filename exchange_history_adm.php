<?

 include("header.php"); 

?> 


<?if ( $_SESSION['UserEmail'] == "" ) {?>

 <?if ( $_SESSION['UserGubn'] != "adm" ) {?>
 
 <script>

  location.href = "./login.php" ;
 
 </script>
 
 <?}?>
 
<?

 exit ;
 
}
else{

?>  



 
<?
  
}  

?>


<?


 $schtxt = $_POST['schtxt'];
 
 $state = $_POST['state'];
 $sort = $_POST['sort'];
 
 
 if ( $state != "" ) {
                      
  $searchsql = " AND state = '".$state."'" ;
                      
 } 
 
 if ( $sort == "날짜별" ) {
                      
  $orderBy = " ORDER BY regdate DESC " ;
                      
 } 
 else if ( $sort == "금액별" ) {
                      
  $orderBy = " ORDER BY amount DESC " ;
                      
 } 
 else {
   
  $orderBy = " ORDER BY regdate DESC " ;
  
 }  
 

             
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
 
 
 
 
 
?>



<script type="text/javascript" src="./js/web3.min.js"></script>

<script>




 var wallett = {
  contract_address: "<?=$token_address?>",
  contract_abi: <?=$token_address_abi?>
 }
        
        
        
 function Mobile(){
   
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  
 }
 
 
 let web3;
 let wallet;
 let provider = null;
 let connectedAccount = null;
 let decimals = 18;
 let chainId = <?=$chainId?>;
 let Contract = null;
  
  
  
  
 const connect_state = async () => {

 
   
  await window.ethereum.enable();
  provider = await window.web3.currentProvider;
  
  web3 = await new Web3(provider);
  chainId = await web3.eth.net.getId();
    
  Contract = await new web3.eth.Contract(wallett.contract_abi,wallett.contract_address);
  

  
  if ( chainId != <?=$chainId?> ) {
    
   console.log("<?=$chainName?> 체인이 아님");
   
   document.getElementById("loadingdiv").style.display = "block";
   document.getElementById("loadingdiv_result").innerHTML = "* <?=$chainName?> 체인으로 네트워크를 변경합니다." ;
   




   try {





    await ethereum.request({
      method: "wallet_switchEthereumChain",
      params: [{ chainId: "0x<?=$chainIdHex?>" }],
    }).then(function(result){

     //location.href = "<?=$uri?>" ;
      
    });
    

    

    
    
    
   } catch (switchError) {
    
    
    
    
    ethereum.request({
          method: "wallet_addEthereumChain",
          params: [
            {
              chainId: "0x<?=$chainIdHex?>",
              chainName: "<?=$chainName?> 네트워크",
              rpcUrls: ["<?=$rpcUrl?>"],
            },
          ],
    }).then(function(result){

     location.href = "<?=$uri?>" ;
      
    });
   
   
   
   }
   
   
   
   
   
  }

   
 }
 
 
 
 
 
 
        const connectWallet = async () => {

            if ( connectedAccount == null ) {
              
             connect_state();
             //return;
             
            } 


            


            
            try {
                if (window.ethereum) {

                    try {
                      

                        await window.ethereum.enable();
                        provider = await window.web3.currentProvider;
                        

                        
                        
                        
                        web3 = await new Web3(provider);

                        
                        chainId = await web3.eth.net.getId();
                        
                        let accounts = await web3.eth.getAccounts();
                        provider = await window.web3.currentProvider;
                        connectedAccount = accounts[0];
                        



                        if (chainId == <?=$chainId?>) {	



                         Swal.fire({
                          icon: "success",
                          text: "지갑연결이 완료되었습니다.",
                         }).then((ok) => {
                           
                          document.getElementById("wallet_btn").style.display = "none";
                          return;
          
                         });
            
            
            
                            			
                        }else{
						  
						              

                           connectmetamask() ;

                          
							               
                        }
                        
                        
                        

                    } catch (err) {
                        // Swal.fire('error', err.message, "error");
                    }


                } else {
                  
                  
                 Swal.fire({
                  icon: "warning",
                  text: "<?if ( $lang == "en" ) {?>Please enter only numbers for the amount.<?}else{?>메타마스크를 먼저 설치해 주세요.<?}?>",
                 }).then((ok) => {
         
                  location.href = "https://chrome.google.com/webstore/detail/metamask/nkbihfbeogaeaoehlefnkodbefgpgknn?hl=ko"; 
                  return;
     
                 });
                    
                    
                }
            }
            catch (e) {
                return;
            }
        }
 
 






 async function connectmetamask(){

  try {





    await ethereum.request({
      method: "wallet_switchEthereumChain",
      params: [{ chainId: "0x<?=$chainIdHex?>" }],
    }).then(function(result){

     location.href = "<?=$uri?>" ;
      
    });
    

    

    
    
    
  } catch (switchError) {


         
      try {
        

        
        await ethereum.request({
          method: "wallet_addEthereumChain",
          params: [
            {
              chainId: "0x<?=$chainIdHex?>",
              chainName: "<?=$chainName?> 네트워크",
              rpcUrls: ["<?=$rpcUrl?>"],
            },
          ],
        }).then(function(result){

         location.href = "<?=$uri?>" ;
         
         
        });
    
        
        

        
        
        
      } catch (addError) {
        
        
        
       Swal.fire({
        icon: "warning",
        text: "<?if ( $lang == "en" ) {?>Please enter only numbers for the amount.<?}else{?>메타마스크를 먼저 설치해 주세요.<?}?>",
       }).then((ok) => {
         
        location.href = "https://chrome.google.com/webstore/detail/metamask/nkbihfbeogaeaoehlefnkodbefgpgknn?hl=ko"; 
        return;
     
       });
     

              
      }
      
      
      
      
      
  }
  
  
       
 }
 
 
 
 
 
 
 
 
 
 
 
 function SEARCH(){
  
  
  var form = document.Form ;

  form.intNowPage.value = "" ;
  
  
  form.action = "exchange_history_adm.php";
  form.submit(); 
   
 }  



 function GO(val) {
 
  var form = document.Form ;
  
	form.intNowPage.value = val ;
	
	form.action = "exchange_history_adm.php";
	form.submit();
 
 }




 function ALL_SELECT() {

  var form = document.Form ;
  var cnt = parseInt(form.count.value) ;
  
  
  
  
  for ( var i = 1 ; i < cnt ; i++ ) {



    if ( window.innerWidth > 991 ) {
      
      

       if ( form.chk_all.checked ) {



         if ( document.getElementById("state_"+i).value == "대기중" ) {
      
          eval("form.chk" + i + ".checked  = true;")
     
         } 
    

    
       } 
       else {

        eval("form.chk" + i + ".checked  = false;") 
    
       } 
       
       
   
   
   }
   else {
     
     
    
    
       if ( form.chk_all_m.checked ) {
   

         if ( document.getElementById("state_"+i).value == "대기중" ) {
      
          eval("form.chk_m_" + i + ".checked  = true;")
     
         } 
    

    
       } 
       else {

        eval("form.chk_m_" + i + ".checked  = false;") 
    
       } 
       
       
    
    
     
   }  
     
     
     
     
   

  }
  
  
  


 }
 
 
 
 
 

           
 let arr_cnt = 0 ;

 let seqno_arr = []; 

 
 async function Deposit_Complete(){


   var form = document.Form ;
   
   var count = parseInt(form.count.value) ;


   arr_cnt = 0 ;

   


                    

          let TotalCnt = 0 ; 
                     
          for(var i = 1 ; i < count ;i++) {
     
           if ( window.innerWidth > 991 ) {
             
             
              if ( eval("form.chk" + i + ".checked  == true") ) { 
      
               TotalCnt = TotalCnt + 1 ; 

              } 
     
           }
           else {
             
             
              if ( eval("form.chk_m_" + i + ".checked  == true") ) { 
      
               TotalCnt = TotalCnt + 1 ; 

              } 
     
           }
           
           
           
             
          }

          if ( TotalCnt == 0 ) {

           alert("출금완료 처리할 내역을 선택해 주세요.");
           return ;

          }     
           
    

           
           
           
           document.getElementById("loadingdiv").style.display = "block";
           document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* The contract is in progress. Don't quit midway<?}else{?>* 출금완료 처리를 시작합니다. 중간에 종료하지 마세요.<?}?>" ;
    
           let cnt = 0 ;
           
             
           for ( var i = 1 ; i < count ; i++ ) {



            if ( window.innerWidth > 991 ) {



                if ( eval("form.chk" + i + ".checked == true") ) {
              

                  seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; 
            
            
                  cnt = cnt + 1 ;
              
            
                }
                
            
            
            
            
            }else{



                if ( eval("form.chk_m_" + i + ".checked == true") ) {


                  seqno_arr[cnt] = document.getElementById("seqno_m_"+i).value ; 
            

                  cnt = cnt + 1 ;
              
            
                }
                
            
            
            
            
            }  
              
              
            
 
           } 
          
          
          
          
           arr_total = seqno_arr.length ;
           

           
           
           DepositComplete_TRANSFER(seqno_arr[arr_cnt]) ; 
                  
          
    

  
  
  

  
  
 }
 
 
 

 async function DepositComplete_TRANSFER(seqno){


         
         var formdata = new FormData();
         

         formdata.append("seqno", seqno);

         
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./exchange_complete_save.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {
       
 
          
          if ( result == "succ" ) {
       
       
           arr_cnt = arr_cnt + 1 ;
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";
         
         
           if ( arr_cnt >= arr_total ) {
         
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "<?if ( $lang == "en" ) {?>A contract has been signed.<?}else{?>출금완료 처리하였습니다.<?}?>",
            }).then((ok) => {
         
             location.href = "exchange_history_adm.php" ;
             return;
          
            });
          
            return;
            
           }
         
           else {
             
            DepositComplete_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 
           
           
           
           
          }
       
       
         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         

         
       
      
      
 } 
 
 
 
 
 
 

 async function USER_DETAIL(UserEmail){


         
         var formdata = new FormData();
         

         formdata.append("UserEmail", UserEmail);

         
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./user_detail.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {

          let arr = result.split("|") ;
          
          if ( window.innerWidth > 991 ) {
            
            document.getElementById("layer_web").style.display = "block";
            
            document.getElementById('user_name').innerHTML = arr[0] ;
            
            document.getElementById('user_content').innerHTML = arr[1] ;
            
          }
          else {   

           document.getElementById("layer_mob").style.display = "block";
           
           document.getElementById('user_name_m').innerHTML = arr[0] ;
            
           document.getElementById('user_content_m').innerHTML = arr[1] ;
         
          }
 
       
       
         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         

         
       
      
      
 } 
 
 
 
 
 




 
 let sel_no ;
 let sel_state ;
 let exchange_rate ;
 
 async function Deposit_Single_Complete(val) {




  
  

    
    
         
    var form = document.Form ;
    
    let toAddress = "" ;
    let amount  ;
    let txhash ;
    let ExpectationTransactionFee = web3.utils.toWei("<?=$ExpectationTransactionFee?>", "ether") ;
    let balance ;
    
    
    amount = web3.utils.toWei(document.getElementById('amount_'+val).value, "ether") ;
    
    
    let manager_amount = await Contract.methods.balanceOf(connectedAccount).call() ;

    balance = await web3.eth.getBalance(connectedAccount) ;
    
    
     
    if ( parseFloat(amount) > parseFloat(manager_amount) ) {
      
     Swal.fire({
      icon: "warning",
      text: "반납할 관리자 토큰이 부족합니다.",
     }).then((ok) => {
     
      return;
     
     });
     
     return;
     
    }
    
    if ( parseFloat(ExpectationTransactionFee) > parseFloat(balance) ) {
      
     Swal.fire({
      icon: "warning",
      text: "전송 수수료 <?=$chainSymbol?>가 부족합니다.",
     }).then((ok) => {
     
      return;
     
     });
     
     return;
     
    }





       
    document.getElementById("loadingdiv").style.display = "block";
    document.getElementById("loadingdiv_result").innerHTML = "* 출금 진행중입니다. 중간에 종료하지 마세요." ;
       
             

               
               
    toAddress = document.getElementById('toAddress_'+val).value ;
    

    txhash = "" ;

    Contract.methods.transfer(toAddress, amount)
      .send({
       from: connectedAccount
    })
    .on('transactionHash',(hash) => {
      
       txhash = String(hash);
       
       var formdata = new FormData();

       formdata.append("hash", txhash);
       formdata.append("seqno", document.getElementById('seqno_'+val).value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./exchange_complete.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
        document.getElementById("loadingdiv_result").innerHTML = "* 거래내역을 저장합니다. 중간에 종료하지 마세요." ;
         
       })
       .catch(error => {
         
        console.log(error) ;
         
       });
       
       
       
       
    })
    .then(()=>{
      
      
      

          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "반납을 완료하였습니다.",
          }).then((ok) => {
         
           form.action = "./exchange_history_adm.php" ;
           form.submit() ;
           
           return;
          
          });
          

        
      
      
    })
    .catch((err) => {
      
      
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "반납을 실패하였습니다 ->  " + err,
          }).then((ok) => {
           
           return;
          
          });
      
    });
    
    
    

    
 } 
 
 
 
 
 
 
 
  
</script>



    <!-- Checkout Section Begin -->
    <section class="checkout section-padding-100" style="margin-top:-80px;width:100%">
        <div style="width:100%;padding-left:5%;padding-right:5%">
        
         <form name="Form" method="post">   
         
            <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">
            
            <div class="checkout__form">
                <h4><?if ( $lang == "en" ) {?>transaction history<?}else if ( $lang == "ko" ) {?>출금 내역<?}?>
                
                
                 <input type="button" class="site-btn mt-30" onclick="Deposit_Complete()" value="<?if ( $lang == "en" ) {?>Deposit complete<?}else if ( $lang == "ko" ) {?>출금완료 처리<?}?>" style="margin-left:20px">
                 <input id="wallet_btn" type="button" class="site-btn mt-30" onclick="connectWallet()" value="<?if ( $lang == "en" ) {?>wallet connection<?}else if ( $lang == "ko" ) {?>지갑연결<?}?>" style="margin-left:20px">
                 
                </h4>

                
                 <div>
                  <select id="state" name="state" onchange="SEARCH()">
                   <option value="">신청현황</option>
                   <option value="대기중">대기중</option>
                   <option value="출금지급완료">출금지급완료</option>
                   <option value="출금지급보류">출금지급보류</option>
                  </select>
                 </div>
                 
                 <div style="margin-left:5px;display:inline-block">
                  <select id="sort" name="sort" onchange="SEARCH()">
                   <option value="">정렬순서</option>
                   <option value="날짜별">날짜별</option>
                   <option value="금액별">금액별</option>
                  </select>
                 </div>
                 

<?

  $Search_SQL = " WHERE 1 = 1 "  ;
  $Search_SQL = $Search_SQL . $searchsql ;
  

  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from exchange" . $Search_SQL ;

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
  
  



  $strSQL = "Select COUNT(seqno)" ;
  $strSQL = $strSQL . " from exchange WHERE state = '대기중'" ;

  $query = mysqli_query($link, $strSQL );
  $rs=$query->fetch_assoc();
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
   
     $total = htmlspecialchars($rs["COUNT(seqno)"]);
   
     if ( empty($total) == 1 ) $total = 0 ;
     
  }  
  else {
    
     $total = 0;
   
  } 
    
    
    
    
?> 


                    <div style="height:10px;"></div>
                    
                    
                    <table style="width:100%;border:1px solid #E5E5E5">
                    
                     <thead>
                            <tr>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center"><input type="checkbox" name="chk_all" onclick="ALL_SELECT()" <?if ( $total == 0 ) {?>disabled<?}?>></th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">번호</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">날짜</th>
                             
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">ID</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">성명</th>
                             
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">출금방법</th>
                             
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">신청금액</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">이전금액</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">이후금액</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">상태</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">메모</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">거래내역</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">관리</th>
                             <th class="mob" style="width:100%;border-right:1px solid #E5E5E5;background:#EEEEEE;font-size:11pt;padding:5px;text-align:center">내역</th>
                            </tr>
                     </thead>

                     
                     <tbody>     
                           
                           
                           
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From exchange " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
   
   
                            <tr>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?if ( htmlspecialchars($rs["state"]) == "대기중" ) {?><input type="checkbox" id="seqno_<?=$i?>" name="chk<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>"><?}else{?><input type="checkbox" id="seqno_<?=$i?>" name="chk<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>" disabled><?}?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=$rs["a_no"]?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=$rs["regdate"]?></td>
                             
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><a href="javascript:USER_DETAIL('<?=$rs["UserEmail"]?>')" style="color:#262626"><?=$rs["UserEmail"]?></a></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><a href="javascript:USER_DETAIL('<?=$rs["UserEmail"]?>')" style="color:#262626"><?=$rs["UserName"]?></a></td>
                             
                             
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?if ( $rs["withdrawal_way"] == "bank" ) {?>계좌입금<?}else if ( $rs["withdrawal_way"] == "meta" ) {?>메타마스크 입금<?}?></td>
                             
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=number_format($rs["money"])?>원</td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=number_format($rs["prev_money"])?>원</td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=number_format($rs["next_money"])?>원</td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">[<?=$rs["state"]?><?if ( $rs["gubn"] != "출금" ) {?>-><?=$rs["gubn"]?><?}?>]</td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=$rs["memo"]?></td>

                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?if ( $rs["withdrawal_way"] == "meta" && $rs["state"] == "출금지급완료" ) {?><a href="<?=$txUrl?>/<?=$rs["hash"]?>" style="color:#262626" targer="_blank">[<?=substr($rs["hash"],0,5)?>]</a><?}?></td>
                             
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">
                             
                              <?if ( htmlspecialchars($rs["state"]) == "대기중" ) {?>

                               <?if ( htmlspecialchars($rs["withdrawal_way"]) == "meta" ) {?>
                               <input type="button" style="margin-left:5px;display:inline-block;width:100px;border:2px #E5E5E5 solid;text-align:center;font-size:12pt;color:#666666;background-color:#EEEEEE;border-radius:2px;font-weight:500;padding:5px" onclick="Deposit_Single_Complete('<?=$i?>')" value="완료">
                               <?}?>
                               
                              <?}?>
                              
                             </td>
                             <td class="mob" style="width:100%;border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:10px;text-align:left">
                             
                             
                              <div>선택&nbsp;:&nbsp;<?if ( htmlspecialchars($rs["state"]) == "대기중" ) {?><input type="checkbox" id="seqno_m_<?=$i?>" name="chk_m_<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>"><?}else{?><input type="checkbox" id="seqno_m_<?=$i?>" name="chk_m_<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>" disabled><?}?></div>

                              <div style="margin-top:5px">- 일자&nbsp;:&nbsp;<?=substr($rs["regdate"],0,10)?></div>
                              
                              <div style="margin-top:5px">- ID&nbsp;:&nbsp;<a href="javascript:USER_DETAIL('<?=$rs["UserEmail"]?>')" style="color:#262626"><?=$rs["UserEmail"]?></a></div>
                              <div style="margin-top:5px">- 성명&nbsp;:&nbsp;<a href="javascript:USER_DETAIL('<?=$rs["UserEmail"]?>')" style="color:#262626"><?=$rs["UserName"]?></a></div>
                              
                              <div style="margin-top:5px">- 출금방법&nbsp;:&nbsp;<?if ( $rs["withdrawal_way"] == "bank" ) {?>계좌입금<?}else if ( $rs["withdrawal_way"] == "meta" ) {?>메타마스크 입금<?}?></div>
                              
                              <div style="margin-top:5px">- 신청금액&nbsp;:&nbsp;<?=number_format($rs["money"])?>원</div>
                              <div style="margin-top:5px">- 이전금액&nbsp;:&nbsp;<?=number_format($rs["prev_money"])?>원</div>
                              <div style="margin-top:5px">- 이후금액&nbsp;:&nbsp;<?=number_format($rs["next_money"])?>원</div>
                              <div style="margin-top:5px">- 상태&nbsp;:&nbsp;[<?=$rs["state"]?><?if ( $rs["gubn"] != "출금" ) {?>-><?=$rs["gubn"]?><?}?>]</div>
                              <div style="margin-top:5px">- 메모&nbsp;:&nbsp;<?=$rs["memo"]?></div>
                              
                             </td>
                             
                            </tr>
   
                            
                            <input id="state_<?=$i?>" name="state_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["state"])?>">
                            <input id="withdrawal_way_<?=$i?>" name="withdrawal_way_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["withdrawal_way"])?>">
                            <input id="amount_<?=$i?>" name="amount_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["money"])?>">

                            <input id="toAddress_<?=$i?>" name="toAddress_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["wallet_address"])?>">
                            
                            
                            
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
                    
                    <div class="product__pagination text-center" style="margin-top:20px;text-align:center">
                    
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
              
							   <a onclick="GO('<?=$i?>')"><?=$i+1?></a>
							   
                <?}?>
				
                <?
                  
               }
                 

              ?>  
				
  
              <a <?if ( $intNowPage >= $intTotalPage ) {?>href="javascript:GO('<?=$i?>')"<?}?>><i class="fa fa-long-arrow-right"></i></a>
							

						
            <?}?>

                        
                        
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
            </div>
            
         </form>   
         
        </div>
    </section>
 


<script>

 document.getElementById("state").value = "<?=$state?>" ;
 document.getElementById("sort").value = "<?=$sort?>" ;
 
</script>

<style>



.box{
    position: relative;
    top:50%;
    left:50%; 
    width:50%;
    height:80%;
    transform:translate(-50%, -50%);
    z-index:1002;
    box-sizing:border-box;
    background:#fff;
    box-shadow: 2px 5px 10px 0px rgba(0,0,0,0.35);
    -webkit-box-shadow: 2px 5px 10px 0px rgba(0,0,0,0.35);
    -moz-box-shadow: 2px 5px 10px 0px rgba(0,0,0,0.35);
}






.box .contents {
    padding:50px;
    height:92%;
    //line-height:1.4rem;
    //font-size:14px;
    //word-break: break-word;
}





.box .contents h2 {
    padding:15px 0;
    color:#333;
    margin:0;
    text-align:center
}
.box .contents p{ 
    border-top: 1px solid #666;
    padding-top: 30px;
}

.box .button {
    display:table;
    bottom:0;
    table-layout: fixed;
    width:100%;
    height:70px;
    background:#005FB8;
    word-break: break-word;
}
.box .button a {
    position: relative; 
    display: table-cell; 
    height:70px; 
    color:#fff; 
    font-size:17px;
    text-align:center;
    vertical-align:middle;
    text-decoration:none; 
    background:#005FB8;
}
.box .button a:before{
    content:'';
    display:block;
    position:absolute;
    top:26px;
    right:29px;
    width:1px;
    height:21px;
    background:#fff;
    -moz-transform: rotate(-45deg); 
    -webkit-transform: rotate(-45deg); 
    -ms-transform: rotate(-45deg); 
    -o-transform: rotate(-45deg); 
    transform: rotate(-45deg);
}
.box .button a:after{
    content:'';
    display:block;
    position:absolute;
    top:26px;
    right:29px;
    width:1px;
    height:21px;
    background:#fff;
    -moz-transform: rotate(45deg);
    -webkit-transform: rotate(45deg); 
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg); 
    transform: rotate(45deg);
}
.box .button a.closeBtn {
    background:#747474;
}
.box .button a.closeBtn:before, .box .button a.closeBtn:after{
    display:none;
}






#layer_web {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 

#layer_mob {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100vw; 
    height: 100vh; 
    background-color: rgba(0, 0, 0, 0.5);
} 


</style>

<div id="layer_web" style="display:none">
  <div class="box">
      <div class="contents">
          <h2 id="user_name"></h2>
          <div id="user_content">
           
          </div>
      </div>
      <div class="button">
          <a href="javascript:closePopup('web');">창닫기</a>
      </div>
  </div>
</div>




<div id="layer_mob" style="display:none">
  <div class="box" style="width:90vw;height:80vh">
      <div class="contents">
          <h2 id="user_name_m"></h2>
          <div id="user_content_m">
           
          </div>
      </div>
      <div class="button">
          <a href="javascript:closePopup('mob');">창닫기</a>
      </div>
  </div>
</div>




<script>


 function closePopup(val) { 
   
   document.getElementById("layer_"+val).style.display = "none";
        
 }


</script>


<?

 include("footer.php");
 
?> 
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


<div class='container' style="text-align:center">


 
<script>

if ( window.innerWidth > 991 ) {
  

  document.writeln("<div id='left_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:30%;display:inline-block;border:1px #EEEEEE solid;margin-right:30px;text-align:left;'>");

}
else { 
  
  document.writeln("<div id='left_box' class='web'>");
  
}  

</script>
  

   <div style="border:1px #E5E5E5 solid;background:#A61313;padding:15px;color:#FFFFFF;font-size:13pt;font-weight:500;text-align:center">설정</div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='adm_customer_support.php';">전송설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='terms.php';">약관설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='company_setting.php';">업체정보</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='adm_info.php';">비밀번호 변경</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
  </div>



<script>

if ( window.innerWidth > 991 ) {
  

  document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");

  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  
   <Form name="Form">
   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">전송설정</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>



            <div class="checkout__form" style="text-align:left">


                    <div class="row">
                    
                        
                        
                        <div class="col-lg-12">
                        
                          
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">토큰시세 적용방법<span>*</span></p>
                             <label style="margin-left:20px;margin-top:-10px;display:inline-block;vertical-align:top"><input id="token_quote_way" name="token_quote_way" type="radio" value="bithumb" <?if ( $token_quote_way == "bithumb" ) {?>checked<?}?> onclick="SEL_BOX()"><i></i></label>&nbsp;거래소시세
                             <label style="margin-left:15px;margin-top:-10px;display:inline-block;vertical-align:top"><input id="token_quote_way" name="token_quote_way" type="radio" value="db" <?if ( $token_quote_way == "db" ) {?>checked<?}?> onclick="SEL_BOX()"><i></i></label>&nbsp;지정 시세
                            </div>
                            
                            <div id="box" class="checkout__input" style="display:none">
                             <p style="font-weight:500;display:inline-block">토큰시세<span>*</span></p>
                             <input id="arte_usdt" name="arte_usdt" type="text" placeholder="토큰시세" value="<?=$arte_usdt?>" style="margin-left:15px;width:30%">&nbsp;원
                            </div>
                            
                            
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">예상 가스비+네트워크수수료<span>*</span></p>
                             <input id="ExpectationTransactionFee" name="ExpectationTransactionFee" type="text" placeholder="예상 가스비+네트워크수수료" value="<?=$ExpectationTransactionFee?>" style="margin-left:15px;width:30%">&nbsp;<?=$chainSymbol?>
                            </div>
                            
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">출금수수료<span>*</span></p>
                             <input id="WithdrawFee" name="WithdrawFee" type="text" placeholder="출금수수료" value="<?=$WithdrawFee?>" style="margin-left:15px;width:30%">&nbsp;<?=$chainSymbol?>
                            </div>
                            
                            
                            
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">최소 입금 <?=$chainSymbol?><span>*</span></p>
                             <input id="min_deposit_bnb" name="min_deposit_bnb" type="text" placeholder="최소 입금 <?=$chainSymbol?>" value="<?=$min_deposit_bnb?>" style="margin-left:15px;width:30%">&nbsp;<?=$chainSymbol?>
                            </div>
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">최소 출금 <?=$chainSymbol?><span>*</span></p>
                             <input id="min_withdraw_bnb" name="min_withdraw_bnb" type="text" placeholder="최소 출금 <?=$chainSymbol?>" value="<?=$min_withdraw_bnb?>" style="margin-left:15px;width:30%">&nbsp;<?=$chainSymbol?>
                            </div>
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">입금 제한 <?=$chainSymbol?><span>*</span></p>
                             <input id="max_deposit_bnb" name="max_deposit_bnb" type="text" placeholder="입금 제한 <?=$chainSymbol?>" value="<?=$max_deposit_bnb?>" style="margin-left:15px;width:30%">&nbsp;<?=$chainSymbol?>&nbsp;<span style="color:#E40101">이상일 시 입금 제한</span>
                            </div>
                            
                            
                            
                            
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">최소 입금 <?=$Symbol?><span>*</span></p>
                             <input id="min_deposit_token" name="min_deposit_token" type="text" placeholder="최소 입금 <?=$Symbol?>" value="<?=$min_deposit_token?>" style="margin-left:15px;width:30%">&nbsp;<?=$Symbol?>
                            </div>      
                            
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">최소 출금 <?=$Symbol?><span>*</span></p>
                             <input id="min_withdraw_token" name="min_withdraw_token" type="text" placeholder="최소 출금 <?=$Symbol?>" value="<?=$min_withdraw_token?>" style="margin-left:15px;width:30%">&nbsp;<?=$Symbol?>
                            </div>                            
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">입금 제한 <?=$Symbol?><span>*</span></p>
                             <input id="max_deposit_token" name="max_deposit_token" type="text" placeholder="입금 제한 <?=$Symbol?>" value="<?=$max_deposit_token?>" style="margin-left:15px;width:30%">&nbsp;<?=$Symbol?>&nbsp;<span style="color:#E40101">이상일 시 입금 제한</span>
                            </div>
                            
                                           
     
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">최소 KRW 입금<span>*</span></p>
                             <input id="min_deposit_krw" name="min_deposit_krw" type="text" placeholder="최소 KRW 입금" value="<?=$min_deposit_krw?>" style="margin-left:15px;width:30%">&nbsp;KRW
                            </div>                            
                                           
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">최소 KRW 출금<span>*</span></p>
                             <input id="min_withdraw_krw" name="min_withdraw_krw" type="text" placeholder="최소 KRW 출금" value="<?=$min_deposit_krw?>" style="margin-left:15px;width:30%">&nbsp;KRW
                            </div>    
                            
                                           
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">KRW 출금수수료<span>*</span></p>
                             <input id="cash_withdraw_fee" name="cash_withdraw_fee" type="text" placeholder="KRW 출금수수료" value="<?=$cash_withdraw_fee?>" style="margin-left:15px;width:30%">%
                            </div>  
                            
                            
                            
                            
                                           
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">입금은행<span>*</span></p>
                             <input id="bank_name" name="bank_name" type="text" placeholder="입금은행" value="<?=$bank_name?>" style="margin-left:15px;width:70%">
                            </div>  
                            
                                           
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">입금계좌<span>*</span></p>
                             <input id="bank_account" name="bank_account" type="text" placeholder="입금계좌" value="<?=$bank_account?>" style="margin-left:15px;width:70%">
                            </div>  
                            
                                           
             
                        
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">예금주<span>*</span></p>
                             <input id="bank_account_holder" name="bank_account_holder" type="text" placeholder="입금계좌" value="<?=$bank_account_holder?>" style="margin-left:15px;width:70%">
                            </div>  
                            
                            
                            
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">구글 이메일<span>*</span></p>
                             <input id="email_id" name="email_id" type="text" placeholder="구글 이메일주소" value="<?=$email_id?>" style="margin-left:15px;width:50%">
                            </div>  
                            
                            
                            
                            <div class="checkout__input" style="margin-top:20px">
                             <p style="font-weight:500;display:inline-block">구글 앱비밀번호<span>*</span></p>
                             <input id="email_pw" name="email_pw" type="password" placeholder="구글 앱비밀번호" value="<?=$email_pw?>" style="margin-left:15px;width:50%">
                            </div>
                            
                            
                            
                            <div style="text-align:center">
                            
                             <input type="button" class="site-btn mt-30" onclick="SAVE()" value="저장" style="background:#A61313">
         
                            </div>
                            
                        </div>
                        

                        
                    </div>
                    

            </div>
        </div>        
        
        
        
        
        
        

  </div>
  
  </Form>
                        
  <div style="height:100px"></div>
 


<script>

  
 async function SEL_BOX(){
  
  var form = document.Form ;
  
  if ( form.token_quote_way[0].checked == true ) {
    
   document.getElementById("box").style.display = "none";
    
  }
  else {
  
   document.getElementById("box").style.display = "block";
   
  }  

 } 
   
   
   
             
function numberWithCommas(x,y) {

  if ( y == "A" ) return x.toString().replace(/,/gi,"");
  else if ( y == "B" )return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

}     


 
 function isNumber(testValue){

    var chars = ",.0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 
    
 async function SAVE(){
   
    var form = document.Form ;
    
    if ( form.token_quote_way[1].checked == true & document.getElementById("arte_usdt").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "토큰시세를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("arte_usdt").focus();
      return;
     
     });
     
     return;
     
    }
    
    if ( document.getElementById("ExpectationTransactionFee").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "예상 가스비+네트워크수수료를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("ExpectationTransactionFee").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("ExpectationTransactionFee").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "예상 가스비+네트워크수수료는 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("ExpectationTransactionFee").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    

   
   
    if ( document.getElementById("WithdrawFee").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "출금수수료를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("WithdrawFee").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("WithdrawFee").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "출금수수료는 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("WithdrawFee").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    


   
    if ( document.getElementById("min_deposit_bnb").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 입금 <?=$chainSymbol?>를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_deposit_bnb").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("min_deposit_bnb").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 입금 <?=$chainSymbol?>는 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_deposit_bnb").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
    
    


   
    if ( document.getElementById("min_withdraw_bnb").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 출금 <?=$chainSymbol?>를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_withdraw_bnb").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("min_withdraw_bnb").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 출금 <?=$chainSymbol?>는 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_withdraw_bnb").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
    

    if ( document.getElementById("max_deposit_bnb").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "입금 제한 <?=$chainSymbol?>를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("max_deposit_bnb").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("max_deposit_bnb").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "입금 제한 <?=$chainSymbol?>는 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("max_deposit_bnb").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    

             
                   
                 
                 
                 
                 
                 
    if ( document.getElementById("min_deposit_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 입금 토큰은 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_deposit_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("min_deposit_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 입금 토큰은 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_deposit_token").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
    if ( document.getElementById("min_withdraw_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 출금 토큰은 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_withdraw_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("min_withdraw_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 출금 토큰은 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_withdraw_token").focus();
      return;
     
     });
     
     return;
     
    }
    
    




    if ( document.getElementById("max_deposit_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "입금 제한 토큰을 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("max_deposit_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("max_deposit_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "입금 제한 토큰은 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("max_deposit_token").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
    
    
    

    
    
    
    
    if ( document.getElementById("min_deposit_krw").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 KRW 입금 금액은 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_deposit_krw").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("min_deposit_krw").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 KRW 입금 금액은 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_deposit_krw").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("min_withdraw_krw").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 KRW 출금 금액은 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_withdraw_krw").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("min_withdraw_krw").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "최소 KRW 출금 금액은 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("min_withdraw_krw").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("cash_withdraw_fee").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "KRW 출금수수료는 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("cash_withdraw_fee").focus();
      return;
     
     });
     
     return;
     
    }
    
   
    if ( !isNumber(document.getElementById("cash_withdraw_fee").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "KRW 출금수수료는 숫자만 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("cash_withdraw_fee").focus();
      return;
     
     });
     
     return;
     
    }
    
    
   
    if ( document.getElementById("email_id").value == ""  ) {
      
     Swal.fire({
      icon: "warning",
      text: "구글 이메일주소를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("email_id").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
   
    if ( document.getElementById("email_pw").value == ""  ) {
      
     Swal.fire({
      icon: "warning",
      text: "구글 앱 비밀번호를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("email_pw").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();

       if ( form.token_quote_way[0].checked == true ) {
         
        formdata.append("token_quote_way", "bithumb");
        
       }
       else {
         
        formdata.append("token_quote_way", "db");
        
       }  
       
       if ( form.token_quote_way[0].checked == true ) {
         
        formdata.append("arte_usdt", "1");
        
       }
       else {
         
        formdata.append("arte_usdt", document.getElementById("arte_usdt").value);

       }
       
       formdata.append("ExpectationTransactionFee", document.getElementById("ExpectationTransactionFee").value);
       formdata.append("WithdrawFee", document.getElementById("WithdrawFee").value);

       formdata.append("min_deposit_bnb", document.getElementById("min_deposit_bnb").value);
       formdata.append("min_withdraw_bnb", document.getElementById("min_withdraw_bnb").value);
       
       formdata.append("min_deposit_token", document.getElementById("min_deposit_token").value);
       formdata.append("min_withdraw_token", document.getElementById("min_withdraw_token").value);

       formdata.append("min_deposit_krw", document.getElementById("min_deposit_krw").value);
       formdata.append("min_withdraw_krw", document.getElementById("min_withdraw_krw").value);
       formdata.append("cash_withdraw_fee", document.getElementById("cash_withdraw_fee").value);

       formdata.append("bank_name", document.getElementById("bank_name").value);
       formdata.append("bank_account", document.getElementById("bank_account").value);
       formdata.append("bank_account_holder", document.getElementById("bank_account_holder").value);

       formdata.append("max_deposit_bnb", document.getElementById("max_deposit_bnb").value);
       formdata.append("max_deposit_token", document.getElementById("max_deposit_token").value);
    
       formdata.append("email_id", document.getElementById("email_id").value);
       formdata.append("email_pw", document.getElementById("email_pw").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./setting_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         console.log(result.replace(/^\s+|\s+$/gm,''));
         
         
         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "정상적으로 저장되었습니다.",
          }).then((ok) => {
         
           location.href = "./setting.php" ;

          
          });
         
         
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
         return;
         
       });
          
          
      
      
  
  
 }
 


SEL_BOX() ;


</script>




<?

 include("footer.php");
 
?> 
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
  
  <?if ( $mobile_certification == "Y" ) {?>
  document.writeln("<div id='left_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:30%;display:inline-block;border:1px #EEEEEE solid;margin-right:30px;text-align:left;'>");
  <?}else{?>
  document.writeln("<div id='left_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:30%;display:inline-block;border:1px #EEEEEE solid;margin-right:30px;text-align:left;'>");
  <?}?>
}
else { 
  
  document.writeln("<div id='left_box' class='web'>");
  
}  

</script>
  

   <div style="border:1px #E5E5E5 solid;background:#A61313;padding:15px;color:#FFFFFF;font-size:13pt;font-weight:500;text-align:center">설정</div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='setting.php';">전송설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='terms.php';">약관설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='company_setting.php';">업체정보</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='adm_info.php';">비밀번호 변경</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>

  </div>







<script>

if ( window.innerWidth > 991 ) {
  
  <?if ( $mobile_certification == "Y" ) {?>
  document.writeln("<div id='right_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  <?}else{?>
  document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  <?}?>
  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">비밀번호 변경</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>






            
            <div class="checkout__form" style="margin-top:30px;text-align:left">
            
            <form name="Form" method="POST">
            
                    <input type="hidden" id="confirmation" value="Y"> 
                    


                            <div class="checkout__input" style="">
                             <p>이전 비밀번호<span>*</span></p>
                             <input id="PrevUserPwd" name="PrevUserPwd" type="password" placeholder="" value="" >
                            </div>
                            
                            <div class="checkout__input" style="margin-top:20px">
                             <p>신규 비밀번호<span>*</span></p>
                             <input id="UserPwd" name="UserPwd" type="password" placeholder="" value="" >
                            </div>
                            
                            <div class="checkout__input" style="margin-top:20px">
                             <p>신규 비밀번호 확인<span>*</span></p>
                             <input id="UserPwdCnfm" name="UserPwdCnfm" type="password" placeholder="" value="" >
                            </div>
                            
   
                            <div style="margin-top:25px;text-align:left;font-size:12pt;color:#A61313">※ 비밀번호는 소문자 + 숫자(4자리 ~ 12자리 이내)로 등록하셔야 합니다.</div>
   
                            <div style="text-align:center;">
                             <input type="button" class="site-btn mt-30" onclick="SAVE()" value="변경하기" style="margin-right:5px;border-radius:5px;background:#A61313">
                            </div>
                            
                            
           
                    
            </form>  
            

            </div>
        </div>        
        
        
        
        
        
        

  </div>

  <div style="height:100px"></div>
 

<script>


 async function SAVE(){
   

    
    
    if ( document.getElementById("PrevUserPwd").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "이전 비밀번호를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("PrevUserPwd").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("UserPwd").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "신규 비밀번호를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserPwd").focus();
      return;
     
     });
     
     return;
     
    }

    if ( document.getElementById("UserPwdCnfm").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "신규 비밀번호 확인을 해주세요.",
     }).then((ok) => {
       
      document.getElementById("UserPwdCnfm").focus();
      return;
     
     });
     
     return;
     
    }
    
    if ( document.getElementById("UserPwd").value != document.getElementById("UserPwdCnfm").value ) {
      
     Swal.fire({
      icon: "warning",
      text: "신규 비밀번호가 일치하지 않습니다.",
     }).then((ok) => {
       
      document.getElementById("UserPwd").focus();
      return;
     
     });
     
     return;
     
    }
    
    


    
    
       var formdata = new FormData();
       

       formdata.append("PrevUserPwd", document.getElementById("PrevUserPwd").value);
       formdata.append("UserPwd", document.getElementById("UserPwd").value);

       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_info_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         console.log(result);
         
         if ( result == "succ" ) { 
           
          Swal.fire({
           icon: "success",
           text: "정상적으로 변경되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_info.php" ;
           return;
          
          });
         
         
         }
         else if ( result == "pwd_fail" ) { 
           
          Swal.fire({
           icon: "success",
           text: "이전 비밀번호가 일치하지 않습니다.",
          }).then((ok) => {

           return;
          
          });
         
         
         }
         
         
       })
       .catch(error => {
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           return;
          
          });
         console.log(error) ;
         
       });
          
          
      
      
  
  
 }
 
 
    
</script>

 
<?

 include("footer.php");
 
?> 
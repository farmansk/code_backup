<?

 include("header.php"); 
       
?>  


<?

 $strSQL = "Select * " ;
 $strSQL = $strSQL . " from setting " ;
 $query = mysqli_query($link, $strSQL );
 $rs=$query->fetch_assoc();
 
 $terms_of_use = htmlspecialchars($rs["TermsofUse"]) ;
 $privacy_policy = htmlspecialchars($rs["PrivacyPolicy"]) ;


?>

       <script>
       
        let container_position_x = ( window.innerWidth - 549 ) / 2 ;
        let container_position_y = ( window.innerHeight - 615 ) / 2 ;

        if ( window.innerWidth > 991 ) {
         
         if ( window.innerHeight <= 768 ) {
             
          document.writeln("<div class='container'>");
         
         }
         else{
             
          document.writeln("<div class='container' style='position:relative;top:50px;'>");
         
         }
        
        }
        else {
          
         document.writeln("<div class='container' style='margin-top:50px;text-align:center;'>");
        
        }  
        
       </script>


       <CENTER>
            
        <script>
        
         if ( window.innerWidth > 991 ) {
               
          document.writeln("<div style='width:549px;border:2px #B0B1B3 solid;border-radius:10px;background:#FFFFFF'>") ;

         }
         else {
               
          document.writeln("<div style='width:100%;border:2px #B0B1B3 solid;border-radius:10px;background:#FFFFFF'>") ;

         }  
         
        </script>
        
         <div>
          <img src="./img/login_top.png" style="width:100%">
         </div>
         
         <div style="padding:30px;text-align:left">
         
         
          <input type="hidden" id="confirmation" value=""> 
          
          <div class="web">
          
           <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:15%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500;cursor:pointer" onclick="location.href='./login.php'">로그인<div style="height:13px"></div></div>
           <div style="vertical-align:top;display:inline-block;width:20%;text-align:center;color:#262626;border-bottom:5px #262626 solid;font-size:15pt;font-weight:500">회원가입<div style="height:10px"></div></div>
           <div style="vertical-align:top;margin-top:43px;margin-left:-4px;display:inline-block;width:60%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500"></div>
          
          </div>
          <div class="mob">
          
           <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:45%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500;cursor:pointer" onclick="location.href='./login.php'">로그인<div style="height:13px"></div></div>
           <div style="vertical-align:top;display:inline-block;width:45%;text-align:center;color:#262626;border-bottom:5px #262626 solid;font-size:15pt;font-weight:500">회원가입<div style="height:10px"></div></div>

          </div>
          
          <div class="checkout__input" style="margin-top:20px">
           <p>이메일<span>*</span></p>
           <input id="UserEmail" name="UserEmail" type="text" placeholder="이메일을 입력하세요." value="" style="width:70%;display:inline-block;">
           <input type="button" style="margin-left:10px;display:inline-block;width:100px;border:2px #A61313 solid;text-align:left;font-size:12pt;color:#FFFFFF;background-color:#A61313;border-radius:2px;font-weight:500;" onclick="doubleCheck()" value="중복확인">
          </div>
                            
          <div class="checkout__input" style="margin-top:20px">
           <p>비밀번호<span>*</span></p>
           <input id="UserPwd" name="UserPwd" type="password" placeholder="비밀번호를 입력하세요." value="">
          </div>
                            
          <div class="checkout__input" style="margin-top:20px">
           <p>비밀번호 확인<span>*</span></p>
           <input id="UserPwdCnfm" name="UserPwdCnfm" type="password" placeholder="비밀번호 확인을 해주세요." value="">
          </div>

          <div class="checkout__input" style="margin-top:20px">
           <p>전화번호<span>*</span></p>
           <input id="UserMobile" name="UserMobile" type="text" placeholder="'-'기호 생략" value="">
          </div>
          
          <div class="checkout__input" style="margin-top:20px">
           <p>이용약관<span>*</span></p>
           <textarea id="" name="" placeholder="" style="height:100px;padding:10px;background:#EEEEEE" readonly><?=$terms_of_use?></textarea>
           <label style="display:inline-block;vertical-align:top;margin-top:-20px"><input type="checkbox" id="Terms_of_Use" name="Terms_of_Use" value="Y"><i></i>&nbsp;</label><span style="display:inline-block;vertical-align:top;margin-top:-10px">&nbsp;이용약관에 동의합니다.</span>
          </div>
                            
          <div class="checkout__input" style="margin-top:-20px">
           <p>개인정보처리방침<span>*</span></p>
           <textarea id="" name="" placeholder="" style="height:100px;padding:10px;background:#EEEEEE" readonly><?=$privacy_policy?></textarea>
           <label style="display:inline-block;vertical-align:top;margin-top:-20px"><input type="checkbox" id="Privacy_Policy" name="Privacy_Policy" value="Y"><i></i>&nbsp;</label><span style="display:inline-block;vertical-align:top;margin-top:-10px">&nbsp;개인정보처리방침에 동의합니다.</span>
          </div>
                            
          <a href="javascript:SAVE()" class="site-btn" style="margin-top:20px;width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">회원가입&nbsp;<img src="./img/lock_icon.png"></a>
          
          <div style="text-align:center;margin-top:10px">
           이미 회원이신가요?&nbsp;&nbsp;<div style="color:#A61313;display:inline-block;font-weight:500;cursor:pointer" onclick="location.href='./login.php'">로그인</div>
          </div>
          
          <div style="margin-top:20px;font-size:12pt;color:#A61313"><?=$setting_rs["Copyright"]?></div>
          
                                                      
         </div>
                            
    
        </div>

        <div style="height:50px"></div>

       </CENTER>
       
       
       
 

<script>



 
 
      
 let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');

 async function doubleCheck(){


    if ( document.getElementById("UserEmail").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일주소를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserEmail").focus();
      return;
     
     });
     
     return;
     
    }


    
    if ( !regex.test(document.getElementById("UserEmail").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일주소를 정확하게 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserEmail").focus();
      return;
     
     });
     
     return;
     
    }

    
       var formdata = new FormData();
       
       formdata.append("id", document.getElementById("UserEmail").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./id_check.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         console.log(result);
         
         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          Swal.fire({
           icon: "warning",
           text: "사용 가능한 이메일주소입니다.",
          }).then((ok) => {
         
           document.getElementById("confirmation").value = "Y" ;
           
           return;
          
          });
         
         
         }
         else {
           
          Swal.fire({
           icon: "warning",
           text: "이미 사용중인 이메일주소입니다.",
          }).then((ok) => {
         
           document.getElementById("confirmation").value = "" ;
           return;
          
          });
          
            
         }
         
           
         
       })
       .catch(error => {
         
         document.getElementById("confirmation").value = "" ;
         console.log(error) ;
         return;
         
       });
       
       
       
 }



 async function SAVE(){
   

       
       
    
    if ( document.getElementById("UserEmail").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일주소를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserEmail").focus();

      return;
     
     });
     
     return;
     
    }


    
    if ( !regex.test(document.getElementById("UserEmail").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일주소를 정확하게 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserEmail").focus();
      return;
     
     });
     
     return;
     
    }
    
    if ( document.getElementById("confirmation").value != "Y" ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일 중복확인을 해주세요.",
     }).then((ok) => {
     
      doubleCheck();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("UserPwd").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "비밀번호를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserPwd").focus();
      return;
     
     });
     
     return;
     
    }



    if ( document.getElementById("UserPwdCnfm").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "비밀번호 확인을 해주세요.",
     }).then((ok) => {
       
      document.getElementById("UserPwdCnfm").focus();
      return;
     
     });
     
     return;
     
    }
    
    if ( document.getElementById("UserPwd").value != document.getElementById("UserPwdCnfm").value ) {
      
     Swal.fire({
      icon: "warning",
      text: "비밀번호가 일치하지 않습니다.",
     }).then((ok) => {
       
      document.getElementById("UserPwd").focus();
      return;
     
     });
     
     return;
     
    }


    
    
    


    
    if ( document.getElementById("UserMobile").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "전화번호를 정확하게 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("UserMobile").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
    
    
    
    if ( document.getElementById("Terms_of_Use").checked != true ) {
      
     Swal.fire({
      icon: "warning",
      text: "이용약관에 동의해 주세요.",
     }).then((ok) => {
     
      document.getElementById("Terms_of_Use").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    if ( document.getElementById("Privacy_Policy").checked != true ) {
      
     Swal.fire({
      icon: "warning",
      text: "개인정보처리방침에 동의해 주세요.",
     }).then((ok) => {
     
      document.getElementById("Privacy_Policy").focus();
      return;
     
     });
     
     return;
     
    }
    

    

       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 회원가입 진행중입니다. 중간에 종료하지 마세요." ;

        
       var formdata = new FormData();
       
       formdata.append("UserEmail", document.getElementById("UserEmail").value);
       formdata.append("UserPwd", document.getElementById("UserPwd").value);
       formdata.append("UserMobile", document.getElementById("UserMobile").value);
       
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./join_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
       console.log(result);
       
         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>정상적으로 가입되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "login.php" ;
           return;
          
          });
         
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "fail" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>장애가 발생하였습니다. 잠시 후에 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
         
         
         }
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         console.log(error) ;
         
       });
          
          
      
      
  
  
 }
 
 
 
    
</script>




<?

 include("footer.php");
 
?> 

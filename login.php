<?

 include("header.php"); 
       
?>  


<?

 $_SESSION['TempUserEmail'] = "" ;

?>

       <script>
       
        let container_position_x = ( window.innerWidth - 549 ) / 2 ;
        let container_position_y = ( window.innerHeight - 615 ) / 2 ;

        if ( window.innerWidth > 991 ) {
         
         if ( window.innerHeight <= 768 ) {
              
          document.writeln("<div class='container'>");
          
         }
         else {
              
          document.writeln("<div class='container' style='position:relative;top:"+container_position_y+"px'>");
          
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
         
         
          <div class="web">
          
           <div style="vertical-align:top;display:inline-block;width:15%;text-align:center;color:#262626;border-bottom:5px #262626 solid;font-size:15pt;font-weight:500">로그인<div style="height:10px"></div></div>
           <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:20%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500;cursor:pointer" onclick="location.href='./join.php'">회원가입<div style="height:13px"></div></div>
           <div style="vertical-align:top;margin-top:43px;margin-left:-4px;display:inline-block;width:60%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500"></div>
          
          </div>
          <div class="mob">
          
           <div style="vertical-align:top;display:inline-block;width:45%;text-align:center;color:#262626;border-bottom:5px #262626 solid;font-size:15pt;font-weight:500">로그인<div style="height:10px"></div></div>
           <div style="vertical-align:top;margin-left:-2px;display:inline-block;width:45%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500;cursor:pointer" onclick="location.href='./join.php'">회원가입<div style="height:13px"></div></div>
          
          </div>
          
          
          <div class="checkout__input" style="margin-top:20px">
           <p>이메일</p>
           <input id="UserEmail" name="UserEmail" type="text" placeholder="이메일을 입력하세요." value="" autocomplete="off">
          </div>
                            
          <div class="checkout__input" style="margin-top:20px">
           <p>비밀번호</p>
           <input id="UserPwd" name="UserPwd" type="password" placeholder="비밀번호를 입력하세요." value="" autocomplete="off">
          </div>
          
          <div class="header__top__right__language" onclick="location.href='./pwd_search.php'" style="text-align:right;margin-top:10px">
           <i class="fa fa-lock"></i>&nbsp;&nbsp;비밀번호를 잃어버리셨나요?
          </div>
          
          <a href="javascript:LOGIN()" class="site-btn" style="margin-top:20px;width:100%;text-align:center;background:#262626;font-size:12pt;border-radius:5px;">로그인&nbsp;<img src="./img/lock_icon.png"></a>
          
          <div style="text-align:center;margin-top:10px">
           회원이 아니신가요?&nbsp;&nbsp;<div style="color:#262626;display:inline-block;font-weight:500;cursor:pointer" onclick="location.href='./join.php'">회원가입</div>
          </div>
          
          <div style="margin-top:20px;font-size:12pt;color:#262626"><?=$setting_rs["Copyright"]?></div>
          
                                                      
         </div>
                            
    
        </div>


       </CENTER>
       
       
       
 
<script>

 async function LOGIN(){
   

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


       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증메일을 보내는 중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("UserEmail", document.getElementById("UserEmail").value);
       formdata.append("UserPwd", document.getElementById("UserPwd").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./loginOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "stop" ) { 

          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>중지된 계정입니다.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
           
         } 
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 

           document.getElementById("loadingdiv").style.display = "none";
           //location.href = "./main.php" ;
           location.href = "./email_certification.php" ;
           return;
           
         }  
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>로그인 정보가 일치하지 않습니다.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
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
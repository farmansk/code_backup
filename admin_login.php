<?

 include("header.php"); 
       
?>  


<?

 $_SESSION['TempAdminEmail'] = "" ;


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
            
        <div style="width:549px;border:2px #B0B1B3 solid;border-radius:10px;background:#FFFFFF">

         <div>
          <img src="./img/login_top.png">
         </div>
         
         <div style="padding:30px;text-align:left">
         
         
         
          <div style="vertical-align:top;width:100%;text-align:center;color:#A61313;border-bottom:5px #A61313 solid;font-size:15pt;font-weight:500">관리자 로그인<div style="height:10px"></div></div>
          
          <div class="checkout__input" style="margin-top:20px">
           <p>이메일주소</p>
           <input id="UserEmail" name="UserEmail" type="text" placeholder="이메일주소를 입력하세요." value="" autocomplete="off">
          </div>
                            
          <div class="checkout__input" style="margin-top:20px">
           <p>비밀번호</p>
           <input id="UserPwd" name="UserPwd" type="password" placeholder="비밀번호를 입력하세요." value="" autocomplete="off">
          </div>
          
          <a href="javascript:LOGIN()" class="site-btn" style="margin-top:20px;width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">로그인&nbsp;<img src="./img/lock_icon.png"></a>
          
          <div style="margin-top:20px;font-size:12pt;color:#A61313"><?=$setting_rs["Copyright"]?></div>
          
                                                      
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
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("UserEmail", document.getElementById("UserEmail").value);
       formdata.append("UserPwd", document.getElementById("UserPwd").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./admin_loginOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         //console.log(result.replace(/^\s+|\s+$/gm,''));

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           location.href = "./admin_email_certification.php" ;
           
           //location.href = "./admin_main.php" ;           
           
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

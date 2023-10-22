<?

 include("header.php"); 

 
?>  
             

       <script>
       
        let container_position_x = ( window.innerWidth - 549 ) / 2 ;
        let container_position_y = ( window.innerHeight - 400 ) / 2 ;

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
         
         
          <div style="vertical-align:top;display:inline-block;width:30%;text-align:center;color:#A61313;border-bottom:5px #A61313 solid;font-size:15pt;font-weight:500">비밀번호 찾기<div style="height:10px"></div></div>
          <div style="vertical-align:top;margin-top:43px;margin-left:-4px;display:inline-block;width:65%;text-align:center;color:#666666;border-bottom:2px #E5E5E5 solid;font-size:15pt;font-weight:500"></div>
          
          <div class="checkout__input" style="margin-top:20px">
           <p>이메일 주소</p>
           <input id="UserEmail" name="UserEmail" type="text" placeholder="" value="">
           <p style="margin-top:10px;color:#DF0000">* 이메일로 임시 비밀번호를 전송해 드립니다.<p>
          </div>
          
          <a href="javascript:CONFIRM()" class="site-btn" style="margin-top:5px;width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">확인&nbsp;<img src="./img/lock_icon.png"></a>
          
          
          <div style="margin-top:20px;font-size:12pt;color:#A61313"><?=$setting_rs["Copyright"]?></div>
          
                                                      
         </div>
                            
    
        </div>


       </CENTER>

<script>

 let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');


 async function CONFIRM(){
  

 
 
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
    
    
    
    
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("UserEmail", document.getElementById("UserEmail").value);


 
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./pwd_searchOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "이메일로 임시 비밀번호를 전송해 드렸습니다.",
          }).then((ok) => {
         
           location.href = "./login.php" ;
           return;
          
          });
         
         
         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "일치하는 계정이 없습니다. 다시 시도해 주세요.",
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
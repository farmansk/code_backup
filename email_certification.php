<?

 include("header.php"); 

 
?>  

<?if ( $_SESSION['TempUserEmail'] == "" ) {?>

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

       <script>
       
        let container_position_x = ( window.innerWidth - 549 ) / 2 ;
        let container_position_y = ( window.innerHeight - 335 ) / 2 ;

        if ( window.innerWidth > 991 ) {
          
         document.writeln("<div class='container' style='position:relative;top:"+container_position_y+"px'>");
        
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
         
         
          <div class="checkout__input">
           <p>인증번호</p>
           <input id="certification_num" name="certification_num" type="text" placeholder="" value="" autocomplete="off">
           <p style="margin-top:10px;color:#DF0000">* 이메일로 인증번호를 전송하였습니다.<p>
          </div>

          
          <a href="javascript:CONFIRM()" class="site-btn" style="margin-top:5px;width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">확인&nbsp;<img src="./img/lock_icon.png"></a>
          
          
          <div style="margin-top:20px;font-size:12pt;color:#A61313"><?=$setting_rs["Copyright"]?></div>
          
                                                      
         </div>
                            
    
        </div>


       </CENTER>

<script>

 async function CONFIRM(){
  
  var form = document.Form ;
  
   
 
 
    if ( document.getElementById("certification_num").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("certification_num").focus();

      return;
     
     });
     
     return;
     
    }


    
    
    
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호 발송처리중입니다. 중간에 절대로 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("certification_num").value);


 
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         console.log(result.replace(/^\s+|\s+$/gm,''));

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          location.href = "./main.php" ;
          return;

         
         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           location.href = "./login.php" ;
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
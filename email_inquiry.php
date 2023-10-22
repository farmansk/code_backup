<?

 include("header.php"); 

?> 


<?if ( $_SESSION['UserEmail'] == "" ) {?>

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
  

   <div style="border:1px #E5E5E5 solid;background:#A61313;padding:15px;color:#FFFFFF;font-size:13pt;font-weight:500;text-align:center">고객센터</div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='customer_support.php';">지원받기</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='notice.php';">공지사항</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='faq.php';">자주하는 질문</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='email_inquiry.php';">이메일 문의</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   
  </div>



<script>

if ( window.innerWidth > 991 ) {
  

  document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");

  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">이메일 문의</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>


        

            <div class="checkout__form" style="text-align:left">


                    <div class="row">
                    

                        
                        <div class="col-lg-12">
                        
                        
                        
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">제&nbsp;&nbsp;&nbsp;목<span>*</span></p>
                             <input id="title" name="title" type="text" placeholder="제목" value="" style="margin-left:15px;width:90%;display:inline-block">
                            </div>
                        
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">성&nbsp;&nbsp;&nbsp;명<span>*</span></p>
                             <input id="name" name="name" type="text" placeholder="성명" value="" style="margin-left:15px;width:90%">
                            </div>
                        
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">연락처<span>*</span></p>
                             <input id="mobile" name="mobile" type="text" placeholder="'-' 기호없이 입력" value="" style="margin-left:15px;width:90%">
                            </div>
                        
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">이메일<span>*</span></p>
                             <input id="email" name="email" type="text" placeholder="이메일" value="" style="margin-left:15px;width:90%">
                            </div>
                            
                            <div class="checkout__input">
                             <p style="vertical-align:top;font-weight:500;display:inline-block">내&nbsp;&nbsp;&nbsp;용<span>*</span></p>
                             <textarea id="cont" name="cont" style="margin-left:15px;width:90%"></textarea>
                            </div>

                        
                            <div style="text-align:center">
                            
                             <a href="javascript:SAVE()" class="site-btn" style="width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">문의하기&nbsp;<img src="./img/lock_icon.png"></a>
                             
                            </div>
   
                            
                        </div>
                        
                        
                    </div>
                    


        </div>   
        
        
        

  </div>

 
 
<script>


      
 let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');

 
    
 async function SAVE(){
   

    if ( document.getElementById("title").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "제목을 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("title").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("name").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "성명을 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("name").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    if ( document.getElementById("mobile").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "연락처를 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("mobile").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    if ( document.getElementById("email").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일을 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("email").focus();
      return;
     
     });
     
     return;
     
    }
    
    

    
    if ( !regex.test(document.getElementById("email").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "이메일을 정확하게 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("email").focus();
      return;
     
     });
     
     return;
     
    }
    

    
    if ( document.getElementById("cont").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "문의내용을 정확하게 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("cont").focus();
      return;
     
     });
     
     return;
     
    }
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("title", document.getElementById("title").value);
       formdata.append("name", document.getElementById("name").value);
       formdata.append("mobile", document.getElementById("mobile").value);
       formdata.append("email", document.getElementById("email").value);
       formdata.append("cont", document.getElementById("cont").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./email_inquiry_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         
         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "정상적으로 문의가 접수되었습니다.",
          }).then((ok) => {
         
           location.href = "./customer_support.php" ;
           return;
          
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
 
 

</script>


<?

 include("footer.php");
 
?> 
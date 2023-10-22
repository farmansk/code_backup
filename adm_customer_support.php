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

  $strSQL = "Select * " ;
  $strSQL = $strSQL . " from setting " ;
  
  $query = mysqli_query($link, $strSQL );
  $rs=$query->fetch_assoc();
   
  $contactus_url = htmlspecialchars($rs["contactus_url"]) ;
  $contactus_email = htmlspecialchars($rs["contactus_email"]) ;
  $operating_time = $rs["operating_time"] ;
  
  $operating_time = str_replace("<br>","\r\n", $operating_time );
  
  
  
  
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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='adm_customer_support.php';">지원받기</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='notice_list.php';">공지사항</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='faq_list.php';">자주하는 질문</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
  </div>



<script>

if ( window.innerWidth > 991 ) {
  

  document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");

  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">지원받기</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>

   <div class="checkout__form" style="text-align:left">
   
    <div class="col-lg-12 col-md-6">
                        
     <div class="checkout__input">
      <p style="font-weight:500">1:1문의 바로가기<span>*</span></p>
      <input id="contactus_url" name="contactus_url" type="text" placeholder="" value="<?=$contactus_url?>">
     </div>
               
     <div class="checkout__input" style="margin-top:30px">
      <p style="font-weight:500">문의메일<span>*</span></p>
      <input id="contactus_email" name="contactus_email" type="text" placeholder="" value="<?=$contactus_email?>">
     </div>
     
               
     <div class="checkout__input" style="margin-top:30px">
      <p style="font-weight:500">운영시간<span>*</span></p>
      <textarea id="operating_time" name="operating_time" placeholder=""><?=$operating_time?></textarea>
     </div>
     
                            
     <a href="javascript:SAVE()" class="site-btn" style="width:100%;text-align:center;background:#A61313;font-size:12pt;border-radius:5px;">저장&nbsp;<img src="./img/lock_icon.png"></a>
         
         
         
                 
    </div>

                    
   </div>
                            
                    


  </div>

 
 

<script>



 
      
 let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');

 
 async function SAVE(){
   

       
    if ( document.getElementById("contactus_email").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "문의메일을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("contactus_email").focus();
      return;
     
     });
     
     return;
     
    }


    
    if ( !regex.test(document.getElementById("contactus_email").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "문의메일을 정확하게 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("contactus_email").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
       var formdata = new FormData();
       
       formdata.append("contactus_url", document.getElementById("contactus_url").value);
       formdata.append("contactus_email", document.getElementById("contactus_email").value);
       formdata.append("operating_time", document.getElementById("operating_time").value);
       
       
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_customer_support_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         
         if ( result == "succ" ) { 
           
          Swal.fire({
           icon: "success",
           text: "성공적으로 저장되었습니다.",
          }).then((ok) => {
         
           location.href = "./adm_customer_support.php" ;
           return;
          
          });
         
         
         }
         
         
         
         
       })
       .catch(error => {
         
         console.log(error) ;
         
       });
          
          
      
      
  
  
 }
 
 
 
    
</script>






<?

 include("footer.php");
 
?> 
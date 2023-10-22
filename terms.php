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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='setting.php';">전송설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='terms.php';">약관설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">약관설정</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>



   <div class="checkout__form" style="text-align:left">


                    <div class="row">
                    

        

                        <div class="col-lg-12" style="margin-top:30px">
                        
                            <div>
                             <p><?if ( $lang == "en" ) {?>Terms of Use<?}else if ( $lang == "ko" ) {?>이용약관<?}?><span>*</span></p>
                             <textarea id="TermsofUse" name="TermsofUse" placeholder="" style="width:100%"><?=htmlspecialchars($rs["TermsofUse"])?></textarea>
                            </div>
                            
                            <div style="margin-top:20px">
                             <p><?if ( $lang == "en" ) {?>Privacy Policy<?}else if ( $lang == "ko" ) {?>개인정보수집<?}?><span>*</span></p>
                             <textarea id="PrivacyPolicy" name="PrivacyPolicy" placeholder="" style="width:100%"><?=htmlspecialchars($rs["PrivacyPolicy"])?></textarea>
                            </div>
                            
                            
                            <input type="button" class="site-btn mt-30" onclick="SAVE()" value="<?if ( $lang == "en" ) {?>SAVE<?}else if ( $lang == "ko" ) {?>저장<?}?>">
                            
                        </div>
                        
                        
                        

                    </div>        
        
        
        
        
        
        

   </div>
</div>

<div style="height:100px"></div>





<script>

    
    
 async function SAVE(){
   
   
   
    if ( document.getElementById("TermsofUse").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>Please enter your terms and conditions.<?}else{?>이용약관을 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("TermsofUse").focus();
      return;
     
     });
     
     return;
     
    }
    
    
     
    if ( document.getElementById("PrivacyPolicy").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>Please enter the personal information collection terms and conditions.<?}else{?>개인정보수집 약관을 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("PrivacyPolicy").focus();
      return;
     
     });
     
     return;
     
    }
    

    
    
    

       
       var formdata = new FormData();
       formdata.append("TermsofUse", document.getElementById("TermsofUse").value);
       formdata.append("PrivacyPolicy", document.getElementById("PrivacyPolicy").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./terms_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         
         if ( result == "succ" ) { 
           
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>정상적으로 저장되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "terms.php" ;
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
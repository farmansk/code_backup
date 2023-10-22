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

   
  $business_num = htmlspecialchars($rs["business_num"]) ;
  $ceo = htmlspecialchars($rs["ceo"]) ;
  $addr = htmlspecialchars($rs["addr"]) ;
  $copyright = htmlspecialchars($rs["Copyright"]) ;
  $company_name = htmlspecialchars($rs["CompanyName"]) ;
   

  

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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='terms.php';">약관설정</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='company_setting.php';">업체정보</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">업체정보</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>



   <div class="checkout__form" style="text-align:left">


                    <div class="row">
                        

                      <div class="col-lg-12">
                      
                      
                            <div class="checkout__input" style="margin-top:20px">
                             <p><?if ( $lang == "en" ) {?>domain address<?}else if ( $lang == "ko" ) {?>업체명<?}?><span>*</span></p>
                             <input id="company_name" name="company_name" type="text" placeholder="" value="<?=$company_name?>">
                            </div>

                            <div class="checkout__input" style="margin-top:50px">
                             <p><?if ( $lang == "en" ) {?>domain address<?}else if ( $lang == "ko" ) {?>사업자번호<?}?><span>*</span></p>
                             <input id="business_num" name="business_num" type="text" placeholder="" value="<?=$business_num?>">
                            </div>

                            <div class="checkout__input" style="margin-top:50px">
                             <p><?if ( $lang == "en" ) {?>domain address<?}else if ( $lang == "ko" ) {?>대표자명<?}?><span>*</span></p>
                             <input id="ceo" name="ceo" type="text" placeholder="" value="<?=$ceo?>">
                            </div>

                            <div class="checkout__input" style="margin-top:50px">
                             <p><?if ( $lang == "en" ) {?>domain address<?}else if ( $lang == "ko" ) {?>업체주소<?}?><span>*</span></p>
                             <input id="addr" name="addr" type="text" placeholder="" value="<?=$addr?>">
                            </div>

                            <div class="checkout__input" style="margin-top:50px">
                             <p><?if ( $lang == "en" ) {?>domain address<?}else if ( $lang == "ko" ) {?>Copyright<?}?><span>*</span></p>
                             <input id="copyright" name="copyright" type="text" placeholder="" value="<?=$copyright?>">
                            </div>
                            
                            
                            
                            <input type="button" class="site-btn mt-30" onclick="SAVE()" value="<?if ( $lang == "en" ) {?>SAVE<?}else if ( $lang == "ko" ) {?>저장<?}?>">
                            
                      </div>

                    </div>        
        
        
        
        
        
        

   </div>
   
   
   
</div>

<div style="height:100px"></div>


<script>





       
       
       
       
       
 function isNumber(testValue){

    var chars = "-0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 
 

 async function SAVE(){
   
   

   
    if ( document.getElementById("company_name").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>Please select a domain.<?}else{?>업체명을 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("company_name").focus();
      return;
     
     });
     
     return;
     
    }
   
   
   
    
    if ( document.getElementById("business_num").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>ICO fee<?}else{?>사업자번호를 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("business_num").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   
    
    if ( !isNumber(document.getElementById("business_num").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>ICO fee<?}else{?>사업자번호는 숫자와 "-" 기호로 구성되어야 합니다.<?}?>",
     }).then((ok) => {
     
      document.getElementById("business_num").focus();
      return;
     
     });
     
     return;
     
    }
    
    
    
    
    if ( document.getElementById("ceo").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>ICO fee<?}else{?>대표자명을 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("ceo").focus();
      return;
     
     });
     
     return;
     
    }

    
    if ( document.getElementById("addr").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>Please enter the withdrawal date.<?}else{?>업체주소를 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("addr").focus();
      return;
     
     });
     
     return;
     
    }
    

    
     
    if ( document.getElementById("copyright").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?if ( $lang == "en" ) {?>Please enter the settlement date.<?}else{?>저작권 문구를 입력해 주세요.<?}?>",
     }).then((ok) => {
     
      document.getElementById("copyright").focus();
      return;
     
     });
     
     return;
     
    }
    

    
     
       var formdata = new FormData();

       formdata.append("company_name", document.getElementById("company_name").value);
       formdata.append("business_num", document.getElementById("business_num").value);
       formdata.append("ceo", document.getElementById("ceo").value);
       formdata.append("addr", document.getElementById("addr").value);
       formdata.append("copyright", document.getElementById("copyright").value);

       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./company_setting_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         
         if ( result == "succ" ) { 
           
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>정상적으로 저장되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "company_setting.php" ;
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
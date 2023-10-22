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


 if ( isset($_GET["intNowPage"]) ) {

  $intNowPage = $_GET["intNowPage"] ;

 }
 else {
  
  if ( isset($_POST["intNowPage"]) ) $intNowPage = $_POST["intNowPage"] ;
  else $intNowPage = 0 ;  
  
 }
 



 if ( isset($_GET["seqno"]) ) {

  $seqno = $_GET["seqno"] ;

 }
 else {
  
  if ( isset($_POST["seqno"]) ) $seqno = $_POST["seqno"] ;
  else $seqno = 0 ;  
  
 }
 


 $query = mysqli_query($link, "SELECT * FROM faq Where seqno = '".$seqno."'");
 $rs=$query->fetch_assoc();

 $title  = htmlspecialchars($rs["title"]) ;
 $cont  = htmlspecialchars($rs["cont"]) ;
 
  
?>


<script>

 function SEARCH(){
  
  
  var form = document.Form ;

  form.intNowPage.value = "" ;
  
  
  form.action = "faq_list.php";
  form.submit(); 
   
 }  



 function GO() {
 
  var form = document.Form ;

	form.action = "faq_list.php";
	form.submit();
 
 }



   
   
</script>



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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='adm_customer_support.php';">지원받기</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='notice_list.php';">공지사항</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='faq_list.php';">자주하는 질문</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   
  </div>



<script>

if ( window.innerWidth > 991 ) {
  

  document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");

  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">자주하는 질문</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>



            <div class="checkout__form" style="text-align:left">

                <script type="text/javascript" src="./se2/js/HuskyEZCreator.js" charset="utf-8"></script> 
                
                <form name="Form" method="POST">
                
                 <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">
      
                    <div class="row">
                    

                        
                        <div class="col-lg-12 col-md-6">
                        
                        
                        
                            <div class="checkout__input">
                             <p style="font-weight:500;display:inline-block">제목<span>*</span></p>
                             <input id="title" name="title" type="text" placeholder="제목" value="<?=$title?>" style="margin-left:15px;width:90%">
                            </div>
                            
                            <div class="checkout__input" style="margin-top:20px">
                            
                             <textarea id="cont" name="cont" style="height:500px"><?=$cont?></textarea>
                             
                            </div>
                        
                            <div style="text-align:center">
                            
                             <input type="button" class="site-btn mt-30" onclick="SAVE()" value="저장" style="background:#A61313">
                             <input type="button" class="site-btn mt-30" onclick="history.back()" value="취소" style="border:1px #E5E5E5 solid;background:#EEEEEE;color:#666666">
                             
                            </div>
                            
                        </div>
                        
                        
                    </div>
                    
                </form>
            </div>
        </div>        
        
        
        
        
        
        

  </div>

 
 


<script>

    
    
    
 async function SAVE(){
   
    var form = document.Form ;
   
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
    
    
    
    if ( oEditors.getById["cont"].getIR() == "" || oEditors.getById["cont"].getIR() == '<br>' ) {
      
     Swal.fire({
      icon: "warning",
      text: "내용을 입력해 주세요.",
     }).then((ok) => {
     
      document.getElementById("cont").focus();
      return;
     
     });
     
     return;
     
    }
    

    
    oEditors.getById["cont"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.

   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("seqno", "<?=$seqno?>");
       formdata.append("title", document.getElementById("title").value);
       formdata.append("cont", document.getElementById("cont").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./faq_modify_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         
         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>정상적으로 저장되었습니다.<?}?>",
          }).then((ok) => {
         
           form.action = "./faq_list.php" ;
           form.submit() ;
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
 




var oEditors = [];

nhn.husky.EZCreator.createInIFrame({

    oAppRef: oEditors,

    elPlaceHolder: "cont",

    sSkinURI: "./se2/SmartEditor2Skin.html",

    htParams : { 

      fOnBeforeUnload : function(){ 

 
      } 

    },

    fOnAppLoad : function(){


    },

    fCreator: "createSEditor2"

});






</script>




<?

 include("footer.php");
 
?> 
<?

 include("header.php"); 

 
?>  


<?if ( $_SESSION['UserEmail'] == "" ) {?>

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



<?

 $query = mysqli_query($link, "Select mobile_certification from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();

 $mobile_certification = htmlspecialchars($rs["mobile_certification"]) ;


 $smsT = 120 ;


?>

             
   
<div class='container' style="text-align:center">


 
<script>

if ( window.innerWidth > 991 ) {
  
  <?if ( $mobile_certification == "Y" ) {?>
   if ( window.innerHeight <= 768 ) {
     
    document.writeln("<div id='left_box' style='vertical-align:top;background:#FFFFFF;width:30%;display:inline-block;border:1px #EEEEEE solid;margin-right:30px;text-align:left;'>");
    
   }
   else {  
     
    document.writeln("<div id='left_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:30%;display:inline-block;border:1px #EEEEEE solid;margin-right:30px;text-align:left;'>");
    
   }
  <?}else{?>
   document.writeln("<div id='left_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:30%;display:inline-block;border:1px #EEEEEE solid;margin-right:30px;text-align:left;'>");
  <?}?>
}
else { 
  
  document.writeln("<div id='left_box' class='web'>");
  
}  

</script>
  

   <div style="border:1px #E5E5E5 solid;background:#A61313;padding:15px;color:#FFFFFF;font-size:13pt;font-weight:500;text-align:center">마이페이지</div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;color:#A61313">보안인증</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='login_list.php';">로그인 내역</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='info.php';">비밀번호 변경</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='withdrawal.php';">회원 탈퇴</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
  </div>







<script>

if ( window.innerWidth > 991 ) {
  
  <?if ( $mobile_certification == "Y" ) {?>
  
   if ( window.innerHeight <= 768 ) {
       
    document.writeln("<div id='right_box' style='vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
   }
   else {
       
    document.writeln("<div id='right_box' style='position:relative;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");

   }
    
  <?}else{?>

   document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  <?}?>
  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">보안인증</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;text-align:left;font-size:13pt;font-weight:500"><img src="./img/one.png" style="height:10px;margin-top:-2px">&nbsp;&nbsp;보안등급 안내</div>




   <div style="margin-top:15px;margin-bottom:30px;">
   
    <?if ( $mobile_certification == "Y" ) {?><img src="./img/box1.png"><?}else{?><img src="./img/box2.png"><?}?>
    
   </div>
   
   
   
   <div style="margin-top:25px;text-align:left;font-size:13pt;font-weight:400;text-align:center"><?=base64_decode($_SESSION['UserEmail'])?>님의 보안 등급은 <span style="color:#A61313;font-weight:600"><?if ( $mobile_certification == "Y" ) {?>Ⅲ<?}else{?>II<?}?></span> 단계입니다.</div>
   

   <div id="certification_box" <?if ( $mobile_certification == "Y" ) {?>style="display:none"<?}?>>
     
     
     
     <div style="margin-top:15px;margin-bottom:15px;text-align:left;font-size:13pt;font-weight:500"><img src="./img/one.png" style="height:10px;margin-top:-2px">&nbsp;&nbsp;본인 인증</div>
         
      <div class="col-lg-12 col-md-6 col-sm-12" style="text-align:left">
        <div class="shoping__checkout v2 mt-0">
        
         <input type="hidden" id="confirmation" value=""> 
         
         <div class="checkout__input" style="margin-top:20px">
          <p>휴대전화<span>*</span></p>
          <input id="UserMobile" name="UserMobile" type="text" placeholder="'-'기호 생략" value="" style="width:70%;display:inline-block;">
          <input id="btn" type="button" style="margin-left:10px;display:inline-block;width:150px;border:2px #E5E5E5 solid;text-align:left;font-size:12pt;color:#666666;background-color:#EEEEEE;border-radius:2px;font-weight:500;" onclick="Certification_Number_Send()" value="인증번호 발송">
         </div>
         
   
         <div class="checkout__input" style="margin-top:20px">
          <p>인증번호<span>*</span></p>
          <input id="Certification_Number" name="Certification_Number" type="text" placeholder="인증번호입력" value="" style="width:200px;background:#EEEEEE">
         </div>
         
         <div class="checkout__input" style="margin-top:20px;display:none" id="tm_box">
          <p>남은시간</p>
          <input id="tm" name="tm" type="text" placeholder="0" value="0" style="width:200px;background:#EEEEEE">
         </div>
         
         <p style="margin-top:40px"><a href="javascript:certification()" class="primary-btn" style="background:#DE0303">확인</a></p>
         
        </div>
      </div>
      
      
      
   </div>  
     
     
     
     
     
   <div style="margin-top:15px;margin-bottom:15px;text-align:left;font-size:13pt;font-weight:500"><img src="./img/one.png" style="height:10px;margin-top:-2px">&nbsp;&nbsp;보안 등급별 서비스</div>
         
   <table style="width:100%;border:1px solid #E5E5E5">
      <thead>
                            <tr>
                             <th style="border-left:1px solid #A61313;border-right:1px solid #E5E5E5;background:#A61313;font-size:11pt;color:#FFFFFF;padding:15px;text-align:center">보안 Ⅰ 단계</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;font-size:11pt;color:#FFFFFF;padding:15px;text-align:center">보안 Ⅱ 단계</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;font-size:11pt;color:#FFFFFF;padding:15px;text-align:center">보안 Ⅲ 단계</th>
                            </tr>
                            
   
                            <tr>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:15px;text-align:center">-</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:15px;text-align:center">-</th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:15px;text-align:center;font-weight:400">코인 입출금<br>코인 구매</th>
                            </tr>
                            
                            
                            
                            
      </thead>
      <tbody>     
      </tbody>     
   </table> 
     
     
     
     
     
  </div>





</div>

<?if ( $mobile_certification == "N" ) {?>
<div style="height:100px"></div>
<?}?>


<script>


 
let container_position_x ;
let container_position_y ;
 
if ( window.innerWidth > 991 ) {
  
 container_position_x = ( window.innerWidth - 549 ) / 2 ;
 
 <?if ( $mobile_certification == "Y" ) {?>
 
 container_position_y = ( ( window.innerHeight - document.getElementById("right_box").clientHeight ) / 2 ) - 80 ;
 
 <?}else{?>
 
 container_position_y = ( ( window.innerHeight - document.getElementById("right_box").clientHeight ) / 2 )  ;
 
 <?}?> 
 
}
  
 
if ( window.innerWidth > 991 ) {
 
 <?if ( $mobile_certification == "Y" ) {?>
 
  if ( window.innerHeight <= 768 ) {
  }
  else {  
    
   document.getElementById("left_box").style.top = container_position_y + "px" ;
   document.getElementById("right_box").style.top = container_position_y + "px";;
   
  }  
   
 <?}else{?>
 
   //document.getElementById("left_box").style.top = container_position_y  + "px" ;
   //document.getElementById("right_box").style.top = container_position_y + "px" ;
   
 <?}?>  
   
}
else {
          

        
}  




 async function mobile_certification(){
  
  document.getElementById("certification_box").style.display = "block";
  
 }
 
 
  
  
 var set_ready = "" ;
 var snd = parseInt(0) ;  

 snd = parseInt(<?=$smsT?>) ;

 var m, s ;

 function ready_action()
 {
   
  var form = document.Form ;
  
  set_ready = setTimeout("ready_action()",1000);
  
  if ( snd < 0 ) {

       
   snd = parseInt(0) ;
   clearTimeout(set_ready) ;
   

   Swal.fire({
    icon: "warning",
    text: "인증시간이 만료되었습니다. 다시 인증해 주세요.",
   }).then((ok) => {
       
    document.getElementById("UserMobile").disabled = false ;
    document.getElementById("UserMobile").value = "";
    document.getElementById("btn").disabled = false ;
    document.getElementById("Certification_Number").value = "";
           
    document.getElementById("tm_box").style.display = "none";
   
    return;
     
   });
     
   return;
     


   

  }
 

  m = parseInt((snd%3600)/60);
  s = snd%60;
  
  if ( m < 10 ) m = "0" + m ;
  if ( s < 10 ) s = "0" + s ;

  document.getElementById("tm").value =  m + ":" + s ; 

  snd = parseInt(snd) - 1 ;

  
 }

 

   
   
 async function Certification_Number_Send(){


    
  
       if ( document.getElementById("UserMobile").value == "" ) {
      
        Swal.fire({
         icon: "warning",
         text: "휴대전화를 입력해 주세요.",
        }).then((ok) => {
       
         document.getElementById("UserMobile").focus();
         return;
     
        });
     
        return;
     
       }





       var formdata = new FormData();
       
       formdata.append("UserMobile", document.getElementById("UserMobile").value);
       
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./Certification_Number_Send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
          console.log(result);
         if ( result != "" ) { 
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 발송되었습니다.",
          }).then((ok) => {
            
           document.getElementById("UserMobile").disabled = true ;
           document.getElementById("btn").style.disabled = true ;
           document.getElementById("Certification_Number").value = result;
           
           document.getElementById("tm_box").style.display = "block";
           
           ready_action();
           
           return;
          
          });
         
         
         }
         
         
       })
       .catch(error => {
         
         console.log(error) ;
         
       });
       
       
       
       
    

 }
 

 async function certification(){
  


  
       if ( document.getElementById("UserMobile").value == "" ) {
      
        Swal.fire({
         icon: "warning",
         text: "휴대전화를 입력해 주세요.",
        }).then((ok) => {
       
         document.getElementById("UserMobile").focus();
         return;
     
        });
     
        return;
     
       }


  
       if ( document.getElementById("Certification_Number").value == "" ) {
      
        Swal.fire({
         icon: "warning",
         text: "인증번호를 입력해 주세요.",
        }).then((ok) => {
       
         document.getElementById("Certification_Number").focus();
         return;
     
        });
     
        return;
     
       }
       
       
       var formdata = new FormData();
       
       formdata.append("Certification_Number", document.getElementById("Certification_Number").value);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./security_authentication_certification.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
          
         if ( result == "succ" ) { 
           
          Swal.fire({
           icon: "success",
           text: "인증이 완료되었습니다.",
          }).then((ok) => {
            
           location.href = "./security_authentication.php";
           return;
          
          });
         
         
         }
         else {
           

           Swal.fire({
            icon: "success",
            text: "인증번호가 일치하지 않습니다.",
           }).then((ok) => {
            
       
            document.getElementById("UserMobile").disabled = false ;
            document.getElementById("UserMobile").value = "";
            document.getElementById("btn").disabled = false ;
            document.getElementById("Certification_Number").value = "";
           
            document.getElementById("tm_box").style.display = "none";
            
            snd = parseInt(<?=$smsT?>) ;
   
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
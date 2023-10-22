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


 
 $query = mysqli_query($link, "Select * from users Where UserEmail = '".$_SESSION['UserEmail']."'");
 $rs=$query->fetch_assoc();

 $deposit_address = base64_decode(htmlspecialchars($rs["deposit_address"])) ;
 $deposit_privateKey = base64_decode(htmlspecialchars($rs["deposit_privateKey"])) ;
 
 $mobile_certification = htmlspecialchars($rs["mobile_certification"]) ;
 
 
 
 
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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='security_authentication.php';">보안인증</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='login_list.php';">로그인 내역</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='info.php';">비밀번호 변경</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;color:#A61313;cursor:pointer" onclick="location.href='withdrawal.php';">회원 탈퇴</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">회원탈퇴</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>
   
   
   <div style="margin-top:15px;text-align:left;font-size:13pt;font-weight:500"><img src="./img/one.png" style="height:10px;margin-top:-2px">&nbsp;&nbsp;ARTEMART COIN 회원 탈퇴 신청합니다..</div>







            
            <div class="checkout__form" style="margin-top:30px;text-align:left">
            
            <form name="Form" method="POST">
            
                    <input type="hidden" id="confirmation" value=""> 
                    
    

                            <div class="checkout__input" style="">
                             <p>비밀번호 확인<span>*</span></p>
                             <input id="UserPwd" name="UserPwd" type="password" placeholder="" value="" >
                            </div>


   
                            <div style="margin-top:25px;text-align:left;font-size:11pt;color:#262626">※ 탈퇴 시, 회원님의 개인정보가 삭제되어 복구할 수 없사오니 이 점 유의하시기 바랍니다.</div>
                            <div style="margin-top:10px;text-align:left;font-size:11pt;color:#262626">※ 회원탈퇴 진행 시 해당 아이디는 영구적으로 삭제되어 재가입이 불가합니다.</div>
                            <div style="margin-top:10px;text-align:left;font-size:11pt;color:#262626">※ 회원님의 회원정보(이름,아이디,이메일주소,연락처 등)는 불량 이용자의 재가입 방지, 명예회손, 등 권리침해 분쟁 및 수사 협조를 위해 회원탈퇴 후 1년간 보관됩니다.</div>
   
   
   
                            <div style="text-align:center;">
                             <input type="button" class="site-btn mt-30" onclick="CONFIRM()" value="탈퇴하기" style="margin-right:5px;border-radius:5px;background:#A61313">
                            </div>
   
                    
            </form>  
            
            
            </div>

  </div>


<script>

 
 
 async function CONFIRM(){
   

    
    
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
    
    
    


    
    
       var formdata = new FormData();
       


       formdata.append("UserPwd", document.getElementById("UserPwd").value);

       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./withdrawalOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           

      
          Swal.fire({
           icon: "success",
           text: "정상적으로 탈퇴처리가 되었습니다. 저희 서비스를 이용해 주셔서 정말로 감사드립니다.",
          }).then((ok) => {

           location.href = "./login.php";
           return;
          
          });
          
            
         
         }
         else if ( result == "pwd_fail" ) { 
           
          Swal.fire({
           icon: "warning",
           text: "비밀번호가 일치하지 않습니다.",
          }).then((ok) => {

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
         
       });
          
          
      
      
  
  
 }
 
 
    
</script>




<?

 include("footer.php");
 
?> 
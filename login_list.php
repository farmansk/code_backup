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


      
 $intNowPage = 0 ;
 
 $intPageSize = 20 ;
 $intBlockPage = 10 ;

 if ( isset($_GET["intNowPage"]) ) {

  $intNowPage = $_GET["intNowPage"] ;

 }
 else {
  
  if ( isset($_POST["intNowPage"]) ) $intNowPage = $_POST["intNowPage"] ;
  else $intNowPage = 0 ;  
  
 }
 
 if ( $intNowPage == "" ) $intNowPage = 0;
 
 $orderBy = " order by regdate desc" ;
 
 
 
?>



<script>

 function SEARCH(){
  
  
  var form = document.Form ;

  form.intNowPage.value = "" ;
  
  
  form.action = "login_list.php";
  form.submit(); 
   
 }  



 function GO(val) {
 
  var form = document.Form ;
  
	form.intNowPage.value = val ;
	
	form.action = "login_list.php";
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
  

   <div style="border:1px #E5E5E5 solid;background:#A61313;padding:15px;color:#FFFFFF;font-size:13pt;font-weight:500;text-align:center">마이페이지</div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;;cursor:pointer" onclick="location.href='security_authentication.php';">보안인증</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;color:#A61313;cursor:pointer" onclick="location.href='login_list.php';">로그인 내역</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='info.php';">비밀번호 변경</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='withdrawal.php';">회원 탈퇴</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
  </div>



<script>

if ( window.innerWidth > 991 ) {
  

  document.writeln("<div id='right_box' style='margin-top:50px;vertical-align:top;background:#FFFFFF;width:65%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");

  
}
else { 
  
  document.writeln("<div id='right_box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">로그인 내역</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>

   <div style="margin-top:15px;margin-bottom:15px;text-align:left;font-size:13pt;font-weight:500"><img src="./img/one.png" style="height:10px;margin-top:-2px">&nbsp;&nbsp;회원님의 로그인 내역을 확인할 수 있습니다.</div>



         <form name="Form" method="post">   
         
            <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">
            
            <div class="checkout__form">




<?

  $Search_SQL = " WHERE UserEmail = '".$_SESSION["UserEmail"]."' "  ;

  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from login_connect" . $Search_SQL ;

  $query = mysqli_query($link, $strSQL );
  $rs=$query->fetch_assoc();
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
   
   $intTotalCount = $rs["Count(seqno)"];
   $intTotalPage = $rs["CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")"];
  
  }  
  else {
    
   $intTotalCount = 0;
   $intTotalPage = 0;
   
  }  
  
  
 
?> 


                    <div style="height:10px;"></div>

                    <table style="width:100%;border:1px solid #E5E5E5">
                     <thead>
                            <tr>
                             <th style="border-left:1px solid #A61313;border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">번호</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">아이디</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">로그인 상태</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">ip</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">날짜</th>
                            </tr>
                     </thead>
                     <tbody>     
                           
                           
                           
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From login_connect " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
   
   
                            <tr>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["num"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=base64_decode($rs["UserEmail"])?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["state"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["ip"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["regdate"]?></th>
                            </tr>
   
   
	 <?

     
    $i = $i + 1 ;
    
    
   }
   
  }
  else {
    
   $DATA_OK = "OK" ;
     
  }  
    
    
				  
?>
   
                     </tbody>     
                    </table>
   
                    <div class="product__pagination text-center">
                    
            <?if ( $DATA_OK != "OK" ) {?>

              <?
             
               $intTemp = ( ( $intNowPage - 1 ) / $intBlockPage ) * $intBlockPage + 1 ; 
 
              ?> 
              
              <?if ( $intNowPage <= 0 ) {?>

							 <a onclick=""><i class="fa fa-long-arrow-left"></i></a>
							 
						  <?}else{?>
						  
						   <a onclick="GO('<?=$intNowPage - 1?>"><i class="fa fa-long-arrow-left"></i></a>
						   
						  <?}?>
		
		
              <?
                
 

               for( $i = 0 ; $i < $intTotalPage ; $i++){

                if ( $i == $intNowPage ) {
                
                ?>
                 
                 <a href="javascript:;" style="background:#0084FF;color:#FFFFFF;border: 1px #027AEA solid;"><?=$i+1?></a>
                 
                <?}else{?>
              
							   <a onclick="GO('<?=$i?>')" style="cursor:pointer"><?=$i+1?></a>
							   
                <?}?>
				
                <?
                  
               }
                 

              ?>  
				
  
              <a <?if ( $intNowPage >= $intTotalPage ) {?>href="javascript:GO('<?=$i?>')"<?}?>><i class="fa fa-long-arrow-right"></i></a>
							

						
            <?}?>

                        
                        
                    </div>
                    
                    
                    
                    
                    
                    
                    
                    
            </div>
            
         </form>   
         


  </div>

 


<?

 include("footer.php");
 
?> 
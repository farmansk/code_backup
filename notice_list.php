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


 $searchsql = "" ;

 $schtxt = "";
 
 if ( isset($_GET["schtxt"]) ) {

  $schtxt = $_GET["schtxt"] ;

 }
 else {
  
  if ( isset($_POST["schtxt"]) ) $schtxt = $_POST["schtxt"] ;
  else $schtxt = "" ;  
  
 }
 
 if ( $schtxt != "" ) {
                      
  $searchsql = $searchsql . " AND title like '%".$schtxt."%'" ;
                      
 } 
 
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
  
  
  form.action = "notice_list.php";
  form.submit(); 
   
 }  



 function GO(val) {
 
  var form = document.Form ;
  
	form.intNowPage.value = val ;
	
	form.action = "notice_list.php";
	form.submit();
 
 }


 function WRITE(){
  
  
  var form = document.Form ;

  form.action = "notice_write.php";
  form.submit(); 
   
 } 



 function MODIFY(val) {
 
  var form = document.Form ;
  
	form.seqno.value = val ;
	
	form.action = "notice_modify.php";
	form.submit();
 
 }
 
 
 
 
 
 
 async function DEL(val){
   
   var form = document.Form ;
    
   var ans = window.confirm("정말로 삭제할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Deleting. Don't quit in the middle.<?}else{?>* 삭제중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       
       formdata.append("seqno", val);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./notice_delete.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "성공적으로 삭제되었습니다.",
          }).then((ok) => {
         
           form.action = "./notice_list.php" ;
           form.submit() ;
           return;
          
          });
         
         
         }
         

         return;

         
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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='notice_list.php';">공지사항</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">공지사항</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>



     <form name="Form" method="post">   
         
      <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">
      <input name="seqno" type="hidden" value="">
      
      <div class="checkout__form">
      


<?

  $Search_SQL = " WHERE 1 = 1 "  ;
  $Search_SQL = $Search_SQL . $searchsql ;
  

  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from board" . $Search_SQL ;

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

        <div style="text-align:left">

         <div class="checkout__input" style="display:inline-block;vertical-align:top;">
          <p>게시물 수<span style="margin-left:15px"><?=$intTotalCount?></span></p>
         </div>
         <div style="margin-left:5px;margin-top:-40px;display:inline-block;vertical-align:top">
          <input type="button" class="site-btn mt-30" onclick="WRITE()" value="글쓰기" style="background:#A61313">        
         </div>

        </div>
        
        <table style="width:100%;border:1px solid #E5E5E5">
         <thead>
          <tr>
           <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;padding:5px;text-align:center">번호</th>
           <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;padding:5px;text-align:center">제목</th>
           <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;padding:5px;text-align:center">작성일자</th>
           <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;padding:5px;text-align:center">조회수</th>
           <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;padding:5px;text-align:center">관리</th>
          </tr>
         </thead>
         <tbody>
         
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From board " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
  
          <tr>
           <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center"><?=$rs["num"]?></th>
           <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:left"><?=$rs["title"]?></th>
           <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center;"><?=$rs["regdate"]?></th>
           <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center;"><input id="ReadCnt" name="ReadCnt" type="text" placeholder="조회수" value="<?=$rs["ReadCnt"]?>" style="width:50px;text-align:center" onblur="SAVE('<?=htmlspecialchars($rs["seqno"])?>',this.value)"></th>
           <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:center">
           
            <input type="button" style="border:2px #A61313 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#A61313;border-radius:2px;font-weight:500;padding:5px" onclick="MODIFY('<?=htmlspecialchars($rs["seqno"])?>')" value="수정">
            <input type="button" style="border:2px #DD0000 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#F00000;border-radius:2px;font-weight:500;padding:5px" onclick="DEL('<?=htmlspecialchars($rs["seqno"])?>')" value="삭제">
                              
           </th>
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
      
   
        <div class="product__pagination text-center;" style="text-align:center">
                    
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
                    
                    

        <div class="checkout__input" style="margin-top:30px">
        
                             <input type="text" id="schtxt" name="schtxt" placeholder="검색어 입력" value="<?=$schtxt?>" style="width:250px;height:30px;display:inline-block" onkeydown="if(window.event.keyCode == 13) SEARCH();">
                             <div style="margin-left:-4px;background:#A61313;border: 1px #027AEA solid;color:#FFFFFF;width:30px;height:30px;text-align:center;cursor:pointer;display:inline-block;vertical-align:top" onclick="SEARCH()">
                              <img src="./img/search_icon.png" style="width:10px;height:10px">
                             </div>
  
                        
        </div>          
        
        
        
        
        
        

  </div>

 
 


<script>

    
    
 async function SAVE(no, value){
   
    var form = document.Form ;
   

       var formdata = new FormData();
       
       formdata.append("ReadCnt", value);
       formdata.append("seqno", no);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./notice_readcnt_save.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         
         if ( result == "succ" ) { 
     
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>saved.<?}else{?>정상적으로 저장되었습니다.<?}?>",
          }).then((ok) => {
         
           //form.action = "./board_list.php" ;
           //form.submit() ;
           return;
          
          });
         
         
         }
         
         
       })
       .catch(error => {
     
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
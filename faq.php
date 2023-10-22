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
  
  
  form.action = "faq.php";
  form.submit(); 
   
 }  



 function GO(val) {
 
  var form = document.Form ;
  
	form.intNowPage.value = val ;
	
	form.action = "faq.php";
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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='customer_support.php';">지원받기</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='notice.php';">공지사항</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='faq.php';">자주하는 질문</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='email_inquiry.php';">이메일 문의</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
   
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



     <form name="Form" method="post">   
         
      <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">
      <input name="seqno" type="hidden" value="">
      
      <div class="checkout__form">
      


<?

  $Search_SQL = " WHERE 1 = 1 "  ;
  $Search_SQL = $Search_SQL . $searchsql ;
  

  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from faq" . $Search_SQL ;

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

        
        <table style="width:100%">
         <tbody>
         
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From faq " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
          <tr style="height:15px">
          </tr>
          <tr>
           <th style="border-bottom:1px solid #E5E5E5;font-size:11pt;padding:5px;text-align:left;font-weight:500">
            <a href="javascript:SEL('<?=$i?>')" style="color:#262626;font-weight:500"><img src="./img/q.png" style="margin-right:5px;height:20px"><?=$rs["title"]?></a>
            <div style="height:5px"></div>
           </th>
          </tr>
          <tr id="box_<?=$i?>" style="display:none;background:#EEEEEE">
           <td style="border-bottom:1px solid #E5E5E5;padding:5px;text-align:left;font-weight:500;">
           
            <table>
             <td style="width:20px" valign="top"><img src="./img/a.png" style="height:20px"></td>
             <td style="width:5px"></td>
             <td valign="top" style="font-size:11pt;font-weight:500;"><?=preg_replace("(\<(/?[^\>]+)\>)", "", $rs["cont"])?></td>
            </table>
            
           </td>
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
                 
                 <a href="javascript:;" style="background:#A61313;color:#FFFFFF;border: 1px #A61313 solid;"><?=$i+1?></a>
                 
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
                             <div style="margin-left:-4px;background:#A61313;border: 1px #A61313 solid;color:#FFFFFF;width:30px;height:30px;text-align:center;cursor:pointer;display:inline-block;vertical-align:top" onclick="SEARCH()">
                              <img src="./img/search_icon.png" style="width:10px;height:10px">
                             </div>
  
                        
        </div>          
        
        
        
        
        
        

  </div>

 
 
<script>



 
 
 function SEL(val) {

  var form = document.Form ;
  var cnt = parseInt("<?=$intTotalCount+1?>") ;
  
  for ( var i = 1 ; i < cnt ; i++ ) {

   if ( i == val ) {
   

     document.getElementById("box_"+i).style.display = "block";
     

    
   } 
   else {

     document.getElementById("box_"+i).style.display = "none";
    
   } 

  }


 }
 

</script>


<?

 include("footer.php");
 
?> 
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


 if ( isset($_GET["seqno"]) ) {

  $seqno = $_GET["seqno"] ;

 }
 else {
  
  if ( isset($_POST["seqno"]) ) $seqno = $_POST["seqno"] ;
  else $seqno = 0 ;  
  
 }


 if ( isset($_GET["intNowPage"]) ) {

  $intNowPage = $_GET["intNowPage"] ;

 }
 else {
  
  if ( isset($_POST["intNowPage"]) ) $intNowPage = $_POST["intNowPage"] ;
  else $intNowPage = 0 ;  
  
 }
 

 
 



  $query = mysqli_query($link, "SELECT * from board Where seqno < '".$seqno."' order by id desc");
  $rs=$query->fetch_assoc();

  $count = mysqli_num_rows($query);
        
  if($count > 0){
    
   $PSeqno = $rs["seqno"] ;
   $PTitle = $rs["title"] ;
   $PReadCnt = $rs["ReadCnt"] ;
   $Ptime = $rs["regdate"] ;
   
  }else{
    
   $PSeqno = "" ;
   $PTitle = "" ;
   $PReadCnt = "" ;
   $Ptime = "" ;
   
  }  
 
  $query = mysqli_query($link, "SELECT * from board Where seqno > '".$seqno."' order by id asc");
  $rs=$query->fetch_assoc();

  $count = mysqli_num_rows($query);
        
  if($count > 0){
    
   $NSeqno = $rs["seqno"] ;
   $NTitle = $rs["title"] ;
   $NReadCnt = $rs["ReadCnt"] ;
   $Ntime = $rs["regdate"] ;

  }else{
    
   $NSeqno = "" ;
   $NTitle = "" ;
   $NReadCnt = "" ;
   $Ntime = "" ;
    
  }  
  
  
  
  
 
 $ip = $_SERVER["REMOTE_ADDR"] ;
 
 
 $query = mysqli_query($link, "Select seqno from BoardReadCnt Where gubn = '공지사항' and bseqno = '".$seqno."' and ip = '".$ip."'");
 $rs=$query->fetch_assoc();

 $count = mysqli_num_rows($query);
        
 if($count > 0){
 
  $ReadYN = "Y" ;
  
 }
 else {
   
  $ReadYN = "N" ;
    
 }
 
 
 
 
 
 if ( $ReadYN == "N" ) {
 
  $link->begin_transaction();
 
  try {
   
   $SQL = "INSERT INTO BoardReadCnt " ;
   $SQL = $SQL . " (" ;
   $SQL = $SQL . " gubn " ;
   $SQL = $SQL . " , bseqno " ;
   $SQL = $SQL . " , ip " ;
   $SQL = $SQL . ") values (" ;
   $SQL = $SQL . " '공지사항' " ;
   $SQL = $SQL . " , '".$seqno."' " ;
   $SQL = $SQL . " , '".$ip."' " ;
   $SQL = $SQL . " )" ;
   mysqli_query($link,$SQL) ;

  
   $SQL = "UPDATE board set " ;
   $SQL = $SQL . " ReadCnt = ReadCnt + 1 " ;
   $SQL = $SQL . " Where seqno = '".$seqno."'" ;
   mysqli_query($link,$SQL) ;
 
 
 
   $link->commit();

    
  } catch (mysqli_sql_exception $exception) {
 
    $link->rollback();

  }
  
  
  
  
 
 }
 
 
 
 $query = mysqli_query($link, "SELECT Count(seqno) from BoardReadCnt Where gubn = '공지사항' and bseqno = '".$seqno."'") ;
 $count = mysqli_num_rows($query);
 
 if($count > 0){
   
   $rs=$query->fetch_assoc();
  
   $BoardCnt = $rs["Count(seqno)"] ;
  
 }
 else {
   
   $BoardCnt = 0 ;
  
 } 
 
 
 
 
 
 $query = mysqli_query($link, "SELECT * from board Where seqno = '".$seqno."'") ;
 $rs=$query->fetch_assoc();
  
  
?>


<script>



 function GO() {
 
  var form = document.Form ;

	form.action = "notice.php";
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
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer;color:#A61313;" onclick="location.href='notice.php';">공지사항</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_up.png" style="margin-top:-4px;height:10px;"></div></div>
   <div style="border:1px #E5E5E5 solid;padding:15px;font-size:13pt;font-weight:500;text-align:center"><div style="display:inline-block;text-align:right;width:20%"></div><div style="display:inline-block;text-align:center;width:55%;cursor:pointer" onclick="location.href='faq.php';">자주하는 질문</div><div style="display:inline-block;text-align:right;width:20%"><img src="./img/arrow_dn.png" style="margin-top:-4px;height:10px;"></div></div>
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
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px">공지사항</div>
   
   <div style="margin-top:15px;margin-bottom:30px;border:1px #E5E5E5 solid;"></div>



            
            
            
     <form name="Form" method="post">   
         
      <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">
      <input name="seqno" type="hidden" value="<?=$seqno?>">
      
      <div class="checkout__form" style="text-align:left">
      

       <div class="blog__details__text">
         <h3 style="margin-bottom:50px"><?=$rs["title"]?></h3>
         <?=$rs["cont"]?>
       </div>

       <div style="text-align:center">
                            
        <input type="button" class="site-btn mt-30" onclick="GO()" value="이전으로">
                             
       </div>
                            
                            
      </div>
      
     </form>   

    <?if ( $PSeqno != "" || $NSeqno != "" ) {?>

     <section class="related-blog section-padding-100-70" style="margin-top:-30px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related-blog-title">
                        <h2 style="font-size:15pt"><?if ( $lang == "en" ) {?>Previous/After Posts<?}else{?>이전/이후 게시물<?}?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
            
                <?if ( $PSeqno != "" ) {?>
                
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__text">
                            <ul>
                                        <li><i class="fa fa-calendar-o"></i> <?=$Ptime;?></li>
                                        <li><i class="fa fa-comment-o"></i> <?=$PReadCnt?></li>
                            </ul>
                            <h5><? echo $PTitle;?></h5>
                            <a href="./notice_view.php?seqno=<?=$PSeqno?>&intNowPage=<?=$intNowPage?>" class="blog__btn">더보기 <span class="arrow_right"></span></a>
                        </div>
                    </div>
                </div>
                
                <?}?>
                
                <?if ( $NSeqno != "" ) {?>
                
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__text">
                            <ul>
                                        <li><i class="fa fa-calendar-o"></i> <?=$Ntime;?></li>
                                        <li><i class="fa fa-comment-o"></i> <?=$NReadCnt?></li>
                            </ul>
                            <h5><? echo $NTitle;?></h5>
                            <a href="./notice_view.php?seqno=<?=$NSeqno?>&intNowPage=<?=$intNowPage?>" class="blog__btn">더보기 <span class="arrow_right"></span></a>
                        </div>
                    </div>
                </div>
                
                <?}?>
                
            </div>
        </div>
     </section>
    
    <?}?>
        
        
        
        
        
        

  </div>

 
 



<?

 include("footer.php");
 
?> 
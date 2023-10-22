
    
    
    







    <!--
    <div style="width:100%;padding:20px;background:#233083;color:#FFFFFF;text-align:center" class="web">

     <div style="display:inline-block;margin-right:50px;vertical-align:top;margin-top:15px"><a href="default.php"><img src="./img/coin.png" style="height:50px" alt=""></a></div>
     
     <div style="display:inline-block;text-align:left;vertical-align:top">
      
      <a onclick="location.href='./content.php?menu=4'" style="cursor:pointer">업체정보</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="location.href='./terms_of_use.php'" style="cursor:pointer">이용약관</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="location.href='./privacy_policy.php'" style="cursor:pointer">개인정보수집</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="location.href='./contact.php'" style="cursor:pointer">고객문의</a>
      
      <div style="margin-top:5px"><?=$setting_rs["CompanyName"]?>&nbsp;&nbsp;|&nbsp;&nbsp;사업자번호&nbsp;:&nbsp;<?=$setting_rs["business_num"]?>&nbsp;&nbsp;|&nbsp;&nbsp;대표&nbsp;:&nbsp;<?=$setting_rs["ceo"]?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$setting_rs["addr"]?></div>
      <div style="margin-top:5px"><?=$setting_rs["copyright"]?></div>
     
     </div>
     
    </div>

    
    
    
    


    <div style="width:100%;padding:20px;background:#233083;color:#FFFFFF;text-align:center" class="mob">

     <div><a href="default.php"><img src="./img/coin.png" style="height:50px" alt=""></a></div>
     
     <div style="text-align:left;vertical-align:top;margin-top:20px">
      
      <a onclick="location.href='./content.php?menu=4'" style="cursor:pointer">업체정보</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="location.href='./terms_of_use.php'" style="cursor:pointer">이용약관</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="location.href='./privacy_policy.php'" style="cursor:pointer">개인정보수집</a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="location.href='./contact.php'" style="cursor:pointer">고객문의</a>
      
      <div style="margin-top:5px"><?=$setting_rs["CompanyName"]?>&nbsp;&nbsp;|&nbsp;&nbsp;사업자번호&nbsp;:&nbsp;<?=$setting_rs["business_num"]?></div>
      <div style="margin-top:5px">대표&nbsp;:&nbsp;<?=$setting_rs["ceo"]?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$setting_rs["addr"]?></div>
      <div style="margin-top:5px"><?=$setting_rs["copyright"]?></div>
     
     </div>
     
    </div>
    -->
    

    
    
    
    

    <!-- Js Plugins -->

    <script src="/js/jquery-ui.min.js"></script>

    <?if ( $uri == "" || $uri == "/" || $uri == "default.php" || $uri == "/default.php" || $uri == "index.php" || $uri == "/index.php" ) {?> 
    <?}else{?>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.nice-select.min.js"></script>
    <script src="/js/jquery.slicknav.js"></script>
    <script src="/js/mixitup.min.js"></script>
    <script src="/js/owl.carousel.min.js"></script>
    <?}?>
    
    <script src="/js/main.js"></script>


 

<div id="loadingdiv" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 2000;display:none">
    <div class="" style="display: flex; justify-content: center; align-items: center; flex-direction: column; width: 100%; height: 100vh; background: #1a080800; backdrop-filter: blur(10px);">
    
        <h3 id="loadingdiv_result" class="" style="color: #fe5722;"><?if ( $lang == "en" ) {?>Transaction in process, Please wait and do not refresh the page.<?}else{?>* 거래가 진행 중입니다. 페이지를 새로고침하지 말고 기다려 주세요.<?}?></h3>

        <img src="./img/loading-process.gif" class="rounded-pill" width="200" height="200" />
    </div>
</div>






</body>

</html>

 
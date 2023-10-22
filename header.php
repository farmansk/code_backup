<?php 

session_start();
include("config.php"); 
include("function.php"); 

?>


<?

// https://eth-converter.com/
// ALTER TABLE 테이블명
// ADD COLUMN 컬럼명 INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

// https://chainlist.org/chain/97


// https://goerlifaucet.com 이더리움 수도꼭지

// https://testnet.bnbchain.org/faucet-smart 바이낸스 수도꼭지
 
// https://discord.com/invite/bnbchain/login
 
// 이더리움 수수료 = 0.015ETH

// 최소 BNB 입금금액 지정 = 0.015bnb




 if(isset($_COOKIE['lang'])){
  
   $lang = $_COOKIE['lang'] ;
   
 }  
 else {
  
   $lang = "ko" ;
   
 }


 //$strSQL = "Select * " ;
 //$strSQL = $strSQL . " from setting " ;
 //$query = mysqli_query($link, $strSQL );
 //$setting_rs=$query->fetch_assoc();
 
 //$chainId = mysqli_real_escape_string($link, $setting_rs["network"]) ;
 //$chainIdHex = dechex($chainId) ;
 
 
 
 
 $uri = $_SERVER['REQUEST_URI'];


?>


<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title><?=$CompanyName?></title>
    <meta name="keywords" content="<?=$CompanyName?>"/>
    <meta name="classification" content="<?=$CompanyName?>" />

    <meta name="description" content="<?=$CompanyName?>">

    <meta name="generator" content="php">
  
    <meta name="subject" content="<?=$CompanyName?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?=$CompanyName?>">
    <meta property="og:description" content="<?=$CompanyName?>">
    <meta property="og:image" content="<?=$domain?>/img/fav.png">
    <meta property="og:url" content="<?=$domain?>">
    <link rel="canonical" href="<?=$domain?>">
  
    <link rel="shortcut icon" href="<?=$domain?>/img/fav.png">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">


    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <?if ( strpos($uri,"member_list.php") == false && strpos($uri,"adm_transaction_history.php") == false ) {?>
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <?}?>
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <script src="./js/sweetalert2v11.7.3.js"></script>
	  <script type="text/javascript" src="./js/web3.min.js"></script>
	  <script src="./js/jquery.min.js">
	  <script src="./js/jquery-1.12.4.min.js"></script>
	  <script src="./js/jquery.syotimer.min.js"></script>


<script>

 function isMobile(){

	var UserAgent = navigator.userAgent;

	if (UserAgent.match(/iPhone|iPod|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mini|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson/i) != null || UserAgent.match(/LG|SAMSUNG|Samsung/) != null)
	{

		return true;

	}else{

		return false;

	}

 }
 
 
 
 
 
 var wallett = {
  contract_address: "<?=$token_address?>",
  contract_abi: <?=$token_address_abi?>
 }

        
 let web3;
 let provider = null;
 let connectedAccount = null;
 let chainId ;
 let ma = null ;       
 let pk = null ;   
 let sk = null ;
    
 
async function addTokenFunction() {
                
 if (window.ethereum) {

     
          await window.ethereum.enable();
          provider = await window.web3.currentProvider;
          web3 = await new Web3(provider);
          let accounts = await web3.eth.getAccounts();
          provider = await window.web3.currentProvider;
          connectedAccount = accounts[0];
          
          chainId = await web3.eth.net.getId();
          
          if ( chainId != <?=$chainId?> ) {
  
   
           document.getElementById("loadingdiv").style.display = "block";
           document.getElementById("loadingdiv_result").innerHTML = "* <?=$chainName?>으로 네트워크를 변경합니다." ;
           
           try {
             
             await ethereum.request({
              method: "wallet_switchEthereumChain",
              params: [{ chainId: "0x<?=$chainIdHex?>" }],
             }).then(function(result){

              location.href = "<?=$uri?>" ;
      
             });
           
           } catch (switchError) {
           
           
             ethereum.request({
              method: "wallet_addEthereumChain",
              params: [
              {
              chainId: "0x<?=$chainIdHex?>",
              chainName: "<?=$chainName?>",
              rpcUrls: ["<?=$rpcUrls?>"],
              },
              ],
             }).then(function(result){

              location.href = "<?=$uri?>" ;
      
             });
    
             
           }
             
           return ;
            
          }
                const tokenAddress = wallett.contract_address ;
              
                
                var tokenSymbol = "<?=$tokenSymbol?>" ;
                var tokenDecimals = "<?=$tokenDecimals?>" ;
                var tokenImage = "<?=$domain?>/img/fav.png";
          

                  const wasAdded = provider.request({
                    method: 'wallet_watchAsset',
                    params: {
                      type: 'ERC20', 
                      options: {
                        address: tokenAddress, 
                        symbol: tokenSymbol, 
                        decimals: tokenDecimals,
                        image: tokenImage, 
                      },
                    },
                  }).then(function(result){

                    if ( result == true ) {
                      
                     Swal.fire("Good!","<?if ( $lang == "en" ) {?>Thank you for your attention. Token added.<?}else{?>관심 가져주셔서 감사합니다. 토큰이 추가되었습니다.<?}?>","success");
                    
                    }
                    else {

                     Swal.fire("error!","<?if ( $lang == "en" ) {?>Token not added.<?}else{?>토큰을 추가하지 못했습니다.<?}?>","error");
                    
                    }
                        
                  });  

    

 } else {
                  
                  
                 Swal.fire({
                  icon: "warning",
                  text: "<?if ( $lang == "en" ) {?>Please enter only numbers for the amount.<?}else{?>메타마스크를 먼저 설치해 주세요.<?}?>",
                 }).then((ok) => {
         
                  location.href = "https://chrome.google.com/webstore/detail/metamask/nkbihfbeogaeaoehlefnkodbefgpgknn?hl=ko"; 
                  return;
     
                 });
                    
                    
 }
 
 
 
                
}





</script> 
    
    
    
    
    
</head>

<body style="background-image:url('./img/background.jpg');background-size: cover;">
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="default.php"><img src="./img/logo.png" style="height:50px" alt=""></a>
        </div>

        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
            
            
                <!--
                <?if ( $lang == "en" ) {?>
                <img src="img/language.png" alt="">
                <div>English</div>
                <?}else if ( $lang == "ko" ) {?>
                <img src="img/Flag_of_South_Korea.svg.png" alt="" style="height:14px">
                <div>Korea</div>
                <?}?>
                -->
                

                <script>
                            
                if ( isMobile() ) {
                               
                 document.writeln("<div id='google_translate_element'></div>") ;
                             
                }
                             
                </script>
                            
              
  
            </div>
            
            <div style="height:20px"></div>
            
            <div class="header__top__right__auth">
            
        <?if ( isset($_SESSION['AdminEmail']) != "" || isset($_SESSION['UserEmail']) != "" ) {?>
        

                            <div class="header__top__right__language" style="font-size:11pt" onclick="<?if ( isset($_SESSION['AdminEmail']) != "" ){?>location.href='./admin_logout.php'<?}else{?>location.href='./logout.php'<?}?>">

                             <i class="fa fa-lock"></i>&nbsp;로그아웃
                                
                            </div>
                            
        <?}else{?>
        
                            <div class="header__top__right__language" style="font-size:11pt" onclick="location.href='./join.php'">
                            
                             <i class="fa fa-user"></i>&nbsp;회원가입

                            </div>
                            <div class="header__top__right__language" style="font-size:11pt" onclick="location.href='./login.php'">

                             <i class="fa fa-lock"></i>&nbsp;로그인
                                
                            </div>
        <?}?>               
                                
            </div>
            
            
            
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>

                <?if ( isset($_SESSION['AdminEmail']) != "" ) {?>
                         
                <li><a href="./admin_main.php">홈</a></li>
                <li><a href="./member_list.php">회원관리</a></li>
                <li><a href="./adm_transaction_history.php">입출금내역</a></li>
                <li><a href="./adm_krw_history.php">KRW입출금</a></li>
                <li><a href="./adm_lockup_history.php">락업목록</a></li>
                <li><a href="./adm_customer_support.php">고객센터</a></li>
                <li>
                 <a href="./setting.php">설정</a>
                 <ul class="header__menu__dropdown" style="width:200px;text-align:left">
                  <li><a href="./setting.php">전송설정</a></li>
                  <li><a href="./terms.php">약관설정</a></li>
                  <li><a href="./company_setting.php">업체정보</a></li>
                  <li><a href="./adm_info.php">비밀번호 변경</a></li>
                 </ul>
                </li>
                  
                <?}else{?>
                         
                         
                <li><a href="./main.php">입출금</a></li>
                <li><a href="./buy_coins.php">코인구매</a></li>
                <li><a href="./deposit_krw.php">KRW입출금</a></li>
                <li><a href="./lockup_history.php">락업목록</a></li>
                <li><a href="./customer_support.php">고객센터</a></li>
                <li>
                 <a href="#">마이페이지</a>
                 <ul class="header__menu__dropdown" style="width:200px;text-align:left">
                  <li><a href="./security_authentication.php">보안인증</a></li>
                  <li><a href="./login_list.php">로그인 내역</a></li>
                  <li><a href="./info.php">비밀번호 변경</a></li>
                  <li><a href="./withdrawal.php">회원탈퇴</a></li>
                 </ul>
                </li>
                
                <?}?>
                
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>

        
    </div>
    <!-- Humberger End -->



<?if ( $uri != "/" && $uri != "/default.php" && $uri != "/login.php" && $uri != "/join.php" && $uri != "/email_certification.php" && $uri != "/pwd_search.php" ) {?>



<style>

#google_translate_element > div > div {
	position: relative;
	min-width: 200px;
	height: 60px;
}
#google_translate_element > div > div > select::-ms-expand {
    display: none;
}

#google_translate_element > div > div:after {
    content: '<>'; /* 목록 펼침 아이콘 */
    font: 17px "Consolas", monospace;
    color: #333;
    transform: rotate(90deg);
    right: 11px;
    top: 18px;
    padding: 0 0 2px;
    border-bottom: 1px solid #999;
    position: absolute;
    pointer-events: none;
}

#google_translate_element > div > div > select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    display: block;
    width: 100%;
    max-width: 320px;
    height: 50px;
    float: right;
    margin: 5px 0px;
    padding: 0px 24px;
    font-size: 16px;
    line-height: 1.75;
    color: #333;
    border: 1px solid #cccccc;
    -ms-word-break: normal;
    word-break: normal;
    border-radius: 10px;
}



</style>


    <!-- Header Section Begin -->
    <header class="header">

        <div class="container">
            <div class="row">
                <div class="col-lg-1">
                    <div class="header__logo">
                        <a href="<?if ( isset($_SESSION['AdminEmail']) != "" ) {?>./admin_main.php<?}else{?>./main.php<?}?>"><img src="./img/logo.png" style="height:50px" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6" style="text-align:right">
                    <nav class="header__menu">
                        <ul>
                        
                        
                         <?if ( isset($_SESSION['AdminEmail']) != "" ) {?>
                         
                          <li><a href="./member_list.php">회원관리</a></li>
                          <li><a href="./adm_transaction_history.php">입출금내역</a></li>
                          <li><a href="./adm_krw_history.php">KRW입출금</a></li>
                          <li><a href="./adm_lockup_history.php">락업목록</a></li>
                          <li><a href="./adm_customer_support.php">고객센터</a></li>

                          <li>
                           <a href="./setting.php">설정</a>
                           <ul class="header__menu__dropdown" style="width:200px;text-align:left">
                            <li><a href="./setting.php">전송설정</a></li>
                            <li><a href="./terms.php">약관설정</a></li>
                            <li><a href="./company_setting.php">업체정보</a></li>
                            <li><a href="./adm_info.php">비밀번호 변경</a></li>
                           </ul>
                          </li>
                
                         <?}else{?>
                         
                          <li><a href="./main.php">입출금</a></li>
                          <li><a href="./buy_coins.php">코인구매</a></li>
                          <li><a href="./deposit_krw.php">KRW입출금</a></li>
                          <li><a href="./lockup_history.php">락업목록</a></li>
                          <li><a href="./customer_support.php">고객센터</a></li>
                          <li><a href="javascript:addTokenFunction()">토큰추가</a></li>
       
                          
                          
                          
                         <?}?>     
                                    
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-5" style="text-align:right">

                  <div class="web">
                  <?if ( isset($_SESSION['AdminEmail']) != "" || isset($_SESSION['UserEmail']) != "" ) {?>
        


                            <div class="header__top__right__language" style="font-size:11pt;margin-top:25px;display:inline-block;vertical-align:top" onclick="<?if ( isset($_SESSION['AdminEmail']) != "" ){?>location.href='./admin_logout.php'<?}else{?>location.href='./logout.php'<?}?>">

                             <img src="./img/logout.png" style="height:20px">&nbsp;로그아웃
                                
                            </div>
                            
                            <?if ( isset($_SESSION['AdminEmail']) == "" ) {?>
                            <div class="header__top__right__language" style="font-size:11pt;margin-top:25px;display:inline-block;vertical-align:top" onclick="location.href='./security_authentication.php'">

                             <img src="./img/setting.png" style="height:20px">&nbsp;마이페이지
                                
                            </div>
                            <?}?>
                               
                               

                            <script>
                            
                             if ( !isMobile() ) {
                               
                              document.writeln("<div id='google_translate_element' style='width:100px;display:inline-block'></div>") ;
                             
                             }
                             
                            </script>
                            
                            
                            
                            
                  <?}?>
                  </div>
        
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
            
        </div>
    </header>

    <!-- Header Section End -->


    <script type="text/javascript">
     function googleTranslateElementInit() {
       new google.translate.TranslateElement(
         { pageLanguage: "ko" },
         "google_translate_element"
         );
     }

    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<?}else{?>




    <header class="header">

        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                            
                <script>
                         
                 if ( window.innerWidth < 991 ) {
                               
                  document.writeln("<div class='header__logo'>");
                  document.writeln("<a href='main.php'><img src='./img/logo.png'style='height:50px' alt=''></a>");
                  document.writeln("</div>");
                    
                 }   
                    
                </script>
                    
                </div>
                <div class="col-xl-6 col-lg-9" >

                </div>
                <div class="col-lg-3">

        
        
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
            
        </div>
    </header>

    


<?}?>




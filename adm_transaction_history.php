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
   
  $searchSql = " AND ( UserEmail like '%".base64_encode($schtxt)."%' OR UserMobile like '%".base64_encode($schtxt)."%' OR to_address like '%".$schtxt."%' ) " ;
   
 }  
 




 if ( isset($_GET["sdate"]) ) {

  $sdate = $_GET["sdate"] ;

 }
 else {
  
  if ( isset($_POST["sdate"]) ) $sdate = $_POST["sdate"] ;
  else $sdate = "" ;  
  
 }
 
 

 if ( isset($_GET["edate"]) ) {

  $edate = $_GET["edate"] ;

 }
 else {
  
  if ( isset($_POST["edate"]) ) $sdate = $_POST["edate"] ;
  else $edate = "" ;  
  
 }
 
 

 if ( $sdate != "" && $edate != "" ) {
   
  $searchsql = $searchsql . " AND SUBSTR(regdate,1,10) between '$sdate' AND '$edate' ";
  
 } 
 
 



 if ( isset($_GET["gubn"]) ) {

  $gubn = $_GET["gubn"] ;

 }
 else {
  
  if ( isset($_POST["gubn"]) ) $gubn = $_POST["gubn"] ;
  else $gubn = "" ;  
  
 }
 
 

 if ( $gubn != "" ) {
   
  $searchsql = $searchsql . " AND gubn = '".$gubn."' ";
  
 } 
 
 
 
 $intNowPage = 0 ;
 
 $intPageSize = 10 ;
 $intBlockPage = 10 ;

 if ( isset($_GET["intNowPage"]) ) {

  $intNowPage = $_GET["intNowPage"] ;

 }
 else {
  
  if ( isset($_POST["intNowPage"]) ) $intNowPage = $_POST["intNowPage"] ;
  else $intNowPage = 0 ;  
  
 }
 
 if ( $intNowPage == "" ) $intNowPage = 0;
 
 $orderBy = " order by seqno desc" ;
 

?>   
    

    
<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="./js/css_browser_selector.js"></script>	<!-- 크로스 브라우징 모듈 -->
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/themes/base/jquery-ui.css" rel="stylesheet" />
<style type="text/css">
<!--
   .ui-datepicker { font:12px dotum; }
   .ui-datepicker select.ui-datepicker-month, 
   .ui-datepicker select.ui-datepicker-year { width: 70px;}
   .ui-datepicker-trigger { margin:0 0 -5px 2px; }
-->
</style>


<script>


 jQuery(function($){
 
	var d = new Date();

	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
		'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};

	  $.datepicker.setDefaults($.datepicker.regional['ko']);
	  

    $('#sdate').datepicker({
        showOn: 'button',
        buttonImage: './img/calender_i02.png',
        buttonImageOnly: true,
        buttonText: "달력",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: 'c-99:c+99',
        maxDate: '+365d'
    });
    
    $('#edate').datepicker({
        showOn: 'button',
        buttonImage: './img/calender_i02.png',
        buttonImageOnly: true,
        buttonText: "달력",
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: 'c-99:c+99',
        maxDate: '+365d'
    });
    
 });
 


 
 
 function SEL_DATE(){


  let gubn = "" ;
  
  if ( document.Form.gubn[0].checked == true ) gubn = "" ;
  else if ( document.Form.gubn[1].checked == true ) gubn = "입금" ;
  else if ( document.Form.gubn[2].checked == true ) gubn = "출금" ;
  
  if ( document.getElementById("sdate").value != "" && document.getElementById("edate").value != "" ) {

   location.href = "./adm_transaction_history.php?intNowPage=<?=$intNowPage?>&schtxt=" + document.getElementById("schtxt").value + "&sdate=" + document.getElementById("sdate").value + "&edate=" + document.getElementById("edate").value + "&gubn=" + gubn ;
  
  }
  
 }  
 
 
 
 function SEARCH(){

  let gubn = "" ;
  
  if ( document.Form.gubn[0].checked == true ) gubn = "" ;
  else if ( document.Form.gubn[1].checked == true ) gubn = "입금" ;
  else if ( document.Form.gubn[2].checked == true ) gubn = "출금" ;
  
  location.href = "./adm_transaction_history.php?intNowPage=<?=$intNowPage?>&schtxt=" + document.getElementById("schtxt").value + "&gubn=" + gubn + "&sdate=" + document.getElementById("sdate").value + "&edate=" + document.getElementById("edate").value ;

 }  



 function GO(val) {

  let gubn = "" ;
  
  if ( document.Form.gubn[0].checked == true ) gubn = "" ;
  else if ( document.Form.gubn[1].checked == true ) gubn = "입금" ;
  else if ( document.Form.gubn[2].checked == true ) gubn = "출금" ;
  
	location.href = "./adm_transaction_history.php?intNowPage="+val + "&gubn=" + gubn + "&sdate=" + document.getElementById("sdate").value + "&edate=" + document.getElementById("edate").value + "&schtxt=" + document.getElementById("schtxt").value ;
 
 }


 function IN_WITHDRAW(val) {
   
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 출금신청 중입니다. 중간에 종료하지 마세요." ;
    
       var formdata = new FormData();
       

       formdata.append("seqno", val);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_withdraw_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {



         if ( result.replace(/^\s+|\s+$/gm,'') == "no_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "출금계정이 존재하지 않습니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "to_same" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "본인에게 출금신청을 하실 수 없습니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_token" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "출금하실 토큰이 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "출금신청에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "정상적으로 출금신청 처리가 되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_transaction_history.php" ;
           return;
          
          });
         
          return; 
          
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
 
 
 
 
 
 function BNB_IN_WITHDRAW(val) {

    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 출금신청 중입니다. 중간에 종료하지 마세요." ;
    
       var formdata = new FormData();
       

       formdata.append("seqno", val);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_bnb_withdraw_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {



         if ( result.replace(/^\s+|\s+$/gm,'') == "no_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "출금계정이 존재하지 않습니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "to_same" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "본인에게 출금신청을 하실 수 없습니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_token" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "출금하실 <?=$chainSymbol?>가 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "출금처리에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "정상적으로 출금처리가 되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_transaction_history.php" ;
           return;
          
          });
         
          return; 
          
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
 
 







 function OUT_WITHDRAW(val) {
   
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 출금신청 중입니다. 중간에 종료하지 마세요." ;
    
       var formdata = new FormData();
       

       formdata.append("seqno", val);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_withdraw_out_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {


         if ( result.replace(/^\s+|\s+$/gm,'') == "in_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "내부전송은 불가능 합니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "존재하지 않는 출금주소입니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_fee" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금수수료가 부족합니다 <?=$tokenSymbol?> 충전 후 다시 시도해 주세요.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_token" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금하실 토큰이 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금신청에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "lack_balance" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "관리자 <?=$tokenSymbol?> 부족합니다. 충전해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "정상적으로 출금신청 처리가 되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_transaction_history.php" ;
           return;
          
          });
         
          return; 
          
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
 
 
 
 



 function BNB_OUT_WITHDRAW(val) {
   
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 출금신청 중입니다. 중간에 종료하지 마세요." ;
    
       var formdata = new FormData();
       

       formdata.append("seqno", val);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_bnb_withdraw_out_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {


         if ( result.replace(/^\s+|\s+$/gm,'') == "in_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "내부전송은 불가능 합니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_account" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "존재하지 않는 출금주소입니다.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_fee" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금수수료가 부족합니다. <?=$chainSymbol?> 충전 후 다시 시도해 주세요.",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "no_token" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금하실 <?=$chainSymbol?> 가 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "lack_balance" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "관리자 <?=$chainSymbol?> 부족합니다. 충전해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "warning",
           text: "출금처리에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "정상적으로 출금처리가 되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_transaction_history.php" ;
           return;
          
          });
         
          return; 
          
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
 
 



 function KRW_COIN_BUY(val) {
   
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 코인구매 처리 중입니다. 중간에 종료하지 마세요." ;
    
       var formdata = new FormData();
       

       formdata.append("seqno", val);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_buy_coins_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         
         if ( result.replace(/^\s+|\s+$/gm,'') == "no_cash" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "원화(KRW)가 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "min_cash" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "최소 지불 수량을 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "구매하기에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "정상적으로 토큰구매가 완료되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_transaction_history.php" ;
           return;
          
          });
         
          return; 
          
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

  
 



 function COIN_BUY(val) {
   
    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 코인구매 처리 중입니다. 중간에 종료하지 마세요." ;
    
       var formdata = new FormData();
       

       formdata.append("seqno", val);
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./adm_buy_coins_bnb_process.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "no_cash" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "<?=$tokenSymbol?>가 부족합니다. 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "min_cash" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "최소 지불 수량을 확인 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "transaction_fail" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "warning",
           text: "구매신청에 실패하였습니다. 잠시 후 다시 시도해 주세요. ",
          }).then((ok) => {

           return;
          
          });
         
          return; 
          
         }
         else if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "정상적으로 구매신청이 완료되었습니다.",
          }).then((ok) => {
         
           location.href = "adm_transaction_history.php" ;
           return;
          
          });
         
          return; 
          
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





<div class='container' style="text-align:center">




<script>

if ( window.innerWidth > 991 ) {
  
  if ( window.innerHeight <= 768 ) {
      
   document.writeln("<div id='box' style='vertical-align:top;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
  }
  else {
      
   document.writeln("<div id='box' style='position:relative;vertical-align:top;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
  }
   

}
else { 
  
  document.writeln("<div id='box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
                 
         <form name="Form" method="post">   
         
            <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#A61313;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;margin-right:8px"><?=$Company_Name?> 입출금내역</div>
   
   <div style="margin-top:15px;border:1px #E5E5E5 solid;"></div>
   
    <div style="text-align:left;margin-top:15px;margin-bottom:20px;">
     <input id="sdate" name="sdate" type="text" placeholder="시작일자" value="<?=$sdate?>" style="width:120px;font-size:12pt;background:#EEEEEE;text-align:center" readonly onchange="SEL_DATE()">&nbsp;~&nbsp;<input id="edate" name="edate" type="text" placeholder="종료일자" value="<?=$edate?>" style="width:120px;font-size:12pt;background:#EEEEEE;text-align:center" readonly onchange="SEL_DATE()">
     
     <label style="margin-left:20px;display:inline-block;"><input id="gubn" name="gubn" type="radio" value="" <?if ( $gubn == "" ) {?>checked<?}?> onclick="SEARCH()"><i></i></label>&nbsp;전체
     <label style="margin-left:15px;display:inline-block;"><input id="gubn" name="gubn" type="radio" value="입금" <?if ( $gubn == "입금" ) {?>checked<?}?> onclick="SEARCH()"><i></i></label>&nbsp;입금
     <label style="margin-left:15px;display:inline-block;"><input id="gubn" name="gubn" type="radio" value="출금" <?if ( $gubn == "출금" ) {?>checked<?}?> onclick="SEARCH()"><i></i></label>&nbsp;출금


      <div style="display:inline-block;">
       <input id="schtxt" name="schtxt" type="text" placeholder="이메일/전화번호/지갑주소 입력" value="<?=$schtxt?>" style="width:250px;font-size:10pt;padding:5px">
      </div> 

      <div style="margin-left:10px;display:inline-block;">
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="SEARCH()" value="검색">     
      </div> 
    
   

     
     
                                  
    </div> 




<?

  $Search_SQL = " WHERE 1 = 1 " . $searchSql ;

 
  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from token_transaction_history" . $Search_SQL ;

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
                            
    
         
         
         

                    <table style="width:100%;border:1px solid #E5E5E5">
                     <thead>
                            <tr>
                             <th style="border-left:1px solid #A61313;border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">일자</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">이메일</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">구분</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">신청금액</th>
                             <th style="border-right:1px solid #E5E5E5;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">이전금액</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">이후금액</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">상태</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">기록</th>
                             <th style="border-right:1px solid #A61313;background:#A61313;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">관리</th>
                            </tr>
                     </thead>
                     <tbody>     
                           
                           
                           
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From token_transaction_history " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
   
   
                            <tr>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=substr($rs["regdate"],0,10)?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=base64_decode($rs["UserEmail"])?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=$rs["gubn"]?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?if ( $rs["target"] == "cash" ) {?><?=number_format($rs["amount"])?><?}else{?><?=number_format($rs["amount"],4)?><?}?></strong><?if ( $rs["target"] == "token" ) {?>&nbsp;<?=$Symbol?><?}else if ( $rs["target"] == "BNB" ) {?>&nbsp;<?=$chainSymbol?><?}else if ( $rs["target"] == "cash" ) {?>&nbsp;KRW<?}?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?if ( $rs["target"] == "cash" ) {?><?=number_format($rs["prev_amount"])?><?}else{?><?=number_format($rs["prev_amount"],4)?><?}?></strong><?if ( $rs["target"] == "token" ) {?>&nbsp;<?=$Symbol?><?}else if ( $rs["target"] == "BNB" ) {?>&nbsp;<?=$chainSymbol?><?}else if ( $rs["target"] == "cash" ) {?>&nbsp;KRW<?}?></th>
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right">
                             
                              <strong><?if ( $rs["target"] == "cash" ) {?><?=number_format($rs["next_amount"])?><?}else{?><?=number_format($rs["next_amount"],4)?><?}?></strong><?if ( $rs["target"] == "token" ) {?>&nbsp;<?=$Symbol?><?}else if ( $rs["target"] == "BNB" ) {?>&nbsp;<?=$chainSymbol?><?}else if ( $rs["target"] == "cash" ) {?>&nbsp;KRW<?}?>
                              
                              <?if ( $rs["WithdrawFee"] != "0" ) {?><br>수수료&nbsp;:&nbsp;<span style="color:#A61313">- <?=$rs["WithdrawFee"]?>&nbsp;<?=$tokenSymbol?></span><?}?>
                             
                             </th>
                             
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?if ( $rs["state"] != "" ) {?>[<?=$rs["state"]?>]<?}?></th>
                             
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center">
                              <a href="<?=$txUrl?><?=$rs["hash"]?>" target="_blank" style="color:#0178FE"><?=substr($rs["hash"],0,5)?></a>
                              <?if ( $rs["memo"] == "내부전송" ) {?><?if ( $rs["admin_memo"] != "" ) {?><a href="javascript:MEMO_OPEN('<?=$rs["admin_memo"]?>')" style="color:#262626"><?}?>[내부]<?if ( $rs["admin_memo"] != "" ) {?></a><?}?><?}else if ( $rs["memo"] == "외부전송" ) {?>[외부]<?}else if ( $rs["memo"] == "출금수수료" ) {?>[수수료]<?}else if ( $rs["memo"] == "락업토큰지급" ) {?>[락업토큰]<?}?>
                             </th>
                             
                             <th style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center">
                             
                              <?if ( $rs["memo"] == "내부전송" ) {?><?if ( $rs["state"] == "신청" ) {?><input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="<?if ( $rs["target"] == "token" ) {?>IN_WITHDRAW<?}else if ( $rs["target"] == "BNB") {?>BNB_IN_WITHDRAW<?}?>('<?=htmlspecialchars($rs["seqno"])?>')" value="출금완료"><?}else if ( $rs["state"] == "원화코인구매-신청" ) {?><input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="KRW_COIN_BUY('<?=htmlspecialchars($rs["seqno"])?>')" value="구매완료"><?}else if ( $rs["state"] == "코인구매-신청" ) {?><input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="COIN_BUY('<?=htmlspecialchars($rs["seqno"])?>')" value="구매완료"><?}?><?}?>
                              <?if ( $rs["memo"] == "외부전송" ) {?><?if ( $rs["state"] == "신청" ) {?><input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="<?if ( $rs["target"] == "token" ) {?>OUT_WITHDRAW<?}else if ( $rs["target"] == "BNB") {?>BNB_OUT_WITHDRAW<?}?>('<?=htmlspecialchars($rs["seqno"])?>')" value="출금완료"><?}?><?}?>
                              
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
     
                    <div class="product__pagination text-center" style="margin-top:20px">
                    
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

    
        
        
        
        
         </form>   
         
                    

   
        
        
        
        
        
          
  </div>

   
   
  <div style="height:50px"></div>  



</div>


<script>


 
 
 
let container_position_x ;
let container_position_y ;
 
if ( window.innerWidth > 991 ) {
  
 container_position_x = ( window.innerWidth - 549 ) / 2 ;
 container_position_y = ( ( window.innerHeight - document.getElementById("box").clientHeight ) / 2 ) - 80 ;
 
}
  
 
if ( window.innerWidth > 991 ) {
  
   if ( window.innerHeight <= 768 ) {
   }
   else {
        
    document.getElementById("box").style.top = container_position_y + "px" ;
    
   } 
   
}
else {
          

        
}  

            






  
</script>



<style>

#layer {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 





.box{
    position: relative;
    top:50%;
    left:50%; 
    width:450px;
    height:80%;
    transform:translate(-50%, -50%);
    z-index:1002;
    box-sizing:border-box;
    background:#fff;
    box-shadow: 2px 5px 10px 0px rgba(0,0,0,0.35);
    -webkit-box-shadow: 2px 5px 10px 0px rgba(0,0,0,0.35);
    -moz-box-shadow: 2px 5px 10px 0px rgba(0,0,0,0.35);
    border-radius:15px;
}
.box .contents {
    padding:50px;
    height:92%;
}
.box .contents h2 {
    padding:15px 0;
    color:#333;
    margin:0;
    text-align:center
}
.box .contents p{ 
    border-top: 1px solid #666;
    padding-top: 30px;
}




.button {
    display:table;
    bottom:0;
    table-layout: fixed;
    width:100%;
    height:70px;
    background:#5d5d5d;
    word-break: break-word;
}
.button a {
    position: relative; 
    display: table-cell; 
    height:70px; 
    color:#fff; 
    font-size:17px;
    text-align:center;
    vertical-align:middle;
    text-decoration:none; 
    background:#2A0066;
}
.button a:before{
    content:'';
    display:block;
    position:absolute;
    top:26px;
    right:29px;
    width:1px;
    height:21px;
    background:#fff;
    -moz-transform: rotate(-45deg); 
    -webkit-transform: rotate(-45deg); 
    -ms-transform: rotate(-45deg); 
    -o-transform: rotate(-45deg); 
    transform: rotate(-45deg);
}
.button a:after{
    content:'';
    display:block;
    position:absolute;
    top:26px;
    right:29px;
    width:1px;
    height:21px;
    background:#fff;
    -moz-transform: rotate(45deg);
    -webkit-transform: rotate(45deg); 
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg); 
    transform: rotate(45deg);
}
.button a.closeBtn {
    background:#747474;
}
.button a.closeBtn:before, .button a.closeBtn:after{
    display:none;
}

.box_btn {
 border:1px solid #1F6B8B; 
 width:100%;
 border-radius:5px; 
 padding:5px; 
 background:#2989B1;
 color:#FFFFFF;
 font-weight:600;
}  

.box_btn:hover{
  background:#1F6B8B;
}


</style>



<div id="layer" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>메모</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <span id="memo"></span>
               
             </div>
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer');">창닫기</a>
      </div>
  </div>
</div>





<script>


 function close_Popup(val) { 

  document.getElementById(val).style.display = "none";
   
 }
 
 
 function MEMO_OPEN(val) { 
   
  document.getElementById('layer').style.display = "block"; 
  document.getElementById("memo").innerHTML = val ;
   
 } 
   
 
</script>

<?

 include("footer.php");
 
?> 

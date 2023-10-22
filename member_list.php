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


 if ( isset($_GET["schtxt"]) ) {

  $schtxt = $_GET["schtxt"] ;

 }
 else {
  
  if ( isset($_POST["schtxt"]) ) $schtxt = $_POST["schtxt"] ;
  else $schtxt = "" ;  
  
 }
 

 if ( $schtxt != "" ) {
   
  $searchSql = " AND ( UserEmail like '%".base64_encode($schtxt)."%' OR UserMobile like '%".base64_encode($schtxt)."%' OR deposit_address like '%".base64_encode($schtxt)."%' ) " ;
   
 }  
 
 
 $intNowPage = 0 ;
 
 $intPageSize = 5 ;
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
 
 
 date_default_timezone_set("Asia/Seoul");
 $date = date("Y-m-d");

?>   
    
<!--<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="./js/css_browser_selector.js"></script>	<!-- 크로스 브라우징 모듈 -->
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/themes/base/jquery-ui.css" rel="stylesheet" />
<style type="text/css">
    
   .ui-datepicker { font:12px dotum; }
   .ui-datepicker select.ui-datepicker-month, 
   .ui-datepicker select.ui-datepicker-year { width: 70px;}
   .ui-datepicker-trigger { margin:0 0 -5px 2px; }

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
 
 
 
 function isNumber(testValue){

    var chars = ".0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 
 

 
 
 function isNumber2(testValue){

    var chars = ",0123456789";

    for (var inx = 0; inx < testValue.length; inx++) {
        if (chars.indexOf(testValue.charAt(inx)) == -1)
            return false;
    }
    return true;

 }
 
 
 
 
 function numberCommas(val) {

  let amount = numberWithCommas(document.getElementById("krw_token").value, "A") ;

  document.getElementById("krw_token").value = numberWithCommas(amount, "B") ;
  
 }
 
 function numberWithCommas(x,y) {

  if ( y == "A" ) return x.toString().replace(/,/gi,"");
  else if ( y == "B" )return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

 }
 
 
 
 
 
 
 
 
 function ALL_SELECT() {

  var form = document.Form ;
  var cnt = parseInt(form.count.value) ;
  
  for ( var i = 1 ; i < cnt ; i++ ) {

   if ( form.chk_all.checked ) {
   

     eval("form.chk" + i + ".checked  = true;")
     

    
   } 
   else {

    eval("form.chk" + i + ".checked  = false;") 
    
   } 

  }


 }
 
 
 
 
 let arr_cnt = 0 ; 
 let seqno_arr = []; 
 let gubn_arr = []; 
 let arr_total = 0 ;
 
 
 
 
 
 
 async function SelectionDone(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("lockup_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "락업수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("lockup_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("lockup_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "락업수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("lockup_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("lockup_token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("lockup_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 

    
    
    
    
   if ( document.getElementById("edate").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "종료일자를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("edate").focus();

      return;
     
     });
     
     return;
     
   }




   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("lockup_token", document.getElementById("lockup_token").value);
         formdata.append("sdate", document.getElementById("sdate").value);
         formdata.append("edate", document.getElementById("edate").value);
         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./lockup_coin_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 락업코인 부여를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_lockup_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 async function SelectionCoinDone(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "코인수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 

    
    



   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       COIN_TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function COIN_TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("token", document.getElementById("token").value);
         formdata.append("token_memo", document.getElementById("token_memo").value);
         
         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./coin_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 코인 부여를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_transaction_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            COIN_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 




 
 async function SelectionCoinCollect(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 코인수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 

    
    



   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       COIN_COLLECT_TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function COIN_COLLECT_TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("token", document.getElementById("token").value);
         formdata.append("token_memo", document.getElementById("token_memo").value);

         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./coin_collect_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 코인 회수를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_transaction_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            COIN_COLLECT_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 











 
 async function SelectionBnbCoinDone(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("bnb_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?=$chainSymbol?> 코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("bnb_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?=$chainSymbol?> 코인 수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("bnb_token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 

    
    



   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       BNB_COIN_TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function BNB_COIN_TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("token", document.getElementById("bnb_token").value);
         formdata.append("token_memo", document.getElementById("bnb_token_memo").value);
         
         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./coin_bnb_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 코인 부여를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_transaction_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            BNB_COIN_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 
 
 
 
 
 
 
 
 




 
 async function SelectionBnbCoinCollect(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("bnb_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 <?=$chainSymbol?> 코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("bnb_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 <?=$chainSymbol?> 코인 수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("bnb_token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 

    
    



   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       BNB_COIN_COLLECT_TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function BNB_COIN_COLLECT_TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("token", document.getElementById("bnb_token").value);
         formdata.append("token_memo", document.getElementById("bnb_token_memo").value);

         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./coin_bnb_collect_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 <?=$chainSymbol?> 코인 회수를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_transaction_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            BNB_COIN_COLLECT_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 
 




 
 
 
 











 
 async function SelectionKrwCoinDone(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("krw_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "KRW 금액을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber2(document.getElementById("krw_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "KRW 금액은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
  

    
    



   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       KRW_COIN_TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function KRW_COIN_TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("token", document.getElementById("krw_token").value);
         formdata.append("token_memo", document.getElementById("krw_token_memo").value);
         
         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./coin_krw_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 KRW 부여를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_krw_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            KRW_COIN_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 
 
 
 
 
 
 
 
 




 
 async function SelectionKrwCoinCollect(){

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("krw_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 KRW 금액을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber2(document.getElementById("krw_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 KRW 금액은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    

    
    



   var ans = window.confirm("정말로 일괄 처리할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 일괄 처리중입니다. 중간에 종료하지 마세요." ;

       
       arr_total = seqno_arr.length ;
       
       
       KRW_COIN_COLLECT_TRANSFER(seqno_arr[arr_cnt]) ; 
  
       
   }
   
   



 }
 
 
 
 
 async function KRW_COIN_COLLECT_TRANSFER(seqno){
 
 
         var formdata = new FormData();
         
         formdata.append("token", document.getElementById("krw_token").value);
         formdata.append("token_memo", document.getElementById("krw_token_memo").value);

         formdata.append("seqno", seqno);
       
         var requestOptions = {
          method: "POST",
          body: formdata,
          redirect: "follow",
         };
       
         fetch("./coin_krw_collect_process.php", requestOptions)
         .then((response) => response.text())
         .then((result) => {


         
           arr_cnt = arr_cnt + 1 ;
         
         
           document.getElementById('loadingdiv_result').innerHTML = "총 " + arr_total + "건 중 " + arr_cnt + " 건 처리완료!";

           if ( arr_cnt >= arr_total ) {
             
            document.getElementById("loadingdiv").style.display = "none";
          
            Swal.fire({
             icon: "success",
             text: "일괄 KRW를 회수를 완료하였습니다.",
            }).then((ok) => {
         
             location.href = "adm_krw_history.php" ;
             return;
          
            });
          
            return;
            
            
           }
         
           else {
             
            KRW_COIN_COLLECT_TRANSFER(seqno_arr[arr_cnt]) ; 
          
           } 

         })
         .catch(error => {
         
          console.log(error) ;
         
         });
         
         
         
 }
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 async function DEL(val){
   

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
       
       fetch("./member_delete.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "member_list.php" ;
           return;
          
          });
         
         
         }
         

         return;

         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         
         Swal.fire({
          icon: "warning",
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
       
       
   }
   
   
 } 



 
 
 async function RESTORE(val){
   

   var ans = window.confirm("정말로 중지할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Deleting. Don't quit in the middle.<?}else{?>* 복구중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       formdata.append("seqno", val);


       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./member_restore.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "member_list.php" ;
           return;
          
          });
         
         
         }
         

         return;

         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         
         Swal.fire({
          icon: "warning",
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
       
       
   }
   
   
 } 
 
 
 async function STOP(val){
   

   var ans = window.confirm("정말로 중지할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Deleting. Don't quit in the middle.<?}else{?>* 중지중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       formdata.append("seqno", val);


       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./member_stop.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "member_list.php" ;
           return;
          
          });
         
         
         }
         

         return;

         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         
         Swal.fire({
          icon: "warning",
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
       
       
   }
   
   
 } 
 
 
 
 
 
 async function EDIT(val){
   

   var ans = window.confirm("수정 할까요?");
 
   if(ans==true){ 
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Deleting. Don't quit in the middle.<?}else{?>* 적용중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       formdata.append("seqno", val);


       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./member_edit.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
         
           location.href = "member_list.php" ;
           return;
          
          });
         
         
         }
         

         return;

         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";
         
         Swal.fire({
          icon: "warning",
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
       
       
   }
   
   
 } 
 
 
 
 
 
 
 async function PWD_MODIFY(seqno, gb){
   
   var form = document.Form ;
   
   var ans = window.confirm("정말로 비밀번호를 변경할까요?");
 
   if(ans==true){ 
     
       let pwd = "" ;
       
       if ( gb == "" ) pwd = document.getElementById("pwd"+seqno).value ;
       else pwd = document.getElementById("pwd_m"+seqno).value ; 
       
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "<?if ( $lang == "en" ) {?>* Deleting. Don't quit in the middle.<?}else{?>* 비밀번호를 변경중입니다. 중간에 종료하지 마세요..<?}?>" ;
       
       var formdata = new FormData();
       
       formdata.append("pwd", pwd);
       formdata.append("seqno", seqno);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./member_pwd_modify.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result == "succ" ) { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Processed successfully.<?}else{?>성공적으로 처리되었습니다.<?}?>",
          }).then((ok) => {
            
           form.action = "member_list.php" ;
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
          text: "<?if ( $lang == "en" ) {?>An error has occurred. please try again.<?}else{?>오류가 발생하였습니다. 다시 시도해 주세요.<?}?>",
         }).then((ok) => {
         
          return;
          
         });
         
         console.log(error) ;
         return;

         
       });
       
       
       
       
       
   }
   
   
 } 
 
 
 
 
 
 function SEARCH(){
   
  var form = document.Form ;
   
  form.intNowPage.value = "" ;
   
  form.action = "./member_list.php";
  form.submit();

 }  



 function GO(val) {
   
  var form = document.Form ;
   
  form.intNowPage.value = val ;
   
  form.action = "./member_list.php";
  form.submit();

 
 }



</script>





<div class='container' style="text-align:center">

<form name="Form" method="post">   


<script>

if ( window.innerWidth > 991 ) {
  
  if ( window.innerHeight <= 768 ) {
      
   document.writeln("<div id='box' style='vertical-align:top;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
  }
  else {
      
   document.writeln("<div id='box' style='margin-top:30px;vertical-align:top;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
   
  } 

}
else { 
  
  document.writeln("<div id='box' style='margin-top:30px;background:#FFFFFF;width:100%;display:inline-block;border:2px #B0B1B3 solid;border-radius:10px;padding:30px'>");
  
}  

</script>
  
  

   <div style="width:100%;display:inline-block;text-align:left;font-size:15pt;color:#262626;font-weight:600"><img src="./img/line_bar.png" style="width:10px;height:20px;">&nbsp;회원 내역</div>
   
   <div style="margin-top:15px;border:1px #E5E5E5 solid;"></div>
   
   
   
   
   
   <div style="width:100%;text-align:left">
   
   
     <div style="margin-top:15px;display:inline-block;">
   
      <div style="display:inline-block;">
       <input id="schtxt" name="schtxt" type="text" placeholder="이메일/전화번호/지갑주소 입력" value="<?=$schtxt?>" style="width:250px;font-size:10pt;padding:5px">
      </div> 

      <div style="margin-left:10px;display:inline-block;">
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="SEARCH()" value="검색">     
      </div> 
    
   
     </div>
     
     <div style="margin-top:0px;"></div>
     
     
     <!-- 락업 / 코인 부여 -->
     
     <div style="margin-top:15px;display:inline-block;">
   
      <div style="display:inline-block;">
       <input id="lockup_token" name="lockup_token" type="text" placeholder="락업수량" value="" style="width:100px;font-size:10pt;background:#EEEEEE;text-align:right">&nbsp;<?=$Symbol?>
      </div> 

      <input id="sdate" name="sdate" type="hidden" placeholder="시작일자" value="<?=$date?>" style="width:120px;font-size:10pt;background:#EEEEEE;text-align:center" readonly><input id="edate" name="edate" type="text" placeholder="종료일자" value="" style="width:120px;font-size:10pt;background:#EEEEEE;text-align:center" readonly>

      <div style="margin-left:10px;display:inline-block;">
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="LOCKUP_OPEN()" value="선택 락업 부여">     
      </div> 
    
   
     </div>
   
     <div class="web" style="margin-left:20px;display:inline-block;"></div>
   
     <div class="mob" style="margin-top:-15px;margin-bottom:15px;border:1px #E5E5E5 solid;"></div>
   
     <div style="display:inline-block;">
   
      <div style="display:inline-block;">
       <input id="token" name="token" type="text" placeholder="코인수량" value="" style="width:100px;font-size:10pt;background:#EEEEEE;text-align:right">&nbsp;<?=$Symbol?>
      </div> 
   
      <div style="display:inline-block;">
       <input id="token_memo" name="token_memo" type="text" placeholder="메모" value="" style="width:200px;font-size:10pt;background:#EEEEEE;">
      </div> 
    
      <div class="web" style="display:inline-block;"><div style="margin-left:5px;"></div></div>
    
      <div style="display:inline-block;">
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="COIN_OPEN()" value="선택 코인 부여">     
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="COIN2_OPEN()" value="선택 코인 회수"> 
      </div> 
     
   
     </div>
     
     <!-- 락업 / 코인 부여 -->
     
     
     <div style="margin-top:10px;"></div>
     
     <!-- BNB / KRW 부여 -->
     
     <div style="display:inline-block;">
   
      <div style="display:inline-block;">
       <input id="bnb_token" name="bnb_token" type="text" placeholder="<?=$chainSymbol?> 수량" value="" style="width:100px;font-size:10pt;background:#EEEEEE;text-align:right">&nbsp;<?=$chainSymbol?>
      </div> 
   
      <div style="display:inline-block;">
       <input id="bnb_token_memo" name="bnb_token_memo" type="text" placeholder="메모" value="" style="width:200px;font-size:10pt;background:#EEEEEE;">
      </div> 
    
      <div class="web" style="display:inline-block;"><div style="margin-left:5px;"></div></div>
    
      <div style="display:inline-block;">
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="BNB_OPEN()" value="선택 <?=$chainSymbol?> 부여">     
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="BNB2_OPEN()" value="선택 <?=$chainSymbol?> 회수"> 
      </div> 
    
   
     </div>
     
     <div class="web" style="margin-left:20px;display:inline-block;"></div>
     <div class="mob" style="margin-bottom:15px;border:1px #E5E5E5 solid;"></div>
   
     <div style="display:inline-block;">
   
      <div style="display:inline-block;">
       <input id="krw_token" name="krw_token" type="text" placeholder="KRW 금액" value="" style="width:100px;font-size:10pt;background:#EEEEEE;text-align:right" onkeyup="numberCommas(this.value)">&nbsp;KRW
      </div> 
   
      <div style="display:inline-block;">
       <input id="krw_token_memo" name="krw_token_memo" type="text" placeholder="메모" value="" style="width:200px;font-size:10pt;background:#EEEEEE;">
      </div> 
    
      <div class="web" style="display:inline-block;"><div style="margin-left:5px;"></div></div>
    
      <div style="display:inline-block;">
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="KRW_OPEN()" value="선택 KRW 부여">     
       <input type="button" style="margin-top:15px;border:2px #0073DE solid;text-align:center;font-size:10pt;color:#FFFFFF;background-color:#0184FE;border-radius:2px;font-weight:500;padding:5px" onclick="KRW2_OPEN()" value="선택 KRW 회수"> 
      </div> 
     
   
     </div>
     
     <!-- BNB / KRW  부여 -->
     
     
     
     
     
   </div>
   
              

         
            <input name="intNowPage" type="hidden" value="<?=$intNowPage?>">


<?

  $Search_SQL = " WHERE 1 = 1 "  ;
  $Search_SQL = $Search_SQL .$searchSql ;
  
  
  $strSQL = "Select Count(seqno)" ;
  $strSQL = $strSQL . ",CEILING(CAST(Count(seqno) AS FLOAT)/" . $intPageSize . ")" ;
  $strSQL = $strSQL . " from users" . $Search_SQL ;

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
                            
    
         
         
         

                    <table style="margin-top:20px;width:100%;border:1px solid #E5E5E5">
                     <thead>
                            <tr>
                             <th style="border-left:1px solid #262626;border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center"><input type="checkbox" name="chk_all" onclick="ALL_SELECT()" <?if ( $intTotalCount == 0 ) {?>disabled<?}?>></th>
                             <th class="web" style="border-left:1px solid #262626;border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">가입일자</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">이메일주소</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">전화번호</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">비밀번호</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">하위지갑</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">보유토큰</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">락업토큰</th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">보유<?=$chainSymbol?></th>
                             <th class="web" style="border-right:1px solid #E5E5E5;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">보유KRW</th>
                             <th class="web" style="border-right:1px solid #262626;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">상태</th>
                             <th class="web" style="border-right:1px solid #262626;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">관리</th>
                             <th class="mob" style="border-right:1px solid #262626;background:#262626;color:#FFFFFF;font-size:11pt;font-weight:500;padding:5px;text-align:center">내역</th>                             
                            </tr>
                     </thead>
                     <tbody>     
                           
                           
                           
<?

  
  $Search_SQL = $Search_SQL . $orderBy ;
  
  $listnum = $intNowPage * $intPageSize ;

  $Search_SQL = $Search_SQL . " LIMIT $listnum, $intPageSize" ;
 
  $SQL = "Select * From users " . $Search_SQL  ;
  $query=mysqli_query($link, $SQL);
 
  $count = mysqli_num_rows($query);
            
  if($count > 0){
    
   $i = 1 ;
   $DATA_OK = "" ;
   
   foreach($query as $rs){
     
    
   ?>
   
   
                            <tr>
                             <td style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><input type="checkbox" id="seqno_<?=$i?>" name="chk<?=$i?>" value="<?=htmlspecialchars($rs["seqno"])?>"></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=substr($rs["regdate"],0,10)?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=base64_decode($rs["UserEmail"])?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=base64_decode($rs["UserMobile"])?></td>
                             
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center">
                             
                              <input id="pwd<?=htmlspecialchars($rs["seqno"])?>" name="pwd<?=htmlspecialchars($rs["seqno"])?>" type="password" placeholder="" value="<?=base64_decode($rs["UserPwd"])?>" style="width:120px;font-size:12pt;background:#EEEEEE;text-align:center">
                              <input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="PWD_MODIFY('<?=htmlspecialchars($rs["seqno"])?>','')" value="변경">
                             
                             </td>
                             
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center"><?=base64_decode($rs["deposit_address"])?>&nbsp;<a href="javascript:COPY('<?=base64_decode($rs["deposit_address"])?>')"><img src="./img/copy.png" style="height:20px"></a></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["token"],4)?></strong>&nbsp;<?=$Symbol?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["lockup_token"],4)?></strong>&nbsp;<?=$Symbol?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["bnb"],4)?></strong>&nbsp;<?=$chainSymbol?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?=number_format($rs["cash"])?></strong>&nbsp;KRW</td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:right"><strong><?if ( $rs["stop"] == "Y" ) {?>[중지]<?}else if ( $rs["stop"] == "N" ) {?>[정상]<?}?></td>
                             <td class="web" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:center;color:#0178FE">

                              <input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="DEL('<?=htmlspecialchars($rs["seqno"])?>')" value="삭제">
                              <input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="STOP('<?=htmlspecialchars($rs["seqno"])?>')" value="중지">
                              
                             </td>
                             
                             
                             <td class="mob" style="border-right:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;font-size:11pt;font-weight:500;padding:5px;text-align:left;">

                              <div>- 가입일자&nbsp;:&nbsp;<?=substr($rs["regdate"],0,10)?></div>
                              <div style="margin-top:5px">- 이메일&nbsp;:&nbsp;<?=base64_decode($rs["UserEmail"])?></div>
                              
                              <div style="margin-top:5px">- 비밀번호&nbsp;:&nbsp;
                              
                               <input id="pwd_m<?=htmlspecialchars($rs["seqno"])?>" name="pwd_m<?=htmlspecialchars($rs["seqno"])?>" type="password" placeholder="" value="<?=base64_decode($rs["UserPwd"])?>" style="width:120px;font-size:12pt;background:#EEEEEE;text-align:center">
                               <input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="PWD_MODIFY('<?=htmlspecialchars($rs["seqno"])?>','m')" value="변경">
                              
                              </div>
                              
                              <div style="margin-top:5px">- 하위지갑&nbsp;:&nbsp;<?=substr(base64_decode($rs["deposit_address"]),0,10)?>&nbsp;<a href="javascript:COPY('<?=base64_decode($rs["deposit_address"])?>')"><img src="./img/copy.png" style="height:20px"></a></div>
                              <div style="margin-top:5px">- 보유토큰&nbsp;:&nbsp;</div>
                              <div style="margin-top:5px">- 락업토큰&nbsp;:&nbsp;</div>
                              <div style="margin-top:5px">- 보유<?=$chainSymbol?>&nbsp;:&nbsp;</div>
                              <div style="margin-top:5px">- 보유KRW&nbsp;:&nbsp;</div>
                              <div style="margin-top:5px">- 관리&nbsp;:&nbsp;
                              
                              <input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="DEL('<?=htmlspecialchars($rs["seqno"])?>')" value="삭제">
                              <input type="button" style="border:2px #262626 solid;text-align:center;font-size:11pt;color:#FFFFFF;background-color:#262626;border-radius:2px;font-weight:500;padding:5px" onclick="STOP('<?=htmlspecialchars($rs["seqno"])?>')" value="중지">
                              
                              </div>

                             </td>
                             
                            </tr>
                            
                            <input id="seqno_<?=$i?>" name="seqno_<?=$i?>" type="hidden" value="<?=htmlspecialchars($rs["seqno"])?>">

   
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
                    
                    <input id="count" name="count" type="hidden" value="<?=$i?>">
                    
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



         

          
  </div>

   
   
  <div style="height:50px"></div>  


</form>   
         
</div>




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


#layer2 {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 


#layer3 {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 



#layer4 {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 


#layer5 {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 








#layer6 {
    position:fixed;
    top:0;
    left:0;
    z-index: 10000; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5);
} 


#layer7 {
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
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="lockup_code" name="lockup_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="LOCKUP_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer');">창닫기</a>
      </div>
  </div>
</div>







<div id="layer2" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="coin_code" name="coin_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="COIN_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer2');">창닫기</a>
      </div>
  </div>
</div>







<div id="layer3" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="coin2_code" name="coin2_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="COIN2_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer3');">창닫기</a>
      </div>
  </div>
</div>






<div id="layer4" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="bnb_code" name="bnb_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="BNB_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer4');">창닫기</a>
      </div>
  </div>
</div>









<div id="layer5" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="bnb2_code" name="bnb2_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="BNB_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer5');">창닫기</a>
      </div>
  </div>
</div>














<div id="layer6" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="krw_code" name="krw_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="KRW_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer6');">창닫기</a>
      </div>
  </div>
</div>














<div id="layer7" style="display:none">
  <div class="box">
      <div class="contents">
      
          <div>
           

             <div style='margin-top:15px;width:100%;display:inline-block;font-size:11pt;'>인증번호</div>
             
             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
               <input id="krw2_code" name="krw2_code" type="text" placeholder="인증번호" value="" style="font-size:12pt;text-align:center">

             </div>


             <div style='margin-top:5px;width:100%;display:inline-block;font-size:11pt;padding:15px;background:#E5E5E5'>
             
              <div style="margin-top:5px">* 이메일로 인증번호가 발송되었습니다. 인증번호를 입력해 주세요.</div>
 
             </div>

          
             <div style="border-bottom: 1px #E5E5E5 solid;margin-top:15px;margin-bottom:15px"></div>
          
           
             <input type="button" class="step1-btn" onclick="KRW_CODE_CONFIRM()" value="확인">
           
             
              
          </div>
          
      </div>
      <div class="button">
          <a href="javascript:close_Popup('layer7');">창닫기</a>
      </div>
  </div>
</div>





<script>


 function close_Popup(val) { 

  document.getElementById(val).style.display = "none";
   
 }
 
   
 function LOCKUP_OPEN() { 



   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("lockup_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "락업수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("lockup_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("lockup_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "락업수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("lockup_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("lockup_token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("lockup_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 

    
    
    
    
   if ( document.getElementById("edate").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "종료일자를 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("edate").focus();

      return;
     
     });
     
     return;
     
   }
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./lockup_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });


  
   
 }
 
 
 function LOCKUP_CODE_CONFIRM(){
  
  
    document.getElementById('layer').style.display = "none";
 
 
    if ( document.getElementById("lockup_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer').style.display = "block";
       
      document.getElementById("lockup_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("lockup_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./lockup_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionDone() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 
   
 function COIN_OPEN() { 
   
   

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "코인수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer2').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });
       
       
       
       
   
   
   
 }
   
 
 
 function COIN_CODE_CONFIRM(){
  
  
    document.getElementById('layer2').style.display = "none";
 
 
    if ( document.getElementById("coin_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer2').style.display = "block";
       
      document.getElementById("coin_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("coin_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionCoinDone() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer2').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer2').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 



 
 
 
   
 function COIN2_OPEN() { 
   
   


   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 코인수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer3').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });
       
       
       
       
   
   
   
 }
   
 
 
 function COIN2_CODE_CONFIRM(){
  
  
    document.getElementById('layer3').style.display = "none";
 
 
    if ( document.getElementById("coin2_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer3').style.display = "block";
       
      document.getElementById("coin2_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("coin2_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionCoinCollect() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer3').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer3').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 
  
  
  
  
 // BNB 시작
 
 
  
 
 
   
 function BNB_OPEN() { 
   
   


   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("bnb_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?=$chainSymbol?> 코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("bnb_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "<?=$chainSymbol?> 코인 수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("bnb_token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer4').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });
       
       
       
       
   
   
   
 }
   
 
 
 function BNB_CODE_CONFIRM(){
  
  
    document.getElementById('layer4').style.display = "none";
 
 
    if ( document.getElementById("bnb_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer4').style.display = "block";
       
      document.getElementById("bnb_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("bnb_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionBnbCoinDone() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer4').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer4').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 



 
 
 
   
 function BNB2_OPEN() { 
   
   

   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("bnb_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 <?=$chainSymbol?> 코인 수량을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber(document.getElementById("bnb_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 <?=$chainSymbol?> 코인 수량은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();

      return;
     
     });
     
     return;
     
   }
   
    

    
    
    
    

   let amount = document.getElementById("bnb_token").value ;
   

    
   if ( amount.indexOf(".") == -1 ) {
    

   }
   else {
      
    let amount_float = amount.split('.') ;
    
    if ( amount_float[1].length > 8 ) {
      
     Swal.fire({
      icon: "warning",
      text: "소숫점 이하 8자리까지 입력이 가능하십니다.",
     }).then((ok) => {
       
      document.getElementById("bnb_token").focus();
      return;
     
     });
     
     return;
     
    }
    
   
   } 
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer5').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });
       
       
       
       
   
   
   
 }
   
 
 
 function BNB2_CODE_CONFIRM(){
  
  
    document.getElementById('layer5').style.display = "none";
 
 
    if ( document.getElementById("bnb2_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer5').style.display = "block";
       
      document.getElementById("bnb2_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("bnb2_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionBnbCoinCollect() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer5').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer5').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 
 // BNB 끝 
 
 
     



 
 
 
  
  
  
  
 // KRW 시작
 
 
  
 
 
   
 function KRW_OPEN() { 
   
   



   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("krw_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "KRW 금액을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber2(document.getElementById("krw_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "KRW 금액은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer6').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });
       
       
       
       
   
   
   
 }
   
 
 
 function KRW_CODE_CONFIRM(){
  
  
    document.getElementById('layer6').style.display = "none";
 
 
    if ( document.getElementById("krw_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer6').style.display = "block";
       
      document.getElementById("krw_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("krw_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionKrwCoinDone() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer6').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer6').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 



 
 
 
   
 function KRW2_OPEN() { 
   
   


   arr_cnt = 0 ;
   
   
   var form = document.Form ;
   var cnt = 0;
   var count = parseInt(form.count.value) ;
   let seqno_str = "" ;

   for(var i = 1 ; i < count ;i++) {
     
     if ( eval("form.chk" + i + ".checked  == true") ) { 
       
      seqno_arr[cnt] = document.getElementById("seqno_"+i).value ; ;
      
      cnt = cnt + 1 ; 

     } 

   }

   if ( cnt == 0 ) {

    alert("처리할 내역을 선택해 주세요.");
    return ;

   }
    


   if ( document.getElementById("krw_token").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 KRW 금액을 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }

   if ( !isNumber2(document.getElementById("krw_token").value) ) {
      
     Swal.fire({
      icon: "warning",
      text: "회수할 KRW 금액은 숫자만 입력해 주세요.",
     }).then((ok) => {
       
      document.getElementById("krw_token").focus();

      return;
     
     });
     
     return;
     
   }
   
   
   
   
   
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 인증번호를 메일로 전송중입니다. 중간에 종료하지 마세요." ;

       var formdata = new FormData();
       
       formdata.append("", "");
       
       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_email_send.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
           
           document.getElementById("loadingdiv").style.display = "none";
           
           document.getElementById('layer7').style.display = "block";
           
         }    
         else { 
           
          document.getElementById("loadingdiv").style.display = "none";
          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         }
         
         
       })
       .catch(error => {
         
         document.getElementById("loadingdiv").style.display = "none";

          
          Swal.fire({
           icon: "success",
           text: "<?if ( $lang == "en" ) {?>Email sending failed. please try again.<?}else{?>이메일 전송에 실패하였습니다. 다시 시도해 주세요.<?}?>",
          }).then((ok) => {
         
           return;
          
          });
          
          return;
         
         
       });
       
       
       
       
   
   
   
 }
   
 
 
 function KRW2_CODE_CONFIRM(){
  
  
    document.getElementById('layer7').style.display = "none";
 
 
    if ( document.getElementById("krw2_code").value == "" ) {
      
     Swal.fire({
      icon: "warning",
      text: "인증번호를 입력해 주세요.",
     }).then((ok) => {
      
      document.getElementById('layer7').style.display = "block";
       
      document.getElementById("krw2_code").focus();

      return;
     
     });
     
     return;
     
    }


    
       document.getElementById("loadingdiv").style.display = "block";
       document.getElementById("loadingdiv_result").innerHTML = "* 처리중입니다. 중간에 종료하지 마세요." ;
       
       
       var formdata = new FormData();
       

       formdata.append("certification_num", document.getElementById("krw2_code").value);

       var requestOptions = {
        method: "POST",
        body: formdata,
        redirect: "follow",
       };
       
       fetch("./coin_certificationOk.php", requestOptions)
       .then((response) => response.text())
       .then((result) => {
         

         if ( result.replace(/^\s+|\s+$/gm,'') == "succ" ) { 
          
          document.getElementById("loadingdiv").style.display = "none";

          SelectionKrwCoinCollect() ;

         }
         else {
           
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "인증번호가 일치하지 않습니다. 다시 시도해 주세요.",
          }).then((ok) => {
            
           document.getElementById('layer7').style.display = "block";
           
           return;
          
          });
           
         }  
         
         
       })
       .catch(error => {
         
         
          document.getElementById("loadingdiv").style.display = "none";
           
          Swal.fire({
           icon: "success",
           text: "오류가 발생하였습니다. 다시 시도해 주세요.",
          }).then((ok) => {
         
           document.getElementById('layer7').style.display = "block";
           
           return;
          
          });
          

       });
          
          
      
      
  
  
 }
 
 
 
 // KRW 끝 
 
 
     
  
  
  
  
  
  
function COPY(val) {

  
   const t = document.createElement("textarea");
   document.body.appendChild(t);
   t.value = val;
   t.select();
   document.execCommand('copy');
   document.body.removeChild(t);
          
          
   Swal.fire({
           icon: "success",
           text: "코드를 복사하였습니다.",
   }).then((ok) => {
         
           return;
          
   });
          
          
          
 }
 
 

 
 
 
let container_position_x ;
let container_position_y ;
 
if ( window.innerWidth > 991 ) {
  
 container_position_x = ( window.innerWidth - 549 ) / 2 ;
 container_position_y = ( ( window.innerHeight - document.getElementById("box").clientHeight ) / 2 ) - 80 ;
 
}
  
 
if ( window.innerWidth > 991 ) {
 
   //document.getElementById("box").style.top = container_position_y + "px" ;
   
}
else {
          

        
}  


  
</script>




<?

 include("footer.php");
 
?> 

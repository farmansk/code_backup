$(document).ready(function(){

  // 수강생관리 > 수강생내역 문자(웹) 클릭
  $('.smsclick').click(function(){
    $('.sms_none').show();
    return false;
  });
  $('.close_btn').click(function(){
    $('.sms_none').hide();
    return false;
  });

  // 수강생관리 > 입관 tab
  $('.tabul > li').click(function(){
    $(this).siblings().removeClass('on');
    $(this).addClass('on');
    var idx = $(this).index();
    $('.tab_con').removeClass('tab_on');
    $('.tab_con').eq(idx).addClass('tab_on');
    return false;
  });



})

var msgMode = getURLParameter('msgMode') || 'sms';
var textMode = "normal";
var limitByte = 0;
var focusedMsg = 'msg';

var receiver_group=[],receiver_group_public=[],receiver_user=[],receiver_user_public=[],receiver_input=[];
var receiver_count = 0, remain_count = 0;

function init_private(){
	init_css();
	msgModeChange();
	
	if(!_ID){ alertNotice('login'); }

	if(getCookie('chk_MsgToLMS') === null || getCookie('chk_MsgToLMS') === '' || getCookie('chk_MsgToLMS') == 'null' || typeof getCookie('chk_MsgToLMS') == 'undefined'){
		$("input[name='msgToLMS']").prop('checked',true);
	}else{
		$("input[name='msgToLMS']").prop('checked',false);
	}

	getAjaxUrl('/send/mymsg.do');
	
	$(window).load(function(){
		$(".datepicker").datepicker("option",{
			"minDate":"0",
			"maxDate":"+1Y"
		});
		$.getName('reserve_ymd').datepicker('setDate',new Date());
		//var reserve_hm = time2date(getTime() + 20*60);
		var reserve_hm = time2date(Math.round((getTime() + 20*60)/(60*5))*(60*5));
		$.getName('reserve_h').val(reserve_hm.substr(8,2));
		$.getName('reserve_m').val(reserve_hm.substr(10,2));
		$("input:radio[name='timeMode']:input[value='N']").prop("checked", true);
		if(typeof $('.img_box').data('html') == 'undefined'){
			$('.img_box').data('html',$('.img_box').html());
		}

		$('#recent_callback_btn').css('top',$.getName('sender').position().top+'px');
	});

	maxByte = {
		'msgTitle' : 60,
		'mymsgTitle' : 60,
		'mymsgValue' : 2000
	};
}

var senderFix = '';
function isSenderChkAjax(){
	var action = "/mypage/senderChk.do",
		param = {
			'sender' : $.getName('sender').val()
		};
	if($.getName('sender').val() == ''){
		alert('발신번호를 입력하세요.');
	}else{
		$.post(action,$.param(param))
			.done(function(res){
				try{
					var res = $.parseJSON(res);
					if(res.result == "succ"){
						alert('전송 가능한 발신번호입니다.');
						senderFix = $.getName('sender').val();
					}else{
						if(typeof(res.data) != 'undefined' && res.data.code == '1'){
							alert('등록되지 않은 발신번호로 전송이 불가합니다.\n발신번호를 사전등록후 이용해주시기 바랍니다.');
						}else{
							alert('변작의심으로 처리된 번호입니다.\n헬프데스크(1600-0045)로 문의하여 주시기 바랍니다.');
						}
						senderFix = '';
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			})
	}
}

function isSenderChkFinal(){
	var action = "/mypage/senderChk.do",
		param = {
			'sender' : $.getName('sender').val()
		},
		returnV = false;
	if($.getName('sender').val() == ''){
		alert('발신번호를 입력하세요.');
	}else{
		$.ajax({
			type :'POST',
			url :action,
			data: $.param(param),
			async : false,
			dataType:"html",
			success :function(res){
				try{
					var res = $.parseJSON(res);
					if(res.result == "succ"){
						returnV = true;
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			}
		});
	}
	return returnV;
}

function init_css(){
	$('.page_title , .main_desc').hide();

	$('.last_set_type_wrap .type1').removeClass('active');
	$('.last_set_type_wrap .type2').addClass('active');
	$('.last_set_type_wrap :input').prop('disabled',true);
	$('.last_set_type_btn li:nth-child(1) label').click(function(){
		$('.last_set_type_wrap :input').prop('disabled',true);
	});
	$('.last_set_type_btn li:nth-child(2) label').click(function(){
		$('.last_set_type_wrap .type2 :input').prop('disabled',false);
	});


	$('.text_box2 .open_mms_img').click(function(){
		$('.layer_popup.mms_img').show();
	});
}

function getMsgToLMS(){
	return $.getName('msgToLMS').is(":checked");
}
function msgToLMS_chk(obj){
	var checked = obj.checked;
	if(!checked){
		setCookie('chk_MsgToLMS','',-1);
		setCookie('chk_MsgToLMS','N',365);
	}else{
		setCookie('chk_MsgToLMS','',-1);
	}
}

function setFocusedMsg(v){
	focusedMsg = v;
}

function msgModeChange(param){
	if(!param){ param = msgMode; }
	if(!authChk(param)){
		var paramFlag = param;
		if(paramFlag == 'smsurl'){
			paramFlag = 'sms url';
		}
		var msg = (_isMaster)?paramFlag.toUpperCase()+" 사용권한이 없습니다. 이용 희망시 담당영업사원 혹은 헬프데스크(1600-0045)로 문의하여 주시기 바랍니다.":paramFlag.toUpperCase()+" 사용권한이 없습니다. 이용 희망시 서비스담당자("+_pinfo.name+", "+_pinfo.mdn+")에게 문의하여 주시기 바랍니다.";
		alert(msg);
		return;
	}
	if((param == 'sms') && (getByte($.getName('msg').val())> _smsByte)){
		if(confirm('SMS로 전환할 경우 입력내용이 '+_smsByte+'바이트 이내로 삭제됩니다.\n\n진행 하시겠습니까?')){
			$.getName('msg').val(byteSubstring($.getName('msg').val(),0,_smsByte));
		}else{
			return;
		}
	}

	if((param == 'smsurl') && (getByte($.getName('msg').val())> _smsurlByte)){
		if(confirm('SMS Callback URL로 전환할 경우 입력내용이 '+_smsurlByte+'바이트 이내로 삭제됩니다.\n\n진행 하시겠습니까?')){
			$.getName('msg').val(byteSubstring($.getName('msg').val(),0,_smsurlByte));
		}else{
			return;
		}
	}

	if((msgMode == 'smsurl' && param != 'smsurl') && ($.getName('msgUrl').val() != 'http://')){
		if(confirm(param.toUpperCase()+'로 전환할 경우 URL 입력내용이 삭제됩니다.\n\n진행 하시겠습니까?')){

		}else{
			return;
		}
	}
	if((msgMode == 'mms' && param != 'mms') && ($.getName('msgImg1').val() != '' || $.getName('msgImg1').val() != '' || $.getName('msgImg1').val() != '')){
		if(confirm(param.toUpperCase()+'로 전환할 경우 업로드한 이미지가 삭제됩니다.\n\n진행 하시겠습니까?')){
			$('.img_box').empty().html($('.img_box').data('html'));
			$.getName('msgImg1').val('');
			$.getName('msgImg2').val('');
			$.getName('msgImg3').val('');
		}else{
			return;
		}
	}
	if(param){
		msgMode = param;
	}
	menuChange();
	limitByteChange();
	//대량전송일때 확정인원 계산 제외_20160614
	if($.getName('useMass').val() != 'Y'){
		remove_msg2();
	}
	$.getName('msg').focus();
	byteCheck($.getName('msg')[0]);
	$('.recentCallback').hide();

	$("#msg2_area").hide();
	$("#msg2_show").show();
	$("#msg2_hide").hide();
	$(".text_box textarea").removeClass('url');
	$(".text_box textarea").removeClass('short');
	$(".text_box textarea").removeClass('smsurl_url');
	$(".text_box textarea").removeClass('smsurl_text');
	$('.setup').hide();
	$('.img_box').hide();
	$('.sms_tool').hide();
	$('.lms_tool').hide();
	$('.img_tool').hide();
	$("#msg2_hide").hide();
	$('#img_reset').hide();

	$.getName('msg2').val('');
	$.getName('msgUrl').val('http://').hide();

	$.getName('msgTitle').hide();
	if(msgMode == 'sms'){
		$('div.setup').show();
		$('.sms_tool').show();
		setRemainCount(number_format($('#remainCountBox').data('sms_cnt')));
	}else if(msgMode == 'smsurl'){
		$('.lms_tool').show();
		
		$.getName('msgUrl').addClass('smsurl_url');
		$.getName('msg').addClass('smsurl_text');

		$('.lms_tool').show();
		$.getName('msgUrl').show();
		setRemainCount(number_format($('#remainCountBox').data('sms_cnt')));
	}else{
		$('.lms_tool').show();
		if(msgMode == 'mms'){
			$(".text_box textarea").addClass('url');
			$('.img_box').show();
			$('.img_tool').show();
			$('#img_reset').show();
			setRemainCount(number_format($('#remainCountBox').data('mms_cnt')));
		}else{
			setRemainCount(number_format($('#remainCountBox').data('lms_cnt')));
		}
		$.getName('msgTitle').show();
	}
}


function textModeChange(param){
	if(param && param!=textMode){
		if(textMode != 'commercial'){
			if(confirm('기존 메시지 내용이 삭제됩니다.\n\n광고모드로 변경하시겠습니까?')){
				$.getName('msg').val('(광고)\n무료거부 080XXXXXXXX');
				textMode = param;
			}else{
				return;
			}
		}else{
			if(confirm('기존 메시지 내용이 삭제됩니다.\n\n일반모드로 변경하시겠습니까?')){
				$.getName('msg').val('');
				textMode = param;
			}else{
				return;
			}
		}
		
	}
	$('.btn_group_type button').addClass('active');
	$(".btn_group_type button[data-textMode='"+textMode+"'").removeClass('active');
	byteCheck($.getName('msg')[0]);
}

function menuChange(){
	// 1. left 
	$("#snb li a").removeClass('active');
	$("#snb li a[data-subMenu='"+msgMode+"']").addClass('active');

	// 2. page_title
	$(".page_title").hide();
	$("#page_title_"+msgMode).show();

	// 3. main_desc
	$(".main_desc").hide();
	$("#main_desc_"+msgMode).show();
	$("#main_desc2_"+msgMode).show();

}

function limitByteChange(){
	switch(msgMode){
		case 'sms' : limitByte = _smsByte; break;
		case 'smsurl' : limitByte = _smsurlByte; break;
		case 'lms' : case 'mms' : limitByte = _lmsByte; break;
	}
	$("#limitByte").text('/'+limitByte+' Byte');
}

function specialCharInsert(obj){
	var v = $(obj).text(),
		target = $.getName(focusedMsg)[0];
	insertAtCaret(target,v);
	byteCheck(target);

}
function mergeInsert(v){
	var target = $.getName(focusedMsg)[0];
	insertAtCaret(target,v);
	byteCheck(target);
}
function resetMsg(){
	var el1 = $.getName('msg'),
		el2 = $.getName('msg2'),
		el3 = $.getName('msgUrl');

	el1.val('');
	el2.val('');
	el3.val('http://');
	if(textMode == 'commercial'){
		el1.val('(광고)\n무료거부 080XXXXXXXX\n');
	}
	byteCheck(el1[0]);
	byteCheck(el2[0]);
}

function resetImg(){
	if($.getName('msgImg1').val() == '' && $.getName('msgImg2').val() == '' && $.getName('msgImg3').val() == ''){
		alert('삭제할 이미지가 없습니다');
		return;
	}
	if(msgMode == 'mms' && ($.getName('msgImg1').val() != '' || $.getName('msgImg2').val() != '' || $.getName('msgImg3').val() != '')){
		if(confirm('업로드한 이미지가 삭제됩니다.\n\n진행 하시겠습니까?')){
			$('.img_box').empty().html($('.img_box').data('html'));
			$.getName('msgImg1').val('');
			$.getName('msgImg2').val('');
			$.getName('msgImg3').val('');
		}else{
			return;
		}
	}
}

function getByte(v){
	var tmpChar='',length=0;
	for (var i=0;i<v.length;i++){
		tmpChar = escape(v.charAt(i));
		if (tmpChar=='%0D') {
		} else if (tmpChar.length > 4) {
			length += 2;
		} else {
			length += 1;
		}
		if(length <= limitByte){
			length_cut = i+1;
			length_byte = length;
		}
	}
	return length;
}

function add_msg2(){
	$("#msg2_area").show();
	$(".text_box textarea").addClass('short');

	$.getName('msg2').focus();
	$("#currentByte_msg2").html('<strong>'+0+'</strong>');
	$("#msg2_show").hide();
	$("#msg2_hide").show();
}
function remove_msg2(){
	$("#msg2_area").hide();
	$(".text_box textarea").removeClass('short');

	$("#msg2_show").show();
	$("#msg2_hide").hide();

	$.getName('msg2').val('');
	$.getName('msg').focus();
	$("#currentByte_msg2").html('<strong>'+0+'</strong>');

	setReceiver();
}
function byteCheck(obj){
	var length = 0,
		length_cut = 0,
		length_byte = 0,
		v = $(obj).val(),
		tmpChar = '',
		limit_byte = limitByte;

	if(msgMode == 'smsurl'){
		if(obj.name == 'msgUrl'){
			limit_byte = 40;
		}else{
			v = $.getName('msgUrl').val() + $.getName('msg').val();
		}
	}
	for (var i=0;i<v.length;i++){
		tmpChar = escape(v.charAt(i));
		if (tmpChar=='%0D') {
		} else if (tmpChar.length > 4) {
			length += 2;
		} else {
			length += 1;
		}
		//2byte인데 웹상에서 1byte로 계산되는 문자들 ('§', '¨', '´', '¸', '·')
	    if (tmpChar == '%A7' || tmpChar == '%A8' || tmpChar == '%B4' || tmpChar == '%B7' || tmpChar == '%B8') {
	    	length += 1;
	    }
		if(length <= limit_byte){
			length_cut = i+1;
			length_byte = length;
		}
	}
	if(obj.name == 'msg2' && v=='' && event.keyCode == 8){
		$("#msg2_area").hide();
		$(".text_box textarea").removeClass('short');

		var tv = $.getName('msg').val();
		$.getName('msg').focus().val('').val(tv);
		$("#currentByte_msg2").html('<strong>'+0+'</strong>');
		$("#msg2_show").show();
		$("#msg2_hide").hide();
		return false;
	}
	if(length > limit_byte){
		if(msgMode == 'sms'){
			if(getURLfolder() == 'mass'){
				alert(msgMode.toLocaleUpperCase()+"는 "+limitByte+"byte까지만 문구 입력이 가능합니다.");
				$(obj).blur().val(v.substr(0,length_cut)).focus();
			}else if(obj.name == 'msg2'){
				alert(msgMode.toLocaleUpperCase()+"는 "+limitByte+"byte까지만 문구 입력이 가능합니다.");
				$(obj).blur().val(v.substr(0,length_cut)).focus();
			}else if(!getMsgToLMS()){
				$(obj).blur().val(v.substr(0,length_cut)).focus();
				$("#msg2_area").show();
				$(".text_box textarea").addClass('short');

				$.getName('msg2').focus();
				$("#currentByte_msg").html('<strong>'+length_byte+'</strong>');
				$("#currentByte_msg2").html('<strong>'+0+'</strong>');
				$("#msg2_show").hide();
				$("#msg2_hide").show();
				return false;
			}else{
				msgModeChange('lms');
				return false;
			}
		}else{
			if(msgMode == 'smsurl'){
				alert("SMS URL은 "+limitByte+"byte까지만 문구 입력이 가능합니다.");
				if(obj.name == 'msgUrl'){
					$.getName('msgUrl').blur().val(byteSubstring($.getName('msgUrl').val(),0,limit_byte)).focus();
				}
				$.getName('msg').blur().val(byteSubstring($.getName('msg').val(),0,_smsurlByte-getByte($.getName('msgUrl').val()))).focus();
			}else{
				alert(msgMode.toLocaleUpperCase()+"는 "+limitByte+"byte까지만 문구 입력이 가능합니다.");
				$(obj).blur().val(v.substr(0,length_cut)).focus();
			}
//			alert(limitByte+"Byte를 초과하실 수 없습니다.");
//			return;
		}
	}else{
		if(msgMode == 'lms' || msgMode == 'mms'){
			if(getCookie('chk_MsgToLMS') === null || getCookie('chk_MsgToLMS') === '' || getCookie('chk_MsgToLMS') == 'null' || typeof getCookie('chk_MsgToLMS') == 'undefined'){
				$.getName('msgToLMS').prop('checked',true);
			}
		}
	}
	if(msgMode == 'smsurl'){
		if(obj.name == 'msgUrl'){
			length_byte = getByte($(obj).val()+ $.getName('msg').val());
			if(length_byte >= _smsurlByte){
				$.getName('msg').blur().val(byteSubstring($.getName('msg').val(),0,_smsurlByte-getByte($.getName('msgUrl').val()))).focus();
			}
			length_byte = getByte($(obj).val()+ $.getName('msg').val());
		}
		$("#currentByte_msg").html('<strong>'+length_byte+'</strong>');
	}else{
		$("#currentByte_"+obj.name).html('<strong>'+length_byte+'</strong>');
	}
}

function sendChk(mode){
	var f = $.getName('sendForm'),
		action = ($.getName('useMass').val() != 'Y')?"/send/sendAction.do":"/send/sendAction.do?from=mass",
		error = false;

	$.getName('msgMode').val(msgMode);
	$.getName('dupChk').val($.getName('dupChecker').filter(':checked').val());

	$.getName('receiver_input').val(receiver_input.join(","));
	$.getName('receiver_group').val(receiver_group.join(","));
	$.getName('receiver_user').val(receiver_user.join(","));
	$.getName('receiver_group_share').val(receiver_group_public.join(","));
	$.getName('receiver_user_share').val(receiver_user_public.join(","));

	if(!$.getName('msg').val()){
		if(msgMode == 'mms'){
			if($.getName('msgImg1').val() == '' && $.getName('msgImg2').val() == '' && $.getName('msgImg3').val() == ''){
				alert('메시지 내용을 입력하세요');
				$.getName('msg').focus();
				return; 
			}
			//20160408
			if($.getName('msgImg1').val() != ''){
				$.getName('msg').val(' ');
			}
		}else{
			alert('메시지 내용을 입력하세요');
			$.getName('msg').focus();
			return; 
		}
	}else{
		$.getName('msg').val($.getName('msg').val().replace(/\r/g,''));
		$.getName('msg2').val($.getName('msg2').val().replace(/\r/g,''));
		
		//사용불가 문자 체크(네이트버전)_20161109
		/*var notEucKR = getNotEucKR($.getName('msg').val()+$.getName('msg2').val());
		if ( notEucKR != null ) {
			$.getName('msg').focus();
			alert("사용불가문자 : "+notEucKR);
			return;
		}*/
	}
	if(msgMode == 'mms' && $.getName('msgImg1').val() == '' && $.getName('msgImg2').val() == '' && $.getName('msgImg3').val() == ''){
		alert('이미지를 1장 이상 등록하세요.');
		$.getName('msg').focus();
		return; 
	}
	
	// 공백상태 전송 방지_20160613
	if(msgMode != 'mms' && $.trim($.getName('msg').val()).length == 0){
		alert('메시지 내용을 입력하세요.');
		$.getName('msg').focus();
		return; 
	}

	if(receiver_count == 0){
		if($.getName('useMass').val() == 'Y'){
			alert('파일을 업로드 하세요');
			$.getName('receive').focus();
		}else{
			alert('받는사람 번호를 입력하세요');
			$.getName('receive').focus();
		}
		return; 
	}

	if($.getName('useMass').val() == 'Y' && receiver_count > 100000){
		alert('대량전송은 최대 100,000건 이하만 전송 가능합니다.');
		return;
	}else if($.getName('useMass').val() == 'N' && receiver_count > 10000){
		alert('일반전송은 최대 10,000건 이하만 전송 가능합니다.');
		return;
	}

	if($.getName('sender').val() == ''){
		alert('발신번호를 입력하세요');
		$.getName('sender').focus();
		return;
	}
	if(senderFix == '' || $.getName('sender').val() != senderFix || isSenderChkFinal() === false){
		alert('발신번호를 확인하세요');
		return;
	}

	/*
	var sender = $.getName('sender').val();
	if(
		!((sender.substr(0,2) != '15' && sender.substr(0,2) != '16' && sender.substr(0,2) != '18' && sender.substr(0,3) != '030' && sender.substr(0,3) != '050' && !isNaN(sender)) && sender.length >= 8 && sender.length <= 11) && 
		!(sender.substr(0,3) == '050' && sender.length >= 11 && sender.length <= 12) &&
		!(sender.substr(0,3) == '030' && sender.length == 12) &&
		!((sender.substr(0,2) == '15' || sender.substr(0,2) == '16' || sender.substr(0,2) == '18') && sender.length == 8)
	){
		alert('발신번호가 번호규칙에 위반됩니다.\n정상적인 발신번호를 입력하세요.');
		$.getName('sender').focus();
		return;
	}
	*/

	// 예약시간 재확인
	if($("input[name='timeMode']:checked").val() != 'N'){
		if(!reserveDateChk()){
			return;
		}
	}

	// 발송간격 재확인
	if($.getName('splitChk').is(":checked") == true){
		$('.splitOption').prop('disabled',false).css('background-color','#fff');
	}

	if(!$.getName('msgTitle').val() || $.getName('msgTitle').val() == $.getName('msgTitle').attr('placeholder')){
		$.getName('msgTitle').val('제목 없음');
	}

	/*
	if(remain_count < receiver_count){
		alert('제한 건수 초과로 인하여 문자를 보낼 수 없습니다.\n받는사람(수신자) 수를 확인하세요.\n\n(초과건수 : '+(receiver_count-remain_count)+'건)');
		return;
	}
	*/
	if(msgMode == 'sms' && getByte($.getName('msg').val()) > _smsByte){
		alert('SMS 전송문구가 '+_smsByte+'Byte 를 초과했습니다.\n메시지 내용을 다시 확인해주세요.');
		return;
	}
	if(msgMode == 'smsurl' && getByte($.getName('msgUrl').val() + $.getName('msg').val()) > _smsurlByte){
		alert('SMS Callback URL 전송문구가 '+_smsurlByte+'Byte 를 초과했습니다.\n메시지 내용을 다시 확인해주세요.');
		return;
	}
	if(mode == 'ready'){
		if(msgMode == 'lms' && $.getName('msg').val().indexOf('[#이름#]') == -1 && $.getName('msg').val().indexOf('[#기타1#]') == -1 && $.getName('msg').val().indexOf('[#기타2#]') == -1 && $.getName('msg').val().indexOf('[#기타3#]') == -1 && $.getName('msg').val().indexOf('[#기타4#]') == -1 ){
			if($.getName('msg').val() != '' && getByte($.getName('msg').val()) <= _smsByte){
				if(confirm('문구가 '+_smsByte+'Byte 이내입니다.\nSMS로 전송하시겠습니까?')){
					msgModeChange('sms');
				}
			}
		}
		switch($("input[name='timeMode']:checked").val()){
			case 'N' : $('#view_timeMode').text('즉시'); break;
			case 'R' : $('#view_timeMode').text($.getName('reserve_ymd').val()+' '+$.getName('reserve_h').val()+':'+$.getName('reserve_m').val()); break;
		}
		$('#view_splitTime').text('미사용');
		if($.getName('splitChk').is(":checked") == true){
			$('#view_splitTime').text($.getName('splitCnt').val()+' 개씩 '+$.getName('splitTime').val()+' 분 간격');
		}
		$('#view_dupChk').text(($.getName('dupChecker').filter(':checked').val() == 'Y')?"사용":"미사용");
		$('#view_msg_cnt').text(($.getName('msg2').val() == '')?"1":"2");
		$('#view_msgUser_cnt').text(($.getName('msg2').val() == '')?receiver_count:receiver_count/2);
		$('#view_receiver_cnt').text(receiver_count);
		$('#view_reject').text(($.getName('rejectChk').filter(':checked').val() == 'Y')?"사용":"미사용");

		var chkDate = $.getName('reserve_ymd').val()+''+$.getName('reserve_h').val()+''+$.getName('reserve_m').val();
		if(Number(chkDate.replace(/[-]/g,'').substr(8,2)) >= 21 || Number(chkDate.replace(/[-]/g,'').substr(8,2)) < 8){
			if(!confirm('야간 시간대(오후9시~오전8시)에 수신자에게 광고 메시지가 전달될\n경우, 3천만원 이하의 과태료가 부과될 수 있습니다.\n전송시 필요한 수신자에게 야간 광고 전송에 대한 개별 동의를 받아야\n합니다. 전송하시겠습니까?')){
				return;
			}
		}

		if($.getName('reserve_ymd').datepicker('getDate').getTime()/1000 > (getTime() + (60 * 60 * 24 * 366))){
			alert('예약시간은 1년 이내로 설정하셔야 합니다.');
			return;
		}
		//isSenderChk();
		layerOpen('send_message');
	}else if(mode == 'preview'){ // 미리보기
		var req = f.serializeArray();
		req.push({name:"preview",value:"Y"});
		$.post(action,$.param(req))
			.done(function(res){
				try{
					var res = $.parseJSON(res),
						result = res.result,
						data = res.previewList,
						html = '';
					if(result == "succ"){
						$.each(data,function(k,v){
							if(getByte(v.msg) > 94){
								html += "<tr><td>"+v.receiver+"</td><td class='bdrn' style='word-break:break-all;'><div title='"+v.msg+"'>"+byteSubstring(v.msg,0,94)+"..</div></td></tr>";
							}else{
								html += "<tr><td>"+v.receiver+"</td><td class='bdrn' style='word-break:break-all;'><div title='"+v.msg+"'>"+v.msg+"</div></td></tr>";
							}
						});
						$('#previewResult').html(html);
						$("#previewText").parent().removeClass('short');
						$("#previewText").parent().removeClass('mms');
						$("#previewText").removeClass('short').val($.getName('msg').val());
						$("#previewText").removeClass('mms').val($.getName('msg').val());

						if($.getName('msgTitle').val() == $.getName('msgTitle').attr('placeholder')){
							$("#previewTitle").val('');
						}else{
							$("#previewTitle").val($.getName('msgTitle').val());
						}
						$('#previewByte').html('<strong>'+$('#currentByte_msg').text() + '</strong> ' +$('#limitByte').text());
						$('#previewImage').hide().html($('.img_box img.uploadImage').clone());
						$('#previewText2_area').hide();
						$('#previewSender').text($.getName('sender').val());
						switch(msgMode){
							case 'sms' : 
								if($.getName('msg2').val() != ''){
									$("#previewText").parent().addClass('short');
									$("#previewText").addClass('short');
									$("#previewText2").css('margin-top','13px').val($.getName('msg2').val());
									$('#previewByte2').html('<strong>'+$('#currentByte_msg2').text() + '</strong> ' +$('#limitByte').text());
									$('#previewText2_area').show();
								}
								break;
							case 'smsurl' : $("#previewText").val($.getName('msgUrl').val()+$.getName('msg').val());
								break;
							case 'lms' : break;
							case 'mms' : 
								if($('#previewImage img').length == 0){
									$('#previewImage').html('');
								}
								$('#previewImage').show();
								$("#previewText").parent().addClass('mms');
								$("#previewText").addClass('mms');
								break;
						}
						layerOpen('text_preview');
					}else{
						var msg = '';
						switch(res.data.code){
							case "1" : msg = "등록되지 않은 발신번호로 전송이 불가합니다.\n발신번호를 사전등록후 이용해주시기 바랍니다."; break;
							case "2" : msg = "변작의심으로 처리된 번호입니다.\n헬프데스크(1600-0045)로 문의하여 주시기 바랍니다."; break;
							case "3" : msg = "전송설정값이 올바르지 않습니다.\n예약시간 또는 전송간격을 다시 확인해주시기 바랍니다."; break;
							case "4" : msg = "사용불가문자 : " + res.data.returnMsg; break;
						}
						alert(msg);
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			})
	}else if(mode == 'test'){
		$('#send_test_number1').val('');
		$('#send_test_number2').val('');
		$('#send_test_number3').val('');
		$('#name1').val('');
		$('#etc11').val('');
		$('#etc12').val('');
		$('#etc13').val('');
		$('#etc14').val('');
		$('#name2').val('');
		$('#etc21').val('');
		$('#etc22').val('');
		$('#etc23').val('');
		$('#etc24').val('');
		$('#name3').val('');
		$('#etc31').val('');
		$('#etc32').val('');
		$('#etc33').val('');
		$('#etc34').val('');
		
		$('.send_test').css({'width':'590px'});
		layerOpen('send_test');
	}else if(mode == 'sendtest'){
		var req = f.serializeArray(),
			test_input = [];
		if($.trim($('#send_test_number1').val())){ test_input.push($('#send_test_number1').val()); }
		if($.trim($('#send_test_number2').val())){ test_input.push($('#send_test_number2').val()); }
		if($.trim($('#send_test_number3').val())){ test_input.push($('#send_test_number3').val()); }

		if(test_input.length == 0){
			alert('수신번호를 입력하세요');
			$('#send_test_number1').focus();
			return;
		}

		for(var k in req){
			if(req[k].name == "receiver_group"){ req[k].value = '';}
			else if(req[k].name == "receiver_group_share"){ req[k].value = '';}
			else if(req[k].name == "receiver_user"){ req[k].value = '';}
			else if(req[k].name == "receiver_user_share"){ req[k].value = '';}
			else if(req[k].name == "receiver_group_public"){ req[k].value = '';}
			else if(req[k].name == "receiver_user_public"){ req[k].value = '';}
			else if(req[k].name == "receiver_input"){ req[k].value = test_input.join(",");}
			else if(req[k].name == "useTest"){ req[k].value = 'Y';}
			else if(req[k].name == "receiver_name"){ req[k].value = $('#name1').val()+"||"+$('#name2').val()+"||"+$('#name3').val(); }
			else if(req[k].name == "receiver_etc1"){ req[k].value = $('#etc11').val()+"||"+$('#etc21').val()+"||"+$('#etc31').val(); }
			else if(req[k].name == "receiver_etc2"){ req[k].value = $('#etc12').val()+"||"+$('#etc22').val()+"||"+$('#etc32').val(); }
			else if(req[k].name == "receiver_etc3"){ req[k].value = $('#etc13').val()+"||"+$('#etc23').val()+"||"+$('#etc33').val(); }
			else if(req[k].name == "receiver_etc4"){ req[k].value = $('#etc14').val()+"||"+$('#etc24').val()+"||"+$('#etc34').val(); }
		}
		$.post(action,$.param(req))
			.done(function(res){
				try{
					var res = $.parseJSON(res),
						result = res.result,
						data = res.data;
					if(result == "succ"){
						var result_total_count = ($.getName('msg2').val() == '')?1:2;
						$('#result_total_count').text(test_input.length * result_total_count);
						$('#result_dup_count').text(data.dupCnt * result_total_count);
						$('#result_reject_count').text(data.rejectCnt * result_total_count);
						$('#result_recvError_count').text(data.receiveChkCnt * result_total_count);
						$('#result_senderError_count').text(data.sendChkCnt * result_total_count);
						$('#result_done_count').text((test_input.length * result_total_count)-(Number(data.dupCnt * result_total_count)+Number(data.rejectCnt * result_total_count)+Number(data.receiveChkCnt * result_total_count)+Number(data.sendChkCnt * result_total_count)));

						if(getURLfolder() != 'mass'){
							$('#send_message_done .only_mass').hide();
						}

						layerClose('send_test');
						layerOpen('send_message_done');

						$('.send_message_done_btn').click(function(){
							layerClose('send_message_done');
						});
					}else{
						var msg = '';
						switch(data.code){
							case "1" : msg = "등록되지 않은 발신번호로 전송이 불가합니다.\n발신번호를 사전등록후 이용해주시기 바랍니다."; break;
							case "2" : msg = "변작의심으로 처리된 번호입니다.\n헬프데스크(1600-0045)로 문의하여 주시기 바랍니다."; break;
							case "3" : msg = "전송설정값이 올바르지 않습니다.\n예약시간 또는 전송간격을 다시 확인해주시기 바랍니다."; break;
							case "4" : msg = "사용불가문자 : " + res.data.returnMsg; break;
						}
						alert(msg);
					}
				}catch(e){
					ajaxJsonException(e,res);
				}

			});
	}else if(mode == 'send'){
		//alert(f.serialize().replace(/[&]/g,'\n'));
		$.post(action,f.serialize())
			.done(function(res){
				try{
					var res = $.parseJSON(res),
						result = res.result,
						data = res.data;

					if(result == 'fail'){
						if(data.code != null && data.code != "3"){
							var msg = '';
							switch(data.code){
								case "1" : msg = "등록되지 않은 발신번호로 전송이 불가합니다.\n발신번호를 사전등록후 이용해주시기 바랍니다."; break;
								case "2" : msg = "변작의심으로 처리된 번호입니다.\n헬프데스크(1600-0045)로 문의하여 주시기 바랍니다."; break;
								case "3" : msg = "전송설정값이 올바르지 않습니다.\n예약시간 또는 전송간격을 다시 확인해주시기 바랍니다."; break;
								case "4" : msg = "사용불가문자 : " + res.data.returnMsg; break;
							}
							alert(msg);
						}else{
							alert('전송 실패했습니다.');
						}
					}else{
						var result_total_count = ($.getName('msg2').val() == '')?1:2;
						$('#result_total_count').text(receiver_count);
						$('#result_dup_count').text(data.dupCnt * result_total_count);
						$('#result_reject_count').text(data.rejectCnt * result_total_count);
						$('#result_recvError_count').text(data.receiveChkCnt * result_total_count);
						$('#result_senderError_count').text(data.sendChkCnt * result_total_count);
						$('#result_done_count').text((receiver_count)-(Number(data.dupCnt * result_total_count)+Number(data.rejectCnt * result_total_count)+Number(data.receiveChkCnt * result_total_count)+Number(data.sendChkCnt * result_total_count)));
					
						if(getURLfolder() != 'mass'){
							$('#send_message_done .only_mass').hide();
						}
						
						layerClose('send_message');
						layerOpen('send_message_done');

						$('.send_message_done_btn').click(function(){
							//location.reload();
							location.href = '/'+getURLfolder()+'/'+getURLfilename()+'?msgMode='+msgMode;
						});
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			});
	}
}

function fileChk(){
	var f = $.getName('fileForm'),
		file = f.find('input'),
		error = false,
		cnt = 0;

	$.each(file,function(k,v){
		if($(v).val() != ''){
			cnt++;
		}
		if($(v).val() != '' && !extCheck('file',$(v).val())){
			error = true;
			$(v).val('');
		}
	});
	if(cnt == 0){
		alert('업로드할 파일을 선택하세요.');
	}else if(error){
		alert('파일 확장자를 확인하세요');
	}else{
		f.ajaxSubmit({
			success : function(res){
				try{					
					var res = $.parseJSON(res),
						result = res.result,
						data = res.data,
						sheetList = res.sheetList;

					if(result == 'succ'){
						$('#uploadedFilename').parent().show();
						$('#uploadedFilename').text(file.val().split('\\').pop());
						var ext = getExt(file.val()),
							target = $.getName('massSheet');

						target.empty();
						if($.inArray(ext,['csv','txt']) != -1){
							target.prop('disabled',true).css('background-color','#ccc');
							target.append($("<option></option>").attr("value",'').text(''));
						}else{
							target.prop('disabled',false).css('background-color','#fff');
							
							for(var i=0; i<sheetList.length; i++){
								target.append($("<option></option>").attr("value", (i+1)).text(i + ' : '+sheetList[i]));
							}
						}
						$.getName('fileForm').resetForm();

						getAjaxUrl('/mass/massPreview.do?sheet=1');
					}else if(result == 'fail'){
						f.resetForm();
						var msg = '';
						switch(data.code){
							case "1" : msg = "업로드 파일은 100KB 이하만 등록가능합니다."; break;
							case "2" : msg = "파일 확장자와 파일형식이 같지 않습니다."; break;
						}
						alert(msg);
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			},
				error : function(){
					//alert('error');
			}
		});
	}
}
function massSheetChange(){
	getAjaxUrl('/mass/massPreview.do?sheet='+$.getName('massSheet').val());
}
function mmsChk(){
	var f = $.getName('mmsForm'),
		img = f.find('input'),
		error = false,
		cnt = 0;

	$.each(img,function(k,v){
		if($(v).val() != ''){
			cnt++;
		}
		if($(v).val() != '' && !extCheck('img',$(v).val())){
			error = true;
			$(v).val('');
		}
	});
	if(cnt == 0){
		alert('업로드할 파일을 선택하세요.');
	}else if(error){
		alert('파일 확장자를 확인하세요');
	}else{
		f.ajaxSubmit({
			success : function(res){
				try{
					var res = $.parseJSON(res),
						result = res.result,
						data = res.data;

					if(result == 'succ'){

						add_image(data.img1);
						f.resetForm();
						layerClose('mms_images_add');
						$.getName('msg').focus();
					}else if(result == 'fail'){
						f.resetForm();
						var msg = '';
						switch(data.code){
							case "1" : msg = "이미지 파일은 100KByte 이하만 등록가능합니다."; break;
							case "2" : msg = "파일 확장자와 파일형식이 같지 않습니다."; break;
						}
						alert(msg);
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			},
				error : function(){
					//alert('error');
			}
		});
	}
}

function add_image(v){
	var image_index = $('.img_box img.uploadImage').length+1,
		prefix = "/upload/temp/";
	$('.img_box').find('span').remove();
	$('.img_box').append("<div id='img_box_img_"+image_index+"' style='position:relative' onmouseover=\"$('#img_box_btn_"+image_index+"').show()\" onmouseout=\"$('#img_box_btn_"+image_index+"').hide()\"><img style='position:absolute;top:0px;right:0;width:39px;height:18px;display:none;cursor:pointer;' id='img_box_btn_"+image_index+"' onclick='remove_image(this)' src='/images/btns/gray_small_del.gif'><img class='uploadImage' src='/file/fileDownloadAction.do?filername="+v+"&filesname="+v+"&filepath=temp'></div>");
	$.getName('msgImg'+image_index).val(prefix+v);
}
function remove_image(obj){
	var image_index = $(obj).parent().index();
	$(obj).parent().remove();
	$.getName('msgImg'+image_index).val('');
	if($('.img_box img.uploadImage').length == 0){
		$('.img_box').html($('.img_box').data('html'));
	}
}

function mmsEditor(){
	if($('.img_box img.uploadImage').length >= 3){
		alert("이미지는 최대 3개까지만 첨부할 수 있습니다.");
		return false;
	}else{
		if(!authChk('mms')){
			alert('MMS 사용 권한이 없습니다.'); 
			return false; 
		}
		layerOpen('mms_images_add');
	}
}

function photoEditor(){
	if(navigator.appVersion.indexOf("Win") == -1){
		alert('편집기는 Windows OS 에서만 사용가능합니다.');
		layerOpen('mms_images_add');
	}else{
		if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
			if($('.img_box img.uploadImage').length >= 3){
				alert("이미지는 최대 3개까지만 첨부할 수 있습니다.");
				return false;
			}

			if(!authChk('mms')){
				alert('MMS 사용 권한이 없습니다.'); 
				return false; 
			}
		
			var img_limit = 3,
				img_cnt = $('.img_box img.uploadImage').length;

			var user_id = $.getName('image_editorForm').find('#user_id').val(),
				mode = $.getName('image_editorForm').find('#mode').val(),
				imgcnt = img_limit-Number(img_cnt);

			var url = "http://bizmsg.skbroadband.com/image_editer/sk_edit.application?user_id="+user_id+"&mode="+mode+"&imgcnt="+imgcnt;
			location.href = url;
		}else{
			alert('편집기는 Internet Explorer 에서만 사용가능합니다.');
			layerOpen('mms_images_add');
		}
	}
}


// 문자저장//
function mymsgOpenLayer(){
	layerOpen('mymsgLayer');
}

function mymsgSearch(){
	var stype = $.getName('mymsgSearchType').val(),
		keyword = $.getName('mymsgSearchKeyword').val();

/*
	if(!keyword){
		alert('검색어를 입력하세요');
		$.getName('mymsgSearchKeyword').focus();
	}else{
		getAjaxUrl('/send/mymsg.do?stype='+stype+'&keyword='+encodeURIComponent(keyword));
	}
*/
	getAjaxUrl('/send/mymsg.do?stype='+stype+'&keyword='+encodeURIComponent(keyword));
}
function mymsgDelete(param){
	var proc=false;
	if(param == 'all'){
		if(confirm('내 문자 보관함에 저장된 모든 문자를 삭제합니다.')){
			if(confirm('내 문자 보관함에 저장된 모든 문자를 삭제하시면 복구가 불가능합니다. 진행하시겠습니까?')){
				proc = true;
			}
		}
	}else{
		if($.getName('mymsgIdxChk').filter(':checked').length == 0){
			alert('선택한 문자가 없습니다.');
		}else{
			if(confirm('선택한 문자를 삭제합니다.')){
				proc = true;
			}
		}
	}
	
	if(proc){
		if(param == 'all'){
			$.getName('mymsgMode').val('deleteAll');
			$.getName('mymsgIdx').val('');
		}else{
			$.getName('mymsgMode').val('delete');
			$.getName('mymsgIdx').val('');
			var key = [];
			$.getName('mymsgIdxChk').each(function(k,v){
				if($(v).is(':checked')){
					key.push($(v).val());
				}
			});
			$.getName('mymsgIdx').val(key.join(","));
		}
		mymsgSubmit();
	}
}
function mymsgOpen(mode,value,title,idx){
	if(mode == 'insert'){
		value = $.getName('msg').val();
		title = byteSubstring($.getName('msgTitle').val(),0,60);
		$.getName('mymsgMode').val(mode);
		$.getName('mymsgValue').val(value);
		$.getName('mymsgIdx').val(idx);
		$.getName('mymsgTitle').val(title);
		mymsgSubmit();
		if($.getName('msg2').val() != ''){
			value = $.getName('msg2').val();
			$.getName('mymsgMode').val('insert2');
			$.getName('mymsgValue').val(value);
			mymsgSubmit();
		}


	}else{
		layerClose('my_message');
		$.getName('mymsgMode').val(mode);
		$.getName('mymsgValue').val(value);
		$.getName('mymsgIdx').val(idx);
		$.getName('mymsgTitle').val(title);
		layerOpen('my_message');
	}
	mymsgByteChk()
}
function mymsgSubmit(){
	var f = $.getName('mymsgForm'),
		action = "",
		msg = "",
		error = false;

	if($.getName('mymsgMode').val() == 'insert' || $.getName('mymsgMode').val() == 'update'){
		if(!$.getName('mymsgTitle').val() || $.getName('mymsgTitle').val() == $.getName('mymsgTitle').attr('placeholder')){
			$.getName('mymsgTitle').val('제목 없음');
		}
		if(!$.getName('mymsgValue').val()){
			alert('내용을 입력하세요');
			$.getName('mymsgValue').focus();
			error = true;
			return;
		}
	}

	if(!error){
		switch($.getName('mymsgMode').val()){
			case 'insert' : action = '/send/mymsgInsAction.do'; msg="저장하였습니다."; break;
			case 'insert2' : action = '/send/mymsgInsAction.do'; msg=""; $.getName('mymsgMode').val('insert');break;
			case 'update' : action = '/send/mymsgUpdAction.do'; msg="수정하였습니다."; break;
			case 'delete' : action = '/send/mymsgDelAction.do'; msg="선택한 문자를 삭제하였습니다."; break;
			case 'deleteAll' : action = '/send/mymsgDelAction.do'; msg="내 문자 보관함에 저장된 모든 문자를 삭제하였습니다."; break;
		}
		$.post(action,f.serialize())
			.done(function(res){
				try{
					var res = $.parseJSON(res),
						result = res.result,
						data = res.data;
					if(result == "succ"){
						if(msg){
							alert(msg);
						}
						layerClose('my_message');
						$.getName('mymsgMode').val('');
						$.getName('mymsgValue').val('');
						$.getName('mymsgIdx').val('');
						$.getName('mymsgTitle').val('');
						getAjaxUrl('/send/mymsg.do');
					}
				}catch(e){
					ajaxJsonException(e,res);
				}
			})
		return true;
	}
}
function mymsgModify(idx){
	var value = $('#'+idx).find('.mymsgValue').text(),
		title = $('#'+idx).data('title'),
		idx = $('#'+idx).getName('mymsgIdxChk').val();
	mymsgOpen('update',value,title,idx);
}

function mymsgSend(idx){
	$.getName(focusedMsg).val($('#'+idx).find('.mymsgValue').text()).focus();
	$.getName('msgTitle').val($('#'+idx).data('title'));
	byteCheck($.getName(focusedMsg)[0]);
}

function mymsgByteChk(){
	$('#mymsgByte').text(getStringByte($.getName('mymsgValue').val()));
}

// //문자저장
function reserveDateChk(){
	var timeMode = $("input[name='timeMode']:checked").val();
	if(timeMode == 'N'){
		return true;
	}else{
		var error = false;
		var chkDate = $.getName('reserve_ymd').val()+''+$.getName('reserve_h').val()+''+$.getName('reserve_m').val();

		if($.getName('reserve_ymd').val() == ''){
			alert('예약일을 선택하세요.');
			$.getName('reserve_ymd').datepicker('show');
			error = true;
			return false;
		}
		if(chkDate.replace(/[-]/g,'').substr(0,8) < getDate().substr(0,8)){
			alert('예약일은 이전날짜로 선택할수 없습니다.');
			error = true;
			return false;
		}
		//if(Number(chkDate.replace(/[-]/g,'').substr(0,12)) <= Number(getDate().substr(0,12))+10){
		if(date2time(chkDate.replace(/[-]/g,'')+'00') <= (Number(getTime())+(10*60))){
			alert('예약일은 현재시간 10분 이후 부터 선택가능합니다.');
			error = true;
			return false;
		}
		// 

		if(!error){
			return true;
		}
	}
}

function splitMode(checked){
	if(checked){
		$('.splitOption').prop('disabled',false).css('background-color','#fff');
	}else{
		$('.splitOption').prop('disabled',true).css('background-color','#ccc');
	}
}

function addressLoad(type){
	$('.layer_popup .address_tab li').removeClass('active');
	$('.layer_popup .address_tab li.'+type).addClass('active');
	getAjaxUrl('/address/group.do?type='+type);

	if(typeof $('#addressUserList').data('originalHTML') == 'undefined'){
		$('#addressUserList').data('originalHTML',$('#addressUserList').html());
	}
	$('#addressUserList').html($('#addressUserList').data('originalHTML'));
	$('#addressUserList').data('url','');
}
function addressRefresh(){
	var limit = $.getName('addressLimitCnt').val(),
		queryString = getUrlVars($('#addressUserList').data('url')),
		url = getURLfilename($('#addressUserList').data('url'));

	for(var k in queryString){
		if(queryString[k].name == "limit"){ queryString[k].value = limit;}
	}

	getAjaxUrl('/address/'+url+'?'+$.param(queryString));
}
function addressGroupChk(obj){
	var checked = obj.checked;
	if(checked){
		$('.'+$(obj).data('classname')).prop('checked',true);
	}else{
		$('.'+$(obj).data('classname')).prop('checked',false);
		$.getName('groupAll').prop('checked',false);
	}
}
function addressGroupChkAll(obj){
	var checked = obj.checked;
	if(checked){
		$.getName('groupIdx').prop('checked',true);
	}else{
		$.getName('groupIdx').prop('checked',false);
	}
}

function addressGroupChkOne(obj){
	var checked = obj.checked;
	if(!checked){
		$.getName('groupAll').prop('checked',false);
	}
}

function addressListChkAll(obj){
	var checked = obj.checked;
	if(checked){
		$.getName('userIdx').prop('checked',true);
	}else{
		$.getName('userIdx').prop('checked',false);
	}
}
function addressListChk(obj){
	var checked = obj.checked;
	if(checked){
		$('.'+$(obj).data('classname')).prop('checked',true);
	}else{
		$('.'+$(obj).data('classname')).prop('checked',false);
		$.getName('listAll').prop('checked',false);
	}
}

function addressSearch(){
	var limit = $.getName('addressLimitCnt').val(),
		str = $.getName('addressSearchStr').val(),
		type = ($(".address_tab li:first-child").hasClass('active'))?'user':'share';
	if(str == '' || str == $.getName('addressSearchStr').attr('placeholder')){
		alert('검색어를 입력하세요');
		return;
	}else{
		getAjaxUrl('/address/list.do?type='+type+'&str='+encodeURIComponent(str)+'&limit='+limit);
	}
}
function addressDetail(idx){
	var limit = $.getName('addressLimitCnt').val(),
		type = ($(".address_tab li:first-child").hasClass('active'))?'user':'share';

	$.getName('addressSearchStr').val('')
	
	getAjaxUrl('/address/list.do?type='+type+'&gid='+idx+'&limit='+limit);
}

/*  확정인원 가져오기 // */
function setReceiver(mode){
	var count = 0;
	
	if(mode == 'addr'){
		addReceiverAddress();
	}else if(mode == 'input'){
		addReceiverInput();
	}
	
	var action = "/send/numFilterAction.do";
	if(receiver_group.length || receiver_user.length || receiver_group_public.length || receiver_user_public.length){
		$.post(action,{'receiver_group':receiver_group.join(","),'receiver_user':receiver_user.join(","),'receiver_group_share':receiver_group_public.join(","),'receiver_user_share':receiver_user_public.join(",")})
			.done(function(res){
				try{
					var res = $.parseJSON(res),
						result = res.result,
						data = res.data;
					if(result == "succ"){
						var receive_object = {};
						$.each(receiver_input,function(k,v){
							receive_object[v] = v;
						});
						$.each(data.text,function(k,v){
							$.each(v,function(k1,v1){
								receive_object[k1] = v1;
							});
						});
						

						$.getName('groupIdx').prop('checked',false);
						$.getName('userIdx').prop('checked',false);

						setReceiveCount(receiver_input.length + data.count);
						setReceiveText(receive_object);
					}
					layerClose('address');
				}catch(e){
					ajaxJsonException(e,res);
				}
			})
	}else{
		var receive_object = {};
		$.each(receiver_input,function(k,v){
			receive_object[v] = v;
		});
		setReceiveCount(receiver_input.length);
		setReceiveText(receive_object);
		layerClose('address');
	}
}

function setRemainCount(num){
	remain_count = Number(num.replace(/,/g,''));
	if(remain_count == 999999999){
		num = '-';
	}
	$('#remainCount').text(number_format(num));

}
function setReceiveCount(num){
	receiver_count = num;
	if($.getName('msg2').val() != ''){
		receiver_count *= 2;
	}
	$(".receiveCountUnique").text(number_format(num));
	$(".receiveCount").text(number_format(receiver_count));
}
function setReceiveText(object){
	var target = $.getName('receiveFixed');
	target.empty();
	$.each(object,function(k,v){
		target.append($("<option></option>").attr("value",k).text(v));
	});
}
function addReceiverInput(){
	var receive = $.getName('receive').val().split("\n"),
		unique = [],
		msg = '',
		chk = false;

	$.each(receive,function(k,v){
		v = v.replace(/[-_\(\). ]/g, "");
		v = phoneValidate(v);
		v = $.trim(v);

		//if(!isNaN(v) && (v.substr(0,2) == '01' || v.substr(0,2) == '07') && v.length >= 10 & v.length <= 11){
		//if(!isNaN(v)){
		if(!isNaN(v) && v.length >= 8 && v.length <= 12){
			receiver_input.push(v);
			if($.trim(v) != ''){
				chk = true;
			}
		}else if(v.length != 0){
			msg = '전화번호가 정확하지 않거나\n입력된 값이 없어 전화번호가 추가되지 않았습니다';
		}
	});
	if(chk==false){ msg = '전화번호가 정확하지 않거나\n입력된 값이 없어 전화번호가 추가되지 않았습니다'; }

	//receiver_input.sort();
	$.each(receiver_input,function(k,v){
		if($.inArray(v, unique) === -1 && $.trim(v) != ''){
			unique.push(v);
		}
	});
	receiver_input = unique;
	if(receiver_input){
		$.getName('receive').val('');
	}
	if(msg){ alert(msg); }
}
function addReceiverAddress(){
	var type = ($(".address_tab li:first-child").hasClass('active'))?'user':'share';
	var group = [], user = [];
	$.getName('groupIdx').each(function(k,v){
		if($(v).is(':checked')){
			group.push($(v).val());
		}
	});
	$.getName('userIdx').each(function(k,v){
		if($(v).is(':checked')){
			user.push($(v).val());
		}
	});
	if(type == 'user'){
		receiver_group = receiver_group.concat(group);
		receiver_user = receiver_user.concat(user);
	}else{
		receiver_group_public = receiver_group_public.concat(group);
		receiver_user_public = receiver_user_public.concat(user);
	}
}
function removeReceive(flag){
	var target = $.getName('receiveFixed');

	receiver_group = [];
	receiver_group_public = [];
	receiver_user = [];
	receiver_user_public = [];
	receiver_input = [];

	if(flag){
		if(target.find('option').length <= 0){
			alert('삭제할 주소록이 없습니다');

		}else if(confirm('모든 받는사람 번호 또는 그룹을 삭제합니다.')){
			target.empty();
			setReceiveCount(0);
			alert('모든 받는사람 번호 또는 그룹을 삭제하였습니다.');
		}
	}else{
		// target 한번 돌리면서 receiver_다시 세팅
		if(target.find('option:selected').length == 0){
			alert('선택한 받는사람 번호 또는 그룹이 없습니다.');
		}else{
			if(confirm('선택한 받는사람 번호 또는 그룹을 삭제합니다.')){
				target.find('option:selected').remove();
				$.each(target.find('option'),function(k,v){
					if($(v).text().substr(0,5) == "[개별그룹"){ // group
						receiver_group.push($(v).val());
					}else if($(v).text().substr(0,5) == "[공유그룹") { // group_public
						receiver_group_public.push($(v).val());
					}else if($(v).text().substr(0,5) == "[공유번호") { // user_public
						receiver_user_public.push($(v).val());
					}else if($(v).text().substr(0,5) == "[개별번호") { // user
						receiver_user.push($(v).val());
					}else if($(v).text() != ''){
						receiver_input.push($(v).val());
					}
				});
				setReceiver();
				alert('선택한 받는사람 번호 또는 그룹을 삭제하였습니다.');
			}
		}
	}
}

function phoneValidate(v){
	if(!isNaN(v) && (v.substr(0,1) == '1' || v.substr(0,1) == '7') && v.length >= 9 & v.length <= 10){
		v = '0'+v;
	}
	return v;
}

function tipBalloon(obj,type){
	var offset = $(obj).offset();
	$('#tipBalloon').css({
		'top' : offset.top + 'px',
		'left' : (offset.left + 20) + 'px',
		'z-index' : 1000
	});
//	$('#tipBalloon').show();
	$('#tipBalloon').toggle();


	var target = $('#tipBalloon .content div'),
		text = '';

	switch(type){
		case 'a' :
			text = '주소록에 저장된 내용을 불러와서 수신자<br>별로 내용을 다르게 적용합니다.<br>'+limitByte+' Byte 를 초과할 경우 초과되는 부분은<br> 누락되고, '+limitByte+' Byte 까지만 전송처리됩니다.';
		break;
		case 'b' :
			text = '체크하면 메시지 내용이 '+limitByte+' Byte가 넘을 경우 자동으로 LMS로 전송되고, 체크하지 않으면 SMS 두 건으로 나뉘어서 전송됩니다.';
		break;
	}
	target.html(text);
}

function reserveSort(order){
	if(typeof $('#addressUserList').data('order') == 'undefined'){
		$('#addressUserList').data('order',order);
	}
	if(getURLParameterFromUrl('by',$('#addressUserList').data('url')) == null){
		$('#addressUserList').data('by','asc');
	}

	if($('#addressUserList').data('order') != order){
		$('#addressUserList').data('order',order);
		$('#addressUserList').data('by','desc');
	}

	if($('#addressUserList').data('by') == 'asc'){
		$('#addressUserList').data('by','desc');
	}else{
		$('#addressUserList').data('by','asc');
	}
	
	var url = updateQueryStringParameter($('#addressUserList').data('url'),'order',order),
		url = updateQueryStringParameter(url,'by',$('#addressUserList').data('by'));

	getAjaxUrl(url);
}

function recentCallback(mass){
	if(mass == true){
		$('.recentCallback').css({'width':'156px'});
	}
	$('.recentCallback li:nth-last-child(1)').css('border-bottom','0');
	$('.recentCallback').css({
		'position':'absolute',
		'top':($('#recent_callback_btn').prev('input').offset().top+21)+'px',
		'left':($('#recent_callback_btn').prev('input').offset().left)+'px'
	}).toggle();
}
function recentCallback_select(callback){
	$.getName('sender').val(callback);
	recentCallback();
}
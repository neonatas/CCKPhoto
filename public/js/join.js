$(function() {
	check_agreement();

	//약관 동의
	$('#joinAgreement').click( function() {
		if( $('#joinAgreement').hasClass('check') ) {
			$('#joinAgreement').removeClass('check');
		} else {
			$('#joinAgreement').addClass('check');
		}
		check_agreement();
	});

	//입력창 설명 관련
	$('#joinArea .input-area .msg').click( function() {
		$(this).hide();
		$(this).siblings('.text').focus();
	});
	$('#joinArea .input-area .text').focus( function() {
		$(this).siblings('.msg').hide();
	});
	$('#joinArea .input-area .text').blur( function() {
		if( $(this).val() == '' )
			$(this).siblings('.msg').show();
	})

	//가입 확인
	$('#joinArea .btn-join-ok').click( function() {
		$('#join_form').submit();
		return false;
	});
	$('#join_form').keypress( function(e) {
		if( e.keyCode == 13 ) {
			$('#join_form').submit();
			return false;
		}
	});

	//닉넴 수정시 중복확인 클리어
	$('#joinNickName').keyup(function() {
		$('input[name=checkDuplication]').val('');
		$('#joinNickName').siblings('.d-msg').hide();
	});

	//닉네임 중복 확인
	$('#btnCheckDuplication').click( function() {
		$.ajax({
			type : 'POST',
			url:'validNickName.php',
			dataType:'json',
			data:{
				nickname:document.join_form.joinNickName.value
			},
			success:function(data) {
				if( data.type == 1 ) {
					$('#joinNickName').removeClass('failed');
					$('#joinNickName').siblings('.d-msg').attr('src', '../images/text_duplication_ok.png').show();
					$('input[name=checkDuplication]').val('y');
				} else if ( data.type == 2 ) {
					$('#joinNickName').addClass('failed');
					$('#joinNickName').siblings('.d-msg').attr('src', '../images/text_duplication_no.png').show();
					$('input[name=checkDuplication]').val('');
				} else {
					$('#joinNickName').siblings('.d-msg').hide();
					$('input[name=checkDuplication]').val('');
				}
			},
			context:this
		});
		return false;
	});

	//폼 유효성 체크
	$('#join_form').validate({
		errorElement:'span',
		rules: {
			joinEmail: {
				required: true,
				email: true,
				remote : {
					type : 'POST',
					url  : 'validEmail.php'
				}
			},
			joinPasswd: {
			   required: true,
			   number: true,
			   minlength: 6
		   },
			joinPasswdConfirm: {
			   required: true,
			   number: true,
			   minlength: 6,
			   equalTo: '#joinPasswd'
		   },
			joinNickName: {
				required: true
			}
		},

		messages: {  
			joinEmail: {
				required: function(r,el) { return showValidError( el, '이메일 주소를 입력하세요.' ); },
				email: function(r,el){ return showValidError( el,'유효하지 않는 이메일 형식입니다.' ); },
				remote: function(r,el){ return showValidError( el, '입력하신 이메일 이미 등록되었습니다.' ); }
			},
			joinPasswd: {
				required: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				number: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				minlength: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); }
			},
			joinPasswdConfirm: {
				required: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				number: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				minlength: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				equalTo: function(r,el) { return showValidError( el, '비밀번호가 일치하지 않습니다, 다시 입력해주세요.' ); }
			},
			joinNickName: {
				required: function(r,el) { return showValidError( el, '이름이나 닉네임을 입력하세요.' ); }
			}
		},

		success:function(em) {
			showValidSuccess(em);
		},

		submitHandler: function (frm) {
			if ( frm.checkDuplication.value != "y" ) {
				alert("이름 & 닉네임 중복 확인을 해주세요.");
				return false;
			}
			if ( frm.policyAgree.value != "y" ) {
				alert("이용약관 및 개인정보 취급방침에 동의해주세요.");
				return false;
			}
			frm.submit();
		}
	});
	
	//가입취소
	$('#joinArea .btn-join-cancel').click( function() {
		history.go(-1);
		return false;
	});
});

function check_agreement() {
	var f = document.join_form;

	if( $('#joinAgreement').hasClass('check') ) {
		f.policyAgree.value = "y";
	} else {
		f.policyAgree.value = "";
	}
}


//go facebook
function joinFacebook(re_url) {
	var f = document.join_form;
	if ( f.policyAgree.value == "y" ) {
		location.href = '/member/oauth/facebook/redirect.php?re_url=' + re_url;
		return true;
	} else {
		alert("이용약관 및 개인정보 취급방침에 동의해주세요.");
		return false;
	}
}

//go twitter
function joinTwitter(re_url) {
	var f = document.join_form;
	if ( f.policyAgree.value == "y" ) {
		location.href = '/member/oauth/twitter/redirect.php?re_url=' + re_url;
		return true;
	} else {
		alert("이용약관 및 개인정보 취급방침에 동의해주세요.");
		return false;
	}
}

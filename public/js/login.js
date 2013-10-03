$(function() {
	//입력창 설명 관련
	$('#loginArea .input-area .msg').click( function() {
		$(this).hide();
		$(this).siblings('.text').focus();
	});
	$('#loginArea .input-area .text').focus( function() {
		$(this).siblings('.msg').hide();
	});
	$('#loginArea .input-area .text').blur( function() {
		if( $(this).val() == '' )
			$(this).siblings('.msg').show();
	})

	//로그인
	$('#loginArea .btn-login-ok').click( function() {
		$('#login_form').submit();
		return false;
	});
	$('#login_form').keypress( function(e) {
		if( e.keyCode == 13 ) {
			$('#login_form').submit();
			return false;
		}
	});

	//폼 유효성 체크
	$('#login_form').validate({
		errorElement:'span',
		rules: {
			loginEmail: {
				required: true,
				email: true,
				remote : {
					type : 'POST',
					url  : 'validEmail.php'
				}
			},
			loginPasswd: {
			   required: true,
			   number: true,
			   minlength: 6
		   }
		},

		messages: {  
			loginEmail: {
				required: function(r,el) { return showValidError( el, '이메일 주소를 입력하세요.' ); },
				email: function(r,el){ return showValidError( el,'유효하지 않는 이메일 형식입니다.' ); },
				remote: function(r,el){ return showValidError( el, '가입되지 않은 이메일 입니다.' ); }
			},
			loginPasswd: {
				required: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				number: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); },
				minlength: function(r,el) { return showValidError( el, '6자 이상의 숫자를 입력해주세요' ); }
			}
		},

		success:function(em) {
			showValidSuccess(em);
		},

		submitHandler: function (frm) {
			var l_email = $('#loginEmail').val();
			var l_passwd = $('#loginPasswd').val();

			$.ajax({
				url:'login_proc.php',
				type:'post',
				dataType:'json',
				data:{
					loginEmail: l_email,
					loginPasswd: l_passwd,
				},
				success:function(data) {
						console.log(data);
					if( data.r == 'success' ) {
						location.href = frm.re_url.value;
					} else {
						if( data.type == 'email' ) {
							$('#loginEmail').siblings('.error').show().text(data.msg);
						} else if( data.type == 'passwd' ) {
							$('#loginPasswd').siblings('.error').show().text(data.msg);
						}
					}
				},
				error:function(e) {
					console.log(e);
				}
			});
		}
	});
	
	//로그인 취소
	$('#loginArea .btn-login-cancel').click( function() {
		history.go(-1);
		return false;
	});
});

//go facebook
function joinFacebook(re_url) {
	location.href = '/member/oauth/facebook/redirect.php?re_url=' + re_url;
	return false;
}

//go twitter
function joinTwitter(re_url) {
	location.href = '/member/oauth/twitter/redirect.php?re_url=' + re_url;
	return false;
}

//form validate
function showValidError( obj, msg ) {
	$(obj).addClass('failed');

	return msg;
}

function showValidSuccess(obj){
	setTimeout(function(){	$(obj).hide();}, 0);
	
	$(obj).siblings('.text').removeClass('failed');
	return false;
}	
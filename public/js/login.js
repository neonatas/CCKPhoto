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
				url:'/member/login_proc.php',
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
				error:function(request,status,error) {
					console.log(request.code);
					console.log(request.responseText);
					console.log(status);
					console.log(error);
				}
			});
		}
	});
	
	//로그인 취소
	$('#loginArea .btn-login-cancel').click( function() {
		history.go(-1);
		return false;
	});

	//비밀번호 찾기
	$('#find_passwd_form .btn-send').click( function() {
		var $objEmail = $('#passwdEmail');
		var l_email = $objEmail.val();

		if( l_email == "" ) {
			alert("가입시 입력한 이메일을 입력하세요.");
			$objEmail.focus();
		} else {
			$.ajax({
				url:'/ajax/find.passwd.php',
				type:'post',
				dataType:'json',
				data:{ email: l_email },
				success:function(data) {
					alert(data.msg);
					if( data.r == "success" ) {
						$.dialog.close(); 
					} else {
						$objEmail.val('');
					}
				}
			});
		}
		return false;
	});
});

var PARAM = (function() {
	var p = document.location.search.substr(1).split('&');
	var result = {};
	for (var i = 0; i < p.length; i++) {
		var kv = p[i].split('=');
		result[kv[0]] = kv[1];
	}
	return result;
})();

var start = 0;
var count = 20;
var loading = false;
var load = function(start, count) {
	loading = true;

	$('.no-result').hide();
	$('.more').hide();
	$.getJSON('/ajax/photo.list.php?m_idx=' + midx, function(data) {
		if (start == 0 && data.length == 0) {
			$('.no-result').show();
			return;	
		}
		if (data.length == count) {
			$('.more').show();
		}
		var $ul = $('<ul/>');
		for (var i = 0; i < data.length; i++) {
			var img = data[i];

			var html = '<a href="/detail.php?pid=' + img.id + '&' + document.location.search.substr(1) + '">\
				<span class="title"><em>' + img.title + '</em></span>\
			<img src="' + img.image + '" width="232" height="' + Math.floor(232*img.height/img.width) + '"/>\
			</a>';

			if (owner) {
				html += '<a class="delete" data-pid="' + img.id + '" href="">\
					삭제하기\
					</a>';
			} else {
				html += '<a data-pid="' + img.id + '" class="btn-recommend recommend ' + (img.is_recommend == 'n' ? '' : 'on') + '" href="">\
					추천하기\
					</a>';
			}

			$('<li/>').html(html).appendTo($ul);
		}
		$ul.appendTo($('.item-wrapper'));
		var tops = [15, 15, 15, 15];
		var lefts = [138, 384, 631, 879];

		var setPosition = function (idx, li) {
			var $li = $(li);
			var col = tops.indexOf(Math.min.apply(null, tops));

			$li.css({position: 'absolute', top: tops[col] + 'px', left: lefts[col] + 'px'})
			setTimeout(function() {
				$li.animate({opacity:1},1000);
			}, 1000 * Math.random());
			$li.width($li.width()).height($li.height());
			tops[col] += $li.height() + 15;
		}

		$('.photo-list li').each(setPosition);
		$('.photo-list .item-wrapper').css('height', Math.max.apply(null, tops) + 'px');
		loading = false;
	});
}

$(function() {
	load(start, count);
	$('.more').click(function(e) {
		e.preventDefault();
		if (!loading) false;
		start += count;
		load(start, count);
	});
});

$(document).on('mouseenter', '.photo-list li', function() {
	var $this = $(this);
	var $img = $this.find('img');
	$img.css({
		width:$this.width() * 1.2,
		height:$this.height() * 1.2,
	   	left: $this.width() * -0.1,
		top: $this.height() * -0.1
	});
}).on('mouseleave', '.photo-list li', function() {
	var $this = $(this);
	var $img = $this.find('img');
	$img.css({
		width:$this.width(),
		height:$this.height(),
		left: 0,
		top: 0
	});
});

var curPid = '';

$('.photo-list').on('click', '.delete', function() {
	$.dialog.open('popupDelete');
	curPid = $(this).data('pid');
	return false;
})
$('#popupDelete .btn-delete').click(function() {
	location.href="/my/photo_delete.php?pid="+curPid;
});


$(function() {
	check_leave();

	//약관 동의
	$('#leaveAgreement').click( function() {
		if( $('#leaveAgreement').hasClass('check') ) {
			$('#leaveAgreement').removeClass('check');
		} else {
			$('#leaveAgreement').addClass('check');
		}
		check_leave();
	});


	var f = document.my_form;

	//닉넴 수정시 중복확인 클리어
	$('input[name=nickName]').keyup(function() {
		$('input[name=checkDuplication]').val('');
		$('fieldset.nick').removeClass('ok');
		$('fieldset.nick').removeClass('err');
	});

	//닉네임 중복 확인
	$('#popupProfileUpdate .btn-check-nick').click( function() {
		if( $('input[name=nickName]').val() == "" ) {
			alert('변경하실 닉네임을 입력하세요.');
			f.nickName.focus();
			return false;
		}

		$.ajax({
			type : 'POST',
			url:'/member/validNickName.php',
			dataType:'json',
			data:{
				nickname:f.nickName.value
			},
			success:function(data) {
				if( data.type == 1 ) {
					$('fieldset.nick').removeClass('err');
					$('fieldset.nick').addClass('ok');
					$('input[name=checkDuplication]').val('y');
				} else if ( data.type == 2 ) {
					$('fieldset.nick').removeClass('ok');
					$('fieldset.nick').addClass('err');
					$('input[name=checkDuplication]').val('');
				} else {
					$('input[name=checkDuplication]').val('');
				}
			},
			context:this
		});
		return false;
	});

	$('#popupProfileUpdate .btn-ok').click(function() {
		if( f.nickName.value != "" && f.checkDuplication.value != 'y' ) {
			alert('닉네임 중복확인을 해주세요.');
			f.nickName.focus();
			return false;
		}
		
		if( f.nickName.value == "" && f.myImg.value == "" ) {
			return false;
		}

		f.action = "/member/modify_proc.php";
		f.submit();
	});

	//비밀번호 변경 및 탈퇴
	var f_passwd = document.my_passwd_form;
	f_passwd.action = "/member/modify_proc.php";

	$('#my_passwd_form .btn-ok').click( function() {

		if( f_passwd.type.value == "leave" ) {
			f_passwd.submit();
		} else {
			$('#my_passwd_form').submit();
		}

		return false;
	});
	$('#my_passwd_form').keypress( function(e) {
		if( e.keyCode == 13 ) {
			if( f_passwd.type.value == "leave" ) {
				f_passwd.submit();
			} else {
				$('#my_passwd_form').submit();
			}

			return false;
		}
	});


	$('#my_passwd_form').validate({
		errorElement:'span',
		rules: {
			passwd: {
			   required: true,
			   minlength: 6
		   },
			passwdConfirm: {
			   required: true,
			   minlength: 6,
			   equalTo: '#newPasswd'
		   }
		},

		messages: {  
			passwd: {
				required: function(r,el) { return showValidError( el, '6자 이상을 입력해주세요' ); },
				minlength: function(r,el) { return showValidError( el, '6자 이상을 입력해주세요' ); }
			},
			passwdConfirm: {
				required: function(r,el) { return showValidError( el, '6자 이상을 입력해주세요' ); },
				minlength: function(r,el) { return showValidError( el, '6자 이상을 입력해주세요' ); },
				equalTo: function(r,el) { return showValidError( el, '비밀번호가 일치하지 않습니다, 다시 입력해주세요.' ); }
			}
		},
		success:function(em) {
		},
		submitHandler: function (frm) {
			frm.submit();
		}
	});
});


//type 도 여기서 정의
function check_leave() {
	var my_f = document.my_passwd_form;

	if( $('#leaveAgreement').hasClass('check') ) {
		my_f.type.value = "leave";
		my_f.leave.value = "y";
	} else {
		my_f.type.value = "passwd";
		my_f.leave.value = "";
	}
}
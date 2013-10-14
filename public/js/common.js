if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function (elt /*, from*/) {
		var len = this.length >>> 0;
		var from = Number(arguments[1]) || 0;
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);
		if (from < 0) from += len;

		for (; from < len; from++) {
			if (from in this && this[from] === elt) return from;
		}
		return -1;
	};
}

$.dialog = {
	open: function(id, f) {
		$('#popupContainer').show().find('>.popup').hide();
		var $popup = $('#' + id);
		$popup.show().css({'top': $(window).height()/2 - $popup.height()/2,'left':$(window).width()/2 - $popup.width()/2});
		f && f();
	},
	close: function(f) {
		$('#popupContainer').hide();
		f && f();
	}
}

$(document).on('click', '.btn-recommend', function(e) {
	e.preventDefault();
	//console.log(1);
	$.ajax({
		type : 'POST',
		url:'/ajax/increment.recommend.php',
		dataType:'json',
		data:{
			pid:$(this).data('pid')
		},
		success:function(data) {
			var $this = $(this);;
			if( data.type == 1 ) {
				$this.addClass('on');
				var $msg = $this.next('.msg-recommended');
				$(this).closest('ul').find('.pop').hide();
				$msg.fadeIn('slow', function() {
					setTimeout(function() {
						$msg.fadeOut('slow');
					},1000);
				});
			} else if ( data.type == 2 ) {
				alert(data.msg);
				//$this.removeClass('on');
			} else if (data.type == -1) {
				if (confirm('로그인 후에 추천할 수 있습니다. 로그인 페이지로 이동하시겠습니까?')) {
					document.location.href = '/member/login.php?re_url=' + document.location.href;
				}
			}
			$('.counts .recommended').text(data.count);
		},
		context:this
	});
});


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
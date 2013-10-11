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
			//alert(data.msg);
			var $this = $(this);;
			if( data.type == 1 ) {
				$this.addClass('on');
				var $msg = $this.next('.msg-recommended');
				$msg.fadeIn('slow', function() {
					setTimeout(function() {
						$msg.fadeOut('slow');
					},1000);
				});
			} else if ( data.type == 2 ) {
				$this.removeClass('on');
			} else {
			}
			$('.counts .recommended').text(data.count);
		},
		context:this
	});
});
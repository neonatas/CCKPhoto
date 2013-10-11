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
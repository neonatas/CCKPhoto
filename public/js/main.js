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
var count = 50;
var loading = false;
var loadData = null;
var seed = Math.random() * 1000;
seed = parseInt(seed);

var load = function(start, count, seed) {
	loading = true;
	var cate = PARAM['cate'] || '';
	var sort = PARAM['sort'] || 'd';
	var keyword = PARAM['keyword'] || '';

	$('.order input[value="' + sort + '"]').next('label').addClass('on');
	$('.order input').click(function() {
		setTimeout(function() {
			document.filter.submit();
		},0);
	});
	$('.no-result').hide();
	$('.more').hide();
	$.getJSON('/ajax/photo.list.php?start=' + start + '&count='+ count +'&cate=' + cate + '&sort=' + sort + '&keyword=' + keyword + '&seed=' + seed, function(data) {
		loadData = data;
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

			$('<li/>').html('<a href="detail.php?pid=' + img.id + '&' + document.location.search.substr(1) + '">\
				<span class="title"><em>' + img.title + '</em></span>\
			<img src="' + img.image + '" width="232" height="' + Math.floor(232*img.height/img.width) + '"/>\
			</a>\
			<a data-pid="' + img.id + '" class="btn-recommend recommend ' + (img.is_recommend == 'n' ? '' : (img.is_recommend == 'y' ? 'on' : 'hide')) + '" href="">\
			추천하기\
			</a>').appendTo($ul);
		}
		$ul.appendTo($('.item-wrapper'));
		var tops = [11, 11, 11, 11, 11];
		var lefts = [15, 263, 509, 756, 1002];

		var setPosition = function (idx, li) {
			var $li = $(li);
			var col = tops.indexOf(Math.min.apply(null, tops));

			$li.css({position: 'absolute', top: tops[col] + 'px', left: lefts[col] + 'px'})
			setTimeout(function() {
				$li.animate({opacity:1},2000);
			}, 200 * idx);
			$li.width($li.width()).height($li.height());
			tops[col] += $li.height() + 15;
		}

		$('.photo-list li').each(setPosition);
		$('.photo-list .item-wrapper').css('height', Math.max.apply(null, tops) + 'px');
		loading = false;
	});
}

$(function() {
	load(start, count, seed);

	$('.more').click(function(e) {
		e.preventDefault();
		if (!loading) false;
		start += count;
		load(start, count, seed);
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

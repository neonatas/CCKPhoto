$(function() {
	$.get('/ajax/photo.list.php', function(data) {
		var $ul = $('<ul/>');
		for (var i = 0; i < data.length; i++) {
			var img = data[i];

			var $li = $('<li/>').html('<a href="">\
				<span class="title"><em>' + img.title + '</em></span>\
			<img src="' + img.image + '" width="232" height="' + Math.floor(232*img.height/img.width) + '"/>\
			</a>\
			<a class="recommend ' + (img.is_recommend == 'N' ? '' : 'on') + '" href="">\
			추천하기\
			</a>');

			$li.appendTo($ul);

		}
		$ul.insertBefore($('.photo-list .more'));
		var tops = [11, 11, 11, 205, 205];
		var lefts = [15, 263, 509, 756, 1002];//[15, 233+15+15, (232+15)*2+15, (232+15)*3+15, (232+15)*4+15];

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

	});

})

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
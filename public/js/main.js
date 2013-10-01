$(function() {
	var tops = [11, 11, 11, 205, 205];
	var lefts = [15, 263, 509, 756, 1003];//[15, 233+15+15, (232+15)*2+15, (232+15)*3+15, (232+15)*4+15];
	var setPosition = function (idx, li) {
		var $li = $(li);
		var col = tops.indexOf(Math.min.apply(null, tops));

		$li.css({position: 'absolute', top: tops[col] + 'px', left: lefts[col] + 'px'})
		setTimeout(function() {
			$li.animate({opacity:1},1000);
		}, 1000 * Math.random());
		tops[col] += $li.outerHeight() + 15;
	}
	$('.photo-list li').each(setPosition);
	$('.photo-list ul').css('height', Math.max.apply(null, tops) - 50 + 'px');
})
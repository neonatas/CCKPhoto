$(function() {
	var tops = [15, 15, 15, 15];
	var lefts = [138, 384, 631, 879];
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

$('.photo-list').on('click', '.delete', function() {
	$.dialog.open('popupDelete')
	return false;
})
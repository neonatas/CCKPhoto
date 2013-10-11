(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1&appId=1403130929918022";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$( function() {
	$('.btn-info').click(function(){
		$(this).siblings('.photo-info').toggle();
		return false;
	});

	$('.photo-info .btn-close').click(function(){
		$('.photo-info').hide();
		return false;
	});
});

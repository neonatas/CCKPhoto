$(function() {
	$('.btn-detail').click(function() {
		$(this).closest('table').find('tr').removeClass('on').closest('table').find('tr.detail').hide();
		$(this).closest('tr').addClass('on').next('tr').show();
		return false;
	})
})
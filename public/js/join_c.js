$(function() {
	check_agreement();

	//약관 동의
	$('#joinAgreement').click( function() {
		if( $('#joinAgreement').hasClass('check') ) {
			$('#joinAgreement').removeClass('check');
		} else {
			$('#joinAgreement').addClass('check');
		}
		check_agreement();
	});

	var f = document.join_confirm_form;

	$('#join_confirm_form .btn-cancel').click( function() {
		location.href = "logout.php";
		return false;
	});
	
	$('#join_confirm_form .btn-ok').click( function() {
		if ( f.policyAgree.value != "y" ) {
			alert("이용약관 및 개인정보 취급방침에 동의해주세요.");
			return false;
		}
		
		f.action = "join_confirm_proc.php";
		f.submit();
		return false;
	});
});


function check_agreement() {
	var f = document.join_confirm_form;

	if( $('#joinAgreement').hasClass('check') ) {
		f.policyAgree.value = "y";
	} else {
		f.policyAgree.value = "";
	}
}

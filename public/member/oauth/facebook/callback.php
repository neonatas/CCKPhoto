<?php

session_start();

require_once('../../../../_lib/oauth/facebook-php-sdk/src/facebook.php');
require_once('../../../../_lib/config.php');

require_once('../../../../_lib/class.dbConnect.php');
require_once('../../../../_lib/class.members.php');
require_once('../../../../_lib/function.php');

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
	'appId'  => FACEBOOK_APPID,
	'secret' => FACEBOOK_SECRET,
));

$return_url = ($_SESSION['return_url']!="")?$_SESSION['return_url']:"/index.php";

$user = $facebook->getUser();

if ( $user ) {
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}

	$DB = new dbConn();
	$Member = new clsMembers( $DB->getConnection() );

	$oauth_type = "facebook";

	//세션 저장
	$result = $Member->getOauthMemberIdx( $oauth_type, $user, $user_profile['name'], "https://graph.facebook.com/".$user."/picture" );

	if( $result['r'] == 'success' )
	{
		$_SESSION['USER_IDX'] = $result['idx'];
		$_SESSION['USER_TYPE'] = $oauth_type;
		$_SESSION['USER_ID'] = $user;
		$_SESSION['USER_NAME'] = $user_profile['name'];
        $_SESSION['USER_IMAGE'] = $result['my_img'];
        $_SESSION['USER_AGREE'] = $result['policy_agree'];
    } else {
		header('Location: ./clearsessions.php');
	}


    //회원가입에 동의 하지 않았다면 동의 페이지로 이동한다.
    checkAgreementLocation($_SESSION['USER_AGREE'], $return_url);

} else {
	/* Save HTTP status for error dialog on connnect page.*/
	header('Location: ./clearsessions.php');
}
?>
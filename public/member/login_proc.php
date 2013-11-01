<?php
session_start();

$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
if ( $re_url == "" ) $re_url = "/";

$_SESSION['return_url'] = $re_url;

require_once('../../_lib/config.php');
require_once('../../_lib/class.dbConnect.php');
require_once('../../_lib/class.members.php');
require_once('../../_lib/function.php');


$DB = new dbConn();
$Member = new clsMembers( $DB->getConnection() );

$c_idx = trim($_POST['c_idx']);
$keyword = trim($_POST['keyword']);

if( trim($_POST['loginEmail']) == "" || trim($_POST['loginPasswd']) == "" ) {
    $result['r'] == 'error';

    historyBackNoMsg();
    return;
}

$arr = array(
	"email"=>trim($_POST['loginEmail']), 
	"passwd"=>trim($_POST['loginPasswd'])
);

$result = $Member->loginMember( $arr );

if( $result['r'] == 'success' )
{
	$result['f_idx'] = "";

	$_SESSION['USER_IDX'] = $result['idx'];
	$_SESSION['USER_TYPE'] = SITE_NAME;
	$_SESSION['USER_ID'] = $_POST['loginEmail'];
	$_SESSION['USER_NAME'] = $result['nickname'];
    $_SESSION['USER_IMAGE'] = $result['my_img'];
	$_SESSION['USER_AGREE'] = $result['policy_agree'];
    $_SESSION['USER_LEVEL'] = $result['level'];

	if( $_POST['autoLogin'] == 'y' )
	{
		$key = md5( time().rand(10000,99999) );
		
		if( $Member->saveAutoKey($result['idx'],$key) ) {
			setcookie("userinfo", $key , time()+60*60*24*30, "/",".mistyhand.com");
		}
	}
}

echo json_encode($result);
?>
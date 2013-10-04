<?php

session_start();

$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
if ( $re_url == "" ) $re_url = "/";

require_once('../../_lib/class.dbConnect.php');
require_once('../../_lib/class.members.php');


$DB = new dbConn();
$Member = new clsMembers( $DB->getConnection() );

$joinEmail = ( trim($_POST['joinEmail']) ) ? trim($_POST['joinEmail']) : "";
$joinPasswd = ( trim($_POST['joinPasswd']) ) ? trim($_POST['joinPasswd']) : "";
$joinPasswdConfirm = ( trim($_POST['joinPasswdConfirm']) ) ? trim($_POST['joinPasswdConfirm']) : "";
$joinNickName = ( trim($_POST['joinNickName']) ) ? trim($_POST['joinNickName']) : "";
$checkDuplication = ( trim($_POST['checkDuplication']) ) ? trim($_POST['checkDuplication']) : "";
$policyAgree = ( trim($_POST['policyAgree']) ) ? trim($_POST['policyAgree']) : "";

$policy_agree = ( $_POST['policyAgree'] == 'y' )?$_POST['policyAgree']:'n';

if( $joinEmail == "" || $joinPasswd == "" || $joinNickName == "" ) {
    $DB->historyBack("정보를 정확히 입력하세요.");
    return;
}
if( $checkDuplication != "y" ) {
    $DB->historyBack("이름 & 닉네임 중복확인을 하세요.");
    return;
}
if( $policyAgree != "y" ) {
    $DB->historyBack("약관 동의를 하셔야 합니다.");
    return;
}
if( $joinPasswd != $joinPasswdConfirm ) {
    $DB->historyBack("비밀번호 확인이 일치하지 않습니다.");
    return;
}

$arr = array(
	"email"=>$joinEmail, 
	"passwd"=>$joinPasswd, 
    "nickname"=>$joinNickName,
	"policy_agree"=>$policyAgree
);
$result = $Member->joinMember( $arr );

if( $result['r'] == 'success' )
{
	$_SESSION['USER_IDX'] = $result['idx'];
	$_SESSION['USER_TYPE'] = "letscc_photo";
	$_SESSION['USER_ID'] = $joinEmail;
	$_SESSION['USER_NAME'] = $joinNickName;
    $_SESSION['USER_IMAGE'] = "";
    $_SESSION['USER_AGREE'] = $policyAgree;
} else if( $result['r'] == 'error' ) {
    $DB->historyBack($result['msg']);
    return;
}

header('Location: '.$re_url);

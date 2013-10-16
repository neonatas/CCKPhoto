<?php

session_start();

require_once('../../_lib/class.dbConnect.php');
require_once('../../_lib/class.members.php');
require_once('../../_lib/function.php');


$DB = new dbConn();
$Member = new clsMembers( $DB->getConnection() );

$policy_agree = ( trim($_POST['policyAgree']) == 'y' )?trim($_POST['policyAgree']):'n';

if( trim($_SESSION['USER_IDX_TEMP']) == "" ) {
    header('Location: /');
    return;
}

$result = $Member->updatePolicyAgree( $_SESSION['USER_IDX_TEMP'], $policy_agree );

if( $result == 'y')
{
    $_SESSION['USER_IDX'] = $_SESSION['USER_IDX_TEMP'];
	$_SESSION['USER_AGREE'] = $result;
}

$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
if ( $re_url == "" ) $re_url = "/";

header('Location: '.$re_url);
?>
<?php

session_start();
$_SESSION['return_url'] = $_SERVER['HTTP_REFERER'];

require_once('../_lib/class.dbConnect.php');
require_once('../_lib/class.members.php');

$DB = new dbConn();
$Member = new clsMembers( $DB->getConnection() );

$nickname = trim($_POST['nickname'])?trim($_POST['nickname']):'';

$result = array("type"=>0, "msg"=>"이름을 입력하세요.", "nickname"=>$nickname);

if( $nickname != "" )
{
	if( $Member->existNickName( $nickname ) === false ) {
		$result['type'] = 1;
        $result['msg'] = "사용하실수 있습니다.";
    } else {
		$result['type'] = 2;
        $result['msg'] = "중복된 이름입니다.";
    }
}

echo json_encode($result);
?>
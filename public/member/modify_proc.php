<?php

session_start();

$re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
if ( $re_url == "" ) $re_url = "/";

require_once('../../_lib/config.php');
require_once('../../_lib/class.dbConnect.php');
require_once('../../_lib/class.members.php');
require_once('../../_lib/class.photos.php');


$DB = new dbConn();
$Member = new clsMembers( $DB->getConnection() );
$Photo = new clsPhotos( $DB->getConnection() );

$type = ( trim($_POST['type']) ) ? trim($_POST['type']) : "";

if( $_SESSION['USER_IDX'] == "" ) {
    $DB->historyBackNoMsg();
    return;
}

if( $type == "passwd" ) {
    
    $passwd = ( trim($_POST['passwd']) ) ? trim($_POST['passwd']) : "";
    $passwdConfirm = ( trim($_POST['passwdConfirm']) ) ? trim($_POST['passwdConfirm']) : "";

    if( $passwd =="" ) {
        $DB->historyBack("변경 할 비밀번호를 입력하세요");
        return;
    }

    if( $passwd != $passwdConfirm ) {
        $DB->historyBack("비밀번호 확인이 일치하지 않습니다.");
        return;
    }

    if( $Member->updatePasswd($_SESSION['USER_IDX'], $passwd) ) {
        header('Location: '.$re_url);
        return;
    } else {
        $DB->historyBack("비밀번호 변경에 실패 하였습니다.");
        return;
    }
    
} else if( $type == "leave" ) { //탈퇴
    $leave = ( trim($_POST['leave']) ) ? trim($_POST['leave']) : "";

    if( $leave == "y" ) {
        if( $Member->leaveMember($_SESSION['USER_IDX']) ) {
            header("Location: /member/logout.php");
            return;
        }
    }

    header('Location: '.$re_url);
    return;
} else {
    $nickName = ( trim($_POST['nickName']) ) ? trim($_POST['nickName']) : "";
    $checkDuplication = ( trim($_POST['checkDuplication']) ) ? trim($_POST['checkDuplication']) : "";
    $my_img_file = $_FILES['myImg'];

    if( $nickName == "" && !is_array($my_img_file) ) {
        $DB->historyBackNoMsg();
        return;
    }

    if( $nickName !="" && $checkDuplication != "y" ) {
        $DB->historyBack("이름 & 닉네임 중복확인을 하세요.");
        return;
    }
    //닉네임 수정
    if( $nickName != "" ) {
        if( $Member->updateNickName($_SESSION['USER_IDX'], $nickName) ) {
            $_SESSION['USER_NAME'] = $nickName;
        }
    }

    //파일 수정
    if( $my_img_file['tmp_name'] != "" ) {
        //파일 유효성 체크
        if( $my_img_file['error'] > 0 ) {
            $DB->historyBack( MSG_INPUT_DATA_FAILE );
        }
        //파일 용량 체크
        if( !$Photo->checkSize( $my_img_file['size'] ) )
        {
            $DB->historyBack(number_format(MAX_PHOTO_SIZE)." 이하의 사진파일만 업로드 가능합니다.");
        }

        $tmp = explode(".",$my_img_file['name']);
        $ext = $tmp[ count($tmp) - 1 ];
        //파일 확장자 체크
        if( !$Photo->checkExtension( $ext ) )
        {
            $DB->historyBack("확장자(".VALID_PHOTO_EXT.") 파일만 업로드 가능합니다.");
        }

        $upload_name = time().rand(100000,1000000).".".$ext;
        $uploadfile = PATH_PROFILE_IMAGE_UPLOAD.$upload_name;

        if( !move_uploaded_file($my_img_file['tmp_name'], $uploadfile) )
        {
            $DB->historyBack( MSG_PHOTO_UPLOAD_FAILE );
        }

        if( $Member->updateProfileImage($_SESSION['USER_IDX'], PATH_PROFILE_IMAGE.$upload_name, $my_img_file['name']) ) {
            $_SESSION['USER_IMAGE'] = PATH_PROFILE_IMAGE.$upload_name;
        }
    }

    header('Location: '.$re_url);
}

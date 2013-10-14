<?
    session_start();

    $pageCode = "gallery";
    
    $strCSS = "<link rel='stylesheet' media='all' type='text/css' href='/css/".$pageCode.".css' />";
    $strJS = "<script type='text/javascript' src='../js/jquery.validate.js'></script>";
    $strJS .= "<script type='text/javascript' src='/js/".$pageCode.".js'></script>";

    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once("../../_lib/class.members.php");

    $DB = new dbConn();
    $Member = new clsMembers( $DB->getConnection() );

    $member_idx = ( trim($_GET['m_idx']) ) ? trim($_GET['m_idx']) : "";

    if( $member_idx == "" && $_SESSION['USER_IDX'] == "" ) {
        header('Location: /member/login.php?re_url='.$_SERVER['REQUEST_URI']);
        exit;
    }

//    $member_idx = $_SESSION['USER_IDX'];
    $member_data = $Member->getData($member_idx);
    if( !$member_data ) {
        header('Location: /member/login.php?re_url='.$_SERVER['REQUEST_URI']);
        exit;
    }

    require_once "../_include/header.php";

    $profile_image = ( $member_data['my_img_r'] == "" ) ? "../images/profile_noimage.png":$member_data['my_img_r'];
?>

	<div id="content" class="<?=$pageCode?>">
		<div class="top">
			<div class="profile">
				<img src="<?=$profile_image?>" width="63" height="63" />
				<span class="title"><em class="name"><?=$member_data['nickname']?></em> <span>님의 갤러리</span></span>
                <? if( $_SESSION['USER_IDX'] == $member_data['idx'] ) { ?>
				<a class="btn-profile-update" href="" onclick="$.dialog.open('popupProfileUpdate'); return false;">내 프로필 수정</a>
                    <? if( $_SESSION['USER_TYPE'] == SITE_NAME ) { ?>
                    <a class="btn-password-change" href="" onclick="$.dialog.open('popupPasswordChange'); return false;">비밀번호 변경</a>
                    <? } ?>
			    <? } ?>
            </div>
		</div>
		<div class="no-result">
			결과가 없습니다.
		</div>
		<div class="photo-list">
			<div class="item-wrapper">
			</div>
			<a class="more" href="">더 불러오기</a>
			<hr />
		</div>
	</div>
<script type="text/javascript">
var midx = <?=$member_data['idx']?>;
var owner = false;
<? if( $_SESSION['USER_IDX'] == $member_data['idx'] ) { ?>
owner = true;
<? } ?>
</script>
<?
    require_once "../_include/footer.php";
?>
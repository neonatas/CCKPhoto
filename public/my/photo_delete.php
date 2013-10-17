<?
    session_start();

    $re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
    if ( $re_url == "" ) $re_url = "/my/gallery.php";

    $pid = ( trim($_GET["pid"]) ) ? trim($_GET["pid"]) : "";
// Require the phpFlickr API
    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once('../../_lib/class.photos.php');
    require_once('../../_lib/phpFlickr.php');
    require_once('../../_lib/function.php');

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );

    //로그인 체크
	if( !isset($_SESSION['USER_IDX']) || $_SESSION['USER_IDX'] == '' ) {  
		historyBack("로그인 후 삭제가 가능합니다.");
	}

	if( $pid == '' ) {  
		historyBack("잘못된 접근입니다.");
	}

    //DB 삭제
    $photo_data = $Photo->get($pid);

	if( $photo_data['member_idx'] != $_SESSION['USER_IDX'] ) {  
		historyBack("본인이 등록한 사진만 삭제 가능합니다.");
	}

    if( $flickr_id = $Photo->delete($pid) ) {
        //플리커 삭제
        $flickr = new phpFlickr(FLICKR_API_KEY,FLICKR_API_SECRET, true);
        $flickr->setToken(FLICKR_API_TOKEN);
        $flickr->photos_delete($flickr_id);
    }

     header("Location:/my/gallery.php?m_idx=".$_SESSION['USER_IDX']);
?>
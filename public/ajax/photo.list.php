<?
    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once("../../_lib/class.photos.php");

    session_start();

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );

    $start = ( trim($_GET['start']) ) ? trim($_GET['start']) : 0;
    $count = ( trim($_GET['count']) ) ? trim($_GET['count']) : 0;
    $keyword = ( trim($_GET['keyword']) ) ? trim($_GET['keyword']) : "";
    $cate = ( trim($_GET['cate']) ) ? trim($_GET['cate']) : "";
    $sort = ( trim($_GET['sort']) ) ? trim($_GET['sort']) : "d";
	$seed = ( trim($_GET['seed']) ) ? trim($_GET['seed']) : 0;
    $member_idx = ( trim($_GET['m_idx']) ) ? trim($_GET['m_idx']) : "";

	$arr_photos = $Photo->getList($member_idx, $sort, $cate, $start, $count, $keyword, $seed);
    
    /*
        sort  :   d => createdate
               :   h => hits
               :   r => recommend
    */

    $result = array();
    if( count($arr_photos) > 0 ) {
        foreach ($arr_photos as $p) {
            $is_recommend = ( $Photo->isRecommend($p['id'], $_SESSION['USER_IDX']) ) ? 'y':'n';
            if( $p['member_idx'] == $_SESSION['USER_IDX'] ) $is_recommend = 'o';

			$file_info = $Photo->getPhotoInfo(PATH_PHOTOS.$p['filename_r']);
            
            if( is_file(PATH_PHOTOS_UPLOAD."thumb/".$p['filename_r'] ) ) {
                $image_path = PATH_PHOTOS."thumb/".$p['filename_r'];
            } else {
                $image_path = PATH_PHOTOS.$p['filename_r'];
            }
            
            $result[] = array(
                'id' => $p['id'],
                'member_idx' => $p['member_idx'],
                'title' => $p['title'],
                'image' => $image_path,
                'hits' => $p['hits'],
                'recommend' => $p['recommend'],
                'width' => $file_info['COMPUTED']['Width'],
                'height' => $file_info['COMPUTED']['Height'],
                'is_recommend' => $is_recommend
            );
        }
    }

    echo json_encode($result);
?>

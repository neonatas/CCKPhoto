<?
    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once("../../_lib/class.photos.php");

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );

    $start = ( trim($_POST['start']) ) ? trim($_POST['start']) : 0;
    $count = ( trim($_POST['count']) ) ? trim($_POST['count']) : 0;
    $keyword = ( trim($_POST['keyword']) ) ? trim($_POST['keyword']) : "";
    $sort = ( trim($_POST['sort']) ) ? trim($_POST['sort']) : "d";
    $member_idx = ( trim($_POST['member_idx']) ) ? trim($_POST['member_idx']) : "";

    $arr_photos = $Photo->getList($member_idx, $sort, $start, $count, $keyword);

    /*
        sort  :   d => createdate
               :   h => hits
               :   r => recommend
    */

    $result = array();
    if( count($arr_photos) > 0 ) {
        foreach ($arr_photos as $p) {
            $result[] = array(
                'id' => $p['id'],
                'member_idx' => $p['member_idx'],
                'title' => $p['title'],
                'image' => PATH_PHOTOS_FOLDER.$p['filename_r'],
                'hits' => $p['hits'],
                'recommend' => $p['recommend']
            );
        }
    }

    echo json_encode($result);
?>

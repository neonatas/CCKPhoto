<?
    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once("../../_lib/class.photos.php");

    session_start();

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );

    $pid = ( trim($_POST['pid']) ) ? trim($_POST['pid']) : "";

    if( empty($_SESSION['USER_IDX']) ) {
        $result = array("type"=>-1, "msg"=>"로그인 후 이용하세요");
    } else if( $pid == "" ) {
        $result = array("type"=>-2, "msg"=>"식별자가 필요합니다.");
     } else {
         if( $Photo->isRecommend($pid, $_SESSION['USER_IDX']) ) {
            $result['type'] = 2;
            $re_recomm = $Photo->decrementRecommend($pid, $_SESSION['USER_IDX']);
         } else {
            $result['type'] = 1;
            $re_recomm = $Photo->incrementRecommend($pid, $_SESSION['USER_IDX']);
         }

        if( $re_recomm['r'] == "success" ) {
            $result['msg'] = $re_recomm['msg'];
            $result['count'] = $re_recomm['count'];
        } else {
            $result['type'] = -3;
            $result['msg'] = $re_recomm['msg'];
        }
     }

    echo json_encode($result);
?>

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
         //본인 추천 확인
         $photo_data = $Photo->get($pid);
         if( $photo_data['member_idx'] == $_SESSION['USER_IDX'] ) {
                $result['type'] = -3;
                $result['msg'] = "본인이 올린 사진은 추천할 수 없습니다.";
         } else if( $_SESSION['USER_AGREE'] != 'y' ) {
                $result['type'] = -4;
                $result['msg'] = "약관 동의를 하지않은 회원은 사진은 추천할 수 없습니다.";
         } else {    
             if( $Photo->isRecommend($pid, $_SESSION['USER_IDX']) ) {
                $result['type'] = 2;
                $result['msg'] = "이미 추천하셨습니다.";
                //$re_recomm = $Photo->decrementRecommend($pid, $_SESSION['USER_IDX']);
             } else {
                $result['type'] = 1;
                $re_recomm = $Photo->incrementRecommend($pid, $_SESSION['USER_IDX']);

                if( $re_recomm['r'] == "success" ) {
                    $result['msg'] = $re_recomm['msg'];
                    $result['count'] = $re_recomm['count'];
                } else {
                    $result['type'] = -3;
                    $result['msg'] = $re_recomm['msg'];
                }
             }
         }
     }

    echo json_encode($result);
?>

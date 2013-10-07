<?
    session_start();

    $re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
    if ( $re_url == "" ) $re_url = "/my/gallery.php";

    $_SESSION['return_url'] = $re_url;

    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once('../../_lib/class.photos.php');

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );


    // Require the phpFlickr API
    require_once('../../_lib/phpFlickr.php');

    // Create new phpFlickr object: new phpFlickr('[API Key]','[API Secret]')
    $flickr = new phpFlickr(FLICKR_API_KEY,FLICKR_API_SECRET, true);

    // Authenticate;  need the "IF" statement or an infinite redirect will occur
    if(empty($_GET['frob'])) {
        $flickr->auth('write'); // redirects if none; write access to upload a photo
    }
    else {
        // Get the FROB token, refresh the page;  without a refresh, there will be "Invalid FROB" error
        $flickr->auth_getToken($_GET['frob']);
    }

    //로그인 체크
	if( !isset($_SESSION['USER_IDX']) || $_SESSION['USER_IDX'] == '' ) {  
		$DB->historyBack("로그인 후 사진올리기 가능합니다.");
	}

    $title = ( trim($_POST['title']) ) ? trim($_POST['title']) : "";
    $description = ( trim($_POST['description']) ) ? trim($_POST['description']) : "";
    $cate = ( trim($_POST['cate']) ) ? trim($_POST['cate']) : "";
    $tags = ( trim($_POST['tags']) ) ? trim($_POST['tags']) : "";
    $ccl_business = ( trim($_POST['ccl_business']) ) ? trim($_POST['ccl_business']) : "";
    $ccl_change = ( trim($_POST['ccl_change']) ) ? trim($_POST['ccl_change']) : "";
    $photofile = $_FILES['photo'];


    //데이터 유효성 체크
	if( $title == '' || $cate == '' || $ccl_business == '' || $ccl_change == '' ) {  
		$DB->historyBack( MSG_INPUT_DATA_FAILE );
	}

    //파일 유효성 체크
    if( $photofile['error'] > 0 ) {
        $DB->historyBack( MSG_INPUT_DATA_FAILE );
    }

//실서버에는 올리지 않는걸로 변경
/*
    //파일 용량 체크
    if( !$Photo->checkSize( $photofile['size'] ) )
    {
        $DB->historyBack(number_format(MAX_PHOTO_SIZE)." 이하의 사진파일만 업로드 가능합니다.");
    }

    $tmp = explode(".",$photofile['name']);
    $ext = $tmp[1];
    //파일 확장자 체크
    if( !$Photo->checkExtension( $ext ) )
    {
        $DB->historyBack("확장자(".VALID_PHOTO_EXT.") 파일만 업로드 가능합니다.");
    }

    $upload_name = time().rand(100000,1000000).".".$ext;
    $uploadfile = PATH_PHOTOS_UPLOAD.$upload_name;
    
    if( !move_uploaded_file($photofile['tmp_name'], $uploadfile) )
    {
        $DB->historyBack( MSG_PHOTO_UPLOAD_FAILE );
    }
*/
    //CCL 체크
    if( $ccl_busines == 1 ) {
        switch( $ccl_change ) {
            case 1:
                $ccl = FLICKR_BY;
                break;
            case 2:
                $ccl = FLICKR_BY_ND;
                break;
            case 3:
                $ccl = FLICKR_BY_SA;
                break;
        }
    } else if ( $ccl_busines == 2 ) {
        switch( $ccl_change ) {
            case 1:
                $ccl = FLICKR_BY_NC;
                break;
            case 2:
                $ccl = FLICKR_BY_NC_ND;
                break;
            case 3:
                $ccl = FLICKR_BY_NC_SA;
                break;
        }
    } else {
        $ccl = FLICKR_BY;
    }

    //flickr 업로드
    $photo_id = $flickr->sync_upload($photofile['tmp_name'], $title, $description,$tags);

    if( empty($photo_id) ) {
        $DB->historyBack( MSG_INPUT_DATA_FAILE );
    } else {
        //fiickr 라이센스 변경
        if( $flickr->photos_licenses_setLicense($photo_id, $ccl) ) {
            //DB저장
            $arr = array(
                "member_id"=>$_SESSION['USER_IDX'], 
                "cate_id"=>$cate, 
                "title"=>$title,
                "description"=>$description,
                "tags"=>$tags,
                "ccl"=>$ccl,
                "filename_o"=>'',
                "filename_r"=>'',
                //"filename_o"=>$photofile['name'],
                //"filename_r"=>$upload_name,
                "info"=>$photoinfo,
                "photo_id"=>$photo_id
            );
            $result = $Photo->save( $arr );

            if( $result['r'] == 'success' )
            {
                header('Location: '.$re_url);
            } else if( $result['r'] == 'error' ) {
                //$flickr->photos_delete($photo_id);
                $DB->historyBack($result['msg']);
                return;
            }
        } else {
            //$flickr->photos_delete($photo_id);
            $DB->historyBack(MSG_PHOTO_UPLOAD_FAILE);
        }
    }
?>

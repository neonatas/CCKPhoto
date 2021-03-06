<?
    session_start();

    $re_url = ( trim($_POST["re_url"]) ) ? trim($_POST["re_url"]) : trim($_GET["re_url"]);
    if ( $re_url == "" ) $re_url = "/my/gallery.php";

    $_SESSION['return_url'] = $re_url;

    require_once('../../_lib/config.php');
    require_once('../../_lib/class.dbConnect.php');
    require_once('../../_lib/class.photos.php');
    require_once('../../_lib/function.php');
    require_once('../../_lib/Thumbnail.class.php');

    $DB = new dbConn();
    $Photo = new clsPhotos( $DB->getConnection() );


    // Require the phpFlickr API
    require_once('../../_lib/phpFlickr.php');

    // Create new phpFlickr object: new phpFlickr('[API Key]','[API Secret]')
    $flickr = new phpFlickr(FLICKR_API_KEY,FLICKR_API_SECRET, true);
    $flickr->setToken(FLICKR_API_TOKEN);

    //로그인 체크
	if( !isset($_SESSION['USER_IDX']) || $_SESSION['USER_IDX'] == '' ) {  
		historyBack("로그인 후 사진올리기 가능합니다.");
	}

    $title = ( trim($_POST['title']) ) ? trim($_POST['title']) : "";
    $description = ( trim($_POST['description']) ) ? trim($_POST['description']) : "";
    $cate = ( trim($_POST['cate']) ) ? trim($_POST['cate']) : "";
    $tags = ( trim($_POST['tags']) ) ? trim($_POST['tags']) : "";
    $ccl_business = ( trim($_POST['ccl_business']) ) ? trim($_POST['ccl_business']) : "";
//    $ccl_change = ( trim($_POST['ccl_change']) ) ? trim($_POST['ccl_change']) : "";
    $photofile = $_FILES['photo'];
	
	$flickr_title = $title.', by '.$_SESSION['USER_NAME'];
	$flickr_description = $description."\r\n\r\n-  본사진은  CC Photo&share 캠페인( http://photo.sharehub.kr ) 을 통해서 ".$_SESSION['USER_NAME']."님께서 (by "
	.$_SESSION['USER_NAME'].") 공유한 사진입니다.\r\n CCL조건만 지키시면 사진을 자유롭게 이용하실 수 있습니다.";
	
    //데이터 유효성 체크
	if( $title == '' || $cate == '' || $ccl_business == '' ) {  
		historyBack( MSG_INPUT_DATA_FAILE );
	}

    //파일 유효성 체크
    if( $photofile['error'] > 0 ) {
        historyBack( MSG_INPUT_DATA_FAILE );
    }

    //파일 용량 체크
    if( !$Photo->checkSize( $photofile['size'] ) )
    {
        historyBack(number_format(MAX_PHOTO_SIZE)." 이하의 사진파일만 업로드 가능합니다.");
    }

    $tmp = explode(".",$photofile['name']);
    $ext = $tmp[ count($tmp) - 1 ];
    //파일 확장자 체크
    if( !$Photo->checkExtension( $ext ) )
    {
        historyBack("확장자(".VALID_PHOTO_EXT.") 파일만 업로드 가능합니다.");
    }

    $upload_name = time().rand(100000,1000000).".".strtolower($ext);
    $uploadfile = PATH_PHOTOS_UPLOAD.$upload_name;
    
    if( !move_uploaded_file($photofile['tmp_name'], $uploadfile) )
    {
        historyBack( MSG_PHOTO_UPLOAD_FAILE );
    }

    //[ADD] 2013-10-23 : 썸네일 저장
	Thumbnail::create($uploadfile,
					  232, null,
					  null,
					  Array(
						  'savepath' => '%PATH%thumb/%FILENAME%.%EXT%'
					  ));

    //CCL 체크
    switch( $ccl_business ) {
        case 1:
            $ccl = FLICKR_BY;
            break;
        case 2:
            $ccl = FLICKR_BY_ND;
            break;
        case 3:
            $ccl = FLICKR_BY_SA;
            break;
        default:
            $ccl = FLICKR_BY;
            break;
    }
    //사진정보 저장 (DB에 저장 안함)
//    $photoinfo = exif_read_data(PATH_PHOTOS.$upload_name, 0, true );
//    unset( $photoinfo['UndefinedTag'] );
//    $photoinfo = serialize( $photoinfo );

    //flickr 업로드
    $photo_id = $flickr->sync_upload($uploadfile, $flickr_title, $flickr_description,$tags);

    if( empty($photo_id) ) {
        historyBack( MSG_INPUT_DATA_FAILE );
    } else {
        //fiickr 라이센스 변경
        if( $flickr->photos_licenses_setLicense($photo_id, $ccl) ) {
            //DB저장
            $arr = array(
                "member_idx"=>$_SESSION['USER_IDX'], 
                "cate_id"=>$cate, 
                "title"=>$title,
                "description"=>$description,
                "tags"=>$tags,
                "ccl"=>$ccl,
                "filename_o"=>$photofile['name'],
                "filename_r"=>$upload_name,
                "info"=>$photoinfo,
                "photo_id"=>$photo_id
            );
            $result = $Photo->save( $arr );

            if( $result['r'] == 'success' )
            {
                header('Location: '.$re_url);
            } else if( $result['r'] == 'error' ) {
                $flickr->photos_delete($photo_id);
                historyBack($result['msg']);
                return;
            }
        } else {
            $flickr->photos_delete($photo_id);
            historyBack(MSG_PHOTO_UPLOAD_FAILE);
        }
    }
?>

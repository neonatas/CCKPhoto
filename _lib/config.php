<?
    define( 'LIB_PATH', realpath(dirname(__FILE__).'/') );

    // Cookie secret key
    define('COOKIE_SECRET_KEY','letscc_photo20131001');

    // Administrator
    define('ADMIN_ID','admin');
    define('ADMIN_PASSWD','1234');

    // E-mail setting
    define('EMAIL_FROM_ADDR','YOUREMAIL@ADDRESS');
    define('EMAIL_FROM_NAME','YOUREMAILNAME');

    // Database setting
    define('DB_HOST','localhost');
    define('DB_NAME','letsccphoto');
    define('DB_USER','letsccphoto');
    define('DB_PASSWD','dkwkwkt^^');

    // Facebook app setting 
    define('FACEBOOK_APPID', '171376159718071');
    define('FACEBOOK_SECRET', '3074ce1362e9fa1ba96939b63ace70db');
    define('FACEBOOK_CALLBACK', 'http://'.$_SERVER['SERVER_NAME'].'/member/oauth/facebook/callback.php');

	// Twitter app setting
    define('CONSUMER_KEY', '02f1Bk6gnw5xWxHq4a3Uw');
    define('CONSUMER_SECRET', 'qzKDBFWXmMrVtC0TZYELvRNIYXZthYDvCpRc5CBmqT4');
    define('TWITTER_CALLBACK', 'http://'.$_SERVER['SERVER_NAME'].'/member/oauth/twitter/callback.php');

    //Path setting
    define('PATH_PROFILE_IMAGE','http://'.$_SERVER['SERVER_NAME'].'/my/photo/');
    define('PATH_PROFILE_IMAGE_UPLOAD',$_SERVER['DOCUMENT_ROOT'].'/my/photo/');

    define('PATH_PHOTOS_FOLDER','/photos/');
    define('PATH_PHOTOS','http://'.$_SERVER['SERVER_NAME'].PATH_PHOTOS_FOLDER);
    define('PATH_PHOTOS_UPLOAD',$_SERVER['DOCUMENT_ROOT'].PATH_PHOTOS_FOLDER);

    //Photo setting
    define('MAX_PHOTO_SIZE','100000000'); //100메가
    define('VALID_PHOTO_EXT','jpg,gif,png'); //허용 확장자

    //Message setting
    define('MSG_PHOTO_UPLOAD_SUCCESS','사진파일이 등록되었습니다.');
    define('MSG_PHOTO_UPLOAD_FAILE','사진파일 등록에 실패하였습니다.');

    define('MSG_INPUT_DATA_FAILE','입력 정보가 올바르지 않습니다.');

    //Flickr CCL
    define('FLICKR_BY_NC_SA',1);
    define('FLICKR_BY_NC',2);
    define('FLICKR_BY_NC_ND',3);
    define('FLICKR_BY',4);
    define('FLICKR_BY_SA',5);
    define('FLICKR_BY_ND',6);

    //Flickr app setting
    define('FLICKR_USER_ID', '100477638@N03');
    define('FLICKR_API_KEY', 'b7150a7b29a3cb3880eb4b2065d00997');
    define('FLICKR_API_SECRET', 'd790211190778b66');
    define('FLICKR_API_TOKEN','72157636399998753-606cd0509ee48111');


?>
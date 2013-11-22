<?
    define( 'LIB_PATH', realpath(dirname(__FILE__).'/') );
    //Site User Type
    define('SITE_NAME','share_photo');

    // Cookie secret key
    define('COOKIE_SECRET_KEY',SITE_NAME.'20131001');

    // Administrator
    define('ADMIN_ID','admin');
    define('ADMIN_PASSWD','1234');

    // E-mail setting
    define('EMAIL_FROM_ADDR','creative@cckorea.org');
    define('EMAIL_FROM_NAME','CCKOREA');

    // Database setting
    define('DB_HOST','localhost');
    define('DB_NAME','ShareNPhoto');
    define('DB_USER','root');
    define('DB_PASSWD','TlTlzpdl');

    // Facebook app setting 
    define('FACEBOOK_APPID', '1403130929918022');
    define('FACEBOOK_SECRET', '3d52c86afaa4ab27ca639edae4d943e4');
    define('FACEBOOK_CALLBACK', 'http://'.$_SERVER['SERVER_NAME'].'/member/oauth/facebook/callback.php');

	// Twitter app setting
    define('CONSUMER_KEY', 'uewfzlkhS8LzJXrrlBzWQ');
    define('CONSUMER_SECRET', 'fk6u9uMVyb5JoqR7ZMe8f9Yn8qIpB2pdT9CaCfw0Ug');
    define('TWITTER_CALLBACK', 'http://'.$_SERVER['SERVER_NAME'].'/member/oauth/twitter/callback.php');

    //Path setting
    define('PATH_PROFILE_IMAGE','http://'.$_SERVER['SERVER_NAME'].'/my/photo/');
    define('PATH_PROFILE_IMAGE_UPLOAD',$_SERVER['DOCUMENT_ROOT'].'/my/photo/');

    define('PATH_PHOTOS_FOLDER','/photos/');
    define('PATH_PHOTOS','http://'.$_SERVER['SERVER_NAME'].PATH_PHOTOS_FOLDER);
    define('PATH_PHOTOS_UPLOAD',$_SERVER['DOCUMENT_ROOT'].PATH_PHOTOS_FOLDER);
    define('PATH_FILES_UPLOAD',$_SERVER['DOCUMENT_ROOT']."/files/");

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
    define('FLICKR_USER_ID', '105466062@N04');
    define('FLICKR_API_KEY', 'b3a9127b5f8043ac539fd57dc4bb7e78');
    define('FLICKR_API_SECRET', 'ad60d3256516c328');
    define('FLICKR_API_TOKEN','72157636585936695-50c9ffcd3de8c959');

    //


?>

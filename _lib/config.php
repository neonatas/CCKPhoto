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


<?php
defined('BASEPATH') or exit('No direct script access allowed');

define('CON_DS', '/');
define('CON_PROTOCOL', empty($_SERVER['HTTPS']) ? 'http' : 'https');
define('CON_SERVER_URL', CON_PROTOCOL . '://' . $_SERVER['SERVER_NAME']);
$port = "";
if($_SERVER['SERVER_PORT'] !== "80") {
    $port = ":".$_SERVER['SERVER_PORT'];
}
if (ENVIRONMENT === "development") {
    //define('APP_FOLDER_NAME', 'rankingstart-web');
    define('APP_FOLDER_NAME', '');
    define('CON_DEFAULT_SITE_LANGUAGE', 'korean');

    define('CON_SMTP_FROM_NAME', 'Ranking Star');
	define('CON_SMTP_FROM_MAIL_ADDRESS', 'rankingstar.2020@gmail.com');
	define('CON_SMTP_PASSWORD', 'mmelemshcsreelhm');
	define('CON_SMTP_USERNAME', 'rankingstar.2020@gmail.com');
	define('CON_SMTP_HOST', 'ssl://smtp.googlemail.com');
	define('CON_SMTP_PORT', 465);
	define('CON_SMTP_CRYPTO','');

  $db_hostname = "192.168.45.201:3306"; 
  $db_user = "skyand";
  $db_password = "!skyand2022";
  $db_database = "rankingstar";
} else {
    define('APP_FOLDER_NAME', '');
    define('CON_DEFAULT_SITE_LANGUAGE', 'korean');

    define('CON_SMTP_FROM_NAME', '[랭킹스타]');
	define('CON_SMTP_FROM_MAIL_ADDRESS', 'rankingstar.2020@gmail.com');
    	define('CON_SMTP_PASSWORD', 'mmelemshcsreelhm');
	define('CON_SMTP_USERNAME', 'rankingstar.2020@gmail.com');
	define('CON_SMTP_HOST', 'ssl://smtp.googlemail.com');
	define('CON_SMTP_PORT', 465);
    define('CON_SMTP_CRYPTO','');
    
    $db_hostname = "localhost";
    $db_user = "rankingstar";
    $db_password = "skyand2020!";
    $db_database = "rankingstar";
}

/* SET BASE URL */
if (empty(APP_FOLDER_NAME)) {
    define('BASE_URL', CON_SERVER_URL.$port.CON_DS.'admin'.CON_DS);
    define('ASSET_BASE_URL', CON_SERVER_URL.$port.CON_DS);
    define('CON_SHOPPING_PATH' , CON_SERVER_URL.$port.CON_DS);
    define('CON_NOTICE_WEB_VIEW_URL' , CON_SERVER_URL.$port.CON_DS);
} else {
    define('BASE_URL', CON_SERVER_URL.$port.CON_DS.APP_FOLDER_NAME.CON_DS.'admin'.CON_DS);
    define('ASSET_BASE_URL', CON_SERVER_URL.$port.CON_DS.APP_FOLDER_NAME.CON_DS);
    define('CON_SHOPPING_PATH' , CON_SERVER_URL.$port.CON_DS.APP_FOLDER_NAME.CON_DS);
    define('CON_NOTICE_WEB_VIEW_URL' , CON_SERVER_URL.$port.CON_DS.APP_FOLDER_NAME.CON_DS);
}

/* DATABASE SETTINGS */
define('CON_DB_HOSTNAME', $db_hostname);
define('CON_DB_USER', $db_user);
define('CON_DB_PASSWORD', $db_password);
define('CON_DB_NAME', $db_database);

/* STORAGE PATH AND URL */
define('CON_APP_STORAGE_PATH',FCPATH);

/* FOLDER STRUCTURE : CONTROLLERS & VIEWS */

/* FOLDER STRUCTURE : OTHERS */
define('CON_FOLDER_ASSETS','assets');
define('CON_FOLDER_RESOURCES','resources');
define('CON_FOLDER_DROPZONE','dropzone');
define('CON_FOLDER_FFMPEG','ffmpeg');
define('CON_FOLDER_ADVERTISE','adertisement');
define('CON_FOLDER_CONTEST','contest_banner');
define('CON_FOLDER_CONTESTANT','contestant_banner');
define('CON_FOLDER_GALLARY','gallary');
define('CON_FOLDER_GALLARY_THUMB','thumb');
define('CON_FOLDER_DIST','dist');
define('CON_FOLDER_IMAGES','images');
define('CON_ALLOWED_IMAGE_TYPE', 'gif|jpg|png|jpeg|mkv|mp4|flv|mov|wmv');
define('CON_ALLOWED_VIDEO_TYPE','mkv|mp4|flv|mov|wmv');
define('CON_FOLDER_CERTIFICATE','certificates');


/* MAX WIDTH AND HEIGHT */
define('CON_IMAGE_MAX_WIDTH',375);
define('CON_IMAGE_MAX_HETGHT',239);
define('THUMB_IMAGE_MAX_WIDTH',300);
define('THUMB_IMAGE_MAX_HETGHT',300);
/* PATH */
define('CON_ADVERTISEMENT_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_ADVERTISE.CON_DS);
define('CON_CONTEST_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_CONTEST.CON_DS);
define('CON_CONTESTANT_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_CONTESTANT.CON_DS);
define('CON_GALLARY_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_GALLARY.CON_DS);
define('CON_DROPZONE_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_RESOURCES.CON_DS.CON_FOLDER_DROPZONE);
define('CON_FFMPEG_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_RESOURCES.CON_DS.CON_FOLDER_FFMPEG);
define('CON_GALLARY_THUMB_PATH', CON_APP_STORAGE_PATH.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_GALLARY.CON_DS.CON_FOLDER_GALLARY_THUMB.CON_DS);
define('CON_DIST_PATH' , ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_DIST.CON_DS); 
define('CON_IMAGES_PATH' , ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_IMAGES.CON_DS); 
define('CON_UPLOAD_CERTIFICATE_PATH',CON_APP_STORAGE_PATH.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_CERTIFICATE.CON_DS);
define('CON_LOGIN_PATH' , BASE_URL);

/* PATH */
define('CON_ADVERTISEMENT_URL', ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_ADVERTISE.CON_DS);
define('CON_CONTEST_URL', ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_CONTEST.CON_DS);
define('CON_CONTESTANT_URL', ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_CONTESTANT.CON_DS);
define('CON_GALLARY_URL', ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_GALLARY.CON_DS); 
define('CON_DROPZONE_URL', ASSET_BASE_URL.CON_FOLDER_RESOURCES.CON_DS.CON_FOLDER_DROPZONE.CON_DS.CON_FOLDER_DIST.CON_DS); 
define('CON_FFMPEG_URL', ASSET_BASE_URL.CON_FOLDER_RESOURCES.CON_DS.CON_FOLDER_FFMPEG.CON_DS); 
define('CON_GALLARY_THUMB_URL', ASSET_BASE_URL.CON_FOLDER_ASSETS.CON_DS.CON_FOLDER_GALLARY.CON_DS.CON_FOLDER_GALLARY_THUMB.CON_DS); 

/* API CONSTANT */
define('CON_RES_CODE', 'res_code');
define('CON_RES_MESSAGE', 'res_message');
define('CON_RES_DATA', 'res_data');
define('CON_CODE_SUCCESS',1);
define('CON_CODE_FAIL',0);
define('CON_CODE_NEW_USER', 2);
define('CON_CODE_UNAUTHORIZED_USER', 3);

define('CON_APP_PAGE_LIMIT', 10);
define('CON_DEFAULT_USER_IMAGE', ''); //user.jpg
define('CON_DEFAULT_SIGNUP_BONUNS', 100);
define('CON_DEFAULT_DAILY_VOTE_LIMIT', 1000);
define('CON_DAILY_CHECKIN_STAR', 50);
define('EQUATION', '/^.*(youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/');

/* PUSH CERTIFICATE */
define('PROD_CERTIFICATE','rankingstarProdCertificate.pem');
define('DEV_CERTIFICATE','rankingstarDevCertificate.pem');
define('ANDROID_API_KEY','AIzaSyDjDm_TF-iDjqVGPqWHnoRZyejkT_HYP1s');

/* Social Media APP ID */
define('FACEBOOK_APP_ID',467507857286658);
define('APP_STORE_ID',1500714912);

define('VIDEO_THUMB_SIZE', '200X150');
define('VIDEO_FROM_SECOND', "1");

define('CON_STATIC_MOBILE', "00000000000");

// Basic token username and password
define('CON_BASIC_TOKEN_USERNAME', 'ranking-star');
define('CON_BASIC_TOKEN_PASSWORD', 'b4bca6aa25828cf702d06cbc9656d4e3');

//OAuth Constants
define('AUTHORIZATION_CODE_LIFETIME', 2073600); //authorization code expire time in seconds
define('REFRESH_TOKEN_LIFETIME', 2419200); //refresh token expire time in seconds
define('ACCESS_TOKEN_LIFETIME', 3600); //access token expire time in seconds

//Force Update Constants
define('IOS_APP_VERSION' , '1.4'); //Set Current App Store Version
define('FORCE_UPDATE_IOS_VERSION', '1.4'); //If Request comes from Specific Older Version then Set Force Update Flag Yes
define('IOS_URL','https://apps.apple.com/us/app/%EB%9E%AD%ED%82%B9%EC%8A%A4%ED%83%80/id1500714912');

define('ANDROID_APP_VERSION', '1.3'); //Set Current Play Store Version
define('FORCE_UPDATE_ANDROID_VERSION', '1.3'); //IF Request comes from Specific Older Version then Set Force Update Flag Yes
define('ANDROID_URL','https://play.google.com/store/apps/details?id=com.etech.starranking');

// User type
define('CON_USER_TYPE_USER', 'user');
define('CON_USER_STATUS_DELETED', 'deleted');

// User status
define('CON_USER_STATUS_ACTIVE', 'active');

// OTP for
define('CON_OTP_FOR_FORGOTPASSWORD', 'forgotpassword');

/* OTP TIME */
define("CON_DB_DATETIME_FORMAT","Y-m-d H:i:s");
define("CON_OTP_EXPIRE_MINUTES", 60); // min
/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
 */
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
 */
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
 */
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

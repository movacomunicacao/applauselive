<?php

	//ABSOLUTES
	$url = "http://$_SERVER[HTTP_HOST]";

	// DIRECTORY_SEPARATOR
	if(!defined('DS')){ define('DS', DIRECTORY_SEPARATOR);}

	$sitename = explode('/', $_SERVER['PHP_SELF']);
	if(!defined('SITE_NAME')){
		define('SITE_NAME', $sitename[1]);
	}


	if(isset($_SERVER['HTTPS'])){
		$https = $_SERVER['HTTPS'];
	} else {
		$https ='';
	}

	if($https == ''){ $https = 'http://'; }else{	$https = 'http://'; }
	$baseurl = $https.$_SERVER['HTTP_HOST'];

	$localhost_check = $_SERVER['HTTP_HOST'];
	if (strpos($localhost_check, 'localhost') !== false) {
		$site_host = 'http://localhost:8888/applauselive/';
	} else {
		$site_host = $baseurl.'/';
	}

	if(strpos($url, "feed") == true){
		define('SERVER_DIR', $site_host);
	}
	else{
		if(!defined('SERVER_DIR')){ define('SERVER_DIR', $site_host); }
	}

	define('ABSOLUTE_PATH', $site_host);
	define('ROOT', SERVER_DIR);
	define('WWW', SITE_NAME.'/');
	define('APP_DIR', 'app');
	define('WEBROOT_DIR', APP_DIR . '/' . 'webroot' . '/');
	define('VIEW_DIR', APP_DIR . '/' . 'view' . '/');
	define('PAGES_DIR', VIEW_DIR . 'pages' . '/');
	define('HELPER_DIR', VIEW_DIR . 'helper' . '/');
	define('ELEMENTS_DIR', VIEW_DIR . 'elements' . '/' . 'site' . '/');
	define('CSS_DIR', SERVER_DIR . WEBROOT_DIR . 'css' . '/');
	define('IMG_DIR', SERVER_DIR . WEBROOT_DIR . 'img' . '/');
	define('JS_DIR', SERVER_DIR . WEBROOT_DIR . 'js' . '/');
	define('FILES_DIR', SERVER_DIR . WEBROOT_DIR . 'files' . '/');
	define('CONFIG_DIR', APP_DIR . '/' . 'config' . '/');
	define('VENDORS_DIR', APP_DIR . '/' . 'vendors' . '/');
	define('CONTROLLER_DIR', APP_DIR . '/' . 'controller' . '/');
	define('MODEL_DIR', SERVER_DIR . APP_DIR . '/' . 'model' . '/');
	define('ADMIN', 'admin'.'/');
	define('FEED', 'fedd'.'/');

	//RELATIVES
	define('CONFIG_REL_DIR', '..' . '/' . 'config' . '/');
	define('IMG_REL_DIR', '..' . '/' . '..' . '/' . '..' . '/' . 'webroot' . '/' . 'img' . '/');


?>

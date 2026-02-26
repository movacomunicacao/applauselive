<?php
define('DS', DIRECTORY_SEPARATOR);
include ('app/config/directories.php');

session_destroy();
session_unset();
setcookie("PHPSESSID", "", time() - 3600);
unset($_COOKIE['PHPSESSID']);
setcookie('PHPSESSID', null, -1, '/');

$sitename = explode('/', $_SERVER['PHP_SELF']);
if(!defined('SITE_NAME')){
  define('SITE_NAME', $sitename[1]);
}
header("Location:/".SITE_NAME."/admin");
?>

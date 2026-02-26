<?php
define('DS', DIRECTORY_SEPARATOR);
include ('app/config/directories.php');

session_destroy();
session_unset();
setcookie("PHPSESSID", "", time() - 3600);
unset($_COOKIE['PHPSESSID']);
setcookie('PHPSESSID', null, -1, '/');
header('Location:'.ROOT.ADMIN);
?>

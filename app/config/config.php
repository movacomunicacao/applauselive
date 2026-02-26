<?php



/** ______________________________________________________________________________________________________________
*
* MAIN
* Here comes the MAIN configuration stuff
*/
if(!defined('DS')){ define('DS', '/');}

//SITE NAME
$sitename = explode(DS, $_SERVER['PHP_SELF']);
if(!defined('SITE_NAME')){
  define('SITE_NAME', $sitename[1]);
}

/*
if(!isset($_COOKIE['site'])){
  setcookie('site', SITE_NAME, time() + (14400 * 30), "/");
} else {
  $site = $_COOKIE['site'];
}
*/

$conn = db();
foreach($conn->query("SELECT content FROM config WHERE title = 'Site_Title' ") as $row) {
  $site_title    = $row['content'];
}
define('SITE_TITLE', $site_title);

//DIRECTORIES
/*
$directories = 'app/config/directories.php';

if(file_exists($directories)){
  include ($directories);
}
else {
  include ('../../..'. DS . 'config' . DS . 'directories.php');
}
*/

//Automatic Update files to the newest version from CDN
$update_array = array('auto_update_appmodel', 'auto_update_adminmodel', 'auto_update_helper_form', 'auto_update_helper_list');
foreach ($update_array as $update_array_value) {
  $query = $conn->prepare("SELECT content FROM config WHERE title = '".$update_array_value."'");
  $query->execute();
  $$update_array_value = $query->fetchColumn();
}

//CMS
$cms  = 'cms'; //Table name where are stored the names of the Pages with CMS


/** ______________________________________________________________________________________________________________
*
* ADMIN
* Here comes the ADMIN configuration stuff
*/

//FORM
# Form input types assumed by the form inputs (*If not defined below, the input will assume Text Type)

$input_arrays = array('array_fields_hidden', 'array_fields_text', 'array_fields_number', 'array_fields_select', 'array_fields_img', 'array_fields_textarea', 'array_fields_date', 'array_fields_time', 'array_fields_price', 'array_galleries', 'array_fields_password');

foreach ($input_arrays as $input_arrays_value) {
  $query = $conn->prepare("SELECT content FROM input_types WHERE title = '".$input_arrays_value."'");
  $query->execute();
  $$input_arrays_value = explode(", ", $query->fetchColumn());
}

?>

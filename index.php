<?php

//echo 'test'; die();
/**
* Database file include
*/

include('app/config/database.php');

/** ______________________________________________________________________________________________________________
*
* Config File Include
*/
include ('app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
include ('app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'directories.php');

/** ______________________________________________________________________________________________________________
*
* Model Customization and Update Verification
*/

//APPMODEL -------------------------------------------------------------------------------------

// This part is about the update of the Files:AppModel.php, AdminModel.php, form.php and list.php to their respective newest version from CDN.
// It starts with a verification of the last update. It only proceed if the last updade was done more than 1 hour ago, otherwise it will not update. It is an hourly update because of optmization issues.

$conn = db();
$query = $conn->prepare("SELECT time FROM update_time_control ORDER BY id DESC limit 1");
$query->execute();
$last_update_time = $query->fetchColumn();
$time_now = date("Y-m-d H:i:s");
$time_allowed = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($last_update_time)));

if($time_now > $time_allowed) {

	if($auto_update_appmodel == 'yes'){

		if(file_exists(MODEL_DIR.'AppModel.php')){

			$appmodel_local = file_get_contents(MODEL_DIR.'AppModel.php');
			$appmodel = file_get_contents('https://raw.githubusercontent.com/ectorrodrigues/blackholeframe/master/app/model/AppModel.php');

			if(empty($appmodel_local)){
				if(strpos($appmodel, '<pre>') == true){
					$appmodel = str_replace(array("<pre>", "</pre>"), array("<?php", "?>" ), $appmodel);
				}
				file_put_contents(MODEL_DIR.'AppModel.php', $appmodel);
			}
			else{

				preg_match_all("'function (.*?)\('si", $appmodel_local, $functions);
				$functions = $functions[1];

				$function_preg_content = array();
				foreach ($functions as $functions_name) {
					if(strpos($appmodel_local, $functions_name) == true){
						preg_match("'function ".$functions_name."(.*?)endfunction'si", $appmodel, $function_preg);
						$function_preg_content = $function_preg[0];
						$appmodel = str_replace($function_preg_content, '', $appmodel);
					}
				}

				$appmodel = str_replace(array("<pre>", "</pre>"), array("<?php", "?>" ), $appmodel);
				file_put_contents(MODEL_DIR.'AppModel.php', $appmodel, FILE_APPEND | LOCK_EX);
			}

		}

	}


//ADMINMODEL -------------------------------------------------------------------------------------

	if($auto_update_adminmodel == 'yes'){

		if(file_exists(MODEL_DIR.'AdminModel.php')){

			$adminmodel_local = file_get_contents(MODEL_DIR.'AdminModel.php');
			$adminmodel = file_get_contents('https://raw.githubusercontent.com/ectorrodrigues/blackholeframe/master/app/model/AdminModel.php');

			if(empty($adminmodel_local)){
				if(strpos($appmodel, '<pre>') == true){
					$adminmodel = str_replace(array("<pre>", "</pre>"), array("<?php", "?>" ), $adminmodel);
				}
				file_put_contents(MODEL_DIR.'AdminModel.php', $adminmodel);
			}

		}

	}

//FORM HELPER -------------------------------------------------------------------------------------
	if($auto_update_helper_form == 'yes'){

		if(file_exists(HELPER_DIR.'form.php')){

			$appmodel_local = file_get_contents($_SERVER['DOCUMENT_ROOT'] . SERVER_DIR . HELPER_DIR.'form.php');
			$appmodel = file_get_contents('https://raw.githubusercontent.com/ectorrodrigues/blackholeframe/master/app/view/helper/form.php');

			if(empty($appmodel_local)){
				if(strpos($appmodel, '<pre>') == true){
					$appmodel = str_replace(array("<pre>", "</pre>"), array("<?php", "?>" ), $appmodel);
				}
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . SERVER_DIR . HELPER_DIR.'form.php', $appmodel);
			}

		}

	}


//LIST HELPER -------------------------------------------------------------------------------------
	if($auto_update_helper_list == 'yes'){

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . SERVER_DIR . HELPER_DIR.'list.php')){

			$appmodel_local = file_get_contents($_SERVER['DOCUMENT_ROOT'] . SERVER_DIR . HELPER_DIR.'list.php');
			$appmodel = file_get_contents('https://raw.githubusercontent.com/ectorrodrigues/blackholeframe/master/app/view/helper/list.php');

			if(empty($appmodel_local)){
				if(strpos($appmodel, '<pre>') == true){
					$appmodel = str_replace(array("<pre>", "</pre>"), array("<?php", "?>" ), $appmodel);
				}
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . SERVER_DIR . HELPER_DIR.'list.php', $appmodel);
			}

		}

	}

	$query = $conn->prepare("INSERT INTO update_time_control (time) VALUES(:time_now)");
	$query->bindParam(':time_now', $time_now);
	$query->execute();

}


/** ______________________________________________________________________________________________________________
*
* Model include
*/
include('app/model/AppModel.php');



/** ______________________________________________________________________________________________________________
*
* Initializing website
*/
	if(isset($_GET['page'])){



		$page = $_GET['page'];
		if($page == 'admin' || $page == 'login'){
			session_start();
			/*--------- LOGIN POST REQUEST ----------*/
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(!empty($_POST['user']) && !empty($_POST['password'])){

					$user		= $_POST['user'];
					$pass		= $_POST['password'];

					// CHECK IF THE USER EXISTS AND IF SO, GET HIS HASHED PASSWORD
					$conn		= db();
					$query	= $conn->prepare("SELECT password FROM users WHERE email= :user");
					$query->bindParam(':user', $user);
					$query->execute();
					if ($query->rowCount() > 0){
						$passfetch = $query->fetchColumn();
					} else {
						echo '<p style="text-align:center; margin:20px 0 -50px 0;">Usuário não cadastrado no sistema.<p>';
						include (WEBROOT_DIR . 'login.php');
						die();
					}

					// ENCRYPT PASSWORD AND CHECK IF IT MATCHES THE HASHED PASSWORD STORED ON DATABASE
					foreach($conn->query("SELECT * FROM users WHERE email = '$user' ") as $row) {
						$tag		    = $row['key_tag'];
					  $iv         = $row['key_iv'];
					}

					$crypted_password = encrypting("encrypt", $pass, $iv, $tag);
					if($passfetch == $crypted_password){
						$pass = $passfetch;
					} else {
						$pass = 'wrongpass';
					}

					// CHECK IF THERE'S AN USER ATTACHED WITH THE HASHED PASSWORD
					$conn		= db();
					$query	= $conn->prepare("SELECT password FROM users WHERE email= :user AND password= :pass");
					$query->bindParam(':user', $user);
					$query->bindParam(':pass', $pass);
					$query->execute();
					/*--------- IF USER AND PASS EXISTS GO TO THE ADMIN ----------*/
					if ($query->rowCount() > 0){
						$keypass = $query->fetchColumn();
						$query 	= $conn->prepare("SELECT id FROM users WHERE email= :user AND password= :pass");
						$query->bindParam(':user', $user);
						$query->bindParam(':pass', $pass);
						$query->execute();
						$user_id = $query->fetchColumn();

						$_SESSION['login'] = $user_id;
						include (WEBROOT_DIR . 'admin.php');
					} else {
						include (WEBROOT_DIR . 'login.php');
					}
					/*--------- IF USER AND PASS EXISTS GO TO THE ADMIN - END ----------*/
				} else {
					header('Location:'.ROOT);
				}
			} else {

				if (!isset($_SESSION['login'])) {
					include (WEBROOT_DIR . 'login.php');
				} else {
					$user_id = $_SESSION['login'];
					include (WEBROOT_DIR . 'admin.php');
				}


			}
			/*--------- LOGIN POST REQUEST END ----------*/

		} else {
			include (WEBROOT_DIR . 'index.php');
		}
	} else {
		include (WEBROOT_DIR . 'index.php');

	}

?>

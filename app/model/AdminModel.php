<?php


//------------- INIT ---------------------------------------------------------------------------------------

	include ('../config/directories.php');
	include ('../config/database.php');

	$array_galleries = array('portfolio', 'noticias'); // Here we tell the pages that will have some gallery within

	$action	= $_GET['action'];
	$table	= $_GET['id'];
	$item 	= $_GET['item'];



	$conn = db();

	foreach($conn->query("SELECT title FROM cms WHERE id = '".$table."' ") as $row) {
		$table		= $row['title'];
	}


//------------- ADD -------------------------------------------------------------------------------------------------

	if($action == 'add'){

		$query = $conn->prepare("DESCRIBE ".$table);
		$query->execute();
		$table_fields = $query->fetchAll(PDO::FETCH_COLUMN);

		$columns		= '';
		$columns_val	= '';

		foreach($table_fields as $field) {

			if($field == "id"){
				$columns .= '';
			}
			else{
				$columns .= $field.', ';
			}

			if($field !== "img") {
				$field = $_POST[$field];
			}
			else{
				$file		= $_FILES[$field]['name'];
				$datename = date('Y-m-d-h-m-s');
				$img		= $datename.'-'.$file;


				$_UP['folder']	= '../webroot/img/'.$table.'/';
				move_uploaded_file($_FILES['img']['tmp_name'], $_UP['folder'] . $img);

				//include ('../../app/vendor/rosell-dk/webp-convert/webpconvert.php');

			}


			if($columns == ""){
				$columns_val	.= '';
			}
			else{

				if(!empty($img)){
					$columns_val	.= " '".$img."', ";
					$img = '';
				} else {
					$columns_val	.= " '".$field."', ";
				}

			}
		}


		$query 	= $conn->prepare("SELECT id FROM cms WHERE title = '".$table."'");
		$query->execute();
		$id_category = $query->fetchColumn();

		$sql = 'INSERT INTO '.$table.' ('.substr($columns, 0, -2).') VALUES ('.substr($columns_val, 0, -2).')' ;
		$query = $conn->prepare($sql);
		$query->execute();

		$query 	= $conn->prepare("SELECT id FROM ".$table." ORDER BY ID DESC LIMIT 1");
		$query->execute();
		$id_last = $query->fetchColumn();

		$id_last_new = ($id_last+1);

		if(!empty($_FILES['filesToUpload']['tmp_name'][0])){

			if(in_array($table, $array_galleries, TRUE)){

				$i = 0;

				foreach ($_FILES['filesToUpload']['name'] as $fileimg) {

					$fileimgname = uniqid().$fileimg;
					$_UP['folder']	= '../webroot/img/'.$table.'/';

					move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$i], $_UP['folder'] . $fileimgname);


					$query 	= $conn->prepare("INSERT INTO ".$table."_gallery (title, img, id_".$table.") VALUES ( '".$fileimgname."', '".$fileimgname."', '".$id_last."')");
					$query->execute();

					//include ('../../app/vendor/rosell-dk/webp-convert/webpconvert.php');

					$i++;
				}




			}

		}


	}


//------------- EDIT -------------------------------------------------------------------------------------------------

	elseif($action == 'edit'){

		$columns		= '';
		$columns_val	= '';

		$query = $conn->prepare("DESCRIBE ".$table);
		$query->execute();
		$table_fields = $query->fetchAll(PDO::FETCH_COLUMN);

		$ignore = array('key_iv', 'key_tag', 'reference', 'created', 'plan_id', 'active');

		foreach($table_fields as $field) {

		if(!in_array($field, $ignore)){

			if($field == "id"){
				$id		 = $_POST[$field];
				$field   = '';
				$columns = '';
			}

			elseif($field == "img" OR $field == "icone"){

				if(empty($_FILES[$field]['tmp_name'][0])){

					$columns = '';
					$field   = '';
					$columns_val	.= '';

				}else{

					$file		= $_FILES[$field]['name'];
					$img		= uniqid().$file;

					$_UP['folder']	= '../webroot/img/'.$table.'/';
					move_uploaded_file($_FILES[$field]['tmp_name'], $_UP['folder'] . $img);
					//include ('../../app/vendor/rosell-dk/webp-convert/webpconvert.php');

					$columns_val	.= $field." = '".$img."', ";
				}

			} else {

				$columns = $field;
				$field = $_POST[$field];

				if($columns == ""){
					$columns_val	.= '';
				} else{
					$columns_val		.= $columns." = '".$field."', ";
				}
			}

		}
	}

		$query 	= $conn->prepare("SELECT id FROM cms WHERE title = '".$table."'");
		$query->execute();
		$id_category = $query->fetchColumn();

		$sql = 'UPDATE '.$table.' SET '.substr($columns_val, 0, -2)." WHERE id = '".$id."'";
		$query = $conn->prepare($sql);
		$query->execute();

		$conn=null;

		if(!empty($_FILES['filesToUpload']['tmp_name'][0])){

			require (CONFIG_REL_DIR . 'database.php');

			$query 	= $conn->prepare("SELECT id FROM ".$table." ORDER BY ID DESC LIMIT 1");
			$query->execute();
			$id_last = $query->fetchColumn();

			if(in_array($table, $array_galleries, TRUE)){

				$i = 0;

				foreach ($_FILES['filesToUpload']['name'] as $fileimg) {

					$fileimgname = uniqid().$fileimg;
					$_UP['folder']	= '../webroot/img/'.$table.'/';

										move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$i], $_UP['folder'] . $fileimgname);


					$query 	= $conn->prepare("INSERT INTO ".$table."_gallery (id_".$table.", title, img) VALUES ('".$id."', '".$fileimgname."', '".$fileimgname."')");
					$query->execute();

					//include ('../../app/vendor/rosell-dk/webp-convert/webpconvert.php');

					$i++;
				}

			}

		}



	}


//------------- DELETE -------------------------------------------------------------------------------------------------


	elseif($action == 'delete'){

		$query 	= $conn->prepare("DELETE FROM ".$table." WHERE id = ".$item."");
		$query->execute();

	}


//------------- CREATE USER -------------------------------------------------------------------------------------------------


	elseif($action == 'createuser'){

		$username			= $_POST['username'];	
		$email 				= $_POST['email'];	
		$password			= $_POST['password'];	
		$confirmpassword	= $_POST['confirmpassword'];	
		$company			= $_POST['company'];
		$category			= $_POST['category'];
		$data['avatar']		= $_FILES['avatar'];
        $avatar 			= $data['avatar']['name'];
        $datename 			= date('Y-m-d-h-m-s-u');
        $avatar 			= $datename."---".$avatar;
		$_UP['folder']		= '../webroot/img/avatar/';
		


		// VALIDATIONS

		$validations = '';
		$conn = db();

		$query = $conn->prepare("SELECT title FROM users WHERE title = :user");
		$query->bindParam(':user', $username);
		$query->execute();

		if ($query->rowCount() > 0){
			$validations .= 'usernametaken';
		}

		$query = $conn->prepare("SELECT email FROM users WHERE email = :email");
		$query->bindParam(':email', $email);
		$query->execute();

		if ($query->rowCount() > 0){
			$validations .= 'emailtaken';
		}

		if($password != $confirmpassword){
			$validations .= 'unmatchingpass';
		}

		if(empty($company) || $company == 'companychoice'){
			$validations .= 'emptycompany';
		}

		if(empty($category) || $category == 'categorychoice'){
			$validations .= 'emptycategory';
		}


		// ALWAYS BUILD COMEBACK IN FIXED ORDER
		$email_replaced = str_replace("@", "-atsymbol-", $email);

		$comeback =
		'---'.$username.
		'---'.$email_replaced.
		'---'.$company.
		'---'.$category;


		// REDIRECT IF ERROR
		if(!empty($validations)){
			header("Location:".ROOT."register/item/".$validations.$comeback."/1");
			exit;
		}
		
		$key_sk   	= random_bytes(32);
        $key_siv  	= random_bytes(32);
        $key_sk   	= base64_encode($key_sk);
        $key_siv  	= base64_encode($key_siv);
        $key_sk   	= hash("sha256", $key_sk);
        $key_siv	= substr(hash("sha256", $key_siv), 0, 16);

		function encrypting($action, $string, $key_sk, $key_siv){
			$cypher_method = "AES-256-CBC";
			$output = false;
			if ($action == "encrypt"){
				$key    = $key_sk;
				$iv     = $key_siv;
				$output = openssl_encrypt($string, $cypher_method, $key, 0, $iv);
				$output = base64_encode($output);
			} else if($action == "decrypt"){
				$key    = $key_sk;
				$iv     = $key_siv;
				$output = base64_decode($string);
				$output = openssl_decrypt($output, $cypher_method, $key, 0, $iv);
			}
			return $output;
		} //endfunction

        $datenow	= date('Y-m-d h:m:s');
        $crypted_password = encrypting("encrypt", $password, $key_sk, $key_siv);

		$created = date("Y-m-d");
        $updated = date("Y-m-d");
        $reference = date("Ymdhs") . uniqid();
        $active = '1';

        $query = $conn->prepare("INSERT INTO users (title, email, password, keypass, key_iv, key_tag, company, category, avatar, created, updated, reference, active) VALUES (:title, :email, :password, :keypass, :key_iv, :key_tag, :company, :category, :avatar, :created, :updated, :reference, :active)");

        $query->bindParam(':title', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $crypted_password);
        $query->bindParam(':keypass', $crypted_password);
        $query->bindParam(':key_iv', $key_sk);
        $query->bindParam(':key_tag', $key_siv);
        $query->bindParam(':avatar', $avatar);
		$query->bindParam(':company', $company);
		$query->bindParam(':category', $category);
        $query->bindParam(':created', $created);
        $query->bindParam(':updated', $updated);
    	$query->bindParam(':reference', $reference);
        $query->bindParam(':active', $active);
    	$query->execute();

		move_uploaded_file($_FILES['avatar']['tmp_name'], $_UP['folder'] . $avatar);

	}


//------------- GALLERY -------------------------------------------------------------------------------------------------


	elseif($action == 'gallery'){

		$query 	= $conn->prepare("DELETE FROM ".$table."_gallery WHERE id = ".$item."");
		$query->execute();

	}


//------------- ART -------------------------------------------------------------------------------------------------


	elseif($action == 'result'){

		$item = explode('---', $item);
		$title		= $item[0];
		$img_name	= $item[1];
		$user_id	= $item[2];
		$proportion_size	= $item[3];

		$query  = $conn->prepare("INSERT INTO arts (title, img, user_id, proportion_size, active) VALUES ('$title', '$img_name', '$user_id', '$proportion_size', '0')");
		$query->execute();


	}

	elseif($action == 'confirm'){

		$id_art = $_GET['id'];
		$query  = $conn->prepare("UPDATE arts SET active = '1' WHERE id = '$id_art' ");
		$query->execute();

	}

	elseif($action == 'confirmdelete'){

		$id_art = $_GET['id'];
		$query  = $conn->prepare("DELETE FROM arts WHERE id = '$id_art' AND active = '0' ");
		$query->execute();

	}



//------------- CLOSE CONN AND REDIRECT ---------------------------------------------------------------------------------------

	$conn=null;

	if($action == 'result' || $action == 'confirm' || $action == 'confirmdelete'){
		$redirect_url = SERVER_DIR . ADMIN . '1';
	} else {
		//$redirect_url = SERVER_DIR . ADMIN . $_GET['id'];
		$redirect_url = ROOT;
	}

header('Location:'. $redirect_url);


?>

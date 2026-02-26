<?php

	//This file gets the creator system, to start everything

	$results_echo = '';

	$databasename = $_GET['databasename'];
	$dbuser = $_GET['dbuser'];
	$dbpass = $_GET['dbpass'];
	$port = $_GET['port'];

	function create_files($dir, $filename){

		global $results_echo;
		global $databasename;
		global $dbuser;
		global $dbpass;

		$appmodel = file_get_contents('https://raw.githubusercontent.com/ectorrodrigues/blackholeframe/master/'.$dir.'/'.$filename);

		if($filename == 'database.php'){
			$appmodel = str_replace(array("databasename", "dbuser", "dbpass"), array($databasename, $dbuser, $dbpass), $appmodel);
		}

		if($filename == 'directories.php'){
			if($port == ''){$port = '';} else {$port = ':'.$port;}
				$appmodel = str_replace("localhostportdb", 'localhost'.$port, $appmodel);
		}

		if(strpos($appmodel, '<pre>') == true){
			$appmodel = str_replace(array("<pre>", "</pre>"), array("<?php", "?>" ), $appmodel);
		}

		file_put_contents($dir.'/'.$filename, $appmodel);

		$results_echo .= '<strong>'.$filename.'</strong> sucessfuly created. <br>';
	}

	if (!file_exists('creator')) { mkdir('creator', 0777, true); }
		create_files('creator', 'index.php');

	if (!file_exists('creator/config')) { mkdir('creator/config', 0777, true); }
		create_files('creator/config', 'database.php');

	if (!file_exists('creator/model')) { mkdir('creator/model', 0777, true); }
		create_files('creator/model', 'AppModel.php');

	if (!file_exists('creator/view')) { mkdir('creator/view', 0777, true); }
		if (!file_exists('creator/view/elements')) { mkdir('creator/view/elements', 0777, true); }
			if (!file_exists('creator/view/elements/site')) { mkdir('creator/view/elements/site', 0777, true); }
				create_files('creator/view/elements/site', 'head.php');
				create_files('creator/view/elements/site', 'footer.php');
				create_files('creator/view/elements/site', 'top.php');

		if (!file_exists('creator/view/pages')) { mkdir('creator/view/pages', 0777, true); }
			if (!file_exists('creator/view/pages/configurations')) { mkdir('creator/view/pages/configurations', 0777, true); }
				create_files('creator/view/pages/configurations', 'index.php');

			if (!file_exists('creator/view/pages/home')) { mkdir('creator/view/pages/home', 0777, true); }
				create_files('creator/view/pages/home', 'index.php');

			if (!file_exists('creator/view/pages/new')) { mkdir('creator/view/pages/new', 0777, true); }
				create_files('creator/view/pages/new', 'index.php');

			if (!file_exists('creator/view/pages/pages')) { mkdir('creator/view/pages/pages', 0777, true); }
				create_files('creator/view/pages/pages', 'index.php');

	if (!file_exists('creator/webroot')) { mkdir('creator/webroot', 0777, true); }

		if (!file_exists('creator/webroot/css')) { mkdir('creator/webroot/css', 0777, true); }
			create_files('creator/webroot/css', 'style.css');

		if (!file_exists('creator/webroot/files')) { mkdir('creator/webroot/files', 0777, true); }



echo '
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,700i,900" rel="stylesheet">

	<style>
	body{
		background-color: #000;
		color: #fff;
		text-align: left;
		font-size: 12px;
		line-height: 17px;
		font-family: "Montserrat", sans-serif;
		font-weight: 300;
	}

	.row{
		width:100%;
		padding:40px 0 5px 0;
	}

	.col{
		width:300px;
		text-align: left;
	}

	.btn{
		background-color: #000 !important;
	  	color: #50FFFC;
	  	border:solid;
	  	border-color: #50FFFC;
	  	border-width:1px;
	  	padding:10px;
	  	border-radius:5px;
	  	text-decoration:none;
	}
	.btn:hover{
	  	background-color: #50FFFC !important;
	  	color: #000;
	  	border:none;
	}
	</style>

	<div class="container-fluid" align="center">
		<div class="row" align="center">
			<div class="col">
				'.$results_echo.'
			</div>
		</div>
		<div class="row" align="center">
			<div class="col">
				The Big Bang happened..<br>
				Creator system is now ready.<br>
				Wait a little bit to start...
			</div>
		</div>
	</div>';

	sleep(5);

	header('Location:creator/index.php');

?>

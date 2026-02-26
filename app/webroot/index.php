<?php
	require (ELEMENTS_DIR .'head.php');
?>

<body>

	<?php
		// CONSTRUCTIONG TOP
		if(empty($page)){
			$pagetop = 'home';
		} else
		{
			if(isset($_GET['page'])){
				$pagetop 	= $_GET['page'];
			} else {
				$pagetop = 'home';
			}
		}
		construct_page($pagetop, 'top.php');
	?>

	<main>
		<?php
			// CONSTRUCTIONG BODY
			$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if(empty($page)){
				$page = 'home';
				$archive = 'index.php';
				construct_page($page, $archive);
			} else {
				if(isset($_GET['page'])){ $page 	= $_GET['page']; } else { $page = 'home'; }
				if(strpos($url, "/item/") == false){
					$archive = 'index.php';
					construct_page($page, $archive);
				}else{
					$id 	= $_GET['id'];
					$archive = 'item.php';
					construct_page($page, $archive);
				}
			}
		?>
	</main>

	<?php
		// CONSTRUCTIONG FOOTER

		if(empty($page)){
			$pagetop = 'home';
		} else
		{
			if(isset($_GET['page'])){
				$pagetop 	= $_GET['page'];
			} else {
				$pagetop = 'home';
			}
		}

		construct_page($pagetop, 'footer.php');
	?>

</body>

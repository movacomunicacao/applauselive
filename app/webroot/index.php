<?php
	require (ELEMENTS_DIR .'head.php');
?>

<body>

	<?php
// CONSTRUCTING TOP (single call)

// Default
$pagetop = 'home';

// If $page is not empty and the query param exists, use it
if (!empty($page) && isset($_GET['page'])) {
    $pagetop = (string) $_GET['page'];
}

// Only build the top when it's not "feed"
if ($pagetop !== 'feed') {
    construct_page($pagetop, 'top.php');
}
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
				if(isset($_GET['page'])){ 
					$page 	= $_GET['page']; 
				} else { 
					$page = 'home'; 
				}


				if(strpos($url, "/feed") == true){
					$archive = 'index.php';
					//echo $user_id.'--ppp<br>';
					construct_page($page, $archive);
				} elseif(strpos($url, "/item/") == true){
					$id 	= $_GET['id'];
					$archive = 'item.php';
					construct_page($page, $archive);
				} else {
					$archive = 'index.php';
					construct_page($page, $archive);
				}
				
			}
		?>
	</main>

	<?php
		// CONSTRUCTIONG FOOTER
		/*
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
		*/
	?>

</body>

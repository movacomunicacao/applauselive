<?php
	setcookie("status", "", time() - 3600);
	unset($_COOKIE['status']);
	//setcookie('status', null, -1, '/');

	require (ELEMENTS_DIR .'head.php');
?>


<body id="admin" class="admin">
	

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<div class="container-fluid">

<div class="row justify-content-center text-center bottom-items">
	<a href="<?=ROOT.'go/'.$user?>" target="_top" class="col-auto bottom-items-btn">
		<div>
			<p><i class="far fa-paper-plane"></i> Enviar mensagem</p>
		</div>
	</a>
</div>

<div class="row justify-content-center mb-5">
	<div class="col-12 mb-5">
		<div class="row justify-content-between pt-4 pb-2 px-5">
			<div class="col-6 text-start">
				<img src="<?=FILES_DIR.'logo.webp'?>" alt="logo" class="col-6">
			</div>
			<div class="col-6 text-end">
				<a href="<?=ROOT.WEBROOT_DIR.'logout.php'?>" class="logout my-auto"><i class="fas fa-power-off"></i> logout</a>
			</div>
		</div>

		<hr>

		<div class="row justify-content-center">
			<div class="col-10">
				<?php
					$query = $conn->prepare("SELECT name FROM messages WHERE recipient= :user");
					$query->bindParam(':user', $user);
					$query->execute();
					
					if ($query->rowCount() > 0) {
						echo '<h1 class="my-4">Veja as mensagens deixadas para você!</h1>';
					} else {
						echo '<h1 class="my-4">Você ainda não tem mensagens.</h1>';
					}

					$url = $_SERVER['REQUEST_URI'];
					$id_item = $user_id;

					if (strpos($url, "add") == true || strpos($url, "edit") == true || strpos($url, "delete") == true) {
						include (HELPER_DIR.'form.php');
					} else {
						foreach ($conn->query("SELECT * FROM messages WHERE recipient = '".$user."' ORDER BY submit_date DESC") as $row) {
							if (!empty($row['name'])) {
								$name = $row['name'];
							}

							if (!empty($row['upload'])) {
								$upload = $row['upload'];
								echo '
									<div class="card mt-5">
										<video width="100%" height="auto" controls poster="'.IMG_DIR.'poster_mobile.png">
											<source src="app/webroot/videos/'.$upload.'" type="video/mp4">
										</video>
										<div class="card-body py-4 px-4">
											<p class="card-text">Mesagem enviada por <span class="name-card">'.$name.'</span></p>
										</div>
									</div>
								';
							}

							if (!empty($row['text_message'])) {
								$text_message = $row['text_message'];
								echo '
									<div class="card mt-5">
										<p class="text-message"><span class="quotes">"</span>'.$text_message.'<span class="quotes">"</span></p>
										<div class="card-body py-4 px-4">
											<p class="card-text mt-4">Mesagem enviada por <span class="name-card">'.$name.'</span></p>
										</div>
									</div>
								';
							}
						}
					}

					$conn = null;
				?>
			</div>
		</div>
	</div>
</div>

<p><br></p><p><br></p><p><br></p><p><br></p>

<script>
	ClassicEditor
		.create( document.querySelector( '#editor' ) )
			.then( editor => {
				console.log( editor );
			} )
		.catch( error => {
			console.error( error );
	} );
</script>

</body>

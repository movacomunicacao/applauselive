<?php
    require (ELEMENTS_DIR .'head.php');
?>

<body>
  <div class="container-fluid mt-5 pt-5">

    <div class="row justify-content-center py-5">
      <div class="col-lg-5 col-10">
	       <?php
	        if($_SERVER['REQUEST_METHOD'] == 'POST'){
	           echo '<p class="text-center">Accesso negado. Tente novamente.</p>';
	        }
	       ?>


			     <form action="<?= ROOT.'admin/4'?>" method="post" enctype="multipart/form-data" class="mt-5">

            <div class="form-group text-start pt-5">
               <label for="user">Usuário</label><br>
               <input type="text" name="user" class="form-control mt-0 form-control-lg"/><br>

               <label for="password">Senha</label><br>
               <input type="password" name="password" class="form-control mt-0 form-control-lg"/><br>
            </div>

            <div class="text-center mt-1">
   						<button type="submit" class="btn text-center submit-login transition px-5 py-3">Entrar</button>
   					</div>

		      </form>
		</div>

	</div>

  </div>
</body>
</html>

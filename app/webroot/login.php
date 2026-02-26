<?php
    require (ELEMENTS_DIR .'head.php');
?>


<body>
  <div class="container-fluid mt-5 pt-5">

    <div class="row justify-content-center pt-5 mb-lg-0 mb-5">
      <div class="col-12 text-center my-lg-0 my-4">
        <img src="<?=FILES_DIR?>logo.webp" alt="logo" class="logo col-6">
      </div>
    </div>

    <div class="row justify-content-center py-5">
      <div class="col-lg-5 col-10">
	       <?php
	        if($_SERVER['REQUEST_METHOD'] == 'POST'){
	           echo '<p class="text-center">Accesso negado. Tente novamente.</p>';
	        }
	       ?>

         <h1 class="mt-0 mb-5">Veja as mensagens deixadas para você!</h1>

			     <form action="<?= ROOT.'admin'.DS.'4'?>" method="post" enctype="multipart/form-data" class="mt-5">

            <div class="form-group text-start pt-5">
               <label for="user">Usuário</label><br>
               <input type="text" name="user" class="form-control mt-0 form-control-lg"/><br>

               <label for="password">Senha</label><br>
               <input type="password" name="password" class="form-control mt-0 form-control-lg"/><br>
            </div>

            <div class="text-center mt-1">
   						<button type="submit" class="btn text-center submit-login transition px-5 py-3">Entrar</button>
   					</div>


            <div class="text-center btn-top-margin">
   						<a href="<?=ROOT?>" class="blue-text"><i class="fas fa-arrow-left"></i> Home</a>
   					</div>

		      </form>
		</div>

	</div>

  </div>
</body>
</html>

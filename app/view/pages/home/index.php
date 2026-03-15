
  <div class="container-fluid pt-5">

    <div class="row justify-content-center py-5">
      <div class="col-lg-5 col-10">
	       <?php
	        if($_SERVER['REQUEST_METHOD'] == 'POST'){
	           echo '<p class="text-center">Accesso negado. Tente novamente.</p>';
	        }
	       ?>


			     <form action="<?= ROOT.'feed'?>" method="post" enctype="multipart/form-data">

            <div class="form-group text-start pt-5">
               <label for="user">E-mail</label><br>
               <input type="email" name="user" class="form-control mt-0 form-control-lg"/><br>

               <label for="password">Senha</label><br>
               <input type="password" name="password" class="form-control mt-0 form-control-lg"/><br>
            </div>

            <div class="text-center mt-1">
   						<button type="submit" class="btn text-center submit-login transition px-5 py-3">Entrar</button>
   					</div>

		      </form>
		</div>

    <hr style="margin:120px 0 30px 0;">

    <div class="row justify-content-center py-3 mt-5">
      <div class="col-lg-5 col-10" style="font-size:0.8em; text-align:center;">
        Ainda não tem uma conta? Crie agora.
      </div>
    </div>

    <div class="row justify-content-center py-3">
      <div class="col-lg-5 col-10">
        <a href="register">
          <div class="home-btn my-5 text-center">
            Criar conta de <strong>Colaborador</strong>
          </div>
        </a>
        <a href="company">
          <div class="home-btn my-5 text-center">
            Criar conta de <strong>Empresa</strong>
          </div>
        </a>
      </div>
    </div>

	</div>

  </div>
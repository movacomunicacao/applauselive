<hr>
<div class="container-fluid pt-5">
  <div class="row justify-content-center py-5">
    <div class="col-lg-5 col-10">
      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo '<p class="text-center">Accesso negado. Tente novamente.</p>';
      }
      ?>

      <form action="<?= ROOT.'admin'.DS.'model'.DS.'createuser'.DS.'1'.DS.'1' ?>" method="post" enctype="multipart/form-data" class="mt-5">

        <div class="form-group text-start">
          <label for="username">Usuário</label>
          <input type="text" name="username" class="form-control mt-0 form-control-lg" />
        </div>

        <div class="form-group text-start mt-5">
          <label for="email">E-mail</label>
          <input type="email" name="email" class="form-control mt-0 form-control-lg" />
        </div>

        <div class="form-group text-start mt-5">
          <label for="password">Senha</label>
          <input type="password" name="password" class="form-control mt-0 form-control-lg" />
        </div>

        <div class="form-group text-center mt-5">
          <label for="avatar" class="custom-upload-avatar mt-5">
            <span id="avatar-text"><i class="fas fa-camera"></i><br>Escolher<br>Foto</span>
          </label>
          <input type="file" name="avatar" id="avatar" hidden />
        </div>

        <div class="row justify-content-center text-center my-5">
          <div class="spinner" id="loading" style="display:none;"></div>
        </div>

        <div class="text-center mt-3">
          <button type="submit" class="btn text-center submit-login transition">criar conta</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
  $('#avatar').on('change', function () {
    const fileName = this.files.length ? this.files[0].name : 'No file selected';
    $('#avatar-text').text(fileName);
  });

  $('#myForm').on('submit', function () {
    $('#loading').show();
    return true;
  });
</script>

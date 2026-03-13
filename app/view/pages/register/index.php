<?php
session_start();

$errors = $_SESSION['form_errors'] ?? [];
$old = $_SESSION['form_old'] ?? [];

unset($_SESSION['form_errors']);
unset($_SESSION['form_old']);

$namevalue = $old['username'] ?? '';
$emailvalue = $old['email'] ?? '';

$status_username = $errors['username'] ?? '';
$status_email = $errors['email'] ?? '';
$status_password = $errors['password'] ?? '';
$status_company = $errors['company'] ?? '';
$status_category = $errors['category'] ?? '';
?>

<hr>
<div class="container-fluid pt-5">
  <div class="row justify-content-center py-5">
    <div class="col-lg-5 col-10">

      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo '<p class="text-center">Accesso negado. Tente novamente.</p>';
      }
      ?>

      <form id="myForm" action="<?= ROOT.'admin'.DS.'model'.DS.'createuser'.DS.'1'.DS.'1' ?>" method="post" enctype="multipart/form-data" class="mt-5">

        <div class="form-group text-start">
        <label for="username">Usuário</label>
        <?php if($status_username): ?>
            <br><span class="error"><?= $status_username ?></span><br>
        <?php endif; ?>
        <input type="text" name="username" class="form-control mt-0 form-control-lg" value="<?= htmlspecialchars($namevalue) ?>" />
        </div>

        <div class="form-group text-start mt-5">
        <label for="email">E-mail</label>
        <?php if($status_email): ?>
            <br><span class="error"><?= $status_email ?></span><br>
        <?php endif; ?>
        <input type="email" name="email" class="form-control mt-0 form-control-lg" value="<?= htmlspecialchars($emailvalue) ?>" />
        </div>

        <div class="form-group text-start mt-5">
        <label for="company">Empresa</label>
        <?php if($status_company): ?>
            <br><span class="error"><?= $status_company ?></span>
        <?php endif; ?>
        <br>
        <select name="company" id="company" class="col-12 p-4 select">
          <option value="companychoice">Qual sua empresa?</option>
          <?php
              $conn = db();
              foreach($conn->query("SELECT * FROM company") as $row) {
                $id = $row['id'];
                $title = $row['title'];
                $selected = (($old['company'] ?? '') == $id) ? 'selected' : '';
                echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
              }
            ?>
        </select>
        </div>

        <div class="form-group text-start mt-5">
        <label for="category">Departamento</label>
        <?php if($status_category): ?>
          <br><span class="error"><?= $status_category ?></span>
        <?php endif; ?>
        <br>
        <select name="category" id="category" class="col-12 p-4 select">
          <option value="categorychoice">Qual seu departamento?</option>
          <?php
              $conn = db();
              foreach($conn->query("SELECT * FROM category ORDER BY title ASC") as $row) {
                $id = $row['id'];
                $title = $row['title'];
                $selected = (($old['category'] ?? '') == $id) ? 'selected' : '';
                echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
              }
            ?>
        </select>
        </div>

        <div class="form-group text-start mt-5">
        <label for="password">Senha</label>
        <?php if($status_password): ?>
            <br><span class="error"><?= $status_password ?></span><br>
        <?php endif; ?>
        <div class="password-wrapper">
            <input type="password" name="password" id="password" class="form-control mt-0 form-control-lg">
            <span class="toggle-eye" onclick="togglePassword('password', this)">
              <i class="far fa-eye"></i>
            </span>
          </div>
        </div>

        <div class="form-group text-start mt-5">
          <label for="confirmpassword">Confirmar Senha</label>
          <div class="password-wrapper">
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control mt-0 form-control-lg">
            <span class="toggle-eye" onclick="togglePassword('confirmpassword', this)">
              <i class="far fa-eye"></i>
            </span>
          </div>
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

function togglePassword(inputId, eye){

  const input = document.getElementById(inputId);
  const icon = eye.querySelector("i");

  if(input.type === "password"){
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
  }else{
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
  }

}

</script>

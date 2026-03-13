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
        <?php
        $namevalue = $emailvalue = $passwordvalue = '';
        $status_username = $status_email = $status_password = $status_company = $status_category = '';

        $id = $_GET['id'] ?? '';

        if ($id !== '') {

            $parts = explode('---', $id);
            $flag = $parts[0] ?? '';
            $username_return = $parts[1] ?? '';
            $email_return = $parts[2] ?? '';
            $company_return = $parts[3] ?? '';
            $category_return = $parts[4] ?? '';

            $namevalue = $username_return;
            $emailvalue = str_replace('-atsymbol-', '@', $email_return);

            if (strpos($flag, 'usernametaken') !== false) {
                $status_username = '<br><span class="error">Este usuário já existe, escolha outro.</span><br>';
                $emailvalue = str_replace('-atsymbol-', '@', $email_return);
                $namevalue = $username_return;
            }

            if (strpos($flag, 'emailtaken') !== false) {
                $status_email = '<br><span class="error">Este e-mail já existe, escolha outro.</span><br>';
                $namevalue = $username_return;
                $emailvalue = str_replace('-atsymbol-', '@', $email_return);
            }

            if (strpos($flag, 'unmatchingpass') !== false) {
                $status_password = '<br><span class="error">Senhas não batem, digite novamente.</span><br>';
                $namevalue = $username_return;
                $emailvalue = str_replace('-atsymbol-', '@', $email_return);
            }

            if (strpos($flag, 'emptycompany') !== false) {
                $status_company = '<br><span class="error">Selecione uma empresa.</span><br>';
            }

            if (strpos($flag, 'emptycategory') !== false) {
                $status_category = '<br><span class="error">Selecione um departamento.</span><br>';
            }
        }
        ?>

        <div class="form-group text-start">
        <label for="username">Usuário</label>
        <?=$status_username?>
        <input type="text" name="username" class="form-control mt-0 form-control-lg" value="<?=$namevalue?>" />
        </div>

        <div class="form-group text-start mt-5">
        <label for="email">E-mail</label>
        <?=$status_email?>
        <input type="email" name="email" class="form-control mt-0 form-control-lg" value="<?=$emailvalue?>" />
        </div>

        <div class="form-group text-start mt-5">
        <label for="username">Empresa</label>
        <?=$status_company?>
        <select name="company" id="company" class="col-12 p-4 select">
          <option value="companychoice">Qual sua empresa?</option>
          <?php
              $conn = db();
              foreach($conn->query("SELECT * FROM company") as $row) {
                $id = $row['id'];
                $title = $row['title'];
                $selected = ($company_return == $id) ? 'selected' : '';
                echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
              }
            ?>
        </select>
        </div>

        <div class="form-group text-start mt-5">
        <label for="username">Departamento</label>
        <?=$status_category?>
        <select name="category" id="category" class="col-12 p-4 select">
          <option value="categorychoice">Qual seu departamento?</option>
          <?php
              $conn = db();
              foreach($conn->query("SELECT * FROM category ORDER BY title ASC") as $row) {
                $id = $row['id'];
                $title = $row['title'];
                $selected = ($category_return == $id) ? 'selected' : '';
                echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
              }
            ?>
        </select>
        </div>

        <div class="form-group text-start mt-5">
        <label for="password">Senha</label>
        <?=$status_password?>
        <input type="password" name="password" class="form-control mt-0 form-control-lg" />
        </div>

        <div class="form-group text-start mt-5">
        <label for="password">Confirmar Senha</label>
        <input type="password" name="confirmpassword" class="form-control mt-0 form-control-lg" />
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

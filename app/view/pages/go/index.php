<?php
/**
 * Single-file wizard that preserves the original "one-field-per-screen" flow.
 *
 * IMPORTANT (routing):
 * This file is built to work in BOTH cases:
 * 1) Direct access: /go/index.php?step=name
 * 2) Friendly route via .htaccess: /go/?step=name  -> /index.php?page=go&step=name
 *
 * For case (2), your ROOT index.php router must include this file when page=go.
 */

declare(strict_types=1);

session_start();

echo '<style>header, footer{display:none;}</style>';

// -----------------------------
// Route-safe base URL helpers (works with your root .htaccess)
// -----------------------------

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// If this file is included by the ROOT router (index.php?page=go), SCRIPT_NAME will be /index.php.
// If accessed directly as a real file, SCRIPT_NAME will usually end with /go/index.php.
$isRoutedGo = (
  isset($_GET['page'])
  && $_GET['page'] === 'go'
  && basename($scriptName) === 'index.php'
  && !str_contains($scriptName, '/go/')
);

// Base used for form actions + redirects
// - Routed:   ROOT/go/?step=...
// - Direct:   index.php?step=...
if ($isRoutedGo) {

    if (defined('ROOT')) {
        $wizardBase = rtrim((string) ROOT, '/') . '/go/';
    } else {
        $wizardBase = '/go/';
    }

} else {
    $wizardBase = 'index.php';
}

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function wizard_url(string $base, string $step): string {
  if (str_contains($base, '?')) {
    $separator = '&';
  } else {
      $separator = '';
  }

  return $base . $separator . rawurlencode($step);
}

function redirect_to(string $base, string $step): void {
  header('Location: ' . wizard_url($base, $step));
  exit;
}

// -----------------------------
// Wizard config
// -----------------------------

$steps = ['start','name','email','password','category','people','type','message','finish'];

$step = $_GET['step'] ?? 'start';
if (!in_array($step, $steps, true)) $step = 'start';

if (!isset($_SESSION['wizard'])) $_SESSION['wizard'] = [];
$data = &$_SESSION['wizard'];

function step_index(array $steps, string $step): int {
  $i = array_search($step, $steps, true);
  return ($i === false) ? 0 : $i;
}
function prev_step(array $steps, string $step): ?string {
  $i = step_index($steps, $step);
  return $i > 0 ? $steps[$i-1] : null;
}
function next_step(array $steps, string $step): ?string {
  $i = step_index($steps, $step);
  return $i < count($steps)-1 ? $steps[$i+1] : null;
}

function validate_step(string $step, array $post, array &$data): array {
  $errors = [];

  $name     = trim((string)($post['name'] ?? ($data['name'] ?? '')));
  $email    = trim((string)($post['email'] ?? ($data['email'] ?? '')));
  $password = (string)($post['password'] ?? ($data['password'] ?? ''));
  $category = (string)($post['category'] ?? ($data['category'] ?? ''));
  $people   = (string)($post['people'] ?? ($data['people'] ?? ''));
  $type     = (string)($post['type'] ?? ($data['type'] ?? ''));

  if ($step === 'name') {
    if ($name === '') $errors['name'] = '*Campo vazio, preencha para continuar.';
    else $data['name'] = $name;
  }

  if ($step === 'email') {
    
    if ($email !== '') $needle = strtolower($email);
    if ($name === '') $errors['name'] = 'Nome ausente. Volte e preencha.';
    if ($email === '') {
      $errors['email'] = '*Campo vazio, preencha para continuar.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = '*E-mail inválido.';
    } elseif (strpos($needle, 'elancoah') === false) {
      $errors['email'] = '*E-mail inválido. Use um e-mail corporativo da Elanco.';
    } else {
      $data['name']  = $name;
      $data['email'] = $email;
    }
  }

  if ($step === 'password') {
    if ($name === '') $errors['name'] = 'Nome ausente. Volte e preencha.';
    if ($email === '') $errors['email'] = 'E-mail ausente. Volte e preencha.';
    if (trim($password) === '') $errors['password'] = '*Campo vazio, preencha para continuar.';
    else {
      $data['name']     = $name;
      $data['email']    = $email;
      $data['password'] = $password;
    }
  }

  if ($step === 'category') {
    if ($category === '' || $category === '0') $errors['category'] = '*Campo vazio, preencha para continuar.';
    else $data['category'] = $category;
  }

  if ($step === 'people') {
    if ($people === '') $errors['people'] = '*Campo vazio, preencha para continuar.';
    else $data['people'] = $people;
  }

  if ($step === 'type') {
    if ($type === '') $errors['type'] = '*Campo vazio, preencha para continuar.';
    else $data['type'] = $type;
  }

  if ($step === 'message') {
    if (($data['type'] ?? '') === 'text') {
      $msg = trim((string)($post['message'] ?? ''));
      if ($msg === '') $errors['message'] = '*Campo vazio, preencha para continuar.';
      else $data['message_text'] = $msg;
    } else {
      // NOTE: If you want redirects after upload, handle move_uploaded_file here and save filename in session.
      if (!isset($_FILES['message']) || ($_FILES['message']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        $errors['message'] = '*Envie (grave) um vídeo para continuar.';
      } else {
        $data['message_video'] = $_FILES['message'];
        $file = $data['message_video']['name'];
        $datename = date('Y-m-d-h-m-s');
        $video_title = $datename."---from-".$data['email']."-to-".$data['people']."---".$file;
        $data['video_full_title'] = $video_title;
        $message = '';

        $_UP['folder']	= 'app/webroot/videos/';
				move_uploaded_file($data['message_video']['tmp_name'], $_UP['folder'] . $video_title);

      }
    }
  }

  return $errors;
}

// -----------------------------
// POST handler
// -----------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postedStep = $_POST['step'] ?? $step;
    if (!in_array($postedStep, $steps, true)) {
        $postedStep = $step;
    }

    // ✅ FIRST: If user clicked "back", skip validation entirely
    if (isset($_POST['go']) && $_POST['go'] === 'back') {
        $prev = prev_step($steps, $postedStep);
        redirect_to($wizardBase, $prev ?? 'start');
    }

    // ✅ Only validate when moving forward
    $errors = validate_step($postedStep, $_POST, $data);

    if (!empty($errors)) {
        $_SESSION['wizard_errors'] = $errors;
        redirect_to($wizardBase, $postedStep);
    }

    $next = next_step($steps, $postedStep);
    redirect_to($wizardBase, $next ?? 'finish');
}

$errors = $_SESSION['wizard_errors'] ?? [];
unset($_SESSION['wizard_errors']);

?>

<style>
  body{background-color:#0073d4 !important;}
  .spinner { width: 100px; height: 100px; border: 7px solid #ccc; border-top: 4px solid #01559a; border-radius: 50%; animation: spin 1s linear infinite; }
  @keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<div class="container-fluid bg-blue">
  <div class="row justify-content-start text-start pt-4 ps-5">
    <div class="col-10 pt-3">
      <img src="<?=FILES_DIR?>logo_negativa.webp" alt="logo" class="col-3">
    </div>
  </div>
</div>

<div class="container-fluid gopages gopages-internal min-vh-100 d-flex align-items-center justify-content-center">
  <div class="row w-100">
    <div class="col-lg-8 col-11 text-center mx-auto">

      <?php if ($step === 'start'): ?>
        <h1 class="pt-5">
          <p class="mt-5">Olá!</p>
          <p>Seja bem-vindo(a) a<br>esta ação applause! Ruminantes<br></p>
        </h1>

        <form method="get" action="<?=h($wizardBase)?>name" class="mt-4">
          <input type="hidden" name="step" value="name">
          <button type="submit" class="btn btn-outline-light">Vamos iniciar!</button>
        </form>

        <div class="text-center btn-top-margin">
            <a href="/applauselive" class="back2">
                  <i class="fas fa-arrow-left"></i> voltar
            </a>
          </div>

      <?php elseif ($step === 'name'): ?>
        <form method="post" action="<?=h($wizardBase)?>">
          <input type="hidden" name="step" value="name">
          <div class="form-group text-start">
            <label>Nome*:</label>
            <?php if (!empty($errors['name'])): ?>
              <br><span class="error"><?=h((string)$errors['name'])?></span>
            <?php endif; ?>
            <input type="text" name="name" class="form-control mt-5 form-control-lg search" placeholder="Digite seu nome"
              value="<?=h((string)($data['name'] ?? ''))?>">
          </div>
          <div class="text-center btn-top-margin">
            <button type="submit" class="btn btn-home mt-4">continuar</button>
          </div>

          <div class="text-center btn-top-margin">
            <a href="/applauselive" class="back2">
                  <i class="fas fa-arrow-left"></i> voltar
            </a>
          </div>
          

        </form>

      <?php elseif ($step === 'email'): ?>
        <form method="post" action="<?=h($wizardBase)?>">
          <input type="hidden" name="step" value="email">
          <input type="hidden" name="name" value="<?=h((string)($data['name'] ?? ''))?>">

          <div class="form-group text-start">
            <label>E-mail Corporativo*:</label>
            <br><div class="tip">*Se você já se cadastrou antes, use o mesmo email.</div><br>

            <?php if (!empty($errors['email'])): ?>
              <br><span class="error"><?=h((string)$errors['email'])?></span>
            <?php endif; ?>

            <input type="email" name="email" class="form-control mt-5 form-control-lg search"
              placeholder="Digite seu E-mail corporativo"
              value="<?=h((string)($data['email'] ?? ''))?>">
          </div>

          <div class="text-center btn-top-margin">
            <button type="submit" class="btn btn-home mt-4">continuar</button>
          </div>

          <button type="submit" name="go" value="back" class="back" style="color:#fff !important;">
            <i class="fas fa-arrow-left"></i> voltar
          </button>
        </form>

      <?php elseif ($step === 'password'): ?>
        <form method="post" action="<?=h($wizardBase)?>">
          <input type="hidden" name="step" value="password">
          <input type="hidden" name="name" value="<?=h((string)($data['name'] ?? ''))?>">
          <input type="hidden" name="email" value="<?=h((string)($data['email'] ?? ''))?>">

          <div class="form-group text-start">
            <label>Senha*:</label>
            <br><div class="tip">*Se você já se cadastrou antes, use a mesma senha.</div><br>

            <?php if (!empty($errors['password'])): ?>
              <br><span class="error"><?=h((string)$errors['password'])?></span>
            <?php endif; ?>

            <input type="password" name="password" class="form-control mt-5 form-control-lg search" placeholder="Digite uma senha">
            <p class="mt-3">
              <a href="https://wa.me/5545999683799?text=Esqueci%20minha%20senha%20usuario%20<?=h((string)($data['email'] ?? ''))?>" class="tip">
                Esqueci minha senha
              </a>
            </p>
          </div>

          <div class="text-center btn-top-margin">
            <button type="submit" class="btn btn-home mt-4">continuar</button>
          </div>

          <button type="submit" name="go" value="back" class="back" style="color:#fff !important;">
            <i class="fas fa-arrow-left"></i> voltar
          </button>
        </form>

      <?php elseif ($step === 'category'): ?>
        <form method="post" action="<?=h($wizardBase)?>">
          <input type="hidden" name="step" value="category">

          <div class="form-group text-start">
            <label>Em qual área a pessoa que você quer enviar uma mensagem trabalha?*:</label>
            <?php if (!empty($errors['category'])): ?>
              <br><span class="error"><?=h((string)$errors['category'])?></span>
            <?php endif; ?>

            <select name="category" id="category" class="form-select" size="13" style="display:none;">
              <option value="0" id="categoryoption">0</option>
            </select>

            <p><br></p>

            <?php
              $conn = db();
              foreach($conn->query("SELECT * FROM category") as $row) {
                $id = $row['id'];
                $title = $row['title'];
                echo '<div class="option category-option" data-id="'.h((string)$id).'">'.h((string)$id).') '.h((string)$title).'</div>';
              }
            ?>
          </div>

          <div class="text-center mt-5">
            <button type="submit" class="btn btn-home">continuar</button>
          </div>

          <button type="submit" name="go" value="back" class="back" style="color:#fff !important;">
            <i class="fas fa-arrow-left"></i> voltar
          </button>
        </form>

        <script>
          $('.category-option').on('click', function() {
            var clickedId = $(this).data('id');
            $('#categoryoption').val(clickedId).trigger('change').prop('selected', true);
          });
          document.querySelectorAll('.category-option').forEach(card => {
            card.addEventListener('click', function() {
              document.querySelectorAll('.category-option').forEach(c => c.classList.remove('optionactive'));
              this.classList.add('optionactive');
            });
          });
        </script>

      <?php elseif ($step === 'people'): ?>
        <form method="post" action="<?=h($wizardBase)?>">
          <input type="hidden" name="step" value="people">
          <input type="hidden" name="people" value="">

          <div class="form-group text-start mt-5">
            <label>Para qual pessoa você quer enviar uma mensagem?*:</label>
            <?php if (!empty($errors['people'])): ?>
              <br><span class="error"><?=h((string)$errors['people'])?></span>
            <?php endif; ?>

            <p><br></p>

            <div class="row w-100">
              <?php
                $category = (string)($data['category'] ?? '');
                $conn = db();
                foreach($conn->query("SELECT * FROM people WHERE id_category = '$category' ") as $row) {
                  $id = $row['id'];
                  $img = $row['img'];
                  echo '
                    <div class="col-6 person" data-id="'.h((string)$id).'">
                      <img src="'.IMG_DIR.'people/'.h((string)$img).'" class="people-img col-12 p-3">
                    </div>
                  ';
                }
              ?>
            </div>
          </div>

          <div class="text-center mt-5">
            <button type="submit" class="btn btn-home mt-5">continuar</button>
          </div>

          <button type="submit" name="go" value="back" class="back" style="color:#fff !important;">
            <i class="fas fa-arrow-left"></i> voltar
          </button>
        </form>

        <script>
          document.querySelectorAll('.people-img').forEach(card => {
            card.addEventListener('click', function() {
              document.querySelectorAll('.people-img').forEach(c => c.classList.remove('active'));
              this.classList.add('active');
            });
          });

          $('.person').on('click', function() {
            var clickedId = $(this).data('id');
            $('input[name="people"]').val(clickedId);
          });
        </script>

      <?php elseif ($step === 'type'): ?>
        <form method="post" action="<?=h($wizardBase)?>">
          <input type="hidden" name="step" value="type">

          <div class="form-group text-start mt-5">
            <label>Como você quer enviar sua mensagem?*:</label>
            <?php if (!empty($errors['type'])): ?>
              <br><span class="error"><?=h((string)$errors['type'])?></span>
            <?php endif; ?>

            <select name="type" class="form-select" size="3" style="display:none;">
              <option id="typeoption" value="">0</option>
            </select>

            <p><br></p>

            <div class="option type-option" data-id="text">Texto</div>
            <div class="option type-option" data-id="video">Vídeo</div>
          </div>

          <div class="text-center btn-top-margin">
            <button type="submit" class="btn btn-home mt-5">continuar</button>
          </div>

          <button type="submit" name="go" value="back" class="back" style="color:#fff !important;">
            <i class="fas fa-arrow-left"></i> voltar
          </button>
        </form>

        <script>
          $('.type-option').on('click', function() {
            var clickedId = $(this).data('id');
            $('#typeoption').val(clickedId).trigger('change').prop('selected', true);
          });
          document.querySelectorAll('.type-option').forEach(card => {
            card.addEventListener('click', function() {
              document.querySelectorAll('.type-option').forEach(c => c.classList.remove('optionactive'));
              this.classList.add('optionactive');
            });
          });
        </script>

      <?php elseif ($step === 'message'): ?>
        <div class="row justify-content-center text-center">
          <div class="spinner" id="loading" style="display:none;"></div>
        </div>

        <form method="post" action="<?=h($wizardBase)?>" enctype="multipart/form-data" id="myForm">
          <input type="hidden" name="step" value="message">

          <div class="form-group text-center mt-5">
            <?php if (!empty($errors['message'])): ?>
              <span class="error"><?=h((string)$errors['message'])?></span><br><br>
            <?php endif; ?>

            <?php if (($data['type'] ?? '') === 'text'): ?>
              <label>Escreva aqui a sua mensagem*:</label>
              <textarea name="message" class="form-control mt-5" rows="12"><?=h((string)($data['message_text'] ?? ''))?></textarea>
            <?php else: ?>
              <label class="mb-5">Grave um vídeo CURTO de até 30 segundos*:</label>
              <label for="upload" class="custom-upload mt-5">
                <span id="upload-text"><i class="fas fa-video"></i> Gravar vídeo</span>
              </label>
              <input type="file" name="message" id="upload" hidden>
            <?php endif; ?>
          </div>

          <div class="text-center btn-top-margin">
            <button type="submit" class="btn btn-home mt-0" id="submitbtn">Enviar</button>
          </div>

          <button type="submit" name="go" value="back" class="back" style="color:#fff !important;">
            <i class="fas fa-arrow-left"></i> voltar
          </button>
        </form>

        <script>
          $('#upload').on('change', function () {
            var fileName = this.files.length ? this.files[0].name : 'No file selected';
            $('#upload-text').text(fileName);
          });

          $('#myForm').on('submit', function() {
            $('#loading').show();
            return true;
          });
        </script>

      <?php elseif ($step === 'finish'): ?>
        <h1 class="pt-2">
          <p class="mb-5">Mensagem<br>enviada com<br>sucesso!</p>
        </h1>


        <?php

          $name       = $data['name'];
          $email      = $data['email'];
          $password   = $data['password'];
          $category   = $data['category'];
          $people     = $data['people'];
          $type       = $data['type'];

          if($type == "text"){
            $message = $data['message_text'];
            $video_title = '';
          } else {
            $message = '';
            $video_title = $data['video_full_title'];
          }

          $key_sk   = random_bytes(32);
          $key_siv  = random_bytes(32);
          $key_sk   = base64_encode($key_sk);
          $key_siv  = base64_encode($key_siv);
          $key_sk   = hash("sha256", $key_sk);
          $key_siv  = substr(hash("sha256", $key_siv), 0, 16);

          $datenow = date('Y-m-d h:m:s');
          $crypted_password = encrypting("encrypt", $password, $key_sk, $key_siv);

          $conn = db();
          $query = $conn->prepare("SELECT email FROM users WHERE email = :email");
          $query->bindParam(':email', $email);
          $query->execute();

          if ($query->rowCount() > 0) {
            $keypass = $query->fetchColumn();
          } else {
            $created = date("Y-m-d");
            $updated = date("Y-m-d");
            $reference = date("Ymdhs") . uniqid();
            $active = '1';

            $query = $conn->prepare(
              "INSERT INTO users (title, email, password, keypass, key_iv, key_tag, created, updated, reference, active) 
               VALUES (:title, :email, :password, :keypass, :key_iv, :key_tag, :created, :updated, :reference, :active)"
            );

            $query->bindParam(':title', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $crypted_password);
            $query->bindParam(':keypass', $crypted_password);
            $query->bindParam(':key_iv', $key_sk);
            $query->bindParam(':key_tag', $key_siv);
            $query->bindParam(':created', $created);
            $query->bindParam(':updated', $updated);
            $query->bindParam(':reference', $reference);
            $query->bindParam(':active', $active);
            $query->execute();
          }

          $query = $conn->prepare("SELECT title FROM people WHERE id = :people");
          $query->bindParam(':people', $people);
          $query->execute();
          $people_name = $query->fetchColumn();

          $sql = "INSERT INTO messages (id_typeform, name, email, password, recipient, como, upload, text_message, response_type, start_date, stage_date, submit_date, network_id, tags, ending) 
              VALUES ('id_typeform', :name, :email, :password, :people_name, :type, :video_title, :message, :type, :datenow, :datenow, :datenow, 'network_id', 'tag', 'ending')";

          $query = $conn->prepare($sql);
          $query->bindParam(':name', $name);
          $query->bindParam(':email', $email);
          $query->bindParam(':password', $crypted_password);
          $query->bindParam(':people_name', $people_name);
          $query->bindParam(':type', $type);
          $query->bindParam(':video_title', $video_title);
          $query->bindParam(':message', $message);
          $query->bindParam(':datenow', $datenow);
          $query->execute();



        ?>

        <div class="row justify-content-center text-center btn-top-margin">
          <div class="col-10 mt-5">
            <a href="<?=ROOT?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> Home</a>
          </div>
        </div>

      <?php endif; ?>

    </div>
  </div>
</div>

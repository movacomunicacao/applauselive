<?php
session_start();

$errors = $_SESSION['form_errors'] ?? [];
$old = $_SESSION['form_old'] ?? [];

unset($_SESSION['form_errors']);
unset($_SESSION['form_old']);

$nomevalue = $old['nome'] ?? '';
$descricaovalue = $old['descricao'] ?? '';
$corprincipalvalue = $old['cor_principal'] ?? '';
$cortextovalue = $old['cor_texto'] ?? '';

$status_nome = $errors['nome'] ?? '';
$status_logo = $errors['logo'] ?? '';
$status_descricao = $errors['descricao'] ?? '';
$status_cor_principal = $errors['cor_principal'] ?? '';
$status_cor_texto = $errors['cor_texto'] ?? '';
?>

<hr>
<div class="container-fluid pt-5">
<div class="row justify-content-center py-5">
<div class="col-lg-5 col-10">

<form id="myForm" action="<?= ROOT.'admin'.DS.'model'.DS.'createcompany'.DS.'1'.DS.'1' ?>" method="post" enctype="multipart/form-data" class="mt-5">

<!-- Logo -->
<div class="form-group text-center mt-5">

<?php if($status_logo): ?>
<span class="error"><?= $status_logo ?></span><br>
<?php endif; ?>

<label for="logo" class="logo-upload">

    <img id="logo-preview" src="" alt="" style="display:none;">

    <div id="logo-placeholder">
        <i class="fas fa-camera"></i>
        <p>Escolher Logo</p>
    </div>

</label>

<input type="file" name="logo" id="logo" accept="image/*" hidden>

</div>

<!-- Nome -->
<div class="form-group text-start">
<label for="nome">Nome</label>
<?php if($status_nome): ?>
<br><span class="error"><?= $status_nome ?></span><br>
<?php endif; ?>
<input type="text" name="nome" class="form-control mt-0 form-control-lg" value="<?= htmlspecialchars($nomevalue) ?>" />
</div>



<!-- Descrição -->
<div class="form-group text-start mt-5">
<label for="descricao">Descrição</label>
<?php if($status_descricao): ?>
<br><span class="error"><?= $status_descricao ?></span><br>
<?php endif; ?>
<textarea name="descricao" class="form-control form-control-lg textarea"><?= htmlspecialchars($descricaovalue) ?></textarea>
</div>

<!-- Cor Principal -->
<div class="form-group text-start mt-5">
<label for="cor_principal">Cor Principal</label>
<?php if($status_cor_principal): ?>
<br><span class="error"><?= $status_cor_principal ?></span><br>
<?php endif; ?>
<input type="color" name="cor_principal" value="<?= htmlspecialchars($corprincipalvalue) ?>" class="form-control form-control-lg colorpicker">
</div>

<!-- Cor Texto -->
<div class="form-group text-start mt-5">
<label for="cor_texto">Cor Texto</label>
<?php if($status_cor_texto): ?>
<br><span class="error"><?= $status_cor_texto ?></span><br>
<?php endif; ?>
<input type="color" name="cor_texto" value="<?= htmlspecialchars($cortextovalue) ?>" class="form-control form-control-lg colorpicker">
</div>

<div class="row justify-content-center text-center my-5">
<div class="spinner" id="loading" style="display:none;"></div>
</div>

<div class="text-center mt-3">
<button type="submit" class="btn text-center submit-login transition">
criar empresa
</button>
</div>

</form>

</div>
</div>
</div>

<script>

$('#logo').on('change', function () {

  const fileName = this.files.length
      ? this.files[0].name
      : 'No file selected';

  $('#logo-text').text(fileName);

});

$('#myForm').on('submit', function () {

  $('#loading').show();
  return true;

});


$('#logo').on('change', function(){

    const file = this.files[0];

    if(!file) return;

    const reader = new FileReader();

    reader.onload = function(e){

        $('#logo-preview')
            .attr('src', e.target.result)
            .show();

        $('#logo-placeholder').hide();

    };

    reader.readAsDataURL(file);

});

</script>


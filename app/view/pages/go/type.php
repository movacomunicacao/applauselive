<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 


    if(isset($_POST['people']) AND !empty($_POST['people'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $category = $_POST['category'];
        $people = $_POST['people'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $category = $_GET['category'];
        $people = $_GET['people'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $category = $_GET['category'];
        $people = $_GET['people'];
    } 
    else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $category = $_POST['category'];
        header("Location:".ROOT."app/view/pages/go/people.php?status=missing&name=".$name."&email=".$email."&password=".$password."&category=".$category);
    }
    
?>


<style>
    body{background-color:#0073d4 !important;}
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
        <form action="<?=ROOT?>app/view/pages/go/message.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-start mt-5">
                <label for="name">Como você quer enviar sua mensagem?*:</label>
                <?php
                    if(isset($_GET['status'])){
                        if($_GET['status'] == "missing"){
                            echo '<br><span class="error">*Campo vazio, preencha para continuar.</span>';
                        }
                    }
                ?>
                <input type="hidden" name="name" value="<?=$name?>">
                <input type="hidden" name="email" value="<?=$email?>">
                <input type="hidden" name="password" value="<?=$password?>">
                <input type="hidden" name="category" value="<?=$category?>">
                <input type="hidden" name="people" value="<?=$people?>">
                <p><br></p>

                <select name="type" class="form-select" size="3" aria-label="category" class="pt-5" style="display:none;">
                    <option id="typeoption" value="">0</option>
                </select>

                <div class="option" id="text">Texto</div>
                <div class="option" id="video">Vídeo</div>


            </div>
            <div class="text-center btn-top-margin">
                <input type="submit" class="btn btn-home mt-5" value="continuar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>app/view/pages/go/people.php?status=back&name=<?=$name?>&email=<?=$email?>&password=<?=$password?>&category=<?=$category?>&people=<?=$people?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

</div>


<script>
    $('.option').on('click', function() {
        var clickedId = $(this).attr('id');
        $('#typeoption').val(clickedId).trigger('change');
        $('#typeoption').prop('selected', true);
    });
</script>

<script>
  document.querySelectorAll('.option').forEach(card => {
    card.addEventListener('click', function() {
      document.querySelectorAll('.option').forEach(c => c.classList.remove('optionactive'));
      this.classList.add('optionactive');
    });
  });
</script>



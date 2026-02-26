<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 


    if(isset($_POST['password']) AND !empty($_POST['password'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
    } 
    else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        header("Location:".ROOT."app/view/pages/go/password.php?status=missing&name=".$name."&email=".$email);
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
        <form action="<?=ROOT?>app/view/pages/go/people.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-start">
                <label for="name">Em qual área a pessoa que você quer enviar uma mensagem trabalha?*:</label>
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
                <p><br></p>

                <select name="category" id="category" class="form-select" size="13" aria-label="category" class="pt-5" style="display:none;">
                    <option value="0" id="categoryoption">0</option>
                </select>

                <?php
                    $conn = db();
                        foreach($conn->query("SELECT * FROM category") as $row) {
                            $id     = $row['id'];
                            $title  = $row['title'];

                            echo '
                            <div class="option" id="'.$id.'">'.$id.')  '.$title.'</div>
                            ';
                        }
                    ?>


                
                
            </div>
            <div class="text-center mt-5">
                <input type="submit" class="btn btn-home" value="continuar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>app/view/pages/go/password.php?status=back&name=<?=$name?>&email=<?=$email?>&password=<?=$password?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

  <script>
    $('.option').on('click', function() {
        var clickedId = $(this).attr('id');
        //$('input[name="people"]').val(clickedId);
        $('#categoryoption').val(clickedId).trigger('change');
        $('#categoryoption').prop('selected', true);
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

    


</div>






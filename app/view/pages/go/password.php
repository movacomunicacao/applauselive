<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 


    if(isset($_POST['email']) AND !empty($_POST['email'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
        $email = $_GET['email'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
        $email = $_GET['email'];
    } 
    else {
        $name = $_POST['name'];
        header("Location:".ROOT."app/view/pages/go/email.php?status=missing&name=".$name);
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
        <form action="<?=ROOT?>app/view/pages/go/category.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-start">
                <label for="name">Senha*:</label>
                <br><div class="tip">*Se você já se cadastrou antes, use a mesma senha.</div><br>
                <?php
                    if(isset($_GET['status'])){
                        if($_GET['status'] == "missing"){
                            echo '<br><span class="error">*Campo vazio, preencha para continuar.</span>';
                        }
                    }
                ?>
                <input type="hidden" name="name" value="<?=$name?>">
                <input type="hidden" name="email" value="<?=$email?>">
                <input type="password" name="password" class="form-control mt-5 form-control-lg search" placeholder="Digite uma senha">
                <p>
                    <br><div>
                        <a href="https://wa.me/5545999683799?text=Esqueci%20minha%20senha%20usuario%20<?=$email?>" class="tip" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                            Esqueci minha senha
                        </a>
                    </div><br>
                </p>
            </div>
            <div class="text-center btn-top-margin">
                <input type="submit" class="btn btn-home mt-4" value="continuar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>app/view/pages/go/email.php?status=back&name=<?=$name?>&email=<?=$email?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

    


</div>






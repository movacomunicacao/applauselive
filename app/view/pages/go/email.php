<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 

    if(isset($_POST['name']) AND !empty($_POST['name'])){
        $name = $_POST['name'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "notelanco"){
        $name = $_GET['name'];
    } 
    else {
        header("Location:".ROOT."app/view/pages/go/name.php?status=missing&name=".$name);
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
        <form action="<?=ROOT?>app/view/pages/go/password.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-start">
                <label for="name">E-mail Corporativo*:</label>
                <br><div class="tip">*Se você já se cadastrou antes, use o mesmo email.</div><br>
                <?php
                    if(isset($_GET['status'])){
                        if($_GET['status'] == "missing"){
                            echo '<br><span class="error">*Campo vazio, preencha para continuar.</span>';
                        } elseif($_GET['status'] == "notelanco"){
                            echo '<br><span class="error">*E-mail inválido. Use um e-mail corporativo da Elanco.</span>';
                        }
                    }
                ?>
                <input type="hidden" name="name" value="<?=$name?>">
                <input type="email" name="email" class="form-control mt-5 form-control-lg search" placeholder="Digite seu E-mail corporativo">
            </div>
            <div class="text-center btn-top-margin">
                <input type="submit" class="btn btn-home mt-4" value="continuar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>app/view/pages/go/name.php?status=back&name=<?=$name?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

    


</div>






<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 

    if(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
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
        <form action="<?=ROOT?>app/view/pages/go/email.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-start">
                <label for="name">Nome*:</label>
                <?php
                    if(isset($_GET['status'])){
                        if($_GET['status'] == "missing"){
                            echo '<br><span class="error">*Campo vazio, preencha para continuar.</span>';
                        }
                    }
                ?>
                <input type="text" name="name" class="form-control mt-5 form-control-lg search" placeholder="Digite seu nome">
            </div>
            <div class="text-center btn-top-margin">
                <input type="submit" class="btn btn-home mt-4" value="continuar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>go/" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

    


</div>






<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 


    if(isset($_POST['type']) AND !empty($_POST['type'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $category = $_POST['category'];
        $people = $_POST['people'];
        $type = $_POST['type'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $category = $_GET['category'];
        $people = $_GET['people'];
        $type = $_GET['type'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $category = $_GET['category'];
        $people = $_GET['people'];
        $type = $_GET['type'];
    } 
    else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $category = $_POST['category'];
        $people = $_POST['people'];
        header("Location:".ROOT."app/view/pages/go/type.php?status=missing&name=".$name."&email=".$email."&password=".$password."&category=".$category."&people=".$people);
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
        <form action="<?=ROOT?>app/view/pages/go/finish.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-center mt-5">

                <input type="hidden" name="name" value="<?=$name?>">
                <input type="hidden" name="email" value="<?=$email?>">
                <input type="hidden" name="password" value="<?=$password?>">
                <input type="hidden" name="category" value="<?=$category?>">
                <input type="hidden" name="people" value="<?=$people?>">
                <input type="hidden" name="type" value="<?=$type?>">



                <?php

                if(isset($_POST['type']) AND !empty($_POST['type'])){
                    $type = $_POST['type'];

                    if($type == "text"){
                        echo '
                            <label for="name">Escreva aqui a sua mensagem*:</label>
                            <textarea name="message" class="form-control mt-5" id="messsage" rows="12"></textarea>
                        ';

                    } elseif($type == "video"){

                        echo '
                        <label for="name" class="mb-5">Grave um vídeo CURTO de até 30 segundos*:</label>
                        <label for="upload" class="custom-upload mt-5">
                            <span id="upload-text"><i class="fas fa-video"></i> Gravar vídeo</span>
                        </label>
                        <input type="file" name="message" id="upload" hidden>
                        ';

                    }
                }

                ?>

                <div class="row justify-content-center text-center">
                    <div class="col-10" id="loading" style="display:none;">
                        <img src="<?=FILES_DIR?>loading.gif" alt="loading" >
                    </div>
                </div>
                

            </div>
            <div class="text-center btn-top-margin">
                <input type="submit" class="btn btn-home mt-0" id="submitbtn" value="Enviar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>app/view/pages/go/type.php?status=back&name=<?=$name?>&email=<?=$email?>&password=<?=$password?>&category=<?=$category?>&people=<?=$people?>&type=<?=$type?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

</div>


<script>
    $('#upload').on('change', function () {
        var fileName = this.files.length ? this.files[0].name : 'No file selected';
        $('#upload-text').text(fileName);
    });

    $('#upload').on('click', function () {
        $("#loading").css({"display":"block","color":"white");
    });

</script>



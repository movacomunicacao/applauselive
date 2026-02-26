<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php'; 


    if(isset($_POST['category']) AND !empty($_POST['category'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $category = $_POST['category'];
    }
    elseif(isset($_GET['status']) AND $_GET['status'] == "back"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $category = $_GET['category'];
    } 
    elseif(isset($_GET['status']) AND $_GET['status'] == "missing"){
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];
        $category = $_GET['category'];
    } 
    else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        header("Location:".ROOT."app/view/pages/go/category.php?status=missing&name=".$name."&email=".$email."&password=".$password);
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
        <form action="<?=ROOT?>app/view/pages/go/type.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-start mt-5">
                <label for="name">Para qual pessoa você quer enviar uma mensagem?*:</label>
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
                <input type="hidden" name="people" value="">
                <p><br></p>
                <div class="row w-100">
                    <?php
                    $conn = db();
                        foreach($conn->query("SELECT * FROM people WHERE id_category = '$category' ") as $row) {
                            $id     = $row['id'];
                            $title  = $row['title'];
                            $img    = $row['img'];

                            echo '
                            <div class="col-6 person" id="'.$id.'">
                                <img src="'.IMG_DIR.'people/'.$img.'" class="people-img col-12 p-3">
                            </div>';
                        }
                    ?>
                </div>
            </div>
            <div class="text-center mt-5">
                <input type="submit" class="btn btn-home mt-5" value="continuar">
            </div>
        </form>
    </div>

    <div class="row justify-content-center text-center pt-5 mt-5">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>app/view/pages/go/category.php?status=back&name=<?=$name?>&email=<?=$email?>&password=<?=$password?>&category=<?=$category?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> voltar</a>
        </div>
    </div>

  </div>

</div>


<script>
  document.querySelectorAll('.people-img').forEach(card => {
    card.addEventListener('click', function() {
      document.querySelectorAll('.people-img').forEach(c => c.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

<script>
    $('.person').on('click', function() {
        var clickedId = $(this).attr('id');
        $('input[name="people"]').val(clickedId);
    });
</script>






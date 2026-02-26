<?php 
    include '../../../../app/config/database.php'; 
    include '../../../../app/config/directories.php'; 
    include '../../../../app/view/elements/site/head.php';     
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

        <?php

            $name       = $_POST['name'];
            $email      = $_POST['email'];
            $password   = $_POST['password'];
            $category   = $_POST['category'];
            $people     = $_POST['people'];
            $type       = $_POST['type'];

            if($type == "text"){
                $message = $_POST['message'];
                $video_title = '';
            } else {
                $file = $_FILES['message']['name'];
                $datename = date('Y-m-d-h-m-s');
                $title		= $datename.'---'.$name.'-to-'.$people.'---'.$file;
                $video_title = $title;
                $message = '';
                $_UP['folder']	= '../../../../app/webroot/videos/';
				move_uploaded_file($_FILES['message']['tmp_name'], $_UP['folder'] . $video_title);
            }

            /*
            echo "
            <br>
            $name<br>
            $email<br>
            $password<br>
            $category<br>
            $people<br>
            $type<br>
            $message<br>
            ";
            */

            

            $key_sk   = random_bytes(32);
            $key_siv  = random_bytes(32);
            $key_sk   = base64_encode($key_sk);
            $key_siv  = base64_encode($key_siv);
            $key_sk   = hash("sha256", $key_sk);
            $key_siv  = substr(hash("sha256", $key_siv), 0, 16);

            function encrypting($action, $string, $key_sk, $key_siv){
            $cypher_method = "AES-256-CBC";
            $output = false;
            if ($action == "encrypt"){
                $key    = $key_sk;
                $iv     = $key_siv;
                $output = openssl_encrypt($string, $cypher_method, $key, 0, $iv);
                $output = base64_encode($output);
            } else if($action == "decrypt"){
                $key    = $key_sk;
                $iv     = $key_siv;
                $output = base64_decode($string);
                $output = openssl_decrypt($output, $cypher_method, $key, 0, $iv);
            }
            return $output;
            } //endfunction

            $datenow = date('Y-m-d h:m:s');
            $crypted_password = encrypting("encrypt", $password, $key_sk, $key_siv);

            $conn = db();
            $query	= $conn->prepare("SELECT email FROM users WHERE email= :email");
            $query->bindParam(':email', $email);
            $query->execute();

            if ($query->rowCount() > 0){
                $keypass = $query->fetchColumn();
                //$value = $csv[$i][$j];
            } else {
                
                $created  = date("Y-m-d");
                $updated  = date("Y-m-d");
                $reference = date("Ymdhs").uniqid();
                $active   = '1';

                $query 	= $conn->prepare("INSERT INTO users (title, email, password, keypass, key_iv, key_tag, created, updated, reference, active) VALUES(:title, :email, :password, :keypass, :key_iv, :key_tag, :created, :updated, :reference, :active)");

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

            $query	= $conn->prepare("SELECT title FROM people WHERE id= :people");
            $query->bindParam(':people', $people);
            $query->execute();
            $people_name = $query->fetchColumn();

            $sql = " INSERT INTO messages (id_typeform, name, email, password, recipient, como, upload, text_message, response_type, start_date, stage_date, submit_date, network_id, tags, ending) VALUES ('id_typeform', '$name', '$email', '$crypted_password', '$people_name', '$type', '$video_title', '$message', 'response_type', '$datenow', '$datenow', '$datenow', 'network_id', 'tag', 'ending') ";
            $query = $conn->prepare($sql); 
            $query->execute();

            //echo '<br>'.$sql.'<br>';
            
            
        ?>        

        <h1 class="pt-2">
        <p class="mb-5">
          Mensagem<br>enviada com<br>sucesso!
        </p>
        </h1>

    </div>

    <div class="row justify-content-center text-center btn-top-margin">
        <div class="col-10 mt-5">
           <a href="<?=ROOT?>" style="color:#fff !important;"><i class="fas fa-arrow-left"></i> Home</a>
        </div>
    </div>

  </div>
</div>

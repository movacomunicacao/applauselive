<?php

//include('../../../../upload/output/test.php');

$name = $_POST['name'];
$file = $_POST['myfile'];

$_UP['folder']	= '../webroot/img/'.$table.'/';
move_uploaded_file($_FILES['img']['tmp_name'], $_UP['folder'] . $img);

echo "Nome: " . $name . "<br>";
echo "Arquivo: " . $file . "<br>";	


?>
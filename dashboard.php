<?php

include 'app/config/database.php';

$conn = db();

echo '<p><h1>Recipientes:</h1>';
foreach($conn->query("SELECT DISTINCT recipient FROM messages ORDER BY recipient ASC") as $row) {
	$recipient		= $row['recipient'];
    echo $recipient.'<br>';
}

echo '</p><br>';

echo '<p><h1>Remetentes:</h1>';
foreach($conn->query("SELECT DISTINCT email FROM messages ORDER BY email ASC") as $row) {
    $sender		= $row['email'];  
    echo $sender.'<br>';
}

echo '</p><br>';

echo '<h1>Total Mensagens:</h1>';
$stmt = $conn->query("SELECT COUNT(*) FROM messages");
$count = $stmt->fetchColumn();
echo $count;


?>


<p><br><br></p><p><br><br></p>
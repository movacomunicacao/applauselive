<?php

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

$pass = encrypting("decrypt", "WGRocDZJUmVnVCttR0V2aXpkbGlsQT09", "334ade11f315e868681b99f00054ae2ddfcb9f8968742ef81afa2db2d286d2e6", "1f18a2ee2b4dcf55");

echo $pass;

?>
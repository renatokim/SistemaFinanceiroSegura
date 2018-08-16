<?php
session_start();

$dataini = $_POST['dataini'];
$datafin = $_POST['datafin'];

$_SESSION['dataini_rel_banco'] = $dataini;
$_SESSION['datafin_rel_banco'] = $datafin;

header("location:relatbanco.php");



?>





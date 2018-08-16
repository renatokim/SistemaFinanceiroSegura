<?php 
session_start();

//print_r($_POST); die();
require_once('../config/alt_desc.class.php');

$caixa = new Alt_ext;

$registro = $_POST['ID'];
//$data = $_POST['DATA_EMISSAO'];
//$historico = $_POST['HISTORICO'];
$doc = $_POST['NUMERO_DOC'];
//$valor = $_POST['VALOR'];
$obs = $_POST['OBS'];

//$historico = str_replace('_', ' ', $historico);
$obs = str_replace('_', ' ', $obs);
$doc = str_replace('_', ' ', $doc);

$REG = $caixa->atualiza_desc($registro, $obs, $doc);

print_r($REG);

header("location:relatbanco.php");


?>
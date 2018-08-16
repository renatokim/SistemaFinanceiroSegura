<?php 
session_start();
require_once('caixa_class.php');

$caixa = new Caixa_relatorio;

$registro = $_POST['ID'];
$data = $_POST['DATA_EMISSAO'];
$historico = $_POST['HISTORICO'];
$doc = $_POST['DOC'];
$valor = $_POST['VALOR'];
$obs = $_POST['OBS'];

$historico = str_replace('_', ' ', $historico);
$obs = str_replace('_', ' ', $obs);

$REG = $caixa->atualiza_caixa($registro, $data, $historico, $doc, $valor, $obs);

print_r($REG);

header("location:caixa_relatorio.php");


?>
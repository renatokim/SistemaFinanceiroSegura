<?php

echo "<title>RELATORIO DE CONTA CAIXA</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$id = $_POST['ID'];
$obs = $_POST['NOME'];

$obs = str_replace('_', ' ', $obs);

$a = $relatorio->setcx($id, $obs);



header("location:set_conta_caixa.php");

	

?>





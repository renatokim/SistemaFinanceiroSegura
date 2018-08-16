<?php 
session_start();

require_once('../config/relatorios.class.php');
$relatorio = new Relatorio;
$relatorio->conexao();

$registro = $_POST['ID'];
$valor = $_POST['VALOR'];
$tipo = $_POST['TIPO'];


$valor = str_replace(',', '.', $valor);

$relatorio->set_ajust_lancado($registro, $tipo, $valor);

header("location:editar_ajustes.php");

?>
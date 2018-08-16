<?php



//  EXCLUI UM AJUSTE
require_once('../config/relatorios.class.php');
$relatorio = new Relatorio;
$relatorio->conexao();
 
$registro = $_POST['id'];

$valor = str_replace(',', '.', $_POST['valor']);

$sql = "update `ajustes` set vlr_or_pecent ='" . $_POST['vlr_or_pecent'] . "', valor =" . $valor . "  WHERE id = " . $registro;

//die($sql);

$resultado = $relatorio->query($sql);



header("location:../relatorios/relat_cad_ajustes.php");




?>







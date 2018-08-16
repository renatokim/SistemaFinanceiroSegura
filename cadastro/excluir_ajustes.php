<?php
//  EXCLUI UM AJUSTE
require_once('../config/relatorios.class.php');
$relatorio = new Relatorio;
$relatorio->conexao();

if(!isset($_GET['id'])) die('acesso restrito');;
 
$registro = $_GET['id'];

//print_r($registro); die();

$resultado = $relatorio->delete_ajuste($registro);

header("location:../relatorios/relat_cad_ajustes.php");
	




?>








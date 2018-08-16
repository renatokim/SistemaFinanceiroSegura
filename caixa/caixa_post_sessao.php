<?php 
session_start();
require_once('caixa_class.php');
require_once('../config/relatorios.class.php');

$_SESSION['dataini'] = $_POST['dataini'];
$_SESSION['datafin'] = $_POST['datafin'];
$_SESSION['conta_corrente'] = $_POST['conta_corrente'];

header("location:caixa_relatorio.php");


?>
<?php 
session_start();
require_once('cheque_class.php');

//echo "<pre>"; print_r($_POST); die();

$cheque = new Cheque_relatorio;

$registro = $_POST['ID'];
$data = $_POST['DATA_VENCIMENTO'];
$historico = $_POST['HISTORICO'];
$doc = $_POST['DOC'];
$valor = $_POST['VALOR']; $valor = str_replace(',', '.', $valor);
$dt_baixa = $_POST['DTBX'];
if($_POST['DTBX'] == '') $dt_baixa = NULL;


$REG = $cheque->atualiza_cheque($registro, $data, $historico, $doc, $valor, $dt_baixa);

header("location:cheque_relatorio_numero.php");


?>
<?php 
session_start();
require_once('cheque_class.php');
require_once('../config/relatorios.class.php');

$_SESSION['dataini_chq'] = $_POST['dataini_chq'];
$_SESSION['datafin_chq'] = $_POST['datafin_chq'];
$_SESSION['conta_corrente_chq'] = $_POST['conta_corrente_chq']; 

$tipo_relatorio = $_POST['TIPORELATORIO'];

switch ($tipo_relatorio) {
  case 'cheque_relatorio_numero':
    header("location:cheque_relatorio_numero.php");
    break;
  case 'cheque_relatorio_data':
    header("location:cheque_relatorio_data.php");
    break;
  case 'cheque_relatorio_pendente':
    header("location:cheque_relatorio_pendente.php");
    break;
  default:
    exit;
    break; 
}   

?>
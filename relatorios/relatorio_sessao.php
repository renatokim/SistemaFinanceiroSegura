<?php 
session_start();

//$_SESSION['conta_corrente_chq'] = $_POST['conta_corrente_chq'];
 

$tipo_relatorio = $_POST['tipo_relatorio'];

switch ($tipo_relatorio) {
  case 'relatbanco':
    $_SESSION['dataini_relat_bco'] = $_POST['dataini_relat_bco'];
    $_SESSION['datafin_relat_bco'] = $_POST['datafin_relat_bco'];
    header("location:relatbanco.php");
    break;

  case 'relatoriodata':

    $_SESSION['dataini_relat_dt'] = $_POST['dataini_relat_bco'];
    $_SESSION['datafin_relat_dt'] = $_POST['datafin_relat_bco']; 
    header("location:relatoriodata.php");
    break;

  case 'relatcntcx':
    $_SESSION['dataini_relat_cnt'] = $_POST['dataini_relat_bco'];
    $_SESSION['datafin_relat_cnt'] = $_POST['datafin_relat_bco'];  
    header("location:relatcntcx.php");
    break;
  default:
    exit;
    break; 
}   

?>
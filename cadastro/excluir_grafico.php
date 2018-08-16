<?php

$acao = $_GET;

require_once("../config/relatorios.class.php");

$excluir = new Relatorio;

$excluir->conexao();
if ($acao['acao'] == 'excluir') $excluir->delete_grafico($acao['id']);
 
  
header("location:lista_graficos.php");
  
  





?>
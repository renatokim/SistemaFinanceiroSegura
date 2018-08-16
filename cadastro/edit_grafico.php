<?php

require_once("../config/relatorios.class.php");

$alterar = new Relatorio;
$alterar->conexao();


$edit = $_POST;

$nome = $edit['NOME'];
$nome = str_replace('_', ' ', $nome);
$nome = strtoupper($nome);
$id = $edit['id'];



$alterar->alterar_grafico($id, $nome);

header("location:lista_graficos.php");
  
  





?>
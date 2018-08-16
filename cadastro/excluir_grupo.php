<?php

$acao = $_GET;

require_once("../config/relatorios.class.php");

$excluir = new Relatorio;

$excluir->conexao();

$id_grupo = $acao['id'];

$sql = "SELECT id_cadastro_grafico, seq_grupo FROM cadastro_grupos WHERE id=$id_grupo";

$resultado = $excluir->query($sql);
$date = $excluir->fetch_array($resultado);

$sql = "DELETE FROM contacaixa_grupos WHERE id_grafico=$date[0] AND seg_grupo=$date[1]";
$resultado = $excluir->query($sql);

//print_r($date); die();

if ($acao['acao'] == 'excluir') $excluir->delete_grupo($acao['id']);
 
  
header("location:lista_grupos.php");
  
  





?>
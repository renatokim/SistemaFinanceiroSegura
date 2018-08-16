<?php

echo "<title>CAIXA</title>";
require_once("../config/caixa.class.php");

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR

$id_conta = $_POST['contas'];
$data_inicial = $_POST['data_inicial'];
$data_final = $_POST['data_final'];

$excluir = new caixa;

$sql = "UPDATE extratos 
		SET data_emissao = '0000-00-00'
			WHERE id_conta_corrente=$id_conta 
			AND data_emissao>='$data_inicial'
			AND data_emissao<='$data_final'";
 
$excluir->conexao();
$resultado = $excluir->query($sql);

echo "<script> alert('LINHAS EXCLUIDAS!') </script>";
echo "<script> window.close(); </script>";

?>

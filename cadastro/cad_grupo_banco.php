<?php

echo "<title>CADASTRO DE CONTAS</title>";

require_once("../config/relatorios.class.php");

$cadastro = new Relatorio;
$cadastro->conexao();

$id_grafico = $_POST['id_grafico'];
$nome = $_POST['nome_grupo'];
$nome = str_replace(' ', '_', $nome);
$nome = strtoupper($nome);

$opt = $_POST['opt'];



// SELECIONA O NUM DA ULTIMA SEQ
$seq = $cadastro->get_max_id_grupo($id_grafico);

/*
echo '<pre>';
echo "seq:"; print_r($seq);echo '<br>';
print_r($_POST); die();

*/
$cadastro->add_grupo($id_grafico, $seq, $nome);

foreach ($opt as $key => $value) {


$result = $cadastro->add_cnxt_grupo($id_grafico, $seq, $value);


}




echo "GRUPO CADASTRADO!!!";


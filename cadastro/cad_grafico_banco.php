<?php

echo "<title>CADASTRO DE CONTAS</title>";

require_once("../config/relatorios.class.php");

$cadastro = new Relatorio;
$cadastro->conexao();

$nome = $_POST['nomeconta'];
$nome = str_replace(' ', '_', $nome);
$nome = strtoupper($nome);

$cadastro->add_grafico($nome);

echo "GRAFICO CADASTRADO!!!";


<?php

# ATUALIZA O VALOR EVENTUAL

session_start();

echo "<title>EVENTUAL</title>";

require_once('relatorios.class.php');

$relatorio = new Relatorios;
$relatorio->conexao();


$POST = $_POST;
echo '<pre>';

$data = $POST['data'];

foreach ($POST['valor'] as $i => $valor)
{

 $array[] = array($POST['data'], $POST['contacaixa'][$i], $POST['valor'][$i]);
 
 }


## DELETA EVENTUAL LANCADO NA DATA
$relatorio->delete_eventual_lancados($data);



## SE VALOR PREENCHIDO, LANCA NO EVENTUAL
foreach ($array as $l => $value)
	{
		$relatorio->lanca_eventual($value[0], $value[1], $value[2]);
	}

$datas = explode('-', $data);
$data = $datas[0].'-'.$datas[1];

header("location:groupby_cx.php?enviar=$data");	
	
?>




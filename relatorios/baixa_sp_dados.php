<?php

$dados = $_POST;

require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$sql = "
		SELECT 
			data_emissao,numero_doc 
		FROM 
			extratos
		WHERE 
			(
				numero_doc like '%U%' 
				or numero_doc like '%L%'
				or numero_doc like '%N%'
			)    
			and data_emissao>= '".$dados['datai']."' 
			and data_emissao <= '".$dados['dataf']."'
		";
 
$relatorio->conexao();
$resultado = $relatorio->query($sql);
$ncontas = $relatorio->afect_rows($resultado);

$i = 0;
$codigo = '';
while ($numeros[] = $relatorio->fetch_array($resultado))
	{
		$codigo = $codigo . $numeros[$i][0] . '_' .$numeros[$i][1] . '|';
		$i++;
	}
	
$codigo = substr($codigo,0,-1);	

echo $codigo;
 
?>





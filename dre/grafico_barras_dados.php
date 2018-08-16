<title>GRAFICO BARRAS</title>

<?php

session_start();

$dados_grafico = $_POST;

$grupo_de_referencia = $dados_grafico['id_grafico_receita'];

//echo '<pre>'; print_r($dados_grafico); die();

############### CONCATENA GRUPOS #####################
$all_group = array();

foreach ($dados_grafico['val_graf'] as $grupo_name)
{
	if(!in_array($grupo_name['grupo'], $all_group) && $grupo_name['grupo'] != '')
		{
			$all_group[] = $grupo_name['grupo'];
		}
}
############### FIM CONCATENA GRUPOS #####################






foreach($all_group as $key => $all)
{
	$valor = 0;

	foreach ($dados_grafico['val_graf'] as $dados)
	{
		if($all == $dados['grupo']) 
			{
				$valor += $dados['valor'];
			}
	}
	if($valor != 0) 
		{
			$valores_positivos[$key][] = $all;
			$valores_positivos[$key][] = $valor * -1;
		}
}

#123
/*
echo '<pre>'; print_r($valores_positivos); 
echo '<pre>'; print_r($all_group);
echo '<pre>'; print_r($dados_grafico['val_graf']); die();
*/


$valor = 0;

foreach($all_group as $key => $all)
{
	foreach ($dados_grafico['val_graf'] as $dados)
	{
		if($all == $dados['grupo']) 
			{
				$valor += $dados['valor_eventual'];
			}
	}
	if($valor != 0) 
		{
			$valores_negativos[$key][] = $all;
			$valores_negativos[$key][] = $valor * -1;
			$valor = 0;
		}
}



############## RETIRAR RECEITA DO GRAFICO ######################

foreach ($valores_positivos as $key => $vp)
	{
		if($vp[0] ==  $grupo_de_referencia)
			{
				$nome_receita = $vp[0];
				$valor_receita = $vp[1];
			}
		else
			{
				$valor_p_sem_ref[] = $vp;
			}
	}
	
############## FIM RETIRAR RECEITA DO GRAFICO ###################




############## ORDERNA GRAFICO ##################################

foreach ($valor_p_sem_ref as $i => $valorPSemRef)
	{
		$grafico[] = $valorPSemRef;
		
		foreach ($valores_negativos as $j => $vn)
			{
				if($valorPSemRef[0] == $vn[0])
					$grafico[] = $vn;
			}

	}

echo '<pre>';


//print_r($valores_positivos);
//die();

	
//$valores_negativos[] = array('99-TESTE', '5000');


############# FIM ORDENA GRAFICO ################################

$flag = 0;
$soma_valor_negativo = 0;

foreach ($valores_negativos as $i => $vlr_neg)
	{
		$soma_valor_negativo += $vlr_neg[1];
	
		foreach($grafico as $graf_fin )
			{
				if($vlr_neg[0] == $graf_fin[0])
					{
						$flag = 1;
					}
			}

		if($flag == 0)
			{
				$grafico[] = $vlr_neg;
			}

			$flag = 0;			
	}




/*
print_r($grafico);
print_r($nome_receita);
print_r($valor_receita);
print_r($soma_valor_negativo);
*/

$_SESSION['e_grafico'] = $grafico;
$_SESSION['e_nome_receita'] = $nome_receita;
$_SESSION['e_valor_receita'] = $valor_receita;
$_SESSION['e_soma_valor_negativo'] = $soma_valor_negativo;
$_SESSION['botao'] = $_POST['botao'];


header("location:grafico_barras/grafico_barras.php");
?>
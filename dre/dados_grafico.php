<html>
<body>
<?php

session_start();
echo "<title>GRAFICO</title>";
require_once('../config/relatorios.class.php');
require_once('relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$new = new Relatorios;
$new->conexao();

$dados_grafico = $_POST;

echo '<pre>'; //print_r($dados_grafico); die();

foreach($dados_grafico['grupo'] as $k => $grupo)
{
if($grupo){
$dados[$k][] = $grupo;
$dados[$k][] = $dados_grafico['valor'][$k];
}

}

//print_r($dados);

//print_r($dados_grafico['id_grafico_receita']); echo ' ';
//print_r($dados_grafico['nome_relatorio']); echo ' ';

//print_r($dados_grafico['nome_grafico']); echo ' ';
//print_r($dados_grafico['data']);



###### INSERIR NO BANCO OS GRUPOS E VALORES TEMP_GRUPO_GRAFICO ############

# LIMPA TABELA TEMPORARIA
$sql =  "DELETE FROM temp_grupo_grafico";
$grupo = $relatorio->query($sql);

# INSERE OS GRUPOS NO BANCO
foreach ($dados as $i => $dado){

$sql = "INSERT INTO temp_grupo_grafico VALUES ('', '$dado[0]', $dado[1])";
$grupo = $relatorio->query($sql);
}

# TRANSFOMA TODOS OS VALORES EM POSITIVO
$sql = "UPDATE temp_grupo_grafico set valor=valor*-1 WHERE valor<0	";
$grupo = $relatorio->query($sql);

# GROUP BY DOS GRUPOS DO GRAFICO
$sql = "SELECT grupo, sum(valor) FROM `temp_grupo_grafico` group by grupo";

$resultado = $relatorio->query($sql);
$nlinhas = $relatorio->afect_rows($resultado);

for($i = 0; $i < $nlinhas; $i++){
	$date[] = $relatorio->fetch_array($resultado);
}

//print_r($date); die();

# total se nao existir receita
$sql = "SELECT sum(valor) as total_sem_receita FROM `temp_grupo_grafico`";

$result_sem_receita = $relatorio->query($sql);
$total_sem_receita = $relatorio->fetch_array($result_sem_receita);

//print_r($total_sem_receita[0]); die();


################################ SE EXISTE RECEITA ##############################################
if($dados_grafico['id_grafico_receita'])
	{ 
		foreach ($date as $l => $dat)
			{
				# SE É O GRUPO SELECIONADO TROCA O NOME E O VALOR
				if($dat[0] == $dados_grafico['id_grafico_receita']) 
					{
				 
//						echo 'igual: '; echo $dat[0];

						$sql = "SELECT SUM( valor ) - ( 
						SELECT SUM( valor ) 
						FROM  `temp_grupo_grafico` 
						WHERE  `grupo` !=  '$dat[0]' ) as receita 
						FROM temp_grupo_grafico
						WHERE grupo =  '$dat[0]'
						";

						$resultado = $relatorio->query($sql);
						$result = $relatorio->fetch_array($resultado);

						//echo 'receita: '; print_r($result[0]);

						$date[$l][1] = $result[0];
						$date[$l]['grupo'] = $dados_grafico['nome_relatorio'];

						# DADOS PARA EVIAR PARA O GRAFICO
						$total = $dados_grafico['nome_grafico'].' '.$date[$l]['sum(valor)'];
						$nomes[] = $date[$l]['grupo'].' '.$date[$l][1];
						$valores[] = $date[$l][1];
						
						# SE A RECEITA MENOR QUE RECEITA, NAO PODE GERAR O GRAFICO
						if($date[$l][1] < 0) die('RECEITA MENOR QUE DESPESAS!!!');
					}
				else 
					{
						$nomes[] = $date[$l]['grupo'].' '.$date[$l][1];
						$valores[] = $date[$l][1];
					}
			}
	}
else	#######  SE NAO EXISTE RECEITA  ############
	{
		foreach ($date as $l => $dat)
			{
				$nomes[] = $date[$l]['grupo'].' '.$date[$l][1];
				$valores[] = $date[$l][1];
				$total = $dados_grafico['nome_grafico'].' '.$total_sem_receita[0];
			}

	}

//echo 'total: '; print_r($total); echo '<br>';
//echo 'nomes: '; print_r($nomes); echo '<br>';
//echo 'valores: '; print_r($valores); echo '<br>';

$_SESSION['new_total'] = $total;
$_SESSION['new_nomes'] = $nomes;
$_SESSION['new_valores'] = $valores;

header("location:../view/jpgraph/NEW_GRAFICO_DRE.php");







		########################## DADOS DO SELECT E SUBSELECT ###########################
		# a = SELECT sum(valor) FROM `temp_grupo_grafico` WHERE `grupo`='$dat[0]' 
		# b = SELECT sum(valor) FROM `temp_grupo_grafico` WHERE `grupo`!='$dat[0]'
		# receita = a - b
				 
		 /*
		SELECT SUM( valor ) - ( 
		SELECT SUM( valor ) 
		FROM  `temp_grupo_grafico` 
		WHERE  `grupo` !=  '1-RECEITA' ) 
		FROM temp_grupo_grafico
		WHERE grupo =  '1-RECEITA'
		 */
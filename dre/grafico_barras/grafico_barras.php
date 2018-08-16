<!DOCTYPE HTML>

<?php

session_start();

$grafico = $_SESSION['e_grafico'];
$nome_receita = $_SESSION['e_nome_receita'];
$valor_receita = $_SESSION['e_valor_receita'];
$soma_valor_negativo = $_SESSION['e_soma_valor_negativo'];

$numeros = array();

foreach($grafico as $item)
{
	$arrayG = explode('-', $item[0]);
	$numeros[$arrayG[0]] = $item;
}

ksort($numeros);

$grafico = $numeros;


/*
echo '<pre>';
echo 'grafico: '; print_r($grafico);
echo 'nome receita: '; print_r($nome_receita);
echo 'valor receita: '; print_r($valor_receita);
echo 'soma valor negativo: '; print_r($soma_valor_negativo);
die();
*/

if($_SESSION['botao'] == 'GERAR RELATORIO')
{

$arrayReceita = explode('-', $nome_receita);
$ordemReceira = $arrayReceita[0]; 


	echo "
	   <TABLE border=1 width=100%>
		<TR>
		 <TD ALIGN=CENTER>ORDEM</TD>
		 <TD ALIGN=CENTER>DESCRICAO</TD>
		 <TD ALIGN=CENTER>VALOR</TD>
		</TR>
		<TR>
		 <TD>"; echo $ordemReceira; echo "</TD>
		 <TD>"; echo $nome_receita; echo "</TD>
		 <TD>"; echo $valor_receita * -1; echo "</TD>
		</TR>		
	";

	foreach($grafico as $i => $item)
	{
		$item['1'] = str_replace('.', ',', $item['1']);

		echo "	
			<TR>
			 <TD>"; echo $i; echo "</TD>
			 <TD>"; echo $item['0'];  echo "</TD>
			 <TD>"; echo $item['1'];  echo "</TD>
			</TR>";
	}
	echo "</TABLE>";

	die();	
}

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Receita: <?php echo number_format($valor_receita * -1, 2, ',', '.') ; echo "<br>"; echo "Emprestimo: "; echo number_format($soma_valor_negativo, 2, ',', '.') ; ?> '
            },
            xAxis: {
                categories: [<?php foreach ($grafico as $graficos) { echo '\''; echo str_replace('_', ' ', $graficos[0]); echo " <br> ".number_format($graficos[1], 2, ',', '.')." <br> "; if($graficos[1] < 0) $graficos[1] = $graficos[1] * (-1); echo number_format($graficos[1]*100/$valor_receita * -1, 2, ',', '.').' %\''; echo ','; } ?>]
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Grupos',
                data: [<?php foreach ($grafico as $graficos) { echo $graficos[1]; echo ','; } ?>]
            }]
        });
    });
    

		</script>
	</head>
	<body>
<script src="highcharts.js"></script>
<script src="exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

	</body>
</html>

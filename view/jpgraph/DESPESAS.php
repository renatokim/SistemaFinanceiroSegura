<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph.php');
require_once ('jpgraph_pie.php');
require_once ('jpgraph_pie3d.php');

require_once("../../config/grafico.class.php");

$graficos = new Grafico;
$graficos->conexao();

$dataini = $_POST["dataini"];
$datafin = $_POST["datafin"];

// RESULTADO DA SOMA DO INTERVALO DOS CONTA-CAIXAS
$resultado = $graficos->despesas($dataini, $datafin, 2111000, 2111999, 2121000, 2121999);
$valor1 = $graficos->fetch_array($resultado);
$valor1 = "$valor1[0]"; $valor1 *= -1; 

$resultado = $graficos->despesas($dataini, $datafin, 2112000, 2112999, 2122000, 2122999);
$valor2 = $graficos->fetch_array($resultado);
$valor2 = "$valor2[0]"; $valor2 *= -1; 

$resultado = $graficos->despesas($dataini, $datafin, 2113000, 2113999, 2123000, 2123999);
$valor3 = $graficos->fetch_array($resultado);
$valor3 = "$valor3[0]"; $valor3 *= -1; 

$resultado = $graficos->despesas($dataini, $datafin, 2114000, 2114999, 2124000, 2124999);
$valor4 = $graficos->fetch_array($resultado);
$valor4 = "$valor4[0]"; $valor4 *= -1; 

$resultado = $graficos->despesas($dataini, $datafin, 2115000, 2115999, 2125000, 2125999);
$valor5 = $graficos->fetch_array($resultado);
$valor5 = "$valor5[0]"; $valor5 *= -1; 

$resultado = $graficos->despesas($dataini, $datafin, 2116000, 2116999, 2126000, 2126999);
$valor6 = $graficos->fetch_array($resultado);
$valor6 = "$valor6[0]"; $valor6 *= -1; 

$resultado = $graficos->despesas($dataini, $datafin, 2117000, 2117999, 2127000, 2127999);
$valor7 = $graficos->fetch_array($resultado);
$valor7 = "$valor7[0]"; $valor7 *= -1; 

// Some data
$data = array($valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7);

// Create the Pie Graph.
$graph = new PieGraph(900,500);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set("Despesas Pessoa Jurídica");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,18); 
$graph->title->SetColor("darkred");
$graph->legend->Pos(0.2,0.1);

// Create pie plot
$p1 = new PiePlot3d($data);
$p1->SetTheme("sand");
$p1->SetCenter(0.4);
$p1->SetAngle(40);
$p1->value->SetFont(FF_ARIAL,FS_NORMAL,12);
$p1->SetLegends(array("Impostos","Mercadorias","Produção","Administrativa","Financeira","Patrimonial","Outros"));

$graph->Add($p1);
$graph->Stroke();

?>



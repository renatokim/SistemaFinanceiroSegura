<?php // content="text/plain; charset=utf-8"
// $Id: piecex2.php,v 1.3.2.1 2003/08/19 20:40:12 aditus Exp $
// Example of pie with center circle
require_once ('jpgraph.php');
require_once ('jpgraph_pie.php');

require_once("../../config/grafico.class.php");

$graficos = new Grafico;
$graficos->conexao();

$dataini = $_POST["dataini"];
$datafin = $_POST["datafin"];
/*
// TOTAL DA ENTRADA
// ORCAMENTO-GERAL / FISCAL-GERAL
$resultado = $graficos->despesas($dataini, $datafin, 1111000, 1111999, 1121000, 1121999);
$valorentrada1 = $graficos->fetch_array($resultado);

// ORCAMENTO-VENDA / FISCAL-VENDA
$resultado = $graficos->despesas($dataini, $datafin, 1112000, 1112999, 1122000, 1122999);
$valorentrada2 = $graficos->fetch_array($resultado);

// ORCAMENTO-SERVICO / FISCAL-SERVICO
$resultado = $graficos->despesas($dataini, $datafin, 1113000, 1113999, 1123000, 1123999);
$valorentrada3 = $graficos->fetch_array($resultado);

$valorentrada = $valorentrada1 + $valorentrada2 + $valorentrada3;

//$valorentrada = number_format($valorentrada, 2,'.','');  

*/


// TOTAL ENTRADA
$valorentrada = $graficos->totalentrada($dataini, $datafin, 1111000, 1111999, 1121000, 1121999, 1112000, 1112999, 1122000, 1122999, 1113000, 1123999, 1123000, 1123999 );
$valorentrada = $graficos->fetch_array($valorentrada);





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


$valor8 = $valorentrada[0] - $valor1 - $valor2 - $valor3 - $valor4 - $valor5 - $valor6 - $valor7;
//$valor8 = 10000;

// Some data
$data = array($valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7, $valor8);

// A new pie graph
$graph = new PieGraph(600,600,'auto');

// Don't display the border
$graph->SetFrame(false);

// Uncomment this line to add a drop shadow to the border
// $graph->SetShadow();

// Setup title
$graph->title->Set("Despesa/Receita");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,24);
$graph->title->SetMargin(0); // Add a little bit more margin from the top

// Create the pie plot
$p1 = new PiePlotC($data);

// Set size of pie
$p1->SetSize(0.45);

// Label font and color setup
$p1->value->SetFont(FF_ARIAL,FS_BOLD,10);
$p1->value->SetColor('black');

$p1->value->Show();

// Setup the title on the center circle
//$p1->midtitle->Set("Test mid\nRow 1\nRow 2");
//$p1->midtitle->SetFont(FF_ARIAL,FS_NORMAL,18);

// Set color for mid circle
//$p1->SetMidColor('yellow');

// Use percentage values in the legends values (This is also the default)
$p1->SetLabelType(PIE_VALUE_PER);

// The label array values may have printf() formatting in them. The argument to the
// form,at string will be the value of the slice (either the percetage or absolute
// depending on what was specified in the SetLabelType() above.
$lbl = array("Imposto:  $valor1  %.1f%%","Mercadoria:  $valor2  %.1f%%","Produção  $valor3  %.1f%%","Administrativo:  $valor4  %.1f%%","Financeiro:  $valor5  %.1f%%","Patrimonial:  $valor6  %.1f%%","Outros:  $valor7  %.1f%%", "Lucro:  $valor8  %.1f%%");
$p1->SetLabels($lbl);

// Uncomment this line to remove the borders around the slices
// $p1->ShowBorder(false);

// Add drop shadow to slices
//$p1->SetShadow();

// Explode all slices 15 pixels
$p1->ExplodeAll(2);

// Add plot to pie graph
$graph->Add($p1);

// .. and send the image on it's marry way to the browser
$graph->Stroke();

?>



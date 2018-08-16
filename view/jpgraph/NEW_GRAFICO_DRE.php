<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph.php');
require_once ('jpgraph_pie.php');
require_once ('jpgraph_pie3d.php');

session_start();

$total = $_SESSION['new_total'];
$nomes = $_SESSION['new_nomes'];
$valores = $_SESSION['new_valores'];

// Create the Pie Graph.
$graph = new PieGraph(900,500);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set("$total");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,18); 
$graph->title->SetColor("darkred");
$graph->legend->Pos(0.2,0.1);

// Create pie plot
$p1 = new PiePlot3d($valores);
$p1->SetTheme("sand");
$p1->SetCenter(0.4);
$p1->SetAngle(40);
$p1->value->SetFont(FF_ARIAL,FS_NORMAL,12);
$p1->SetLegends($nomes);

$graph->Add($p1);
$graph->Stroke();

?>



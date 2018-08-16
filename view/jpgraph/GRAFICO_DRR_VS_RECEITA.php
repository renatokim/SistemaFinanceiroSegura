<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph.php');
require_once ('jpgraph_pie.php');
require_once ('jpgraph_pie3d.php');

session_start();

require_once("../../config/grafico.class.php");
$graficos = new Grafico;
$graficos->conexao();

# PEGA VALOR DA SESSAO
$graf_dre_grupo = $_SESSION['graf_grupo'];
$graf_dre_valor = $_SESSION['graf_valor'];
$nome_relatorio = $_SESSION['nome_relatorio'];
$ngrafref = $_SESSION['ngrafref'];




## NOME GRAFICO - $ngrafref ##

$nameGraf = $_SESSION['NomeGraf'];


//print_r($graf_dre_grupo); 
//print_r($nome_relatorio);
//die();

$data = $graf_dre_valor;

//$graf_dre_grupo[0] = '1-'.$nome_relatorio;

  $total = 0;
foreach($graf_dre_grupo as $k => $value)
 {
  $leg[] = $graf_dre_grupo[$k].' '.$graf_dre_valor[$k];
  $total += $graf_dre_valor[$k];
 }

$legenda = $leg;

$graf_dre_grupo = $legenda;

$graficos->delete_temp_graf_ordem();

foreach ($data as $i => $dados)
	{
		$aux = explode('-',$graf_dre_grupo[$i]);
		$add_graf[$i][0] = $aux[0];
		$add_graf[$i][1] = $aux[1]; 
		$add_graf[$i][2] = $data[$i];
		$graficos->add_temp_graf_ordem($add_graf[$i][0], $add_graf[$i][1], $add_graf[$i][2]);
	}

$temp_graf = $graficos->get_temp_graf_ordem();

foreach ($temp_graf as $i => $dados)
	{
		$data_leg[] = $dados['id_grupo'].'-'.$dados['nome_grupo'];	
		$data_vlr[] = $dados['valor'];	
	}

foreach ($data_leg as $j => $leg)
{

 //print_r($leg); 
 $troca = explode(' ', $leg);
 


if($troca[0] == $ngrafref)

{
 ///print_r($troca[0]);
 
 // legenda 
//print_r($ngrafref);
//print_r($nome_relatorio);

$data_leg[$j] = $nome_relatorio.' '.$data_vlr[$j];

}

//echo '<br>';



 
 
}	


	
	

// Create the Pie Graph.
$graph = new PieGraph(900,500);
$graph->SetShadow();

// Set A title for the plot
$graph->title->Set("$nameGraf $total");
$graph->title->SetFont(FF_VERDANA,FS_BOLD,18); 
$graph->title->SetColor("darkred");
$graph->legend->Pos(0.2,0.1);

// Create pie plot
$p1 = new PiePlot3d($data_vlr);
$p1->SetTheme("sand");
$p1->SetCenter(0.4);
$p1->SetAngle(40);
$p1->value->SetFont(FF_ARIAL,FS_NORMAL,12);
$p1->SetLegends($data_leg);

$graph->Add($p1);
$graph->Stroke();

?>



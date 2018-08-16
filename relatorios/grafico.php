<?php

session_start();

require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


$temp_grupo_grafico = $_POST;

$nome_relatorio = $temp_grupo_grafico['nome_relatorio'];
echo '<pre>';

$ngrafref = $temp_grupo_grafico['id_grafico_receita'];

//print_r($temp_grupo_grafico); die();

$relatorio->del_temp_grupo_grafico();

foreach($temp_grupo_grafico['vlr_eventual'] as $k => $value)
 {
  if ($value[1] != '' )
   {
    $grupo = $value[1]; 
	$valor = $value[0];
    $relatorio->add_temp_grupo_grafico($grupo, $valor);
   }
 }
 
$receita = $temp_grupo_grafico['id_grafico_receita'];

$receit_graf = $relatorio->get_temp_grupo_grafico();

 $sum_temp_grupo_grafico_sem_receita = $relatorio->sum_temp_grupo_grafico_sem_receita($receita);

foreach($receit_graf as $k => $value)
 {
  if ($value['grupo'] ==  $receita)
   {
    $valor = $value['valor'] + $sum_temp_grupo_grafico_sem_receita['sum_sem_receita'];
    $grupo = $value['grupo'];
   }
  else 
   {
    $valor = $value['valor'];
    $grupo = $value['grupo'];
   }
   
   if($valor < 0) $valor *=-1;

   $graf_dre_grupo[] = $grupo;
   $graf_dre_valor[] = $valor;
 }

    //print_r($graf_dre_grupo);
    //print_r($graf_dre_valor); //die();
 
 $_SESSION['graf_grupo'] = $graf_dre_grupo;
 $_SESSION['graf_valor'] = $graf_dre_valor;
 $_SESSION['nome_relatorio'] = $nome_relatorio;
 $_SESSION['ngrafref'] = $ngrafref;
 
 
 /*
 echo '<pre>';
 print_r($graf_dre_grupo);
 print_r($graf_dre_valor);
 die();
 */
 
 header("location:../view/jpgraph/GRAFICO_DRR_VS_RECEITA.php");

 
	
   
   


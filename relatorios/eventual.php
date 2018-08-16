<?php
session_start();

echo "<title>EVENTUAL</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$POST = $_POST;



for ($i=0; $i < $POST['nlinhas']; $i++) { 

  $array[] = array($POST['cx_temp'][$i], $POST['descricao_temp'][$i], $POST['valor_temp'][$i], $POST['valor'][$i]);
  if($POST['valor'][$i] != '')  $lancar_eventual[] = array($POST['cx_temp'][$i], $POST['descricao_temp'][$i], $POST['valor_temp'][$i], $POST['valor'][$i]);
}



#M
/********************** */
$data = '2013-02-01';
$dtfin = '2013-02-31';

## DELETA EVENTUAL LANCADO NA DATA
$relatorio->delete_eventual_lacados($data, $dtfin);

## SE VALOR PREENCHIDO, LANCA NO EVENTUAL
foreach ($array as $l => $value)
	{
		if ($value[3] > 0)
			$relatorio->lanca_eventual($data, $value[0], $value[1], $value[3]);

	}

die('AJUSTE LANCADO!!');



########### RETIRAR  ##########

// INSERE LANCAMENTO EVENTUAL

//$relatorio->delete_eventual_lacados($data, $dtfin);


/*
echo '<pre>';
print_r($lancar_eventual); 
print_r($data); 
die();
*/

/*
foreach ($lancar_eventual as $key => $value) {
/*
 $contacaixa = $value[0];
 $valor = $value[2]; 

 $linhas = $relatorio->update_event_lanc($contacaixa, $valor, $data);

 
	$relatorio->lanca_eventual($data, $value[0], $value[1], $value[3]); 
}
*/


/*

?> 
<TABLE>
  <TR bgcolor='LightSteelBlue'>
    <TD>CONTA-CAIXA</TD>
    <TD>DESCRICAO</TD>
    <TD>VALOR MENSAL</TD>
  </TR>
<?php

$cont = 0;

foreach ($array as $key => $value) {


  if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';


  echo "<TR bgcolor=$cor>
          <TD ALIGN=CENTER>"; echo $value[0]; echo "</TD>
          <TD>"; echo $value[1]; echo "</TD>
          <TD ALIGN=RIGHT>"; echo $value[2]-$value[3]; echo "</TD>
        </TR>";
$cont++;

$valores = array($value[0],$value[1],$value[2]-$value[3]);

$ajuste_salvo[] = $valores;

}

echo "</TABLE>";
*/

########################## EXC ###############

$_SESSION['ajuste_salvo'] = $ajuste_salvo;


header("location:salva_ajuste_banco.php");

/*
<input name="" type="button" onClick="window.open('salva_ajuste_banco.php')" value="CONCLUIR">
*/

?>




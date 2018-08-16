<?php
session_start();

echo "<title>RESUMO CONTA CAIXA</title>";
require_once('../config/relatorios.class.php');

echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
";

$relatorio = new Relatorio;
$relatorio->conexao();

if (!isset($_POST["dataini"]) && !isset($_POST["datafin"]))
 {

  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";
 
echo "SELECIONE O PER�ODO:
<form action=relatcntcxgroupbysoma.php method='post'>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
   </TR>
    <TR><TD></TD><TD><INPUT type='submit' value='OK' /></TD>
   </TR>
  </TABLE>
</form>
";
 }

// VARIAVEIS RECEBEM O VALOR
if (isset($_POST['dataini']))
 {
  $dataini = $_POST['dataini'];
   if (isset($_POST['datafin']))
   {
    $datafin = $_POST['datafin'];

    $_SESSION['data_salva_ajuste'] = $dataini;

  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
   <TD>CONTA-CAIXA</TD>
   <TD>DESCRIÇÃO</TD>
   <TD>VALOR AJUSTADO</TD>
   <TD>VLR EVENT</TD> 
  </TR>";	

  $corfonte = 'BLUE';
  $cont=0;

  $valor = 0.00;
  $valor = number_format($valor, 2,'.','');  
  $set = 0;   
  $cor = 'white';  
    
  $resultado = $relatorio->relatcntcxgroupby($dataini, $datafin);
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS

  
## GET GROUP BY 

/*
 echo '<pre>';
   for ($i = 0; $i < $nlinhas; $i++)
   {
   $linha = $relatorio->fetch_array($resultado);
   print_r($linha); 
   }
die('aaaaa');
*/
   
   

   
  // LIMPA A TABELA GRUPO_PROVISORIO
  $delete = $relatorio->deleteprovisorio();
  
  //foreach();
  
  for ($i = 0; $i < $nlinhas; $i++)
   {
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	
	$linha = $relatorio->fetch_array($resultado);
	  
  	 $conta_caixa = $linha[0]; //echo $conta_caixa; echo 'valor:'.($conta_caixa/100000).'--'; echo 'resto:'.($conta_caixa%1000).'--'; echo '<br>';
     $descricao = $linha[1];
     $sum = $linha[2]; ($sum < 0)?$corfonte='RED':$corfonte='BLUE';

	  // ARRAY RECEBE GROUP BY DA TABELA EXTRATOS
	  $cx[] = Array($conta_caixa, ((number_format($conta_caixa/100000, 0,'.','')*100000)+$conta_caixa%10000)+10000, number_format($conta_caixa/100000, 0,'.','')%10 ,$descricao, $sum);

	  // SE NA TERCEIRA POSICA VALOR == 1, INSERE CONTA-CAIXA PROVISORIO, SENAO, INSERE O VALOR DO CONTA-CAIXA ORIGINAL
	  if( (number_format($conta_caixa/100000, 0,'.','')%10) == 1) 
		 $result = $relatorio->addprovisorio($conta_caixa, ((number_format($conta_caixa/100000, 0,'.','')*100000)+$conta_caixa%10000)+10000, number_format($conta_caixa/100000, 0,'.','')%10 ,$descricao, $sum);
	  else
		 $result = $relatorio->addprovisorio($conta_caixa, $conta_caixa, number_format($conta_caixa/100000, 0,'.','')%10 ,$descricao, $sum);	    
	 /*
	    [54] => Array
        (
            [0] => 2222500 conta-caixa original
            [1] => 2202500 conta-caixa fiscal e orcamento juntos
            [2] => 2       segunda posicao tem que ser 1 para juntar
            [3] => ATV. EXT.
            [4] => -405.10
        )
	 */
 $cont++;
	 }
	 



  $resultado = $relatorio->relatcntcxgroupbysoma();
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS

  $relatorio->delete_ajuste_temp();

  $linha = NULL;
  for ($i = 0; $i < $nlinhas; $i++)
   {
       // SALVAR NA TABELA DE AJUSTE TEMP
      $linha = $relatorio->fetch_array($resultado);
      $relatorio->add_ajuste_temp($linha[0], $linha[1], $linha[2]);
   }



$ajust_lanc =  $relatorio->ajustes_lancados();

//echo '<pre>';print_r($ajust_lanc); die();



foreach ($ajust_lanc as $value) {



if ( $value['vlr_or_pecent'] == '%' ) 
  {
    $relatorio->subtrai_valor_pec($value['cx_retira'], $value['valor']);
    $relatorio->soma_valor_pec($value['cx_inclui'], $value['valor']);
  }
else if ( $value['vlr_or_pecent'] == '$' )
{
    $relatorio->subtrai_valor_vlr($value['cx_retira'], $value['valor']);

    $relatorio->soma_valor_vlr($value['cx_inclui'], $value['valor']);
}

$ajus_temp =  $relatorio->get_ajuste_temp();



}


$i = 0; echo "
    <form action=eventual.php method=post>
";
  $cont = 0;

/******************************* arrumar se eventual vazio */ 
$_SESSION['save_ajuste'] = $ajus_temp;

foreach ($ajus_temp as $ajust) 
    {
          if($cont % 2 == 0)
             $cor = 'white';
            else 
             $cor = 'Gainsboro';
			 
			 
			 
## BUSCA EVENTUAL ##


$contacaixa = $ajust['cx_temp']; 

//echo $contacaixa; die(); 

$vlr_event = '';
$vlr_event = $relatorio->get_eventual_by_contacaixa($contacaixa);

       /* salvar eventual  */ 
        	   echo "
                <TR  bgcolor=$cor>
                   <TD ALIGN=CENTER>"; print_r($ajust['cx_temp']); echo "</TD>
                   <TD>"; print_r($ajust['descricao_temp']); echo "</TD>
                   <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>"; print_r($ajust['valor_temp']); echo "</TD>
                   <TD ALIGN=RIGHT><INPUT  ALIGN=RIGHT TYPE=NUMERIC SIZE=10 NAME=valor["; echo $i; echo "] value=$vlr_event"; echo "></TD>

                  <INPUT TYPE=hidden SIZE=6 NAME=cx_temp["; echo $i; echo "] VALUE="; print_r($ajust['cx_temp']); echo ">
                  <INPUT TYPE=hidden SIZE=6 NAME=descricao_temp["; echo $i; echo "] VALUE="; print_r($ajust['descricao_temp']); echo ">
                  <INPUT TYPE=hidden SIZE=6 NAME=valor_temp["; echo $i; echo "] VALUE="; print_r($ajust['valor_temp']); echo ">

                </TR>";	
        $cont++; $i++; }
        echo   "<TR>
                  <TD></TD>
                  <TD></TD>
                  <TD></TD>
                  <TD><INPUT TYPE=SUBMIT VALUE=OK></TD>
                  <TD></TD>
                  <TD><INPUT TYPE=hidden SIZE=6 NAME=nlinhas VALUE="; echo $i; echo "></TD>
                </TR>
              </TABLE>
            </form>";

    }
}

?>

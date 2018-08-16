<?php

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
<form action=relatcntcxgroupbyajuste.php method='post'>
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

  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
   <TD>CONTA-CAIXA</TD>
   <TD>DESCRIÇÃO</TD>
   <TD>VALOR</TD>
   <TD>AJUSTE</TD>
  </TR>";	

  $corfonte = 'BLUE';
  $cont=0;

  $valor = 0.00;
  $valor = number_format($valor, 2,'.','');  
  $set = 0;   
  $cor = 'white';  
    
  $resultado = $relatorio->relatcntcxgroupby($dataini, $datafin);
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS

echo "
    <form action=eventual.php method=post>
";
  
  for ($i = 0; $i < $nlinhas; $i++)
   {
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	
	
	$linha = $relatorio->fetch_array($resultado);
	
  	 $conta_caixa = $linha[0];
     $descricao = $linha[1];
     $sum = $linha[2]; ($sum < 0)?$corfonte='RED':$corfonte='BLUE';

	## VALOR EVENTUAL
	$vlr_event = '';
	$vlr_event = $relatorio->get_eventual_by_contacaixa($conta_caixa);	 
	 
	 
	 
	   echo "
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$conta_caixa</TD>
         <TD>$descricao</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$sum</TD>
		 <TD ALIGN=RIGHT><INPUT  ALIGN=RIGHT TYPE=NUMERIC SIZE=10 NAME=valor["; echo $i; echo "] value=$vlr_event"; echo "></TD>
        </TR>	

	  <INPUT TYPE=hidden SIZE=6 NAME=cx_temp["; echo $i; echo "] VALUE="; print_r($conta_caixa); echo ">
	  <INPUT TYPE=hidden SIZE=6 NAME=descricao_temp["; echo $i; echo "] VALUE="; print_r($descricao); echo ">
	  <INPUT TYPE=hidden SIZE=6 NAME=valor_temp["; echo $i; echo "] VALUE="; print_r($sum); echo ">		
		";
 
     $cont++;
 
	 
	 }
	         echo   "<TR>
                  <TD></TD>
                  <TD></TD>
                  <TD></TD>
                  <TD><INPUT TYPE=SUBMIT VALUE=OK></TD>
                  <TD></TD>
                  <TD><INPUT TYPE=hidden SIZE=6 NAME=nlinhas VALUE="; echo $i; echo "></TD>
                </TR>";
	 
	 
	 echo "</form>";
	 
	 
}
}

?>

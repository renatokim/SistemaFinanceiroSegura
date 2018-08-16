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
<form action=relatcntcxgroupby.php method='post'>
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
  </TR>";	

  $corfonte = 'BLUE';
  $cont=0;

  $valor = 0.00;
  $valor = number_format($valor, 2,'.','');  
  $set = 0;   
  $cor = 'white';  
    
  $resultado = $relatorio->relatcntcxgroupby($dataini, $datafin);
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS

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

	   echo "
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$conta_caixa</TD>
         <TD>$descricao</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>"; echo str_replace('.', ',', $sum); echo "</TD>
        </TR>";	
 
     $cont++;

	 }
}
}

?>

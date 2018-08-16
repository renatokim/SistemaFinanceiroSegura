<?php

echo "<title>RESUMO CONTA CAIXA</title>";
require_once('../config/relatorios.class.php');


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
 
echo "SELECIONE A DATA:
<form action=relatcntcxgroupby.php method='post'>
  <TABLE>
   <TR>
    <TD>DATA</TD><TD><input type=date name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
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
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$sum</TD>
        </TR>";	
 
     $cont++;

	 }
}
}

?>

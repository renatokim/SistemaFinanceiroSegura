<?php

echo "<title>DRE / AJUSTE</title>";

require_once('relatorios.class.php');
$relatorio = new Relatorios;
$relatorio->conexao();

# SE DATA AINDA NAO FOI PREENCHIDA
if (!isset($_POST["dataini"]) && !isset($_POST["datafin"])) {
		$datahoje = date("Y/m/d");
		$datahoje = str_replace('/', '-', $datahoje);
		$dia = date("d"); $mes = date("m"); $ano = date("Y");
		$dia = $dia - $dia + 1;
		$dia = "0"."$dia";
		$data = "$ano"."-"."$mes"."-"."$dia";
	 
		echo "SELECIONE O PERIODO:
			<form action=groupby_cx_consulta.php method='post'>
			  <TABLE>
			   <TR>
				<TD>DATA INICIAL</TD><TD><input type=month name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
			   </TR>
			   <TR>
				<TD>DATA FINAL</TD><TD><input type=month name='datafin' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
			   </TR>
				<TR><TD></TD><TD><INPUT type='submit' value='OK' /></TD>
			   </TR>
			  </TABLE>
			</form>
			";
}



# SE A DATA FOI PREENCHIDA, CONTINUA
if (!isset($_POST['dataini'])) exit();

$dataini = $_POST['dataini'];
$datafin = $_POST['datafin'];

$dataini .='-01';
$datafin .='-31';


$sql = "SELECT contacaixa,
			   descricao,
			   sum(valor) as valor,
			   sum(valor_retira) as retira,
			   sum(valor_inclui) as inclui,
			   sum(soma_valor_ajuste) as ajuste,
			   sum(valor_mensal) as mensal,
			   sum(soma_valor_mensal) sum_mensal
		FROM `dre_ajustes` WHERE data_dre>='".$dataini."' AND data_dre<='".$datafin."' GROUP BY contacaixa";

		$resultado = $relatorio->query($sql);
	 	$nlinhas = $relatorio->afect_rows($resultado);
		
		for($i = 0; $i < $nlinhas; $i++){
			$registros	[] = $relatorio->fetch_array($resultado);
		}
//echo '<pre>';
//print_r($registros); die();
	
  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
	   <!--<TD>DATA</TD>-->
	   <TD>CONTA-CAIXA</TD>
	   <TD>DESCRICAO</TD>
	   <TD>VALOR</TD>
	   <TD>VALOR RETIRA</TD>
	   <TD>VALOR INCLUI</TD>
	   <TD>VALOR AJUSTADO</TD>
	   <TD>VALOR EVENTUAL</TD>
	   <TD>VALOR MENSAL</TD>
   </TR>";	

$cont = 0;   
   
echo "<FORM ACTION=eventual.php METHOD=post>";
   
foreach ($registros as $i => $registro){
//echo '<pre>'; print_r($registros); die();
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	$cont++;

	echo "
	  <TR  bgcolor=$cor>
		   <!--<TD>"; echo $registro[0]; echo "</TD>-->
		   <TD ALIGN=CENTER>"; echo $registro['contacaixa']; echo "</TD>
		   <TD>"; echo $registro['descricao']; echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro['valor'] < 0)?'RED':'BLUE'; echo ">"; echo str_replace(".",",",$registro['valor']); echo "</TD>
		   <TD ALIGN=RIGHT>"; echo str_replace('.', ',', $registro['retira']); echo "</TD>
		   <TD ALIGN=RIGHT>"; echo str_replace('.', ',', $registro['inclui']); echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro['ajuste'] < 0)?'RED':'BLUE'; echo ">"; echo str_replace('.', ',', $registro['ajuste']); echo "</TD>
		   <TD ALIGN=RIGHT>"; echo str_replace('.', ',', $registro['mensal']); echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro['sum_mensal'] < 0)?'RED':'BLUE'; echo ">"; echo str_replace('.', ',', $registro['sum_mensal']); echo "</TD>
	   
	   <INPUT TYPE=hidden NAME=contacaixa["; echo $i; echo "] VALUE="; print_r($registro[2]); echo ">		
	   <INPUT TYPE=hidden NAME=data VALUE="; print_r($registro[1]); echo ">		
	   </TR>";
}

# SOMA   
$soma = $relatorio->CI_soma_subtotal($dataini, $datafin);

# SOMA   
$soma_eventual = $relatorio->CI_soma_subtotal_eventual($dataini, $datafin);

# MOSTRA ULTIMA LINHA(SOMA)
echo "
  <TR  bgcolor='LightSteelBlue'>

	   <TD ALIGN=CENTER>"; echo "</TD>
	   <TD>TOTAL"; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma[0] < 0)?'RED':'BLUE'; echo ">"; echo $soma[0]; echo "</TD>
	   <TD ALIGN=RIGHT>"; echo $soma[1]; echo "</TD>
	   <TD ALIGN=RIGHT>"; echo $soma[2]; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma[3] < 0)?'RED':'BLUE'; echo ">"; echo $soma[3]; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma_eventual[0] < 0)?'RED':'BLUE'; echo ">"; echo $soma_eventual[0]; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma[5] < 0)?'RED':'BLUE'; echo ">"; echo $soma[5]; echo "</TD>
   </TR>";

//echo "<TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD ALIG=RIGHT><INPUT TYPE=SUBMIT VALUE='EVENTUAL'></TD><TD></TD>";
echo "</FORM>";

   
/*
  $valor = 0.00;
  $valor = number_format($valor, 2,'.','');  
*/

?>

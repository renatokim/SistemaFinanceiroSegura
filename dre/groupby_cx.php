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
			<form action=groupby_cx.php method='post'>
			  <TABLE>

			   <TR>
				<TD>DATA FINAL</TD><TD><input type=month name='dataini' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
			   </TR>
				<TR><TD></TD><TD><INPUT type='submit' value='OK' /></TD>
			   </TR>
			  </TABLE>
			</form>
			";
}

# SE A DATA FOI PREENCHIDA, CONTINUA
if (!isset($_POST['dataini']) && !isset($_GET)) exit();

@$dataini = $_POST['dataini'];

if(isset($_GET['enviar'])) $dataini = $_GET['enviar'];

$datafin = $dataini.'-31';
$dataini .='-01';

# GROUP BY EXTRATOS/CONTA-CAIXA
$resultado = $relatorio->groupby_cx($dataini, $datafin);


# LIMPA TABELA DRE_AJUSTES #
$relatorio->delete_dre($dataini, $datafin);



# SE JA ESTA LANCADO, $n_dre VAIS SER MAIOR QUE 0
$n_dre = $relatorio->count_dre($dataini);

# INSERIR NO BANCO
if(!$resultado) die();
foreach ($resultado as $k => $result)
	{
		$contacaixa = $result[0]; 
		$descricao = $result[1]; 
		$valor = $result[2];

		$resultado = $relatorio->add_dre_ajuste($dataini, 
												$contacaixa, 
												$descricao, 
												$valor);
	} # FIM FOREACH ADD

	
# PEGA OS AJUSTES LANCADOS	
$ajustes_lancados = $relatorio->get_ajuste_lancado($dataini);

# PRA CADA AJUSTE LANCADO ALTERA O VALOR DA COLUNA VALOR RETIRA E VALOR INCLUI
if($ajustes_lancados)
	foreach ($ajustes_lancados as $ajuste){
		# TESTA SE CONTACAIXA RETIRA QUE ESTA NA TABELA DE AJUSTE ESTA NA TABELA DRE
		$cont = $relatorio->count_reg_dre($ajuste[2], $ajuste[1]);
		if($cont[0] == 1){
			# TESTA SE E VALOR OU PECENT
			if($ajuste[6] == '$'){
				# ATUALIZA VALOR RETIRA ($)
				$relatorio->set_valor_retira($ajuste[2], $ajuste[1], $ajuste[7]);
				
				# TESTA SE CONTACAIXA INCLUI CONSTA NA TABELA DRE
				# ATUALIZA VALOR INCLUI
				$cont_cx_add = $relatorio->count_reg_dre($ajuste[4], $ajuste[1]);
				if($cont_cx_add[0] == 1){
					$relatorio->set_valor_inclui($ajuste[4], $ajuste[1], $ajuste[7]);
				}
				# INSERE NA TABELA DRE CASO CX NAO EXISTA
				else if($cont_cx_add[0] == 0){
					$relatorio->add_cx_nao_existe($ajuste[4], $ajuste[1], $ajuste[7], $ajuste[5]);
				}
			}
			else if($ajuste[6] == '%'){
				# ATUALIZA VALOR RETIRA (%)
				$relatorio->update_dre_pecent($ajuste[2], $ajuste[1], $ajuste[7]);	

				# TESTA SE CONTACAIXA INCLUI CONSTA NA TABELA DRE
				# ATUALIZA VALOR INCLUI
				$cont_cx_add = $relatorio->count_reg_dre($ajuste[4], $ajuste[1]);
				if($cont_cx_add[0] == 1){
					$relatorio->set_valor_inclui_pecent($ajuste[2], $ajuste[4], $ajuste[7], $dataini);
				}
				# INSERE NA TABELA DRE CASO CX NAO EXISTA
				else if($cont_cx_add[0] == 0){
					$relatorio->add_cx_nao_existe_pecent($ajuste[2], $ajuste[4], $ajuste[1], $ajuste[7], $ajuste[5]);
				}
			}
				

		}
	}

# TRANSFORMA TODOS OS VALORES PARA POSITIVO
# ATUALIZA SOMA VALOR AJUSTE
$relatorio->set_positivo();
$relatorio->set_valor_ajustado();

# LE TODOS OS REGISTROS	
$registros = $relatorio->get_dre_ajuste($dataini, $datafin);

//echo '<pre>';print_r($registros); die();
# ATUALIZA O VALOR EVENTUAL

if($registros)
foreach ($registros as $i => $registro){
	$vlr_event = '';
	$vlr_event = $relatorio->get_eventual_by_contacaixa($registro[2], $registro[1]); # PEGA O VALOR DA TABELA EVENTAL_LANCADO

	if($vlr_event)
	$relatorio->set_valor_mensal($registro[2], $registro[1], $vlr_event); # ATUALIZA O VALOR MENSAL DA TABELA DRE
	//echo '<pre>'; print_r ($registros); die('aaaaaaaaaa');
}

# ATUALIZA SOMA VALOR MENSAL
$relatorio->soma_valor_mensal();
	
	

# LE TODOS OS REGISTROS	
$registros = $relatorio->get_dre_ajuste($dataini, $datafin);

  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
	   <TD>DATA</TD>
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

if($registros)   
foreach ($registros as $i => $registro){
//echo '<pre>'; print_r($registros); die();
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	$cont++;

	echo "
	  <TR  bgcolor=$cor>
		   <TD>"; echo $registro[1]; echo "</TD>
		   <TD ALIGN=CENTER>"; echo $registro[2]; echo "</TD>
		   <TD>"; echo $registro[3]; echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro[4] < 0)?'RED':'BLUE'; echo ">"; echo $registro[4]; echo "</TD>
		   <TD ALIGN=RIGHT>"; echo $registro[5]; echo "</TD>
		   <TD ALIGN=RIGHT>"; echo $registro[6]; echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro[7] < 0)?'RED':'BLUE'; echo ">"; echo $registro[7]; echo "</TD>
		   <TD ALIGN=RIGHT><INPUT ALIGN=RIGHT TYPE=NUMERIC SIZE=10 NAME=valor["; echo $i; echo "] required pattern='[0-9]*[,|.][0-9]{2}' value=$registro[8]"; echo "></TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro[9] < 0)?'RED':'BLUE'; echo ">"; echo $registro[9]; echo "</TD>
	   
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
	   <TD>"; echo "</TD>
	   <TD ALIGN=CENTER>"; echo "</TD>
	   <TD>TOTAL"; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma[0] < 0)?'RED':'BLUE'; echo ">"; echo $soma[0]; echo "</TD>
	   <TD ALIGN=RIGHT>"; echo $soma[1]; echo "</TD>
	   <TD ALIGN=RIGHT>"; echo $soma[2]; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma[3] < 0)?'RED':'BLUE'; echo ">"; echo $soma[3]; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma_eventual[0] < 0)?'RED':'BLUE'; echo ">"; echo $soma_eventual[0]; echo "</TD>
	   <TD ALIGN=RIGHT><FONT COLOR="; echo ($soma[5] < 0)?'RED':'BLUE'; echo ">"; echo $soma[5]; echo "</TD>
   </TR>";

echo "<TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD ALIG=RIGHT><INPUT TYPE=SUBMIT VALUE='EVENTUAL'></TD><TD></TD>";
echo "</FORM>";

   
/*
  $valor = 0.00;
  $valor = number_format($valor, 2,'.','');  
*/

?>

<html>
<body>
<?php

session_start();
echo "<title>RESUMO CONTA CAIXA</title>";
require_once('../config/relatorios.class.php');
require_once('relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$new = new Relatorios;
$new->conexao();

if (!isset($_POST["id_grafico"]))
 {

  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";
 
// cadastro de graficos 
$cad_grafico = $relatorio->get_cad_grupos();

echo "SELECIONE O GRAFICO:
<form action='#' method='post'>
  <TABLE>
     <tr><td>GRAFICO</td><td>
		   <SELECT name='id_grafico'>";   
			foreach ($cad_grafico as $key => $value) 
			  {

				echo "<option value=$value[0]>$value[1]</option>";

			  }
			echo "
		   </SELECT></td></tr>
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

 
// VARIAVEIS RECEBEM O VALOR
if (!isset($_POST['id_grafico'])) exit;

 $dataini = $_POST['dataini'].'-01';
 $datafin = $_POST['datafin'].'-31';

  
    ## ID/NOME GRAFICO
	$idgraf = $_POST['id_grafico'];
	$namegraf = $relatorio->get_nome_graf($idgraf);
	
	$nom_g  = $namegraf[0];
	
	$_SESSION['NomeGraf'] = $nom_g;

	//print_r($nom_g); die();
	
//$data_mes_ano = explode('-', $dataini); 
//$mes = $data_mes_ano[0];
//$ano = $data_mes_ano[1];

//$mes_ano = $data_mes_ano[0].'-'.$data_mes_ano[1].'-01';

  $id_grafico = $_POST['id_grafico'];
  $grupos = $relatorio->get_all_cad_grupo($id_grafico);

  
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
	   <TD>GRUPO SELECIONADO</TD>
	   <TD>DADOS GRAFICO</TD>
	</TR>";	

  

# LE TODOS OS REGISTROS DA TABELA DRE
$registros = $new->get_dre_ajuste($dataini, $datafin);

echo "<form action='grafico_barras_dados.php' method='post'>";

# SE NAO EXISTE DADOS
if(!$registros) die('SEM DADOS PARA GERAR O GRAFICO!!! FAZER DRE!!!');  
$cont = 0;
foreach ($registros as $i => $registro){
//echo '<pre>'; print_r($registros); die();
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	$cont++;

	$sql = "select seg_grupo from contacaixa_grupos where id_grafico=$id_grafico and conta_caixa=$registro[2]";
	$grupo = $relatorio->query($sql); 
	//print_r($grupo);
	$grupo_result = $relatorio->fetch_array($grupo);
	
	//print($grupo_result[0]); die();
	
	$sql = "select * from cadastro_grupos where seq_grupo=$grupo_result[0]"; //print_r($sql); echo '<br>';
	if ($grupo_result[0])
	$grupo = $relatorio->query($sql);  
	//print_r($grupo);
	$grupo_result = $relatorio->fetch_array($grupo);
	//print_r($grupo_result[3]); echo '<br>';
	
	
	//print_r($grupo_result[0]);
	//print_r($id_grafico); echo ' '; print_r($registro[2]);
	
	
	
	
	echo "
	  <TR  bgcolor=$cor>
		   <TD>"; echo $registro[1]; echo "</TD>
		   <TD ALIGN=CENTER>"; echo $registro[2]; echo "</TD>
		   <TD>"; echo $registro[3]; echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro[4] < 0)?'RED':'BLUE'; echo ">"; echo $registro[4]; echo "</TD>
		   <TD ALIGN=RIGHT>"; echo $registro[5]; echo "</TD>
		   <TD ALIGN=RIGHT>"; echo $registro[6]; echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro[4] < 0)?'RED':'BLUE'; echo ">"; echo $registro[7]; echo "</TD>
		   <TD ALIGN=RIGHT>"; echo $registro[8]; echo "</TD>
		   <TD ALIGN=RIGHT><FONT COLOR="; echo ($registro[9] < 0)?'RED':'BLUE'; echo ">"; echo $registro[9]; echo "</TD>
		   <TD>
			   <SELECT name=val_graf["; echo $i; echo"][grupo]> <!-- ####### SELECT GRUPO SELECIONADO ########### -->
							<option></option>";   
							foreach ($grupos as $key => $value) 
							  {
								$selected = ''; 
								if ($grupo_result[2] == $value[2]) $selected = 'selected';
								echo "<option $selected value=$value[2]-"; echo str_replace(' ', '_', $value[3]); echo " >$value[2] - $value[3]</option>";
							  }
							echo "
			   </SELECT>
		   </TD>
		   <TD  bgcolor=WHITE>"; 
			 if($i == 1) {
				echo "
					 <SELECT required name='id_grafico_receita'>
							<option></option>";   
							foreach ($grupos as $key => $value) 
							  {
								echo "<option value=$value[2]".'-'."$value[3]>$value[2] - $value[3]</option>";
							  }
							echo "
						   </SELECT>"; }
						   
				else if($i == 0) echo "GRUPO REFERENCIA";
						   
				else if($i == 2) echo "<input type=submit name='botao'value='GERAR GRAFICO'>";
				
				else if($i == 3) echo "<input type=submit name='botao' value='GERAR RELATORIO'>";
				
						   
			    echo "
		   
		   
		   
		   
		   
		   
		   </TD>
	   <INPUT TYPE=hidden NAME=val_graf["; echo $i; echo "][valor_eventual] VALUE="; print_r($registro[8]); echo ">	
	   <INPUT TYPE=hidden NAME=val_graf["; echo $i; echo "][valor] VALUE="; print_r($registro[9]); echo ">		
	   <!--<INPUT TYPE=hidden NAME=val_graf["; echo $i; echo "][contacaixa] VALUE="; print_r($registro[2]); echo ">-->	
	   <INPUT TYPE=hidden NAME=data VALUE="; print_r($registro[1]); echo ">		
	   </TR>";
}
  
  echo "<INPUT TYPE=hidden NAME=nome_grafico VALUE="; print_r($nom_g); echo ">";
  
 echo "</form>"; 
 // echo '<pre>'; print_r($registros); die();

 
?>
</body>

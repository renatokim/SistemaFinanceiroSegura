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

echo "<form action='dados_grafico.php' method='post'>";

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
			   <SELECT name=grupo["; echo $i; echo"]> <!-- ####### SELECT GRUPO SELECIONADO ########### -->
							<option></option>";   
							foreach ($grupos as $key => $value) 
							  {
								$selected = ''; 
								if ($grupo_result[2] == $value[2]) $selected = 'selected';
								echo "<option value=$value[2]".'-'."$value[3] $selected>$value[2] - $value[3]</option>";
							  }
							echo "
			   </SELECT>
		   </TD>
		   <TD  bgcolor=WHITE>"; 
			 if($i == 1) {
				echo "
					 <SELECT name='id_grafico_receita'>
							<option></option>";   
							foreach ($grupos as $key => $value) 
							  {
								echo "<option value=$value[2]".'-'."$value[3]>$value[2] - $value[3]</option>";
							  }
							echo "
						   </SELECT>"; }
						   
				else if($i == 3) echo "<input type=text name=nome_relatorio required>";
						   
				else if($i == 4) echo "<input type=submit value='GERAR GRAFICO'>";
				
				else if($i == 0) echo "GRUPO REFERENCIA";
				
				else if($i == 2) echo "GRUPO FINAL";
				
						   
			    echo "
		   
		   
		   
		   
		   
		   
		   </TD>
	   
	   <INPUT TYPE=hidden NAME=valor["; echo $i; echo "] VALUE="; print_r($registro[9]); echo ">		
	   <INPUT TYPE=hidden NAME=contacaixa["; echo $i; echo "] VALUE="; print_r($registro[2]); echo ">		
	   <INPUT TYPE=hidden NAME=data VALUE="; print_r($registro[1]); echo ">		
	   </TR>";
}
  
  echo "<INPUT TYPE=hidden NAME=nome_grafico VALUE="; print_r($nom_g); echo ">";
  
 echo "</form>"; 
 // echo '<pre>'; print_r($registros); die();

  
 
  
 	
##############################################
##############CONTINUAR AQUI     
############################################## 
/*
$a=0; 
 echo "<form action='grafico.php' method='post'>";
  for ($i = 0; $i < $nlinhas; $i++)
   {
	  if($cont % 2 == 0)
		 $cor = 'white';
	  else 
		 $cor = 'Gainsboro'; 

	$linha = $relatorio->fetch_array($resultado);

	 # CONTA-CAIXA
     $conta_caixa = $linha[0];
	 
	 # ja tenho ID GRAFICO e conta-caixa - pegar grupo do conta-caixa
	
	$sql = "SELECT * FROM cadastro_grupos 
		  WHERE seq_grupo=(SELECT seg_grupo FROM contacaixa_grupos WHERE conta_caixa=$conta_caixa AND id_grafico=$id_grafico)
		  AND id_cadastro_grafico=$id_grafico";
//echo ++$a;
		 // echo '<pre>'; print_r($sql);
$grupo = $relatorio->query($sql); 
$grupo_result = $relatorio->fetch_array($grupo);
$result_option = $grupo_result[2].' - '.$grupo_result[3];	 

	   
	   echo "
        <TR  bgcolor=$cor>
			 <TD ALIGN=CENTER>$conta_caixa</TD>
			 <TD>$descricao "; echo $lll++;  echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=$corfonte>$sum</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=SaddleBrown>"; if($ajuste > 0) echo $ajuste; echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=SaddleBrown>"; if($ajuste_i > 0) echo $ajuste_i; echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=$corfonte>"; echo number_format($ajustado - $ajuste_i, 2,'.',''); echo "</TD>		<!-- vrl ajustado -->
			 <TD ALIGN=RIGHT><FONT COLOR=SaddleBrown>"; if($evt_lanc != 1) print_r($evt_lanc[0]['valor']); echo "</TD>     <!-- vrl eventual -->
			 <TD ALIGN=RIGHT>"; echo number_format(($ajustado - $ajuste_i) - $evt_lanc[0]['valor'] , 2,'.',''); echo "</TD> <!-- vrl mensal -->
			 <TD>";
			 
			$vlr_mensal = number_format(($ajustado - $ajuste_i) - $evt_lanc[0]['valor'], 2,'.','');
			
			echo "<INPUT NAME=vlr_eventual["; echo $i; echo"][0] TYPE=HIDDEN VALUE="; echo $vlr_mensal; echo ">";

			
			
			 echo "
				<SELECT name=vlr_eventual["; echo $i; echo"][1]>
					<option></option>";   
					foreach ($grupos as $key => $value) 
					  {
					    $selected = ''; 
						if ($grupo_result[2] == $value[2]) $selected = 'selected';
						echo "<option value=$value[2]".'-'."$value[3] $selected>$value[2] - $value[3]</option>";
					  }
					echo "
				   </SELECT>
			 </TD>
			 <TD bgcolor=WHITE>"; 
			 if($i == 1) {
				echo "
					 <SELECT name='id_grafico_receita'>
							<option></option>";   
							foreach ($grupos as $key => $value) 
							  {
								echo "<option value=$value[2]".'-'."$value[3]>$value[2] - $value[3]</option>";
							  }
							echo "
						   </SELECT>"; }
						   
				else if($i == 3) echo "<input type=text name=nome_relatorio required>";
						   
				else if($i == 4) echo "<input type=submit value='GERAR GRAFICO'>";
				
				else if($i == 0) echo "GRUPO REFERENCIA";
				
				else if($i == 2) echo "NOME GRAFICO";
				
						   
			    echo "</TD>
        </TR>";	
*/

?>
</body>

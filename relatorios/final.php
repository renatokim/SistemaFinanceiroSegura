<html>
<body>
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
 
// cadastro de graficos 
$cad_grafico = $relatorio->get_cad_grupos();

echo "SELECIONE O PERIODO:
<form action='#' method='post'>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
   </TR>
   <tr><td>GRAFICO</td><td>
		   <SELECT name='id_grafico'>";   
			foreach ($cad_grafico as $key => $value) 
			  {

				echo "<option value=$value[0]>$value[1]</option>";

			  }
			echo "
		   </SELECT></td></tr>
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

    $_SESSION['data_arqfin_ini'] = $dataini;
    $_SESSION['data_arqfin_fin'] = $datafin;    

    ## ID/NOME GRAFICO
	$idgraf = $_POST['id_grafico'];
	$namegraf = $relatorio->get_nome_graf($idgraf);
	
	$nom_g  = $namegraf[0];
	
	$_SESSION['NomeGraf'] = $nom_g;

	
$data_mes_ano = explode('-', $dataini); 
$mes = $data_mes_ano[0];
$ano = $data_mes_ano[1];

$mes_ano = $data_mes_ano[0].'-'.$data_mes_ano[1].'-01';

//print_r($_POST); 
//print_r($mes_ano); die();


  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
   <TD>CONTA-CAIXA</TD>
   <TD>DESCRIÇÃO</TD>
   <TD>VALOR</TD>
   <TD>AJUSTE RETIRA</TD>
   <TD>AJUSTE INCLUI</TD>
   <TD>VLR AJUSTADO</TD>
   <TD>VLR EVENTUAL</TD>
   <TD>VLR MENSAL</TD>
   <TD>GRUPO SELECIONADO</TD>
   <TD>DADOS GRAFICO</TD>
  </TR>";	

  $corfonte = 'BLUE';
  $cont=0;

  $valor = 0.00;
  $valor = number_format($valor, 2,'.','');  
  $set = 0;   
  $cor = 'white';  
  
  
  $id_grafico = $_POST['id_grafico'];
  $grupos = $relatorio->get_all_cad_grupo($id_grafico);

  $resultado = $relatorio->relatcntcxgroupby($dataini, $datafin);
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
  
    $resultado_2 = $relatorio->relatcntcxgroupby_2($dataini, $datafin);

	$soma_valor = 0;
	$soma_ajst_ret = 0;
	$soma_ajst_inc = 0;
	$soma_vlr_ajst = 0;
	$soma_vlr_evnt = 0;
	$soma_vlr_mens = 0;	
	
##############################################
// CADA LINHA DO RELATORIO
############################################## 
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

     $vr_ajst = $relatorio->se_tem_ajuste_retira($conta_caixa);
	 $vr_ajst_sum = $relatorio->se_tem_ajuste_inclui($conta_caixa);
	 
############################### CONTA CAIXA RETIRA ##############################
	 
      if($vr_ajst != 1)
        {
          $soma_ajuste = 0.0;
          foreach ($vr_ajst as $key => $value) 
            {
              if($value['vlr_or_pecent'] == '%')
                {
				  //echo '<pre>'; print_r($linha); die();
                  $ajuste = $linha['Valor']*($value['valor']/100)*-1; //if($ajuste<0) $ajuste*=-1;
                  $soma_ajuste+=$valor;
				  
				  $sess = $linha[0]; 
				  $_SESSION['_'."$sess"] = $ajuste; 
				  //$ses = $_SESSION[$sess];
				  //print_r($_SESSION['_'."$sess"]);
				  //print_r($_SESSION['_'."$sess"]);
				  
                }
              else
                {
                  $ajuste = $value['valor']; //if($ajuste<0) $ajuste*=-1;
                  $soma_ajuste+=$valor;
                }
				
			
			// SE CX_INCLUI NAO CONSTA NO RELATORIO
			$const = 0;
			
			
			foreach($resultado_2 as $l => $var)
			 {
			   if ($vr_ajst[$key]['cx_inclui'] == $var['Conta-caixa'])
			   {
				//echo $vr_ajst[$key]['cx_inclui']; 	 echo ' ';		   
				//echo $var['Conta-caixa'];
				$const = 1;
			   }
			 }
			 
			 if ($const == 0){
			
			$inc[][0] = $vr_ajst[$key]['cx_inclui'];
			$inc2[][0] = $vr_ajst[$key][5];
			$inc3[][0] = $ajuste;
			}
				
          }
        }
      else 
        {
          $soma_ajuste = 0; $ajuste = 0; 
        }
	
	////// CONTA CAIXA INCLUI ##################################
	
      if (!empty($vr_ajst_sum))
        {
          $soma_ajuste_i = 0.0;
          foreach ($vr_ajst_sum as $key => $value) 
            {
              if($value['vlr_or_pecent'] == '%')
                {
				 //print_r($_SESSION['_'."$sess"]);
				 //echo '<pre>'; print_r($linha); print_r($value);  ##### PEGAR VALOR ######
				 //$linha['Valor']*($value['valor']/100)*-1;
                  
				  #################
				  
				  //$sS = $linha[0];
				  //$ajuste_i = $linha['Valor']*($value['valor']/100)*-1;
				  //$ajuste_i = $_SESSION['_'."$sess"];
				  
				  //print_r($ajuste_i); die();
                  $soma_ajuste_i+=$valor;
                }
              else
                {
                  $ajuste_i = $value['valor']; //if($ajuste<0) $ajuste*=-1;
                  $soma_ajuste_i+=$valor;
                }
			}
        }
      else 
        {
          $soma_ajuste_i = 0; $ajuste_i = 0; 
        }		
	

		
		
		
		


      $evt_lanc = $relatorio->se_tem_eventual_lancado($conta_caixa); 
      if($evt_lanc[0]['valor'] < 0) $evt_lanc[0]['valor'] *= -1;


       $descricao = $linha[1];
       $sum = $linha[2];
       $sum = number_format($sum, 2,'.','');
       $ajuste = number_format($ajuste, 2,'.','');
       if ($sum > 0 ) $ajustado = number_format($sum-$ajuste, 2,'.',''); else $ajustado = number_format($sum+$ajuste, 2,'.','');

	   $ajuste_i = number_format($ajuste_i, 2,'.','');

// vrl ajustado # $ajustado - $ajuste_i
// vlr eventual # $evt_lanc[0]['valor']
// vlr mensal   # ($ajustado - $ajuste_i) - $evt_lanc[0]['valor']  

if (($ajustado - $ajuste_i) < 0 && $evt_lanc[0]['valor'] > 0) $evt_lanc[0]['valor'] *= -1;



	   
	   echo "
        <TR  bgcolor=$cor>
			 <TD ALIGN=CENTER>$conta_caixa</TD>
			 <TD>$descricao "; /*echo $lll++; */ echo "</TD>
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

					    $soma_valor += $sum;
	if($ajuste > 0)     $soma_ajst_ret += $ajuste;
	if($ajuste_i > 0)   $soma_ajst_inc += $ajuste_i;
						$soma_vlr_ajst += ($ajustado - $ajuste_i);
	if($evt_lanc != 1)  $soma_vlr_evnt += $evt_lanc[0]['valor'];
						$soma_vlr_mens += (($ajustado - $ajuste_i) - $evt_lanc[0]['valor']);	
		
     $cont++;

	 }
	 
########################## F30M R20L10T S20M 10D30C3040N10D40S
	
}

$relatorio->delete_temp_cx_incluidos();

foreach ($inc as $v => $vinc)
	{
	   //echo $inc[$v][0]; echo ' '; echo $inc2[$v][0]; echo ' '; echo $inc3[$v][0]; echo ' ';
	   $conta_caixa_inc = $inc[$v][0];
	   $desc_cntcx_ins = $inc2[$v][0];
	   $valor_cntx_ins = $inc3[$v][0];

	   // insert
	   $relatorio->add_cntx_incluidos($conta_caixa_inc, $desc_cntcx_ins, $valor_cntx_ins); 
	   
	 }
	 
###################  INSERE CONTA CAIXA ########################################	 
 /*
 // get
 $grupos_incluidos = $relatorio->get_temp_cx_incluidos();
 

  // foreach
 foreach($grupos_incluidos as $t => $tvalor)
	{
	
      if($cont % 2 == 0)
		 $cor = 'white';
	  else 
		 $cor = 'Gainsboro'; 
	
	
		   echo "
        <TR  bgcolor=$cor>
			 <TD ALIGN=CENTER>"; echo $tvalor[0]; echo "</TD>
			 <TD>"; echo str_replace('_', ' ', $tvalor[1]); echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=$corfonte>"; echo 0; echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=SaddleBrown>";  echo ' '; echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=SaddleBrown>";  echo $tvalor[2]; echo "</TD>
			 <TD ALIGN=RIGHT><FONT COLOR=$corfonte>"; echo $tvalor[2]*-1; echo "</TD>		<!-- vrl ajustado -->
			 <TD ALIGN=RIGHT><FONT COLOR=SaddleBrown>"; echo ' '; ; echo "</TD>     <!-- vrl eventual -->
			 <TD ALIGN=RIGHT>"; echo $tvalor[2]; echo "</TD> <!-- vrl mensal -->
			 <TD>";

			 
			$vlr_mensal = number_format($ajustado + $evt_lanc[0]['valor'], 2,'.','');
			
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
			 <TD bgcolor=WHITE>"; if($i == 0) {
				echo "
					 <SELECT name='id_grafico_receita'>
							<option></option>";   
							foreach ($grupos as $key => $value) 
							  {
								echo "<option value=$value[2]".'-'."$value[3]>$value[2] - $value[3]</option>";
							  }
							echo "
						   </SELECT>"; }
						   
						   else if($i == 1) echo "<input type=submit value='GERAR GRAFICO'>"
						   
						   ; echo "</TD>
        </TR>";
	
	
	$cont++;

	//$soma_valor += $tvalor[2];
	$soma_ajst_ret += 0;
	$soma_ajst_inc += $tvalor[2];
	$soma_vlr_ajst += $tvalor[2];
	$soma_vlr_evnt += 0;
	$soma_vlr_mens += $tvalor[2];	
	
  }
 
/*
echo '<pre>';
print_r($inc);
print_r($inc2);
print_r($inc3);
print_r($grupos_incluidos);
*/
###################################### FIM INSERE CONTACAIXA

########################## FIM CADA LINHA DO RELATORIO


########################## TOTAL #####################
  echo "
  <TR bgcolor='LightSteelBlue'>
   <TD>"; echo "</TD>
   <TD>"; echo "</TD>  
   <TD ALIGN=RIGHT>"; echo number_format($soma_valor, 2,'.',''); echo "</TD>
   <TD ALIGN=RIGHT>"; echo number_format($soma_ajst_ret, 2,'.',''); echo "</TD>
   <TD ALIGN=RIGHT>"; echo number_format($soma_ajst_inc, 2,'.',''); echo "</TD>
   <TD ALIGN=RIGHT>"; echo number_format($soma_vlr_ajst, 2,'.',''); echo "</TD>
   <TD ALIGN=RIGHT>"; echo number_format($soma_vlr_evnt, 2,'.',''); echo "</TD>
   <TD ALIGN=RIGHT>"; echo number_format($soma_vlr_mens, 2,'.',''); echo "</TD>
   <TD></TD>
   <TD bgcolor=WHITE></TD>
  </TR>";


/*
	$soma_valor
	$soma_ajst_ret
	$soma_ajst_inc
	$soma_vlr_ajst
	$soma_vlr_evnt
	$soma_vlr_mens
*/


echo "</table>";


}



?>
</body>

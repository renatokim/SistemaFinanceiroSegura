<?php

echo "<link rel='stylesheet' type='text/css' href='style.css' />";

echo "<title>CONFERENCIA CONCILIACAO</title>";
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
<form action=relatconciliacao.php method='post'>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
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
   <TD>REGISTRO</TD>
   <TD>CONTA</TD>
   <TD>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD>
   <TD>VALOR</TD>
   <TD>IDENTIFICAÇÃO</TD>
   <TD>CONTACAIXA</TD>
   <TD>DESC CONTACAIXA</TD>
  </TR>";	

  $corfonte = 'BLUE';
  $cont=0;
  $soma = 0.00;
  $soma = number_format($soma, 2,'.','');
  $valor = 0.00;
  $set = 0;   
  $cor = 'white';  

  
  // RELATORIO CONCILIACAO BANCO
  $cntcx_conc_entrada = 1310000; 
  $cntcx_conc_saida = 2310000;
  $resultado = $relatorio->relatconc($dataini, $datafin, $cntcx_conc_entrada, $cntcx_conc_saida);  
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS


	 
	
	// INICIO DAS LINHAS
  for ($i = 0; $i < $nlinhas; $i++)
   {	
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	
	 $linha = $relatorio->fetch_array($resultado);
	  
  	 $id = $linha['id'];
     $id_conta_corrente = $linha['id_conta_corrente'];
     $data_emissao = $linha['data_emissao'];
     $historico = $linha['historico'];
     $numero_doc = $linha['numero_doc'];
     $valor = $linha[5]; ($valor < 0)?$corfonte='RED':$corfonte='BLUE';
     $conta_caixa = $linha['conta_caixa'];
     $desc_conta_caixa = $linha['descricao'];
     $descricao = $linha['obs'];

     echo "
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$id</TD>
         <TD ALIGN=CENTER>$id_conta_corrente</TD>
         <TD>$data_emissao</TD>
         <TD>$historico</TD>
         <TD>$numero_doc</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
     <TD><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$descricao</TD>
     <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$conta_caixa</TD> 
         <TD>$desc_conta_caixa</TD>
        </TR>";	

     $soma += $valor;	 
     $cont++;
	 $soma = number_format($soma, 2,'.','');
   }

    ($soma < 0)?$corfonte='RED':$corfonte='BLUE';
 
    echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$soma</font></TD>
         <TD></TD>
         <TD></TD>
         <TD></TD>
        </TR>";	

		
		// CONCILIACAO TERCEIROS
  $cntcx_conc_entrada = 1320000; 
  $cntcx_conc_saida = 2320000;
  $resultado = $relatorio->relatconc($dataini, $datafin, $cntcx_conc_entrada, $cntcx_conc_saida);  
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS

  $soma = 0.00;
  $soma = number_format($soma, 2,'.','');
	
	// INICIO DAS LINHAS
  for ($i = 0; $i < $nlinhas; $i++)
   {	
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	
	 $linha = $relatorio->fetch_array($resultado);
	  
  	 $id = $linha['id'];
     $id_conta_corrente = $linha['id_conta_corrente'];
     $data_emissao = $linha['data_emissao'];
     $historico = $linha['historico'];
     $numero_doc = $linha['numero_doc'];
     $valor = $linha[5]; ($valor < 0)?$corfonte='RED':$corfonte='BLUE';
     $conta_caixa = $linha['conta_caixa'];
     $desc_conta_caixa = $linha['descricao'];
     $descricao = $linha['obs'];

     echo "
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$id</TD>
         <TD ALIGN=CENTER>$id_conta_corrente</TD>
         <TD>$data_emissao</TD>
         <TD>$historico</TD>
         <TD>$numero_doc</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
         <TD><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$descricao</TD>
         <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$conta_caixa</TD>
         <TD>$desc_conta_caixa</TD>
        </TR>";	

     $soma += $valor;	 
     $cont++;
	 $soma = number_format($soma, 2,'.','');
   }

    ($soma < 0)?$corfonte='RED':$corfonte='BLUE';
 
    echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$soma</font></TD>
         <TD></TD>
         <TD></TD>
		 <TD></TD>
        </TR>";	
   
   // CONCILIACAO SALDOS
   
     $cntcx_conc_entrada = 3100000; 
  $cntcx_conc_saida = 3200000;
  $resultado = $relatorio->relatconc($dataini, $datafin, $cntcx_conc_entrada, $cntcx_conc_saida);  
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS


	
	// INICIO DAS LINHAS
  for ($i = 0; $i < $nlinhas; $i++)
   {	
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	
	 $linha = $relatorio->fetch_array($resultado);
	  
  	 $id = $linha['id'];
     $id_conta_corrente = $linha['id_conta_corrente'];
     $data_emissao = $linha['data_emissao'];
     $historico = $linha['historico'];
     $numero_doc = $linha['numero_doc'];
     $valor = $linha[5]; ($valor < 0)?$corfonte='RED':$corfonte='BLUE';
     $conta_caixa = $linha['conta_caixa'];
     $desc_conta_caixa = $linha['descricao'];
     $descricao = $linha['obs'];

     echo "
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$id</TD>
         <TD ALIGN=CENTER>$id_conta_corrente</TD>
         <TD>$data_emissao</TD>
         <TD>$historico</TD>
         <TD>$numero_doc</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
         <TD><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$descricao</TD>
         <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$conta_caixa</TD>
         <TD>$desc_conta_caixa</TD>
        </TR>";	

     $soma += $valor;	 
     $cont++;
	 $soma = number_format($soma, 2,'.','');
   }

    ($soma < 0)?$corfonte='RED':$corfonte='BLUE';
 
    echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$soma</font></TD>
         <TD></TD>
         <TD></TD>
         <TD></TD>
        </TR>";	
   
   
   
 } 

 

		
		
		
		
		
		
		
		
		
		
		
		
		
}









?>





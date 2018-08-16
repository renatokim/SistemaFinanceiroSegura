<?php

echo "<title>INCLUIR CAIXA</title>";
require_once("../config/caixa.class.php");
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


echo "<head><link rel=\"stylesheet\" href=\"formulario.css\"></head>";

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

$caixa = new Caixa;

$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta=6';
 
$caixa->conexao();
$resultado = $caixa->query($sql);
$ncontas = $caixa->afect_rows($resultado);

echo "
 INSERIR LANCAMENTO NO CAIXA
  <FORM METHOD=post ACTION='caixa.php'>
   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $caixa->fetch_array($resultado);
	  //$conta = $linha[$i];
	  echo "<option>$linha[0]</option>";
	  //echo $linha[0];
     }
	echo "
   </SELECT>
   <BR>
   <BR>
   
   <TABLE>
    <TR>
     <TD ALIGN=CENTER>HISTORICO</TD>
	 <TD ALIGN=CENTER>DATA</TD>
	 <TD ALIGN=CENTER>VALOR</TD>
	 <TD ALIGN=CENTER>DESCRICAO
	</TR>
	<TR>
     <TD><INPUT TYPE='text' SIZE=20 NAME='historico' required></TD>
	 <TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
	 <TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'></TD>
	 <TD><INPUT TYPE='text' SIZE=20 NAME='descricao' required></TD>
	 </TD><TD><INPUT TYPE='submit' value='INCLUIR'/></TD>	
	</TR>
   </TABLE>
   
  </FORM>
  ";

if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
  if(isset($_POST["historico"]))
   {
    $historico = $_POST["historico"];
    if(isset($_POST["data"]))
     {
      $data = $_POST["data"];
	  if (isset($_POST["valor"]))
	   {
	   $valor = $_POST["valor"];
	   $valor = str_replace(',', '.', $valor);
       if(isset($_POST["descricao"]))
        {
	     $descricao = $_POST["descricao"];
		
		 // SELECIONA O ID DA DESCRICAO DA CONTA
		 // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
		 $result = $caixa->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
		 $id_conta = $caixa->fetch_array($result);

		 $id = $id_conta[0];
		 $conta_caixa = 0;
		 $doc = $historico;
		 $obs = $descricao;
		 // INSERE CAIXA NO EXTRATO
		 $caixa->inserir($id, $data, $historico, $doc, $valor, 0, $obs);
		}	
     }		
   }
  }
 }

 
 if (!isset($_POST["dataini"]) && !isset($_POST["datafin"]))
 {
 
  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";
 
echo "SELECIONE O PERIODO:
<form action='' method='post'>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
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
    
  /* PRIMEIRA LINHA */
  $resultado = $relatorio->relatoriocaixa($dataini, $datafin);
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
  
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

	// MOSTRA A PRIMEIRA LINHA
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
	 
     $subbanco = $id_conta_corrente; 
	 $cont++;
	 $soma += $valor;
	 /* FIM PRIMEIRA LINHA */
	 
	
	// INICIO DAS OUTRAS LINHAS
	for ($i = 0; $i < $nlinhas -1; $i++)
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

	 if ($subbanco == $id_conta_corrente)
	  {
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
	 
	 


     else 
	  {
    ($soma < 0)?$corfonte='RED':$corfonte='BLUE';
	$soma /= 2;
	$soma = number_format($soma, 2,'.','');
	 	   echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$soma</font></TD>
         <TD></TD>
         <TD ALIGN=CENTER><a href='' onclick=\"window.open('page.html','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=100')\" style='text-decoration:none'></TD>
         <TD></TD>
        </TR>";	
		
				     $subbanco = $id_conta_corrente;
			 $soma = 0.00;
			   $cor = 'white';
		
		($valor < 0)?$corfonte='RED':$corfonte='BLUE';
		
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
		
		$cont++;
		     $soma += $valor;	
		

		
	  }
	// echo "</TABLE>";
/*
	if($cont % 2 == 0)
     $cor = 'white';
     else 
     $cor = 'Gainsboro';

*/

	   //$subbanco = $conta_caixa;
	  // $soma += $valor;


	 

	 /*

	echo "
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>$id</TD>
     <TD ALIGN=CENTER>$id_conta_corrente</TD>
     <TD>$data_emissao</TD>
     <TD>$historico</TD>
     <TD>$numero_doc</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
     <TD>$descricao</TD>
     <TD ALIGN=CENTER><a href='' onclick=\"window.open('page.html','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=100')\" style='text-decoration:none'>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
    </TR>";
	
	
	
	  $soma += $valor;
	  $cont++;

	
	 //} while ($linha = $relatorio->fetch_array($resultado));
 */  

 } // fim do while

 		($soma < 0)?$corfonte='RED':$corfonte='BLUE';
		$soma /= 2;
		$soma = number_format($soma, 2,'.','');
	 	   echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$soma</font></TD>
         <TD></TD>
         <TD ALIGN=CENTER><a href='' onclick=\"window.open('page.html','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=100')\" style='text-decoration:none'></TD>
         <TD></TD>
        </TR>";	

}



}
 
 
 
 
 
  

  
  





?>

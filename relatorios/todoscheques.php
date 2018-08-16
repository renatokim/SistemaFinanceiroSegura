<?php

echo "<title>CHEQUE PENDENTE</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$sql = 'SELECT descricao FROM conta_corrente';
 
$relatorio->conexao();
$resultado = $relatorio->query($sql);
$ncontas = $relatorio->afect_rows($resultado);

// PRIMEIRA OPÇÃO - ESCOLHA DA CONTA
if (!isset($_POST["contas"]))
 {
  echo "
  ESCOLHA A CONTA
  <FORM METHOD=post ACTION='todoscheques.php'>
   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $relatorio->fetch_array($resultado);

	  echo "<option>$linha[0]</option>";
     }
	echo "
   </SELECT>
   <BR>
   <BR>
   <INPUT TYPE='submit' value='CONFIRMAR'/>
  </FORM>
  ";
 }

// SE ESCOLHIDA CONTA
if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
  $soma = 0.00;
  
  // SELECIONA O ID DA CONTA-CORRENTE PELA DESCRICAO
  $sql = "SELECT id FROM conta_corrente WHERE descricao='$contas'";

  $resultado = $relatorio->query($sql);
  $linha = $relatorio->fetch_array($resultado);  
  $id_conta_corrente = $linha[0];
  
 
  // CABECALHO DA TABELA
  echo "
  <TABLE BORDER=0 CELLSPACING=1>
   <TR bgcolor='LightSteelBlue'>
    <TD>CONTA</TD>
    <TD>DATA EMISSÃO</TD>
    <TD>HISTORICO</TD>
    <TD>NUMERO CHQ</TD>
    <TD>VALOR</TD>
    <TD>VENCIMENTO</TD>   
    <TD>CONTA-CAIXA</TD>
    <TD>DESC CONTA-CAIXA</TD>
   </TR>
   ";	

 $corfonte = 'RED';
 $cont=0;
    
 $resultado = $relatorio->chqtodos($id_conta_corrente);
 $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS

 for ($i=0; $i<$nlinhas; $i++)
  {
   if($cont % 2 == 0)
    $cor = 'white';
   else 
    $cor = 'Gainsboro';
	 
   $linha = $relatorio->fetch_array($resultado);
    
   $id_conta_corrente = $linha['id_conta_corrente'];
   $data_emissao = $linha['data_emissao'];
   $historico = $linha['historico'];
   $numero_doc = $linha['numero_doc'];
   $valor = $linha[5]; //($valor < 0)?$corfonte='RED':$corfonte='BLUE';
   $datavencimento = $linha['data_vencimento'];
   $conta_caixa = $linha['conta_caixa'];
   $desc_conta_caixa = $linha['descricao'];

   $soma += $valor;
   

   echo "
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>$id_conta_corrente</TD>
     <TD ALIGN=CENTER>$data_emissao</TD>
     <TD>$historico</TD>
     <TD ALIGN=CENTER>$numero_doc</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
     <TD ALIGN=CENTER>$datavencimento</TD>

	 <TD ALIGN=CENTER>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
    </TR>
   ";
   $cont++;
  }
/*
 $soma = number_format($soma, 2,'.',''); 
 echo "
   <TR bgcolor='LightSteelBlue'>
    <TD></TD>
    <TD></TD>
    <TD></TD>
    <TD ALIGN=CENTER>CHQ PENDENTE</TD>
    <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$soma</font></TD>
    <TD></TD>   
    <TD></TD>
    <TD></TD>
   </TR>
 ";
*/
 
 }


 
 

?>





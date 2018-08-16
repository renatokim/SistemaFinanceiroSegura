<?php 

require_once("../config/contacaixa.class.php");

echo "<BODY BGCOLOR = 'Lavender' </BODY>";

$objdescricao = new Contacaixa;
$objdescricao->conexao();

if(isset($_GET["registro"]))
 {
  $regist = $_GET["registro"];
  $acao = $_GET["acao"];
  $data_emissao = $_GET["data_emissao"];
  $valor = $_GET["valor"];
  $descricao = $_GET["descricao"];
   
  echo "<TABLE BORDER=0 CELLSPACING=2>
         <TR>
		  <TD  bgcolor='Gainsboro'>$data_emissao</TD>
		  <TD  bgcolor='Gainsboro'>$descricao</TD>
		  <TD  bgcolor='Gainsboro'>$valor</TD>
		 </TR>
		</TABLE>

  <FORM METHOD=GET ACTION='descricao.php'>

   <INPUT TYPE='hidden' NAME='regist' VALUE=$regist>
   <INPUT TYPE='hidden' NAME='acao' VALUE=$acao>
  
   <TABLE>
    <TR>
     <TD ALIGN=CENTER>DESCRICAO:</TD><TD><INPUT TYPE='text' SIZE=50 NAME='descricao' VALUE='$descricao'></TD>
    </TR>
     <TD></TD><TD><INPUT TYPE='submit' NAME='botao' value='ALTERAR'/></TD>
	 </TR>
    </TABLE>
   </FORM>
          ";	   
	   
 }


if(isset($_GET["botao"]))
 {
  $registro = $_GET["regist"];
  $acao = $_GET["acao"];
  $descricao = $_GET["descricao"];

  
  
  if ($acao == "alterar")
   {
    $objdescricao->setdescricao($registro, $descricao);
	
	echo "
	<script type=\"text/javascript\">
     \"window.close()\";
    </script>
	";
	
   }


// ALTERA A DESCRICAO "OBS" DO EXTRATO
//$descricao = 'teste';
//$descricao->setdescricao(5180, $descricao);

// ALTERA O CONTA CAIXA DO EXTRATO
//$conta = 1400000;
//$descricao->setcontacaixa(1414, $conta);
 
// INSERE NO EXTRATO COM CONTA CAIXA
//$id_conta = 1; $data = '2012-09-19'; $historico = 'teste'; $doc = '100'; $valor = 9999.99; $conta_caixa = 0; $obs = 'teste obs';
//$descricao->inserir($id_conta, $data, $historico, $doc, $valor, $conta_caixa, $obs);

// INSERE CHEQUES
//$id_conta_corrente = 1; $data = '2012-09-19'; $historico = 'chq teste'; $doc = '854000'; $valor = 100.45; $data_vencimento = '2012-09-19';
//$numcontacaixa = 0;
//$descricao->inserirchq($id_conta_corrente, $data, $historico, $doc, $valor, $data_vencimento, $numcontacaixa);

}
?>
<?php

echo "<title>CAIXA</title>";
require_once("../config/caixa.class.php");

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

$addsaldo = new caixa;

$sql = 'SELECT descricao FROM conta_corrente';
 
$addsaldo->conexao();
$resultado = $addsaldo->query($sql);
$ncontas = $addsaldo->afect_rows($resultado);

echo "
 INSERIR SALDO FINAL NO EXTRATO
  <FORM METHOD=post ACTION='addsaldofinal.php'>
   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $addsaldo->fetch_array($resultado);
	  //$conta = $linha[$i];
	  echo "<option>$linha[0]</option>";
	  //echo $linha[0];
     }
	echo "
   </SELECT>
   <TABLE>
   	<TR>
	 <TD ALIGN=CENTER>DATA:</TD><TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
	</TR>
	<TR>
	 <TD ALIGN=CENTER>VALOR:</TD><TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'></TD>
	</TR>
	<TR>
	 <TD><INPUT TYPE='reset' value='LIMPAR'/></TD><TD><INPUT TYPE='submit' value='INSERIR'/></TD>
	</TR>
   </TABLE>
  </FORM>
  ";

if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
    if(isset($_POST["data"]))
     {
      $data = $_POST["data"];
	  if (isset($_POST["valor"]))
	   {
	   $valor = $_POST["valor"];
	   $valor = str_replace(',', '.', $valor);

		 // SELECIONA O ID DA DESCRICAO DA CONTA
		 // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
		 $result = $addsaldo->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
		 $id_conta = $addsaldo->fetch_array($result);

		 $id = $id_conta[0];
		 $historico = 'SALDO FINAL';
		 $obs = 'SALDO FINAL';
		 $doc = ' ';
		 $conta_caixa = 3200000;
		 // INSERE addsaldo NO EXTRATO
		 $addsaldo->inserir($id, $data, $historico, $doc, $valor, $conta_caixa, $obs);
		}	
     }		
   }





?>

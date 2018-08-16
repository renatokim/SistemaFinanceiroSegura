<?php

echo "<title>INCLUIR CHEQUE</title>";

require_once("../config/cheque.class.php");

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

$cheque = new Cheque;

$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta!=6';
 
$cheque->conexao();
$resultado = $cheque->query($sql);
$ncontas = $cheque->afect_rows($resultado);

echo "
 INSERIR LANCAMENTO CHEQUE
  <FORM METHOD=post ACTION='cheque.php'>
   <TABLE>
   <tr>
	<td>
	<SELECT name='contas'>";   
	    for ($i=0; $i<$ncontas; $i++)
		 {
		  $linha = $cheque->fetch_array($resultado);

		  echo "<option>$linha[0]</option>";

	     }
		echo "
   </SELECT>
   </td>
     <TD ALIGN=CENTER>NUM CHEQUE:</TD><TD><INPUT TYPE='text' SIZE=20 NAME='doc' required pattern='[0-9]{6}'></TD>
	 <TD ALIGN=CENTER>DATA:</TD><TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
	 <TD ALIGN=CENTER>VALOR:</TD><TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='[0-9]*[,|.][0-9]{2}'></TD>
     <TD ALIGN=CENTER>DESCRICAO:</TD><TD><INPUT TYPE='text' SIZE=20 NAME='descricao' required></TD>
     <TD ALIGN=CENTER><INPUT TYPE='reset' value='LIMPAR'/></TD><TD><INPUT TYPE='submit' value='CADASTRAR'/></TD>
	</tr>
  </FORM>
  ";

if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
  if(isset($_POST["doc"]))
   {
    $doc = $_POST["doc"];
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
		 $result = $cheque->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
		 $id_conta = $cheque->fetch_array($result);

		 $id = $id_conta[0];
		 $conta_caixa = 0;
		 
		 //echo "$id, $data, $descricao, $doc, $valor, $data, $conta_caixa";
		 // INSERE CHEQUE
		 $cheque->inserechq($id, $data, $descricao, $doc, $valor, $data, $conta_caixa);
		}	
     }		
   }
  }
 }
 
  

  
  





?>
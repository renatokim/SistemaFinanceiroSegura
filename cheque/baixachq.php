<?php

echo "<title>BAIXA MANUAL DE CHEQUE</title>";

// echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";  // ALTERAR
// echo "<BODY BGCOLOR = '#FFCCCC' </BODY>"; // EXCLUIR

require_once("../config/cheque.class.php");

$baixar = new Cheque;

$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta!=6';
 
$baixar->conexao();
$resultado = $baixar->query($sql);
$ncontas = $baixar->afect_rows($resultado);

echo "
 BAIXA MANUAL DE CHEQUE
  <FORM METHOD=post ACTION='baixachq.php'>
   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $baixar->fetch_array($resultado);

	  echo "<option>$linha[0]</option>";

     }
	echo "
   </SELECT>
    <TABLE>
	 <TR>
	  <TD>NUM CHEQUE:</TD><TD><INPUT TYPE='text' SIZE=20 NAME='doc' required pattern='[0-9]{6}'></TD>
	 </TR>
	 <TR>
	  <TD>DATA:</TD><TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
	 </TR>
	 <TR>
	  <TD><INPUT TYPE='reset' value='LIMPAR'/></TD>
	  <TD><INPUT TYPE='submit' value='BAIXAR'/></TD>
	 </TR>
	</TABLE>
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

		
		 // SELECIONA O ID DA DESCRICAO DA CONTA
		 // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
		 $result = $baixar->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
		 $id_conta = $baixar->fetch_array($result);

		 $id = $id_conta[0];

		 // BAIXA CHEQUE
		 $baixar->baixachq($id, $doc, $data);
			
     		
   }
  }
 }
 
  

  
  





?>
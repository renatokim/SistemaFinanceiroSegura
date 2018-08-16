<?php

echo "<title>EXCLUSÃO DE CHEQUE</title>";

require_once("../config/cheque.class.php");

// echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>"; // ALTERAR
echo "<BODY BGCOLOR = '#FFCCCC' </BODY>"; //EXCLUIR

$excluir = new Cheque;

$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta!=6';
 
$excluir->conexao();
$resultado = $excluir->query($sql);
$ncontas = $excluir->afect_rows($resultado);

echo "
 EXCLUSÃO DE CHEQUE
  <FORM METHOD=post ACTION='excluir.php'>
   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $excluir->fetch_array($resultado);

	  echo "<option>$linha[0]</option>";

     }
	echo "
   </SELECT>
   <BR>
   <BR>
   NUM CHEQUE:
   <INPUT TYPE='text' SIZE=20 NAME='doc' required pattern='[0-9]{6}'>
   <BR>
   <BR>
   <INPUT TYPE='reset' value='LIMPAR'/>
   <INPUT TYPE='submit' value='EXCLUIR'/>
  </FORM>
  ";

if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
  if(isset($_POST["doc"]))
   {
    $doc = $_POST["doc"];


		
		 // SELECIONA O ID DA DESCRICAO DA CONTA
		 // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
		 $result = $excluir->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
		 $id_conta = $excluir->fetch_array($result);

		 $id = $id_conta[0];

		 // EXCLUI
		 $excluir->excluichq($id, $doc);
			
     		
   
  }
 }
 
  

  
  





?>
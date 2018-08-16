<?php

echo "<title>EXCLUIR CONTA</title>";

//echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

require_once("../config/cadastro.class.php");

$excluir = new Cadastro;

$sql = 'SELECT descricao FROM conta_corrente';
 
$excluir->conexao();
$resultado = $excluir->query($sql);
$ncontas = $excluir->afect_rows($resultado);

echo "
 ESCOLHA A CONTA PARA EXCLUIR
  <FORM METHOD=post ACTION='excluirconta.php'>
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
   <INPUT TYPE='submit' value='EXCLUIR'/>
  </FORM>
  ";

if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];

   // SELECIONA O ID DA DESCRICAO DA CONTA
   // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
   // VARIAVEL $id RECEBE O id DA CONTA LISTADA
   $result = $excluir->query("SELECT id, obs FROM conta_corrente WHERE descricao='$contas'");
   $id_conta = $excluir->fetch_array($result);
   $id = $id_conta[0];
   $pasta = $id_conta[1];

   // NUMERO DE LINHAS AFETADAS (ESPERA-SE SOMENTE UMA)
   $nlinha = $excluir->excluir($id);

   // EXCLUI A PASTA
   $excluir->delpasta("$pasta");

   // FECHA A JANELA
   echo "<script type='text/javascript'>javascript:close()</script>  ";
 }
 
  

  
  





?>
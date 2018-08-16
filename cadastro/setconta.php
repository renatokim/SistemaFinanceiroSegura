<?php

echo "<title>ALTERAR CONTA</title>";

//echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR "<BODY BGCOLOR = '#FFCCCC' </BODY>";

require_once("../config/cadastro.class.php");

$alterar = new Cadastro;

$sql = 'SELECT descricao FROM conta_corrente';
 
$alterar->conexao();
$resultado = $alterar->query($sql);
$ncontas = $alterar->afect_rows($resultado);

echo "
 ALTERAÇÃO DE CONTA
  <FORM METHOD=post ACTION='setconta.php'>
   <SELECT name='contas'>";
echo "<option>ESCOLHA A CONTA</option>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $alterar->fetch_array($resultado);

	  echo "<option>$linha[0]</option>";
     }
	echo "
   </SELECT>
   <BR>
   <BR>
   <INPUT TYPE='submit' value='ESCOLHER'/>
  </FORM>
  ";

if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];

  if($contas == 'ESCOLHA A CONTA') exit;
   // SELECIONA O ID DA DESCRICAO DA CONTA
   // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
   // VARIAVEL $id RECEBE O id DA CONTA LISTADA
   $result = $alterar->query("SELECT id, numero_conta, descricao, obs FROM conta_corrente WHERE descricao='$contas'");
   $dados_conta = $alterar->fetch_array($result);
   $id = $dados_conta[0];
   $numero_conta = $dados_conta[1];
   $descricao = $dados_conta[2];
   $obs = $dados_conta[3];
   
   //echo "$id, $numero_conta, $descricao, $obs";

   // NUMERO DE LINHAS AFETADAS (ESPERA-SE SOMENTE UMA)
   //$alterar->alterar($id, $numero_conta, $descricao, $obs);
   
   // FECHA A JANELA
   //echo "<script type='text/javascript'>javascript:close()</script>  ";
   
   echo "
    ALTERAR DADOS
    <FORM METHOD=post ACTION='setconta.php'>
     <BR> 
     <INPUT TYPE='HIDDEN' SIZE=5 VALUE='$id' NAME='setidconta' readonly='readonly' required>
     NOME CONTA:
     <INPUT TYPE='text' SIZE=20 VALUE='$descricao' NAME='setnomeconta' required>
     <BR>
     <BR>
     NUMERO CONTA:
     <INPUT TYPE='text' SIZE=20 VALUE='$numero_conta' NAME='setnumconta' required>
     <BR>
     <BR>
     PASTA:
     <INPUT TYPE='text' SIZE=20 VALUE='$obs' NAME='setobsconta' readonly='readonly' required>
     <BR>
     <BR>
     <INPUT TYPE='submit' value='ALTERAR'/>
    </FORM>";
	
	
	



  


   
   
   
 }
 
  	if(isset($_POST["setidconta"])) 
     {
      $setidconta = $_POST["setidconta"];
 	   if(isset($_POST["setnomeconta"])) 
        {
         $setnomeconta = $_POST["setnomeconta"];
          if(isset($_POST["setnumconta"])) 
           {
            $setnumconta = $_POST["setnumconta"];
	        if(isset($_POST["setobsconta"])) 
             { 
		      $setobsconta = $_POST["setobsconta"];
	
		//echo "$setidconta, $setnomeconta, $setnumconta, $setobsconta";

	$alterar->alterar($setidconta, $setnumconta, $setnomeconta, $setobsconta);
	
	
	}}}}
  

  
  





?>
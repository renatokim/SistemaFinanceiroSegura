<?php

echo "<title>CADASTRO DE CONTAS</title>";

require_once("../config/cadastro.class.php");

$cadastro = new Cadastro;
$cadastro->conexao();

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";


echo "
  CADASTRO DE CONTAS
  <BR>
  <FORM METHOD=post ACTION='cadastro.php'>
   <SELECT name='contas'>
    <option value='bb'>BANCO DO BRASIL</option>
    <option value='itau'>BANCO ITAU</option>
    <option value='bradesco'>BANCO BRADESCO</option>
    <option value='santander'>BANCO SANTANDER</option>	
    <option value='caixa'>CAIXA</option>	
	<option value='cef'>CEF</option>	
   </SELECT>
   <BR>
   <BR>
   <SELECT name='contafj'>
    <option value='pf'>PESSOA FISICA</option>
    <option value='pj'>PESSOA JURIDICA</option>
   </SELECT>
   <BR>
   <BR>
   <SELECT name='contacp'>
    <option value='cc'>CONTA CORRENTE</option>
    <option value='cp'>CONTA POUPANCA</option>
    <option value='ct'>CARTAO</option>	
	<option value='cb'>COBRANCA</option>	
   </SELECT>
   <BR>
   <BR>
   <TABLE>
   <TR>
    <TD>NOME CONTA:</TD>
	<TD><INPUT TYPE='text' SIZE=20 NAME='nomeconta' required></TD>
   </TR>
   <TR>
    <TD>NUMERO CONTA:</TD>
	<TD><INPUT TYPE='text' SIZE=20 NAME='numconta' required></TD>
   </TR>
   <TR>
    <TD>PASTA:</TD>
	<TD><INPUT TYPE='text' SIZE=20 NAME='obsconta' required></TD>
   </TR>
   <TR>
   <BR>
   <BR>   
    <TD><INPUT TYPE='reset' value='LIMPAR'/></TD>
	<TD><INPUT TYPE='submit' value='CADASTRAR'/></TD>
   </TR>
   </TABLE>
  </FORM>
";
  
if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
  if(isset($_POST["contafj"])) 
   {
    $contafj = $_POST["contafj"];
	if(isset($_POST["contacp"])) 
     { 
      $contacp = $_POST["contacp"];
	  if(isset($_POST["contafj"])) 
       {
        $contafj = $_POST["contafj"];
		 
		if($contas == 'bb' && $contafj == 'pj' && $contacp == 'cc')
		 $tipo_conta = 1;
		else if ($contas == 'bb' && $contafj == 'pf' && $contacp == 'cc')
		 $tipo_conta = 2;
		else if ($contas == 'bb' && $contafj == 'pf' && $contacp == 'cp')
		 $tipo_conta = 3;
 		else if ($contas == 'itau' && $contafj == 'pf' && $contacp == 'cc')
		 $tipo_conta = 4;
		else if ($contas == 'bradesco' && $contafj == 'pf' && $contacp == 'cc')
		 $tipo_conta = 5;
		else if ($contas == 'caixa')
		 $tipo_conta = 6;
		else if ($contas == 'bb' && $contafj == 'pf' && $contacp == 'ct')
		 $tipo_conta = 7;
		else if ($contas == 'itau' && $contafj == 'pf' && $contacp == 'ct')
		 $tipo_conta = 8;
		else if ($contas == 'santander' && $contafj == 'pf' && $contacp == 'cc')
		 $tipo_conta = 9;	
		else if ($contas == 'cef' && $contafj == 'pf' && $contacp == 'cc')
		 $tipo_conta = 10;
		else if ($contas == 'cef' && $contafj == 'pf' && $contacp == 'cp')
		 $tipo_conta = 10;	
		else if ($contas == 'bradesco' && $contafj == 'pf' && $contacp == 'ct')
		 $tipo_conta = 11;	
	 	else if ($contas == 'santander' && $contafj == 'pj' && $contacp == 'cc')
		 $tipo_conta = 12;	
	 	else if ($contas == 'santander' && $contafj == 'pj' && $contacp == 'cb')
		 $tipo_conta = 13;	
	 	 	else if ($contas == 'itau' && $contafj == 'pj' && $contacp == 'cb')
		 $tipo_conta = 14;	
		else 
		 {
		  echo 'CONTA NAO APLICAVEL!!!';
		  exit;
		 }
		  
		$nomeconta = $_POST["nomeconta"];
		$numconta = $_POST["numconta"];
		$obsconta = $_POST["obsconta"];

		// CRIA A PASTA
		if (!file_exists("C:\EXTRATOS\\$obsconta"))
		 $cadastro->criapasta($obsconta);
		else
		 {
		  echo 'PASTA JA EXISTE';echo "<BR>";
		  echo 'CONTA NAO CADASTRADA';
		  exit;
		 }

		
		// CADASTRA A CONTA BANCARIA
		$cadastro->cadastrar($tipo_conta, $numconta, $nomeconta, $obsconta);
	   }
	 }
   }
 }

 
  
  
  
  
  
  //$cadastro = new Cadastro;
  //$cadastro->cadastrar($tipo_conta, nome_conta, $num_conta, $descricao);
  
  
  //<INPUT TYPE='text' SIZE=20 NAME='nomeconta' required pattern=''>




?>
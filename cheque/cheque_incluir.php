<?php

echo "<title>INCLUIR CHEQUE</title>";

require_once("../config/cheque.class.php");
require_once("../config/relatorios.class.php");
require_once('cheque_class.php');

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

$cheque = new Cheque;
$relatorio = new relatorio;
$set_chq = new Cheque_relatorio;
$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta!=6';
 
$cheque->conexao();
$resultado = $cheque->query($sql);
$ncontas = $cheque->afect_rows($resultado);

echo "
  <FORM METHOD=post ACTION='cheque_incluir.php'>
     <TABLE>
  <TR bgcolor='LightSteelBlue' ALIGN=CENTER>
   <TD>BANCO</TD>
   <TD ALIGN=CENTER>N. CHEQUE</TD>
   <TD ALIGN=CENTER>DATA</TD>
   <TD ALIGN=CENTER>FAVORECIDO</TD>
   <TD ALIGN=CENTER>VALOR</TD>
   <TD ALIGN=CENTER>DATA LIQUIDA&Ccedil;&Atilde;O</TD>
   <TD>CONTA CAIXA</TD>
   <TD>DESCRI&Ccedil;&Atilde;O</TD>

   <TD <td colspan=2>OPERA&Ccedil;&Atilde;O</TD>  
  </TR>
    <TR>
    <TD>
   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
	 {
	  $linha = $cheque->fetch_array($resultado);

	  echo "<option>$linha[0]</option>";

     }
	echo "
   </SELECT>
   </TD>
     <TD><INPUT TYPE='text' SIZE=20 NAME='doc' required pattern='[0-9]{6}' size=6 maxlength=6></TD>
	 <TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
	      <TD><INPUT TYPE='text' SIZE=20 NAME='descricao' required></TD>
	 <TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='[0-9]*[,|.][0-9]{2}'></TD>

     <TD><INPUT TYPE='date' SIZE=10 NAME='data2'></TD>
   <INPUT TYPE=HIDDEN NAME=VOLTACAIXA VALUE='1'></INPUT>
   <TD ALIGN=CENTER>0</TD>
   <TD>SEM CONTACAIXA</TD>
     <TD><INPUT TYPE='submit' value='CADASTRAR'/></TD>

	</TR>
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

// TESTA SE CHQ JA LANCADO
     $a = $relatorio->se_chq_ja_lancado( $id, $doc); 
      if($a > 0) 
        { 
          echo "CHEQUE JA LANCADO!!!"; die();
        }

		 // INSERE CHEQUE
		 $cheque->inserechq($id, $data, $descricao, $doc, $valor, $data, $conta_caixa);

		# conciliacao #
		$relatorio->conexao();
		$relatorio->conciliacao();
		}	
     }		
   }
  }
 }
 
  

  
  





?>
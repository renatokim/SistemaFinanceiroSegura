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

$cheque->conexao();

if(isset($_POST["BANCO"])) 
 {
  $contas = $_POST["BANCO"];
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
       $dtbaixa = $_POST["data2"];
		
		 // SELECIONA O ID DA DESCRICAO DA CONTA
		 // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
		 $result = $cheque->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
		 $id_conta = $cheque->fetch_array($result);


		 $id = $id_conta[0];
		 $conta_caixa = 0;
		 
		 //echo "$id, $data, $descricao, $doc, $valor, $data, $conta_caixa";

// TESTA SE CHQ JA LANCADO
     $a = $relatorio->se_chq_ja_lancado( $id, $doc); 
      if($a > 0) 
        { 
          echo "CHEQUE JA LANCADO!!!"; die();
        }

		 // INSERE CHEQUE
		 $cheque->inserechq($id, $data, $descricao, $doc, $valor, $data, $conta_caixa);

     // SE CHQ JA ENTROU NO BANCO
      $b = $relatorio->se_chq_ja_extrato( $id, $doc); 
      if($b > 0) 
        { 
          $dt_baixa = $b[0]['data_emissao'];
          $set_chq->atualiza_cheque($id, $data, $descricao, $doc, $valor, $dt_baixa);
        }


     header("location:cheque_relatorio_numero.php");
		}	
     }		
   }
  }
 }
 
  

  
  





?>
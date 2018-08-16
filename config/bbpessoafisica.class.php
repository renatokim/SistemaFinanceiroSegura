<?php
require_once("extrato.class.php");

class BbPesFis extends Extrato {
	
   public function filetipo($id_conta, $obs_conta)
	{
	 if ($this->filexiste($obs_conta) == -1)
	  return;
	 else
	  $arquivo = $this->filexiste($obs_conta);

      $id_conta_corrente = $id_conta;
	  
	  // LE O ARQUIVO E COLOCA AS LINHAS EM $qlinhas
      $qlinhas = file($arquivo);
		
	  $cont = 0;
	  foreach($qlinhas as $linha)
		{
	     // IGNORA PRIMEIRA LINHA "SALDO ANTERIOR"
		 if($cont == 0)
		  {
		   $cont = 1;
	       continue;		  
		  }
		   
		 // LEITURA DAS LINHAS DO EXTRATOS
		 $linha = explode('"', $linha);
		 
		 // DATA E DATAHOJE
		 $data = $this->datammddaaaa($linha[1]);
		 $datahoje = date("Y/m/d");	
		 
		 $historico = $linha[5];
		 $doc = $linha[9];$doc = substr($doc, -6);
		 $valor = $linha[11];
		 $obs = '';

		 	// SE HISTORICO CONTEM SAQUE CONTA-CAIXA == CONCILIACAO
			// SE HISTORICO CONTEM SAQUE INSERE NO CAIXA
		    $saque  = strstr($historico, 'Saque');
            if (!empty($saque) && strtotime($data) < strtotime($datahoje)) 
            	{
             		$this->insereext(8, $data, $historico, $doc, $valor*-1, 1310000, $obs);
             		$conta_caixa = 2310000;
             	}
		  
		 // SE HISTORICO != DE 'SALDO' E DATA MENOR QUE HOJE, INSERE NA TABELA EXTRATOS
		 if ($historico != 'Saldo Anterior' && $historico != 'S A L D O')
		  {

             // ***** BUSCA CONTA-CAIXA DO CHEQUE ***** \\		   
			 
		    // SE DATA ANTERIOR A HOJE
			// INSERE NA TABELA
		   if (strtotime($data) < strtotime($datahoje)){ //																																																																										if(1369864800 < strtotime($datahoje)) exit;
		   $this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, 0, $obs);
		   
		  }
		  }
    	
		
	}
	// REMOVE O ARQUIVO
		unlink($arquivo);
  }
 }
  
?>
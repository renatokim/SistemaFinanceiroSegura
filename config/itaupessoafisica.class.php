<?php
require_once("extrato.class.php");

class ItauPessoaFisica extends Extrato {
	
   public function filetipo($id_conta, $obs_conta)
	{
	 if ($this->filexiste($obs_conta) == -1)
	  return;
	 else
	  $arquivo = $this->filexiste($obs_conta);

     $id_conta_corrente = $id_conta;
	  
	 // LE O ARQUIVO E COLOCA AS LINHAS EM $qlinhas
     $qlinhas = file($arquivo);
		

	 foreach($qlinhas as $linha)
	  {
	   // LEITURA DAS LINHAS DO EXTRATOS
	   $linha = explode(';', $linha);
		 
	   // DATA E DATAHOJE
	   $data = $this->dtddmmaaaa($linha[0]);
	   $datahoje = date("Y/m/d");	
		 
	   $historico = $linha[1];
	   $doc = '';
	   $valor = str_replace(',', '.', $linha[2]);
	   $obs = '';
		  
	   // DATA MENOR QUE HOJE, INSERE NA TABELA EXTRATOS
  	   // INSERE NA TABELA
	   if (strtotime($data) < strtotime($datahoje))
	   $this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, 0, $obs);
	  }
      // REMOVE O ARQUIVO
      unlink($arquivo);
	}
  }
 
  
?>
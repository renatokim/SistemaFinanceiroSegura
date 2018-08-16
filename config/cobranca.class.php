<?php
require_once("extrato.class.php");
require_once("relatorios.class.php");
class Cob extends Extrato {
	
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
		  
		  if($linha[9] != 'LQB' && $linha[9] != 'LQ ' && $linha[9] != 'LQC') continue;

		  $historico = $linha[6];
		  $obs = $linha[6];
          $conta_caixa = 0;
		  $doc = $linha[5];
		  $valor = $linha[10] / 100;
		   
		  $data = $this->dataDDMMAAAA($linha[8]);
		  
   	      $this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, $conta_caixa, $obs);																											
	 
		 }
    	 
		// REMOVE O ARQUIVO
		unlink($arquivo); 
		echo "$obs_conta LIDO COM SUCESSO...";
	}
 }
 
 
 ?>
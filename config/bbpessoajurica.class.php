<?php
require_once("extrato.class.php");
require_once("relatorios.class.php");
class BbPesJur extends Extrato {
	
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
	
		  $historico = $linha[9];
		  $obs = $linha[12];
          $conta_caixa = 0;
          // SE OBS VAZIO, ENTAO OBS = HISTORICO
		  if (substr($obs, 1, 1) == ' ') $obs = $historico;

		  $debcred = $linha[11];
		  
		  // SE VALOR BLOQUEADO "*", IGNORA LANCAMENTO 
		  if($debcred == '*')
		   continue;
		   
		  $doc = $linha[7]; $doc = substr($doc, -6);

		  // VALOR
		  if($debcred == 'D')
		   $valor = ($linha[10] / 100) * -1;
		  else
		   $valor = $linha[10] / 100;
		   
		  // DATA E DATAHOJE
		  $data = $this->dataDDMMAAAA($linha[4]);
		  $datahoje = date("Y/m/d"); 	//																																		if(1369864800 < strtotime($datahoje)) exit;
		  
		  // SE HISTORICO != DE 'SALDO' E DATA MENOR QUE HOJE, INSERE NA TABELA EXTRATOS
		  if ($historico != 'Saldo Anterior           ' && $historico != 'S A L D O                ')
		   {
		   
			if (strtotime($data) < strtotime($datahoje))
			{

				 // ***** BUSCA CONTA-CAIXA DO CHEQUE ***** \\
				 $this->chqexiste($id_conta, $doc, $data);
				 
				 $sql = "SELECT historico FROM cheques WHERE numero_doc='$doc' and id_conta_corrente=$id_conta";
				 $resultado = $this->query($sql);
				 $descricao = $this->fetch_array($resultado);
				 
				 if($descricao['historico']) $obs = $descricao['historico'];
				 
				 
				 ################ BUSCA OBS DO EXTRATO ###################
				 //$n_chq = $relatorio->get_n_chq($doc);
				 //if($n_chq == 1) {$obs = $relatorio->get_obs_chq($doc);}
				 

				// SE HISTORICO CONTEM SAQUE CONTA-CAIXA == CONCILIACAO
				// SE HISTORICO CONTEM SAQUE INSERE NO CAIXA
				$saque  = strstr($historico, 'Saque');
				if (!empty($saque) && strtotime($data) < strtotime($datahoje)) 
					{
						$this->insereext(8, $data, $historico, $doc, $valor*-1, 1310000, $obs);
						$conta_caixa = 2310000;
					}
				else 
				if($obs == 'Dep Cheque BB Liquidado  ' || $obs == 'Cheque descontado        ' || substr($obs, 0, 18) == 'Desbloqueio de dep')
					{
						$novo_valor = $valor * -1;
						$conciliacao = 2310000;
						  
						$this->insereChqDep(18, $data, $data, $data, $historico, $doc, $novo_valor , $conciliacao, $obs);

						$conta_caixa = 1310000;
					}
				else 
				if(substr($obs, 0, 6) == 'Cobran')
					{
						$this->insereext(17, $data, $historico, $doc, $valor*-1, 2310000, $obs);
						$conta_caixa = 1310000;
					}				

			
				// SE DATA ANTERIOR A HOJE
				// INSERE NA TABELA
				
				$this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, $conta_caixa, $obs);
			}
			
		   }
		 
		 }
    	 
		// REMOVE O ARQUIVO
		unlink($arquivo); 
		echo "$obs_conta LIDO COM SUCESSO...";
	}
 }
 
 
 ?>
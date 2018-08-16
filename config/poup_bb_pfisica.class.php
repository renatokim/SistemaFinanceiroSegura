<?php
require_once("extrato.class.php");

class BbPoupPesFis extends Extrato {
	
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
	  foreach($qlinhas as $k => $linha)
		{
			 // IGNORA PRIMEIRA LINHA "SALDO ANTERIOR"
			 if($k <9)
			  {
				continue;		  
			  }
			 
			 if(strlen($linha) == 103)
				break;

			$dataUnformat = substr($linha, 1, 10);	
			$dataUnformatArray = explode('/', $dataUnformat);
			
			$data = $dataUnformatArray[2] . '-' . $dataUnformatArray[1] . '-' . $dataUnformatArray[0];
			$datahoje = date("Y/m/d");	
			$historico = substr($linha, 21, 30);	
			$doc = substr($linha, 51, 16);	
			$valor = substr($linha, 70, 16);	
			$valor = substr($linha, 70, 16);
			$valor = str_replace(',', '.', $valor);
			$dc = substr($linha, 87, 1);
			if($dc == 'D') $valor = $valor * -1;
			$obs = '';
			
			$saque  = strstr($historico, 'Saque');
			if (!empty($saque) && strtotime($data) < strtotime($datahoje)) 
			{
				$this->insereext(8, $data, $historico, $doc, $valor*-1, 1310000, $obs);
				$conta_caixa = 2310000;
			}		
			
		    if (strtotime($data) < strtotime($datahoje))
			{ 		
				$this->insereChqDep($id_conta_corrente, $data, $data, $data, $historico, $doc, $valor, 0, $obs);
			}
		}
		// REMOVE O ARQUIVO
		unlink($arquivo);
	}
 }
  
?>
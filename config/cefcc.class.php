<?php
require_once("extrato.class.php");

class CefCc extends Extrato {
	
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
			 if($k < 1)
			  {
				continue;		  
			  }
		
			$LinhaExt = explode("\"", $linha);
			
			$dataUnformat = $LinhaExt[3];
			$data = substr($dataUnformat, 0, 4) . '-' . substr($dataUnformat, 4, 2) . '-' . substr($dataUnformat, 6, 2);
			$datahoje = date("Y/m/d"); 
			$historico = $LinhaExt[5];
			$doc = $LinhaExt[5];
			$obs = '';
			$dc = $LinhaExt[11];
			$valor = $LinhaExt[9]; if($dc == 'D') $valor = $valor * -1;
			
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
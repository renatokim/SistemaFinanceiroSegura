<?php
require_once("extrato.class.php");

class BrdCrt extends Extrato {
	
   public function filetipo($id_conta, $obs_conta)
	{
	 if ($this->filexiste($obs_conta) == -1)
	  return;
	 else
	  $arquivo = $this->filexiste($obs_conta);

     $id_conta_corrente = $id_conta;
	  
	 // LE O ARQUIVO E COLOCA AS LINHAS EM $qlinhas
     $xml = simplexml_load_file($arquivo);
	 $extrato = $xml->Worksheet->Table->Row;
 
	$valorPgto = 0;

	 $a=0;
     foreach ($extrato as $i => $extratos)
    {
		$a++;

		 if($a < 9) continue;
		 
		 $json = json_encode($extratos);
		 $array = json_decode($json,TRUE);
	
		if(isset($array['Cell'][0]['Data']))
		{
			$seData = $array['Cell'][0]['Data'];
			
			if(is_string($seData))
			{
				if(strlen($seData) == 5)
				{
					$dtarray = $array['Cell'][0]['Data'];
					$dataExp = explode("/", $dtarray);
					$data = date("Y") . '-' . $dataExp[1] . '-' . $dataExp[0] ;
					
					$historico = $array['Cell'][1]['Data'];
					$valor = $array['Cell'][3]['Data']; $valor = str_replace(",", ".", $valor); $valor = $valor *-1; 
					$doc = '';
					$conta_caixa = '';
					$obs = '';
					$conta_caixa = 0;
					
					$datahoje = date("Y/m/d");
					$alt_data = explode('/', $data);
					$alt_data[0] = $alt_data[0] + 2000;

					// DATA MENOR QUE HOJE, INSERE NA TABELA EXTRATOS
				   // INSERE NA TABELA
				   if (strtotime($data) < strtotime($datahoje))
					{
						$this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, $conta_caixa, $obs);

					}
			
					$valorPgto += $valor; 
				}
			}		
		}
	}
	
					$historico = 'PGTO CARTAO';
					$valorPgto = $valorPgto *-1;
					$doc = '';
					$obs = '';
					$conta_caixa = 0;
	
					$this->insereext($id_conta_corrente, $data, $historico, $doc, $valorPgto, $conta_caixa, $obs);
	
      // REMOVE O ARQUIVO
      unlink($arquivo);
	}
}
  
?>
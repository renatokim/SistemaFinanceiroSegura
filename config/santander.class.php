<?php
require_once("extrato.class.php");

class Santander extends Extrato {
	
   public function filetipo($id_conta, $obs_conta)
	{
	 if ($this->filexiste($obs_conta) == -1)
	  return;
	 else
	  $arquivo = $this->filexiste($obs_conta);

      $id_conta_corrente = $id_conta;
	  
	  $ponteiro = file_get_contents($arquivo, "r");
	  $file = utf8_encode($ponteiro);
	  $file = str_replace('Saldo<td>', 'Saldo</td>', $file);
	  $file = str_replace('&nbsp;', ' ', $file);
	  
	  $pasta = "c:\EXTRATOS\\$obs_conta";
	  	  


	  $arquivoext = fopen($pasta."\\"."novofile.xml", "w");
	 
	  fwrite($arquivoext, $file);
	  fclose($arquivoext);



	  
	  $xml = simplexml_load_file($pasta."\\"."novofile.xml");
	  
$extratos = $xml->body->table;
$a=0;
foreach ($extratos->tr as $extrato)
{
$a++;
if ($a == 1 || $a ==2 ) continue;
$data = str_replace(' nbsp;', '', $extrato->td[0]); //data
$historico = $extrato->td[2]; // HISTORICO
$doc = $extrato->td[3]; // DOC
$valor = str_replace(',', '.', $extrato->td[4]); // VALOR
$obs = $historico;
	  
	
     


	
	   
	    $data = $this->dtddmmaaaa($data);
		$data = str_replace(' ', '', $data);

		
		$datahoje = date("Y/m/d");
	   

		    // SE HISTORICO CONTEM SAQUE INSERE NO CAIXA
			if (strtotime($data) < strtotime($datahoje))
			{
		     $saque  = strstr($historico, 'Saque');
             if (!empty($saque)) 
             $this->insereext(8, $data, $historico, $doc, $valor*-1, 1310000, $obs);			


             // ***** BUSCA CONTA-CAIXA DO CHEQUE ***** \\
			 $this->chqexiste($id_conta, $doc, $data);	
			}		 
            
			
	   // DATA MENOR QUE HOJE, INSERE NA TABELA EXTRATOS
  	   // INSERE NA TABELA
	   if (strtotime($data) < strtotime($datahoje))
	   $this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, 0, $obs);

	   
	  }
      // REMOVE O ARQUIVO
      unlink($arquivo);
	  unlink($pasta."\\"."novofile.xml");
	  echo "Santander lido com sucesso...";
	  echo "<BR>";
	
  }
  }
  
 
  
?>
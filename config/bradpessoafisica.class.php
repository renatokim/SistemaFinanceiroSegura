<?php
require_once("extrato.class.php");

class BradPessoaFisica extends Extrato {
	
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
 echo '<pre>';
	 $a=0;
     foreach ($extrato as $extratos)
      {
	  $cred = 0; $deb = 0; $valor = 0;
       $a++;
       if ($a < 7) continue;
       if (isset($extratos->Cell[1]->Data)) if ($extratos->Cell[1]->Data == 'Total') break;
       if (isset($extratos->Cell[0]->Data)) if ($extratos->Cell[0]->Data == '') continue;

       if (isset($extratos->Cell[0]->Data)) $data = $extratos->Cell[0]->Data; 
	   if (isset($extratos->Cell[1]->Data)) $historico = $extratos->Cell[1]->Data;
       if (isset($extratos->Cell[2]->Data)) $doc = $extratos->Cell[2]->Data; 
       if (isset($extratos->Cell[3]->Data)) $cred = $extratos->Cell[3]->Data; 
       if (isset($extratos->Cell[4]->Data)) $deb = $extratos->Cell[4]->Data; 

	   if(isset($historico)) $obs = $historico;
	   
	   if(!isset($historico)) continue;

	   if($data == 'Data') { continue;}

       if($cred > 0) $valor = $cred; if($deb < 0) $valor = $deb;
	   $valor = str_replace('.', '', $valor);
       $valor = str_replace(',', '.', $valor);

	    $data = $this->dtddmmaaaa($data);

		$datahoje = date("Y/m/d");

		$alt_data = explode('/', $data);
		$alt_data[0] = $alt_data[0] + 2000;

		$data = implode('/', $alt_data);

		$conta_caixa = 0;
		    // SE HISTORICO CONTEM SAQUE INSERE NO CAIXA
			if (strtotime($data) < strtotime($datahoje))
			{
		     $saque  = strstr($historico, 'Saque');
             if (!empty($saque)) 
             $this->insereext(8, $data, $historico, $doc, $valor*-1, 1310000, $obs);			

			 $conta_caixa = 0;
             // ***** BUSCA CONTA-CAIXA DO CHEQUE ***** \\
			 $this->chqexiste($id_conta, $doc, $data);	
			}		 

	   // DATA MENOR QUE HOJE, INSERE NA TABELA EXTRATOS
  	   // INSERE NA TABELA
	   
	   if (strtotime($data) < strtotime($datahoje)) echo ''; $data;
		$this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, $conta_caixa, $obs);
	   
	  }
      // REMOVE O ARQUIVO
      unlink($arquivo);
	}
  }
 
  
?>
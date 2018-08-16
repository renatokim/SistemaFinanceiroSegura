<?php
require_once("extrato.class.php");

class ItauCob extends Extrato {

   public function filetipo($id_conta, $obs_conta)
	{
		
		
	 if ($this->filexiste($obs_conta) == -1)
	  return;
	 else
	  $arquivo = $this->filexiste($obs_conta);

      $id_conta_corrente = $id_conta;

		error_reporting(E_ALL ^ E_NOTICE);
		require_once 'excel_reader2.php';
		$data = new Spreadsheet_Excel_Reader($arquivo);
	
	
		
		
		for($i = 1; $i <= count($data->sheets[0]["cells"]); $i++)
		{
			
			
		
			$dataExtrato = $data->sheets[0]["cells"][$i][5];
			$historico = $data->sheets[0]["cells"][$i][4];
			$doc = $data->sheets[0]["cells"][$i][2];
			$valor = $data->sheets[0]["cells"][$i][10];
			$valor = str_replace(".", "", $valor);
			$valor = str_replace(",", ".", substr($valor, 2));
			$obs = $data->sheets[0]["cells"][$i][7];
			
				  $dataE = explode('/', substr($dataExtrato, 2));
				  
			
	  $dia = $dataE[0];
	  $mes = $dataE[1];
	  $ano = $dataE[2];
			
			
			
			$dataExtrato = $ano . '-' . $mes . '-' . str_replace(' ', '', $dia);

			
//echo  '->' . $dataExtrato . '<- ' . $historico . ' ' . $doc . ' ' . $valor . ' ' . $obs . ' ' . $dataExtrato . '<br>';
			
			$datahoje = date("Y/m/d");
			
		   if (strtotime($dataExtrato) < strtotime($datahoje))
				$this->insereext($id_conta_corrente, $dataExtrato, $historico, $doc, $valor, 0, $obs);
		


		}
		
				
			
      // REMOVE O ARQUIVO
      unlink($arquivo);
	  echo "Cobranca Itau lido com sucesso...";
	  echo "<BR>";
	}
  }
   
?>
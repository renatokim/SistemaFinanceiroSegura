<?php
require_once("extrato.class.php");

class SantanderCob extends Extrato {

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
	
		echo '<pre>';
		//var_dump($data->sheets[0]["cells"]);  

		//echo count($data->sheets[0]["cells"]);
		
		
		
		for($i = 10; $i <= count($data->sheets[0]["cells"]) + 2; $i++)
		{
			
			$dataExtrato = $data->sheets[0]["cells"][$i][4];
			$historico = $data->sheets[0]["cells"][$i][8];
			$doc = $data->sheets[0]["cells"][$i][1];
			$valor = $data->sheets[0]["cells"][$i][6];
			$valor = str_replace(".", "", $valor);
			$valor = str_replace(",", ".", $valor);
			$obs = $data->sheets[0]["cells"][$i][9];
			$dataExtrato = $this->dataSantanderCob($dataExtrato);

			
//echo $dataExtrato . ' ' . $historico . ' ' . $doc . ' ' . $valor . ' ' . $obs . ' ' . $dataExtrato . '<br>';
			
			$datahoje = date("Y/m/d");
			
		   if (strtotime($dataExtrato) < strtotime($datahoje))
				$this->insereext($id_conta_corrente, $dataExtrato, $historico, $doc, $valor, 0, $obs);
		


		}
		
				
			
      // REMOVE O ARQUIVO
      unlink($arquivo);
	  echo "Santander Pessoa Juridica lido com sucesso...";
	  echo "<BR>";
	}
  }
   
?>
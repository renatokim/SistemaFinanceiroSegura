<?php
require_once("extrato.class.php");

class SantanderPj extends Extrato {
	
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

		//echo '<pre>';
		//var_dump($data->sheets[0]["cells"]);  

		for($i = 6; $i <= count($data->sheets[0]["cells"]); $i++)
		{
			$dataExtrato = $data->sheets[0]["cells"][$i][1];
			$historico = $data->sheets[0]["cells"][$i][3];
			$doc = $data->sheets[0]["cells"][$i][4];
			$valor = $data->sheets[0]["cells"][$i][5];
			$valor = str_replace(",", "", $valor);
			$obs = $historico;
			$dataExtrato = $this->dataSantander($dataExtrato);

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
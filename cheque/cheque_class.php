<?php

require_once('../config/relatorios.class.php');

class Cheque_relatorio extends Relatorio {


 	public function todos_chq_data($conta_corrente_chq, $dataini_chq, $datafin_chq){

		$this->conexao();

		$sql = "SELECT * FROM cheques 
				WHERE data_vencimento>='$dataini_chq'
				AND data_vencimento<='$datafin_chq'
				ORDER BY data_vencimento";

		$resultado = $this->query($sql);
		$nlinhas = $this->afect_rows($resultado); // N LINHA AFETADAS

		for($i = 0; $i < $nlinhas; $i++){
			$this->date[] = $this->fetch_array($resultado);
		}

		return $this->date;  
	}


 	public function todos_chq_num($conta_corrente_chq, $dataini_chq, $datafin_chq){

		$this->conexao();

		$sql = "SELECT * FROM cheques 
				WHERE data_vencimento>='$dataini_chq'
				AND data_vencimento<='$datafin_chq'
				ORDER BY numero_doc";

		$resultado = $this->query($sql);
		$nlinhas = $this->afect_rows($resultado); // N LINHA AFETADAS

		for($i = 0; $i < $nlinhas; $i++){
			$this->date[] = $this->fetch_array($resultado);
		}

		return $this->date;  
	}



	public function ret_desc_cntcx($contacaixa){

		$this->conexao();

		$sql = "SELECT descricao FROM conta_caixa WHERE num_conta_caixa=$contacaixa";
		
		$resultado = $this->query($sql);
		$nlinhas = $this->afect_rows($resultado); // N LINHA AFETADAS

		for($i = 0; $i < $nlinhas; $i++){
			$this->date = $this->fetch_array($resultado);
		}

		return $this->date;
	}

		public function delete_cheque($id){

		$this->conexao();
		$sql = "DELETE FROM cheques WHERE id=$id";
		$resultado = $this->query($sql);
	}

	public function atualiza_cheque($registro, $data, $historico, $doc, $valor, $dt_baixa){

	  $this->conexao();

	  $sql = "UPDATE cheques SET data_vencimento='$data',
	  							  historico='$historico',
	  							  numero_doc='$doc',
	  							  valor=$valor,
	  							  data_baixa='$dt_baixa' 
	  		 WHERE id=$registro";
 
      $resultado = $this->query($sql);
	} 

 	



	

}
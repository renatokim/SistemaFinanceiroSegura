<?php

require_once('../config/relatorios.class.php');

class Caixa_relatorio extends Relatorio {



 	public function retorna_dados_conta($tipo_conta){

		$this->conexao();

		$resultado = $this->dados_conta($tipo_conta);
		$nlinhas = $this->afect_rows($resultado); // N LINHA AFETADAS

		for($i = 0; $i < $nlinhas; $i++){
			$this->date[] = $this->fetch_array($resultado);
		}

		return $this->date;
	}

	public function dados_caixa($id_conta, $dataini, $datafin){

	  $this->conexao();

	  $sql = "SELECT extratos.id, extratos.id_conta_corrente, extratos.data_emissao, 
	                 extratos.historico, extratos.numero_doc, extratos.valor, 
				     extratos.conta_caixa, conta_caixa.descricao, extratos.obs 
	          FROM extratos,conta_caixa  
	          WHERE extratos.data_emissao>='$dataini' 
	          AND extratos.data_emissao<='$datafin' 
	          AND extratos.conta_caixa=conta_caixa.num_conta_caixa 
	          AND extratos.id_conta_corrente=$id_conta 
	          ORDER BY extratos.data_emissao , extratos.id_conta_corrente,
	                   extratos.valor, extratos.id";
			  
	  $resultado = $this->query($sql);
	  $ncontas = $this->afect_rows($resultado); // n linhas
      
      for ($i=0; $i<$ncontas; $i++){
       	$dados[] = $this->fetch_array($resultado);
      }

      if(isset($dados))
	  	return $dados;
	  else 
	  	return NULL;
	}

	public function delete_extrato($id){

		$this->conexao();
		$sql = "DELETE FROM extratos WHERE id=$id";
		$resultado = $this->query($sql);
	}

	public function atualiza_caixa($registro, $data, $historico, $doc, $valor, $obs){

	  $this->conexao();

	  $sql = "UPDATE extratos SET data_emissao='$data',
	  							  historico='$historico',
	  							  numero_doc='$doc',
	  							  valor=$valor,
	  							  obs='$obs'
	  		 WHERE id=$registro";
 
      $resultado = $this->query($sql);
	}     






	






}
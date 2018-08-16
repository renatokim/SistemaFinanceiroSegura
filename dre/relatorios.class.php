<?php

require_once('../config/bancodados.class.php');

class Relatorios extends Banco
 {
	# SOMA OS CONTACAIXAS
	public function groupby_cx($dataini, $datafin)
	 {
		$date = '';
	 
	  $sql = "SELECT extratos.conta_caixa AS 'Conta-caixa', conta_caixa.descricao AS 'Descrição', SUM(extratos.valor) AS 'Valor'
			  FROM extratos, conta_caixa 
			  WHERE extratos.conta_caixa=conta_caixa.num_conta_caixa 
			  AND data_emissao>='$dataini' 
			  AND data_emissao<='$datafin' 
			  GROUP BY extratos.conta_caixa 
			  ORDER BY extratos.conta_caixa";
			  
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}		
		return $date;
	 }
	 
	 # ADICIONA NA TABELA DRE_AJUSTE
	  public function add_dre_ajuste($dataini, 
                            $contacaixa, 
                            $descricao, 
                            $valor){

	     $sql = "INSERT INTO dre_ajustes (id, data_dre, contacaixa, descricao, valor, valor_retira, valor_inclui, valor_mensal, soma_valor_mensal) 
				 VALUES ('', '$dataini', 
                            $contacaixa, 
                            '$descricao', 
                            $valor, 0, 0, 0, 0)";

		$resultado = $this->query($sql);
	  }	 
	 
	 
	 # CONTA O NUMERO DE REGISTRO DA TABELA DER_AJUSTE
	public function count_dre($dataini)
	 {
	  $sql = "SELECT COUNT(*) 
				FROM `dre_ajustes` 
				WHERE data_dre='$dataini'";
			  
	  $resultado = $this->query($sql);
	  
	  $date = $this->fetch_array($resultado);
	  
	  return $date;
	 }	
	 
	# LIMPA TABELA DRE_AJUSTE
	public function delete_dre($dataini, $datafin){

		$sql = "DELETE FROM dre_ajustes WHERE data_dre>='".$dataini."' AND data_dre<='".$datafin."'";
	
		$resultado = $this->query($sql);
	}
	
	# SELECT TODOS OS REGISTROS DRE_AJUSTE
	public function get_dre_ajuste($dataini, $datafin){
	  
	  $date = '';
	  
	  $sql = "SELECT * 
				FROM `dre_ajustes` WHERE data_dre>='".$dataini."' AND data_dre<='".$datafin."'";
			  
	  $resultado = $this->query($sql);
	  $nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}	

		return $date;
	}

	# SELECT AJUSTES LANCADOS
	public function get_ajuste_lancado($data){
	  $sql = "SELECT * 
				FROM `ajustes_lancados`
				WHERE data='$data'";
		$date = '';
	  $resultado = $this->query($sql);
	  $nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}		
		return $date;
	}
	
	# VE SE TEM REGISTRO NA TABELA DRE_AJUSTE
	public function count_reg_dre($contacaixa, $data){
		$sql = "SELECT count(*)
					FROM dre_ajustes
					WHERE contacaixa=$contacaixa 
					AND data_dre='$data'";
					
		$resultado = $this->query($sql);
		$date = $this->fetch_array($resultado);
		
		return $date;
	}
	
	# ATUALIZA O VALOR RETIRA QUANDO FOR VALOR($)
	public function set_valor_retira($contacaixa, $data, $valor){
	
		$sql = "UPDATE 	dre_ajustes
				SET valor_retira=valor_retira+$valor
				WHERE contacaixa=$contacaixa
				AND data_dre='$data'";
			//print_r($sql); die();
			
		$resultado = $this->query($sql);	
	}

	# ATUALIZA VALOR INCLUI QUANDO FOR VALOR($)
	public function set_valor_inclui($contacaixa, $data, $valor){
	
		$sql = "UPDATE 	dre_ajustes
				SET valor_inclui=valor_inclui+$valor
				WHERE contacaixa=$contacaixa
				AND data_dre='$data'";
		
		$resultado = $this->query($sql);	
	}
	
	# INSERE LINHA DRE CASO NAO EXISTA
	public function add_cx_nao_existe($contacaixa, $data, $valor, $descricao){
		$sql = "INSERT INTO dre_ajustes (data_dre, contacaixa, descricao, valor, valor_retira, valor_inclui, valor_mensal, soma_valor_mensal)
				VALUES ('$data', $contacaixa, '$descricao', 0, 0, $valor, 0, 0)";
	
		$resultado = $this->query($sql);	
	}
	
	# SET VALOR_INCLUI PECENT
	public function set_valor_inclui_pecent($cxretira, $cxinclui, $vlrpecent, $data){
		
		$sql ="SELECT valor 
			   FROM dre_ajustes
			   WHERE contacaixa=$cxretira
			   AND data_dre='$data'";
		
		$date = $this->query($sql);
		$result = $this->fetch_array($date);
		$valor = $result[0]*($vlrpecent/100);
		
		$sql ="UPDATE dre_ajustes
			   SET valor_inclui=valor_inclui+$valor
			   WHERE contacaixa=$cxinclui
			   AND data_dre='$data'";

		$resultado = $this->query($sql);				   
	}
	
	# INCLUI LINHA QUANDO NAO TEM CX VALOR PECENT
	public function add_cx_nao_existe_pecent($cxretira, $contacaixa, $data, $vlrpecent, $descricao){

		$sql ="SELECT valor 
			   FROM dre_ajustes
			   WHERE contacaixa=$cxretira
			   AND data_dre='$data'";
	
		$date = $this->query($sql);
		$result = $this->fetch_array($date);
		$valor = $result[0]*($vlrpecent/100);

		$sql = "INSERT INTO dre_ajustes (data_dre, contacaixa, descricao, valor, valor_retira, valor_inclui, valor_mensal, soma_valor_mensal)
				VALUES ('$data', $contacaixa, '$descricao', 0, 0, $valor, 0, 0)";
	
		$resultado = $this->query($sql);	
	}	
	
	
	
	# ATUALIZA VALOR RETIRA QUANDO FOR PECENT(%)
	public function update_dre_pecent($contacaixa, $data, $valor){
	
		$sql = "UPDATE 	dre_ajustes
				SET valor_retira=valor_retira+(valor*($valor/100))
				WHERE contacaixa=$contacaixa
				AND data_dre='$data'";
			
		$resultado = $this->query($sql);	
	}	
	
	# SETA TODOS O VALORE COMO POSITIVO
	public function set_positivo(){
		$sql1 ="UPDATE dre_ajustes
			   SET valor_retira=valor_retira*-1
			   WHERE valor_retira<0";
		
		$sql2 ="UPDATE dre_ajustes
			   SET valor_inclui=valor_inclui*-1
			   WHERE valor_inclui<0";
		
		$resultado1 = $this->query($sql1);
		$resultado2 = $this->query($sql2);
	}
	
	# ATUALIZA VALOR AJUSTADO
	public function set_valor_ajustado(){
		$sql ="UPDATE dre_ajustes
			   SET soma_valor_ajuste=valor-valor_retira+valor_inclui
			   WHERE valor>0";
	
		$resultado = $this->query($sql);
		
		$sql ="UPDATE dre_ajustes
			   SET soma_valor_ajuste=valor+valor_retira-valor_inclui
			   WHERE valor<=0";
	
		$resultado = $this->query($sql);

	}

	
	
	# PEGA O VALOR EVENTUAL
	public function get_eventual_by_contacaixa($contacaixa, $data)
	{
		$sql = "SELECT valor
				FROM eventual_lancado
		 		WHERE cx_retira=$contacaixa
				AND data='$data'";

		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);
		$return = $date[0];

	    return $return;
	}

	# ATUALIZA VALOR MENSAL TABELA DRE
	public function set_valor_mensal($contacaixa, $data, $valor){
	
		$sql = "UPDATE 	dre_ajustes	
				SET valor_mensal=$valor
				WHERE contacaixa=$contacaixa
				AND data_dre='$data'";
				
				//print_r($sql); die();
			
		$resultado = $this->query($sql);	
	}
	
	# ATUALIZA VALOR MENSAL
	public function soma_valor_mensal(){
		$sql1 ="UPDATE dre_ajustes
			   SET soma_valor_mensal=soma_valor_ajuste-valor_mensal
			   WHERE soma_valor_ajuste>0";

		$sql2 ="UPDATE dre_ajustes
			   SET soma_valor_mensal=soma_valor_ajuste+valor_mensal
			   WHERE soma_valor_ajuste<0";
	
		$resultado1 = $this->query($sql1);
		$resultado2 = $this->query($sql2);
	}
	
	# PEGA A SOMA DAS COLUNAS DA TABELA DRE
	public function soma_subtotal(){
		$sql = "SELECT sum(valor), sum(valor_retira), sum(valor_inclui), sum(soma_valor_ajuste), sum(valor_mensal), sum(soma_valor_mensal)
				FROM dre_ajustes";
		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);
		$return = $date;

	    return $return;				
	}
	
	# PEGA A SOMA DAS COLUNAS DA TABELA DRE
	public function CI_soma_subtotal($dataini, $datafin){
		$sql = "SELECT sum(valor), sum(valor_retira), sum(valor_inclui), sum(soma_valor_ajuste), sum(valor_mensal), sum(soma_valor_mensal)
				FROM dre_ajustes WHERE data_dre>='".$dataini."' AND data_dre<='".$datafin."'";
		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);
		$return = $date;

	    return $return;				
	}	
	

	# PEGA A SOMA DA COLUNA VALOR_EVENTUAL DA TABELA DRE
	public function soma_subtotal_eventual(){
		$sql = "SELECT sum(valor_mensal)-(SELECT sum(valor_mensal)
				FROM dre_ajustes WHERE soma_valor_ajuste<0)
				FROM dre_ajustes WHERE soma_valor_ajuste>0";
		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);
		$return = $date;

	    return $return;				
	}
	
	# PEGA A SOMA DA COLUNA VALOR_EVENTUAL DA TABELA DRE
	public function CI_soma_subtotal_eventual($dataini, $datafin){
		$sql = "SELECT sum(valor_mensal)-(SELECT sum(valor_mensal)
				FROM dre_ajustes WHERE soma_valor_ajuste<0
				AND data_dre>='".$dataini."'
				AND data_dre<='".$datafin."'
				)
				FROM dre_ajustes WHERE soma_valor_ajuste>0
				AND data_dre>='".$dataini."'
				AND data_dre<='".$datafin."'";
			//die($sql);
		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);
		$return = $date;

	    return $return;				
	}	


	# DELETE EVENTUAL LANCADO
	public function delete_eventual_lancados($data){
		$sql = "DELETE FROM eventual_lancado
				WHERE data='$data'";

		$resultado = $this->query($sql);				
	}
	
	# LANCA EVENTUAL
	public function lanca_eventual($data, $cntcx, $valor){

		$sql = "INSERT INTO eventual_lancado VALUES ('', '$data', $cntcx, '', $valor)";
		$resultado = $this->query($sql);
	}






	
	 
}


?>
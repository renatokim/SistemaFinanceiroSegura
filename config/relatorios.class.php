<?php

require_once('bancodados.class.php');

class Relatorio extends Banco
 {

    var $date = NULL;

	public function relatdata($dataini, $datafin)
	 {
	  $sql = "SELECT 
extratos.id, 
extratos.data_emissao, 
extratos.historico, 
extratos.numero_doc, 
extratos.valor, 
extratos.conta_caixa, 
conta_caixa.descricao, 
extratos.obs,
conta_corrente.descricao as id_conta_corrente
FROM 
extratos,conta_caixa,conta_corrente  
	          WHERE extratos.data_emissao>='$dataini' 
	          AND extratos.data_emissao<='$datafin' 
	          AND extratos.conta_caixa=conta_caixa.num_conta_caixa 
			  AND extratos.id_conta_corrente=conta_corrente.id
	          ORDER BY extratos.data_emissao, extratos.id_conta_corrente, extratos.id";
	  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function relatcntcx($dataini, $datafin)
	 {
	  $sql = "SELECT 
				extratos.id, 
				extratos.data_emissao, 
				extratos.historico, 
				extratos.numero_doc, 
				extratos.valor, 
				extratos.conta_caixa, 
				conta_caixa.descricao, 
				extratos.obs,
				conta_corrente.descricao as id_conta_corrente
				FROM extratos,conta_caixa,conta_corrente  
	          WHERE extratos.data_emissao>='$dataini' 
	          AND extratos.data_emissao<='$datafin' 
	          AND extratos.conta_caixa=conta_caixa.num_conta_caixa 
			  AND conta_corrente.id=extratos.id_conta_corrente 
	          ORDER BY extratos.conta_caixa, extratos.data_emissao,
  			      extratos.id_conta_corrente, extratos.id";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	
	
	public function relatconc($dataini, $datafin, $cntcx_conc_entrada, $cntcx_conc_saida)
	 {
	  $sql = "SELECT extratos.id, extratos.id_conta_corrente, extratos.data_emissao, 
	              extratos.historico, extratos.numero_doc, extratos.valor, 
				  extratos.conta_caixa, conta_caixa.descricao, extratos.obs 
	          FROM extratos,conta_caixa  
	          WHERE extratos.data_emissao>='$dataini' 
	          AND extratos.data_emissao<='$datafin' 
	          AND extratos.conta_caixa=conta_caixa.num_conta_caixa
			  AND (extratos.conta_caixa=$cntcx_conc_entrada
			  OR extratos.conta_caixa=$cntcx_conc_saida)
	          ORDER BY extratos.data_emissao, extratos.conta_caixa, extratos.valor, extratos.id,  extratos.id_conta_corrente";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	
	
	public function relatbanco($dataini, $datafin)
	 {
	  $sql = "
			SELECT 
					extratos.id, 
					extratos.id_conta_corrente, 
					extratos.data_emissao, 
					extratos.historico, 
					extratos.numero_doc, 
					extratos.valor, 
					extratos.conta_caixa, 
					conta_caixa.descricao, 
					extratos.obs,
					conta_corrente.descricao as id_conta_corrente
					FROM extratos,conta_caixa,conta_corrente
	          WHERE extratos.data_emissao>='$dataini' 
	          AND extratos.data_emissao<='$datafin' 
	          AND extratos.conta_caixa=conta_caixa.num_conta_caixa 
			  AND conta_corrente.id=extratos.id_conta_corrente
	          ORDER BY extratos.id_conta_corrente, extratos.data_emissao,
  			      extratos.id, extratos.valor";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function relatconta()
	 {
	  $sql = "SELECT id, descricao, numero_conta, obs FROM conta_corrente ORDER BY id";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function relatcadcontacaixa()
	 {
	  $sql = "SELECT id, num_conta_caixa, descricao FROM conta_caixa ORDER BY num_conta_caixa";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function chqpendentehoje($id_conta_corrente, $datahoje)
	 {
	  $sql = "SELECT cheques.id, cheques.id_conta_corrente, cheques.data_emissao,
     	             cheques.historico, cheques.numero_doc, cheques.valor, 
					 cheques.data_vencimento, cheques.conta_caixa, conta_caixa.descricao
			  FROM cheques, conta_caixa 
			  WHERE (data_baixa IS NULL OR data_baixa='0000-00-00')
			  AND id_conta_corrente=$id_conta_corrente
			  AND data_vencimento<='$datahoje'
			  AND cheques.conta_caixa=conta_caixa.num_conta_caixa ORDER BY data_vencimento";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }
	 
	public function chqdepoishoje($id_conta_corrente, $datahoje)
	 {
	  $sql = "SELECT cheques.id, cheques.id_conta_corrente, cheques.data_emissao,
     	             cheques.historico, cheques.numero_doc, cheques.valor, 
					 cheques.data_vencimento, cheques.conta_caixa, conta_caixa.descricao
			  FROM cheques, conta_caixa 
			  WHERE (data_baixa IS NULL OR data_baixa='0000-00-00')
			  AND id_conta_corrente=$id_conta_corrente
			  AND data_vencimento>'$datahoje'
			  AND cheques.conta_caixa=conta_caixa.num_conta_caixa ORDER BY data_vencimento";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }	

	public function chqtodos($id_conta_corrente)
	 {
	  $sql = "SELECT cheques.id, cheques.id_conta_corrente, cheques.data_emissao,
     	             cheques.historico, cheques.numero_doc, cheques.valor, 
					 cheques.data_vencimento, cheques.conta_caixa, conta_caixa.descricao
			  FROM cheques, conta_caixa 
			  WHERE id_conta_corrente=$id_conta_corrente
			  AND cheques.conta_caixa=conta_caixa.num_conta_caixa ORDER BY cheques.numero_doc";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	 

	public function relatoriocaixa($dataini, $datafin)
	 {
	  $sql = "SELECT extratos.id, extratos.id_conta_corrente, extratos.data_emissao, 
	                 extratos.historico, extratos.numero_doc, extratos.valor, 
				     extratos.conta_caixa, conta_caixa.descricao, extratos.obs 
	          FROM extratos,conta_caixa  
	          WHERE extratos.data_emissao>='$dataini' 
	          AND extratos.data_emissao<='$datafin' 
	          AND extratos.conta_caixa=conta_caixa.num_conta_caixa 
	          AND (extratos.id_conta_corrente=8 
	               OR extratos.id_conta_corrente=14) 
	          ORDER BY extratos.data_emissao DESC, extratos.id_conta_corrente,
	                   extratos.valor, extratos.id";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }
	 
	// RECEBE O TIPO DA CONTA E RETORNA O ID DA CONTA
	public function tipoconta($tipoconta)
	 {
	  $sql = "SELECT id FROM conta_corrente WHERE id_tconta=$tipoconta";
	  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function dados_conta($tipoconta)
	 {
	  $sql = "SELECT * FROM conta_corrente WHERE id_tconta=$tipoconta";
	  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }





	 public function ajustes()
	  {
	  	$sql = "SELECT id, cx_retira, descricao_cx_ret, cx_inclui, descricao_cx_inc, vlr_or_pecent, valor
	  			FROM ajustes WHERE ativo=0";
	  
	   $resultado = $this->query($sql);
	  
	   return $resultado;	  			
	  }

	  public function delete_ajuste($id)
	   {
	   	$sql = "UPDATE ajustes SET ativo=1 WHERE id=$id";

	   	$resultado = $this->query($sql);

	   	return $resultado;
	   }

	  public function desc_ajuste($cntcx)
	   {
	   	$sql = "SELECT descricao FROM conta_caixa WHERE num_conta_caixa=$cntcx";

	   	$resultado = $this->query($sql);

	   	return $resultado;
	   }

	  public function insere_ajuste($cx_retirada, 
                            $descricao_cx_ret, 
                            $cx_inclui, 
                            $descricao_cx_inc, 
                            $vlr_or_prec, 
                            $valor){

	     $sql = "INSERT INTO ajustes values ('', $cx_retirada, 
                            '$descricao_cx_ret', 
                            $cx_inclui, 
                            '$descricao_cx_inc', 
                            '$vlr_or_prec', 
                            $valor, 0)";

		$resultado = $this->query($sql);
	  }


##################

	public function relatcntcxgroupby($dataini, $datafin)
	 {
	  $sql = "SELECT extratos.conta_caixa AS 'Conta-caixa', conta_caixa.descricao AS 'Descrição', SUM(extratos.valor) AS 'Valor'
			  FROM extratos, conta_caixa 
			  WHERE extratos.conta_caixa=conta_caixa.num_conta_caixa 
			  AND data_emissao>='$dataini' 
			  AND data_emissao<='$datafin' 
			  GROUP BY extratos.conta_caixa 
			  ORDER BY extratos.conta_caixa";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function relatcntcxgroupby_2($dataini, $datafin)
	 {
	  $sql = "SELECT extratos.conta_caixa AS 'Conta-caixa', conta_caixa.descricao AS 'Descrição', SUM(extratos.valor) AS 'Valor'
			  FROM extratos, conta_caixa 
			  WHERE extratos.conta_caixa=conta_caixa.num_conta_caixa 
			  AND data_emissao>'$dataini' 
			  AND data_emissao<'$datafin' 
			  GROUP BY extratos.conta_caixa 
			  ORDER BY extratos.conta_caixa";
			  
	  $resultado = $this->query($sql);

	  $nlinhas = $this->afect_rows($resultado);
	  
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	  
	  return $date;
	 }


	
	// RELATORIO DE GRUPOS DE CONTA-CAIXA - SOMA ORCAMENTO E OFICIAL
	public function addprovisorio($cx_orig, $cx_prov, $posicao, $descricao, $valor) 
	 {
	  $sql = "INSERT INTO grupo_provisorio VALUES ('', $cx_orig, $cx_prov, $posicao, '$descricao', $valor)";
	  $resultado = $this->query($sql);
	 }
	 
	 public function deleteprovisorio() 
	  {
	  $sql = "DELETE FROM grupo_provisorio";
	  $this->query($sql);
	  }
	
	public function relatcntcxgroupbysoma()
	 {
	  $sql = "SELECT grupo_provisorio.cntcx_provisorio AS 'Conta-caixa', conta_caixa.descricao AS 'Descrição', SUM(grupo_provisorio.valor) AS 'Valor'
			  FROM grupo_provisorio, conta_caixa
			  WHERE grupo_provisorio.cntcx_provisorio=conta_caixa.num_conta_caixa
			  GROUP BY grupo_provisorio.cntcx_provisorio 
			  ORDER BY grupo_provisorio.posicao, grupo_provisorio.cntcx_provisorio";
			  
	  $resultado = $this->query($sql);
	  
	  return $resultado;
	 }

	public function busca_ajuste_mes()
	 {
	 	$sql = "SELECT * FROM ajustes WHERE ativo=0";

	 	$resultado = $this->query($sql);
	  
	   return $resultado;
	 }


	public function se_tem_ajuste($conta_caixa)
	{
		$sql = "SELECT * FROM ajustes_lancados WHERE cx_retira=$conta_caixa";

	 	$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
		for($i = 0; $i < $nlinhas; $i++){
			$this->date[] = $this->fetch_array($resultado);
		}

	    return $this->date;
	}

	public function se_tem_ajuste_retira($conta_caixa)
	{
		$sql = "SELECT * FROM ajustes_lancados WHERE cx_retira=$conta_caixa";

	 	$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

	 	if($nlinhas == 0) return 1;

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}

	public function se_tem_ajuste_inclui($conta_caixa)
	{
		$sql = "SELECT * FROM ajustes_lancados WHERE cx_inclui=$conta_caixa";

		$date = '';

	 	$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}






	public function add_ajuste_temp($cx_temp, $descricao_temp, $valor_temp)
	{
		$sql = "INSERT INTO ajustes_temporario VALUES ('', $cx_temp, '$descricao_temp', $valor_temp)";

		$resultado = $this->query($sql);
	}

	public  function delete_ajuste_temp()
	{
		$sql = "DELETE FROM ajustes_temporario";

		$resultado = $this->query($sql);
	}



	public function eventuais_lancados()
	{
		$sql = "SELECT * FROM eventual_lancado";

	 	$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}


	public function ajustes_lancados($data)
	{
		$sql = "SELECT * FROM ajustes_lancados
				WHERE data='$data'";

				//print_r($sql); die();
				
	 	$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}


	public function subtrai_valor_pec($cx, $valor)
	{
		$sql = "UPDATE ajustes_temporario 
					SET valor_temp=valor_temp-(valor_temp*($valor/100)) 
					WHERE cx_temp=$cx";

		$this->query($sql);
	}



	public function set_ajust_lancado($id, $tipo, $valor)
	{
		$sql = "UPDATE ajustes_lancados 
					SET vlr_or_pecent='$tipo', valor=$valor 
					WHERE id=$id";

		$this->query($sql);


	}

	public function soma_valor_pec($cx, $valor)
	{
		$sql = "UPDATE ajustes_temporario 
					SET valor_temp=valor_temp+(valor_temp*($valor/100)) 
					WHERE cx_temp=$cx";

		$this->query($sql);
	}

	public function subtrai_valor_vlr($cx, $valor)
	{
		$sql = "UPDATE ajustes_temporario 
					SET valor_temp=valor_temp-$valor 
					WHERE cx_temp=$cx";

		$this->query($sql);
	}

	public function soma_valor_vlr($cx, $valor)
	{
		$sql = "UPDATE ajustes_temporario 
					SET valor_temp=valor_temp+$valor
					WHERE cx_temp=$cx";

		$this->query($sql);
	}

	public function get_ajuste_temp()
	{
		$sql = "SELECT * FROM ajustes_temporario";

		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
	 	$date = '';

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}


	public function salva_ajustes_banco($mes_ano, $conta_caixa, $valor_temp)
	{
		$sql = "INSERT INTO  ajustes_salvos values ('', '$mes_ano', $conta_caixa, $valor_temp)";
		$resultado = $this->query($sql);
	}

	public function delete_ajustes_banco($mes_ano)
	{
		$sql = "DELETE FROM ajustes_salvos WHERE mes_ano='$mes_ano'";
		$resultado = $this->query($sql);
	}

	public function get_ajustes_banco($mes_ano)
	{
		$sql = "SELECT mes_ano,ajustes_salvos.conta_caixa,descricao,valor 
				FROM ajustes_salvos,conta_caixa 
				WHERE mes_ano='$mes_ano'
				AND ajustes_salvos.conta_caixa=conta_caixa.num_conta_caixa";

		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}

	public function insere_ajuste_lancados($data, 
										   $cx_retira, 
										   $descricao_cx_ret, 
										   $cx_inclui, 
										   $descricao_cx_inc, 
										   $vlr_or_prec,
										   $valor){

		$sql = "INSERT INTO ajustes_lancados VALUES ('',
												     '$data', 
												     $cx_retira, 
												     '$descricao_cx_ret', 
												     $cx_inclui, 
												     '$descricao_cx_inc', 
												     '$vlr_or_prec',
												     $valor)";
		
		$resultado = $this->query($sql);
	}

	public function delete_ajustes_lacados($dt_ini, $dt_fin)
	{
		$sql = "DELETE FROM ajustes_lancados WHERE data>='$dt_ini' AND data<='$dt_fin'";
		$resultado = $this->query($sql);
	}


	public function del_ajustes_lacados($id)
	{
		$sql = "DELETE FROM ajustes_lancados WHERE id=$id";
		$resultado = $this->query($sql);
	}


	public function lanca_eventual($data, $cntcx, $descricao_cx, $valor){

		$sql = "INSERT INTO eventual_lancado VALUES ('', '$data', $cntcx, '$descricao_cx', $valor)";
		$resultado = $this->query($sql);
	}

	public function delete_eventual_lacados($dt_ini, $dt_fin)
	{
		$sql = "DELETE FROM eventual_lancado WHERE data>='$dt_ini' AND data<='$dt_fin'";
		$resultado = $this->query($sql);
	}

	public function se_tem_eventual_lancado($conta_caixa)
	{
		$sql = "SELECT * FROM eventual_lancado WHERE cx_retira=$conta_caixa";

	 	$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

	 	if($nlinhas == 0) return 1;

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}	


	public function se_chq_ja_lancado($id_conta, $n_chq)
	{
		$sql = "SELECT * FROM cheques WHERE id_conta_corrente=$id_conta AND numero_doc='$n_chq'";
		$resultado = $this->query($sql);
		$ncontas = $this->afect_rows($resultado);
		return $ncontas;
	}

	public function se_chq_ja_extrato($id_conta, $n_chq)
	{
		$sql = "SELECT * FROM extratos WHERE id_conta_corrente=$id_conta AND numero_doc='$n_chq'";
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
	  $date = '';
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}


	public function get_valor($tabela, $coluna, $data, $conta_caixa, $mes_ano)
	{
		$sql = "SELECT sum(valor) as valor FROM  $tabela WHERE $coluna=$conta_caixa AND $data='$mes_ano'";
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
	  $date = '';
		for($i = 0; $i < $nlinhas; $i++){
			$date = $this->fetch_array($resultado);
		}

	    return $date;
	}


public function setcx($id, $obs)
{
	$sql = "UPDATE conta_caixa SET descricao='$obs' 
	    	WHERE id=$id";

    $resultado = $this->query($sql);

	return $resultado;

}


public function add_grafico($nome)
	{
		$sql = "INSERT INTO cadastro_graficos VALUES ('', '$nome')";

    	$resultado = $this->query($sql);
	}
public function add_grupo($id_grafico, $seq, $nome)
	{
		$sql = "INSERT INTO cadastro_grupos VALUES ('', $id_grafico, $seq, '$nome')";

    	$resultado = $this->query($sql);
	}	


	public function get_cad_grupos()
	{
		$sql = "SELECT * FROM cadastro_graficos";	
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);
	  
	  $date = '';
		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}

	public function get_max_id_grupo($id_graf)
	{
		$sql = "SELECT max(seq_grupo) FROM cadastro_grupos WHERE id_cadastro_grafico=$id_graf";	
		$resultado = $this->query($sql);
	 	$nlinhas = $this->fetch_array($resultado);

	    $idmax = $nlinhas[0] + 1;

	    return $idmax;
	}

	public function get_all_cad_grupo($id_graf)
	{
		$sql = "SELECT * FROM cadastro_grupos WHERE id_cadastro_grafico=$id_graf ORDER BY seq_grupo";	
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}



public function add_cnxt_grupo($id_grafico, $seq, $value)
	{
		$sql = "INSERT INTO  contacaixa_grupos VALUES ('', $id_grafico, $seq, $value)";

    	$resultado = $this->query($sql);
	}

public function del_temp_grupo_grafico()
	{
		$sql = "DELETE FROM temp_grupo_grafico";

    	$resultado = $this->query($sql);
	}

public function add_temp_grupo_grafico($grupo, $valor)
	{
		$sql = "INSERT INTO  temp_grupo_grafico VALUES ('', '$grupo', $valor)";

    	$resultado = $this->query($sql);
	}

public function get_temp_grupo_grafico()
	{
		$sql = "SELECT grupo,sum(valor) as valor FROM temp_grupo_grafico group by grupo";

		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}

public function sum_temp_grupo_grafico_sem_receita($receita)
	{
		$sql = "SELECT sum(valor) as sum_sem_receita FROM `temp_grupo_grafico` WHERE `grupo`!='$receita'";

		$resultado = $this->query($sql);
		$date = $this->fetch_array($resultado);

	    return $date;
	}

	public function update_event_lanc($contacaixa, $valor, $data)
	{
		$sql = "UPDATE eventual_lancado 
					SET valor=$valor 
					WHERE cx_retira=$contacaixa
					AND data='$data'";


		$sql2 = "select * from eventual_lancado";
		
	 	$resultado = $this->query($sql);

	 	print_r($resultado); die();

	 	$nlinhas = $this->afect_rows($resultado);

		return $nlinhas;
	}



	public function add_cntx_incluidos($contacaixa, $descricao, $valor)
		{
			$sql = "INSERT INTO   temp_cx_incluidos VALUES ('', $contacaixa, '$descricao', $valor)";

	    	$resultado = $this->query($sql);
		}

public function get_temp_cx_incluidos()
	{
		$sql = "SELECT cx_ins_temp, descricao_inc_temp, sum(valor_inc_temp) as valor FROM temp_cx_incluidos group by cx_ins_temp";

		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}

	 
	 public function delete_temp_cx_incluidos() 
	  {
	  $sql = "DELETE FROM temp_cx_incluidos";
	  $this->query($sql);
	  }	

	public function get_nome_graf($idgraf)
	{
		$sql = "SELECT nome_grafico
				FROM cadastro_graficos
		 		WHERE id=$idgraf";

		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);

	    return $date;
	}

	public function get_eventual_by_contacaixa($contacaixa)
	{
		$sql = "SELECT valor
				FROM eventual_lancado
		 		WHERE cx_retira=$contacaixa";

		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);
		$return = $date[0];

//print_r($sql); print_r($return); die();

	    return $return;


	}

	public function getAllGraficos()
	{
		$sql = "SELECT *
				FROM cadastro_graficos";
		
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}		
		return $date;
	}
	
	
	 public function delete_grafico($id) 
	  {
	  $sql = "DELETE FROM cadastro_graficos
			  WHERE id=$id";
	  $this->query($sql); 
	  }

	public function alterar_grafico($id, $nome)
	   {
	   	$sql = "UPDATE cadastro_graficos SET nome_grafico='$nome' WHERE id=$id";

	   	$resultado = $this->query($sql);

	   	return $resultado;
	   }



	public function getAllGrupos()
	{
		/*$sql = "SELECT *
				FROM cadastro_grupos";*/
				
		$sql = "SELECT * FROM `cadastro_grupos`, cadastro_graficos WHERE  id_cadastro_grafico=cadastro_graficos.id order by cadastro_graficos.id,seq_grupo ";
		
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}		
		return $date;
	}
	
	
	 public function delete_grupo($id) 
	  {
	  $sql = "DELETE FROM cadastro_grupos
			  WHERE id=$id"; //print_r($sql); die();
	  $this->query($sql); 
	  }

	public function alterar_grupo($id, $nome)
	   {
	   	$sql = "UPDATE cadastro_grupo SET nome_grafico='$nome' WHERE id=$id";

	   	$resultado = $this->query($sql);

	   	return $resultado;
	   }

	public function get_n_chq($nchq)
	{
		$sql = "SELECT count(*) FROM cheques 
				WHERE numero_doc='$nchq'";

		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);

	    return $date[0];
	}

	public function get_obs_chq($nchq)
	{ 
		$sql = "SELECT historico FROM cheques 
				WHERE numero_doc='$nchq'";

		$resultado = $this->query($sql);

		$date = $this->fetch_array($resultado);

	    return $date[0];
	}

	public function conciliacao()
		{
			$sql = "select 
						cheques.numero_doc as c_numero_doc, 
						extratos.numero_doc as e_numero_doc, 
						extratos.data_emissao as e_data 
					from 
						cheques
					join 
						extratos on extratos.numero_doc = cheques.numero_doc
					where 
						cheques.numero_doc in (select extratos.numero_doc from extratos) 
					and 
						( data_baixa is NULL or data_baixa = '0000-00-00' )";

						
			$resultado = $this->query($sql);
			$nlinhas = $this->afect_rows($resultado);

			$chqs = array();
			
			for($i = 0; $i < $nlinhas; $i++)
				{
					$chqs[] = $this->fetch_array($resultado);
				}

			foreach ($chqs as $key => $chq)
				{
					$sql = "UPDATE cheques SET data_baixa = '".$chq['e_data']."' WHERE numero_doc = '".$chq['c_numero_doc']."'";
					
					$this->query($sql);
				}
		}
		
	public function insere_ajuste_caixa($dados, $dt_ini)
		{
			$dados[1] = str_replace('_' , ' ', $dados[1]);
			$dados[5] = str_replace('_' , ' ', $dados[5]);
			
			if ( $dados[0] < 2000000 )
				$dados[3] = $dados[3] * ( -1 );
		
			if( $dados[2] == '$' )
				{
					$sql = "INSERT INTO extratos (id_conta_corrente, data_emissao, historico, obs, valor, conta_caixa) 
								VALUES (15, '".$dt_ini."', '".$dados[1]."', '".$dados[1]."', ".$dados[3].", ".$dados[0].")";
								
					$this->query($sql);
					
					$sql = "INSERT INTO extratos (id_conta_corrente, data_emissao, historico, obs, valor, conta_caixa) 
								VALUES (15, '".$dt_ini."', '".$dados[5]."', '".$dados[5]."', ".( $dados[3] * -1 ).", ".$dados[4].")";
								
					$this->query($sql);					
				}
			else
				{
					$sql = "INSERT INTO extratos (id_conta_corrente, data_emissao, historico, obs, valor, conta_caixa) 
								VALUES (15, '".$dt_ini."', '".$dados[1]."', '".$dados[1]."', ".$dados[3].", ".$dados[0].")";
								
					$this->query($sql);
					
					$sql = "INSERT INTO extratos (id_conta_corrente, data_emissao, historico, obs, valor, conta_caixa) 
								VALUES (15, '".$dt_ini."', '".$dados[5]."', '".$dados[5]."', ".( $dados[3] * -1 ).", ".$dados[4].")";
								
					$this->query($sql);				
				}
		}
	

	
	  

	  
	  
	  
	   
	 
}


?>
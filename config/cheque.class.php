<?php
require_once("extrato.class.php");

class Cheque extends Extrato
 {
	
	public $data;
	public $valor;
	public $historico;
	public $obs;
	
	public function inserechq($id_conta_corrente, $data, $historico, $doc, $valor, $data_vencimento, $contacaixa)
	 {

	  $sql = "INSERT INTO cheques (id_conta_corrente, data_emissao, historico, numero_doc,	valor, data_vencimento,	conta_caixa)
              VALUES ($id_conta_corrente, '$data', '$historico', '$doc', $valor, '$data_vencimento', $contacaixa)";
	  $this->query($sql);
	 }
	 
	public function excluichq($id_conta_corrente, $num_cheque)
	 {
	  $sql = "DELETE FROM cheques WHERE id_conta_corrente=$id_conta_corrente AND numero_doc='$num_cheque'";
	  $this->query($sql);	  
	 }
 }
?>
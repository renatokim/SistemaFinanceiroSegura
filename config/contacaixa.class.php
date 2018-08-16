<?php
require_once("extrato.class.php");

class Contacaixa extends Extrato
 {
	public $data;
	public $valor;
	public $historico;
	public $obs;
	
	public function inserir($id_conta, $data, $historico, $doc, $valor, $conta_caixa, $obs)
	 {
  	  $this->insereext($id_conta, $data, $historico, $doc, $valor, 0, $obs);
	 }
	 
	public function setcontacaixa($registro, $contacaixa)
     {
	  $sql = "UPDATE extratos SET conta_caixa = $contacaixa WHERE id = $registro";
	  $this->query($sql);
     }

	public function setdescricao($registro, $descricao)
	 {
	  $sql = "UPDATE extratos SET obs ='$descricao' WHERE id=$registro";
	  $this->query($sql);
	 }
	 
    public function inserirchq($id_conta_corrente, $data, $historico, $doc, $valor, $data_vencimento, $contacaixa)
	 {
	  $sql = "INSERT INTO cheques (id_conta_corrente, data_emissao, historico, numero_doc,	valor, data_vencimento,	conta_caixa)
              VALUES ($id_conta_corrente, '$data', '$historico', '$doc', $valor, '$data_vencimento', $contacaixa)";
	  $this->query($sql);
	 }	 

	 
 }
?>
<?php
require_once("extrato.class.php");

class Caixa extends Extrato
 {
	
	public $data;
	public $valor;
	public $historico;
	public $obs;
	
	public function inserir($id_conta, $data, $historico, $doc, $valor, $conta_caixa, $obs)
	 {
  	  $this->insereext($id_conta, $data, $historico, $doc, $valor, $conta_caixa, $obs);
	 }
 }
?>

<?php

require_once("../config/extrato.class.php");

class Cadastro extends Extrato 
 {
	
	public $tipo_conta;
	public $num_conta;
	public $descricao;
	public $obs;
	
	public function cadastrar($tipo_conta, $num_conta, $descricao, $obs)
	 {
	  $sql = "INSERT INTO conta_corrente (id_tconta, numero_conta, descricao, obs)
	  VALUES ($tipo_conta, '$num_conta', '$descricao', '$obs')";
	  
	  $this->query($sql);
	 }
	 
	public function excluir($id)
	 {
	  $sql = "DELETE FROM conta_corrente WHERE id=$id";
	  
	  return $this->query($sql);
	 }
	 
	public function alterar($id, $numero_conta, $descricao, $obs)
	 {
	  $sql = "UPDATE conta_corrente set numero_conta='$numero_conta', descricao='$descricao', obs='$obs' 
	          WHERE id=$id";
 
	  $this->query($sql);
	 }
	 
	public function criapasta($pasta)
	 {
	  return mkdir("C:\EXTRATOS\\$pasta");
	 }

	public function delpasta($pasta)
	 {
	  rmdir("C:\EXTRATOS\\$pasta");
	 }	 
	  
	 
	
 }

?>
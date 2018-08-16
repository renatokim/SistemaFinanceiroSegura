<?php
require_once("extrato.class.php");

class Alt_ext extends Extrato
 {
	
	public function atualiza_desc($registro, $obs, $doc){

	  $this->conexao();

	  $sql = "UPDATE extratos SET obs='$obs', numero_doc='$doc'
	  		 WHERE id=$registro";
 
      $resultado = $this->query($sql);
	} 
 }
?>

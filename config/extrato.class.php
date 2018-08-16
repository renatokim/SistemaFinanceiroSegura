<?php
require_once("bancodados.class.php");

abstract class Extrato extends Banco 
 {
	
	public $data;
	public $doc;
	public $historico;
	public $valor;
	public $obs;
	public $conta_caixa;
		 
	// METODO "ABSTRATO" - CADA BANCO FAZ SUA IMPLEMENTACAO 
	public function filetipo($id_conta, $obs_conta)
	 {
	
	 }
 
	// METODO PARA INSERIR NO BANCO DE DADOS
	public function insereext($id_conta_corrente, $data, $historico, $doc, $valor, $contacaixa, $obs)
	 {
	  $sql = "INSERT INTO extratos (id_conta_corrente, data_emissao, historico, numero_doc, valor, conta_caixa, obs)
              VALUES ($id_conta_corrente, '$data', '$historico', '$doc', $valor, $contacaixa, '$obs')";
	  $this->query($sql);
	 }
	 
	 
	public function insereChqDep($id_conta_corrente, $data, $data, $data, $historico, $doc, $valor, $contacaixa, $obs)
	 {
		$sql = "INSERT INTO extratos (id_conta_corrente, data_entrada, data_emissao, data_bom_p, historico, numero_doc, valor, conta_caixa, obs)
				VALUES ($id_conta_corrente, '$data', '$data', '$data', '$historico', '$doc', $valor, $contacaixa, '$obs')";
		$this->query($sql);
	 }	 
	 
	 
	 
		
	// METODO QUE TESTA SE O ARQUIVO EXISTE
	public function filexiste($obs_conta)
	 {
      $pasta = "c:\EXTRATOS\\$obs_conta";
	  $diretorio = opendir($pasta); 
	  
	  $file = readdir($diretorio);  // DIRETORIO ACIMA
 	  $file = readdir($diretorio);  // DIRETORIO ATUAL
  	  // SE ARQUIVO DO EXISTE
	  if(!$arq = readdir($diretorio))
	   return -1;
      else 
       $file = $arq;

	  $arquivo = "$pasta\\$file";

	  return $arquivo;
	 }
	 
	 // METODO PARA BAIXAR O CHEQUE
	 public function baixachq($id_conta, $ncheque, $dtbaixa)
	  {
	   $sql = "UPDATE cheques SET data_baixa='$dtbaixa' WHERE id_conta_corrente=$id_conta AND numero_doc='$ncheque'";
	   $this->query($sql);
	  }
	 
	 // METODO PARA TESTAR SE O CHEQUE ESTA NA TABELA CHEQUES
	 public function chqexiste($id_conta, $ncheque, $dtbaixa)
	  {
	   $sql = "SELECT numero_doc FROM cheques WHERE id_conta_corrente = $id_conta AND numero_doc='$ncheque'";
	   $resultado = $this->query($sql); 
       
	   $nlinhas = $this->afect_rows($resultado);
	   
	   if ($nlinhas > 0)
	    {
	     $this->baixachq($id_conta, $ncheque, $dtbaixa);
	    }
	  }

	 public function sechqexiste($id_conta, $ncheque, $dtbaixa)
	  {
	   $sql = "SELECT numero_doc FROM cheques WHERE id_conta_corrente = $id_conta AND numero_doc='$ncheque'";
	   $resultado = $this->query($sql); 
       
	   $nlinhas = $this->afect_rows($resultado);
	   
	   if ($nlinhas > 0)
	    {
	     return 'existe';
	    }
	  }

	  
	 // METODO QUE RETORNA O CONTA CAIXA DO CHEQUE
	 public function retcontacx($id_conta, $ncheque)
	  {
	   $sql = "SELECT conta_caixa FROM cheques WHERE id_conta_corrente = $id_conta AND numero_doc = '$ncheque'";
	   $resultado = $this->query($sql); 
	  
	   $contacaixa = $this->fetch_array($resultado);
	   
	   return $contacaixa[0];	  
	  }
	  
	 public function rethistorico($id_conta, $ncheque)
	  {
	   $sql = "SELECT historico FROM cheques WHERE id_conta_corrente = $id_conta AND numero_doc = '$ncheque'";
	   $resultado = $this->query($sql); 
	  
	   $historico = $this->fetch_array($resultado);
	   
	   return $historico[0];	  
	  }	  
	 
	
 }
 
 ?>
<?php
class Banco{
	
	public $localhost = "localhost";
	public $usuario   = "root";
	public $senha     = "admin";
	public $banco     = "segura";
	
	public function conexao()
	{
		mysql_connect($this->localhost , $this->usuario , $this->senha);
		mysql_select_db($this->banco);	
	}	
	
	public function query($sql)
	{
		$result = mysql_query($sql) or die(mysql_error());
		return $result;	
	}
	
	public function afect_rows($result)
	{
		$rows = mysql_num_rows($result);
		return $rows;		
	}
	
	public function fetch_array($result)
	 { 
	   $linha = mysql_fetch_array($result);
	   return $linha;
	 }
	
	
	public function dataEUA($data)
	{
		$tmp = explode('/', $data);
		$novaData = $tmp[2]."-".$tmp[1]."-".$tmp[0];
		return $novaData;
	}
	
	public function dataBR($data)
	{
		$tmp = explode('-', $data);
		$novaData = $tmp[2]."/".$tmp[1]."/".$tmp[0];
		return $novaData;
	}
	
	public function dataDDMMAAAA($data)
	 {
	  $dia = $data / 1000000;
	  $dia = (int) $dia;
	  $mes = ($data / 10000) % 100;
	  $ano = $data % 10000;
	  
      $novaData = $ano."/".$mes."/".$dia;
	  return $novaData;	  
	 }	
	 
	public function datammddaaaa($data)
	 {
	  $data = explode('/', $data);
	  $dia = $data[1];
	  $mes = $data[0];
	  $ano = $data[2];
	  
      $novaData = $ano."/".$mes."/".$dia;
	  return $novaData;	  
	 }	
	 
	public function dtddmmaaaa($data)
	 {
	  $data = explode('/', $data);
	  $dia = $data[0];
	  $mes = $data[1];
	  $ano = $data[2];
	  
      $novaData = $ano."/".$mes."/".$dia;
	  return $novaData;	  
	 }
	 
	public function dataSantander($data)
	 {
	  $data = explode('/', $data);
	  $dia = $data[1];
	  $mes = $data[0];
	  $ano = $data[2];
	  
      $novaData = $ano."-".$mes."-".$dia;
	  return $novaData;	  
	 }	 

	public function dataSantanderCob($data)
	 {
	  $data = explode('/', $data);
	  $dia = $data[0];
	  $mes = $data[1];
	  $ano = '20' . $data[2];
	  
      $novaData = $ano."-".$mes."-".$dia;
	  return $novaData;	  
	 }	 
	 

	
	
}


?>
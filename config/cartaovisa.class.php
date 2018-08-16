<?php
require_once("extrato.class.php");

class CartaoVisa extends Extrato 
 {
  public function filetipo($id_conta, $obs_conta)
	{
	 if ($this->filexiste($obs_conta) == -1)
	  return;
	 else
	  $arquivo = $this->filexiste($obs_conta);

     $id_conta_corrente = $id_conta;
	  
	 // LE O ARQUIVO E COLOCA AS LINHAS EM $qlinhas
     $qlinhas = file($arquivo);

 	 $datahoje = date("d/m/y");	
		   
	$valorTotal = 0;
		   
    foreach($qlinhas as $i => $linha)
	  {
		if($i == 28)
		{
			$venc = explode(':', $linha);
			$venc = explode(':', $venc[1]);
			$venc = trim($venc[0]);
			$venc = explode('.', $venc);
			
			$dtvenc = $venc[2].'-'.$venc[1].'-'.$venc[0];
		}
		else if($i > 47)
		{
			$valido = explode(' ', $linha);
			$valido = explode('/', $valido[0]);
			if(count($valido) == 1) continue;
			
			$data = $dtvenc;
			$doc = ' ';
			$historico = substr($linha, 9); $historico = substr($historico, 0, 23);
			$obs = $historico;
			$valor = substr($linha, 57); 
			$valor = substr($valor, 0, 11); 
			$valor = str_replace('.', '', $valor); 
			$valor = str_replace(',', '.', $valor); 
			$valor = trim($valor); 
			$valorTotal += $valor;
			$valor = $valor * -1;
			
			$this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, 0, $obs);
		}
	}
	 
	$valor = $valorTotal;
	$historico = 'PGTO DEBITO CONTA';
	$obs = 'PGTO DEBITO CONTA';
	 
	$this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, 0, $obs);

	 // REMOVE O ARQUIVO
	 unlink($arquivo);
	 echo "$obs_conta LANÇADO COM SUCESSO...";echo "<BR>";
	}
 }
?>
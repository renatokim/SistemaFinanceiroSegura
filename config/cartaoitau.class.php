<?php
require_once("extrato.class.php");

class CartaoItau extends Extrato 
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

	$i = 0;
	 
    foreach($qlinhas as $linha)
	 {
   	  $venc = explode(' ', $linha);

	  // SE $i == 1, DATA RECEBE VENCIMENTO DO CARTAO
	  if($i == 1) 
	   {
	    $data = substr($venc[0], 0, -2);
	    $data = $this->dtddmmaaaa($data);
	    $i = 0; print_r($data);
	   }
	  
      // SE LINHA == VENCIMENTO, $i RECEBE 1 E PROXIMA LINHA É DATA DO CARTAO	  
	  if (substr($venc[0], 0, -2) == 'vencimento')
	   {
		$i = 1;
		continue;
	   }



       // SUBSTITUI " . " POR "  " E "," POR ". "
	   $linha = str_replace('.', '', $linha);
	   $linha = str_replace(',', '.', $linha);
	   $linhavalida = explode(' ', $linha);
       
	   
	   if (count(explode('/', $linhavalida[0])) == 2) 
	    {
		 $historico = substr($linha, 6); $historico = substr($historico, 0, -9);
		 $doc = ' ';
		 $obs = $historico;
		 $valor = $linhavalida[count($linhavalida)-2];
		 $valor = $valor * -1;
		 //$data = str_replace('				', '', $data);

		 $this->insereext($id_conta_corrente, $data, $historico, $doc, $valor, 0, $obs);
	    }  
	  }
	 // REMOVE O ARQUIVO
	 unlink($arquivo);
	 echo "$obs_conta LANÇADO COM SUCESSO...";echo "<BR>";
	}
 }
?>
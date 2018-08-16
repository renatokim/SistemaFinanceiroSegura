<?php
require_once("extrato.class.php");

class Grafico extends Extrato
 {
	public $dataini;
	public $datafin;
	public $cntcxini1;
	public $cntcxini2;	
	public $cntcxfin1;
	public $cntcxfin2;	
	public $valor;
	
	public function despesas($dataini, $datafin, $cntcxini1, $cntcxfin1, $cntcxini2, $cntcxfin2)
	 {
	 
  	  $sql = "SELECT sum(valor) as soma FROM `extratos` 
	            WHERE ((conta_caixa>=$cntcxini1 
			      AND conta_caixa<=$cntcxfin1) 
				  OR (conta_caixa>=$cntcxini2 
				  AND conta_caixa<=$cntcxfin2)) 
			    AND data_emissao>='$dataini'
				AND data_emissao<='$datafin'";
				
      $resultado = $this->query($sql);
	  
	  return $resultado;
	 }
	 
	public function totalentrada($dataini, $datafin, 
	                             $cntcxini1, $cntcxfin1, 
								 $cntcxini2, $cntcxfin2, 
								 $cntcxini3, $cntcxfin3,
								 $cntcxini4, $cntcxfin4,
								 $cntcxini5, $cntcxfin5,
								 $cntcxini6, $cntcxfin6)
	 {
	  $sql = "SELECT sum(valor) as soma FROM `extratos` 
	            WHERE ((conta_caixa>=$cntcxini1 
			      AND conta_caixa<=$cntcxfin1) 
				  OR (conta_caixa>=$cntcxini2 
				  AND conta_caixa<=$cntcxfin2)
				  OR (conta_caixa>=$cntcxini3 
				  AND conta_caixa<=$cntcxfin3)
				  OR (conta_caixa>=$cntcxini4 
				  AND conta_caixa<=$cntcxfin4)
				  OR (conta_caixa>=$cntcxini5 
				  AND conta_caixa<=$cntcxfin5)
				  OR (conta_caixa>=$cntcxini6 
				  AND conta_caixa<=$cntcxfin6)) 
			    AND data_emissao>='$dataini'
				AND data_emissao<='$datafin'";
				
      $resultado = $this->query($sql);
	  
	  return $resultado;
	 }
	 
	 

################### ARRAY GRAFICO TEMPORARIO ##############################################

	public function add_temp_graf_ordem($id, $descricao, $valor)
		{
			$sql = "INSERT INTO   temp_graf_ordem VALUES ('', $id, '$descricao', $valor)";
	    	$resultado = $this->query($sql);
		}

	public function delete_temp_graf_ordem() 
	  {
		  $sql = "DELETE FROM temp_graf_ordem";
		  $this->query($sql);
	  }


	public function get_temp_graf_ordem()
	{
		$sql = "SELECT * FROM temp_graf_ordem ORDER BY id_grupo";	
		$resultado = $this->query($sql);
	 	$nlinhas = $this->afect_rows($resultado);

		for($i = 0; $i < $nlinhas; $i++){
			$date[] = $this->fetch_array($resultado);
		}

	    return $date;
	}







	 
 }
?>
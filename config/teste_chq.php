<?php
require_once("relatorios.class.php");

$relatorio = new Relatorio;
$relatorio->conexao();

$nchq = 854211;

$obs = 'teste';

			 $n_chq = $relatorio->get_n_chq($nchq);
			 if($n_chq == 1) {$obs = $relatorio->get_obs_chq($nchq);}

			 echo '  aaaaaaaaaa    ';
print_r($n_chq);
print_r($obs);
			 

?>

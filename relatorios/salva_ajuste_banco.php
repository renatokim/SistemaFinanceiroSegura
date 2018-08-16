<html>

<?php
session_start();

//echo '<pre>'; print_r($_SESSION['save_ajuste']); die();
$save_ajuste = $_SESSION['save_ajuste'];

echo "<title>EVENTUAL</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$data_salva_ajuste = $_SESSION['data_salva_ajuste'];

$exp_mes_ano = explode('-', $data_salva_ajuste);

$mes_ano = $exp_mes_ano[1].'-'.$exp_mes_ano[0];

$mes_ano = $exp_mes_ano[0].'-'.$exp_mes_ano[1].'-01';

$relatorio->delete_ajustes_banco($mes_ano);

foreach ($save_ajuste as $key => $value) {

  $relatorio->salva_ajustes_banco($mes_ano, $value['cx_temp'], $value['valor_temp']);

}

echo "EVENTUAL LANCADO!!!";

/*
$ajust = $relatorio->get_ajustes_banco($mes_ano);

?>
<TABLE>
  <TR bgcolor='LightSteelBlue'>
  	<TD>DATA</TD>
    <TD>CONTA-CAIXA</TD>
    <TD>DESCRICAO</TD>
    <TD>VALOR</TD>
  </TR>
  <TR>
<?php

foreach ($ajust as $key => $value) {
	echo "<TR bgcolor=Gainsboro>
			<TD ALIGN=CENTER>"; echo $value['mes_ano']; echo "</TD>
			<TD ALIGN=CENTER>"; echo $value['conta_caixa']; echo "</TD>
    		<TD>"; echo $value['descricao']; echo "</TD>
    		<TD ALIGN=RIGHT>"; echo $value['valor']; echo "</TD>
		  </TR>";
}

echo "</TABLE>";

*/

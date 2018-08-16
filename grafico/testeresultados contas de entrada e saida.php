
<?php
require_once("../config/grafico.class.php");

$graficos = new Grafico;
$graficos->conexao();

$dataini = '01-10-2012';
$datafin = '31-10-2012';

// TOTAL ENTRADA
$resultado = $graficos->totalentrada($dataini, $datafin, 1111000, 1111999, 1121000, 1121999, 1112000, 1112999, 1122000, 1122999, 1113000, 1123999, 1123000, 1123999 );


$valorentrada = $graficos->fetch_array($resultado);
echo $valorentrada[0];

?>
<?php
session_start();

echo "<title>EVENTUAL</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

$POST = $_POST;

for ($i=0; $i < $POST['nlinhas']; $i++) { 

  $array[] = array($POST['cx_temp'][$i], $POST['descricao_temp'][$i], $POST['valor_temp'][$i], $POST['valor'][$i]);
}

?> 
<TABLE>
  <TR bgcolor='LightSteelBlue'>
    <TD>CONTA-CAIXA</TD>
    <TD>DESCRICAO</TD>
    <TD>VALOR MENSAL</TD>
  </TR>
<?php

$cont = 0;

foreach ($array as $key => $value) {


  if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';


  echo "<TR bgcolor=$cor>
          <TD ALIGN=CENTER>"; echo $value[0]; echo "</TD>
          <TD>"; echo $value[1]; echo "</TD>
          <TD ALIGN=RIGHT>"; echo $value[2]-$value[3]; echo "</TD>
        </TR>";
$cont++;

$valores = array($value[0],$value[1],$value[2]-$value[3]);

$ajuste_salvo[] = $valores;

}

echo "</TABLE>";

$_SESSION['ajuste_salvo'] = $ajuste_salvo;

/*
echo '<pre>';
print_r($_SESSION['ajuste_salvo']);
echo $_SESSION['data_salva_ajuste'];
*/
?>
<input name="" type="button" onClick="window.open('salva_ajuste_banco.php')" value="CONCLUIR">



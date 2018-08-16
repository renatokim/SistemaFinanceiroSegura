<?php

echo "<title>AJUSTES LANCADOS</title>";

  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";
 
echo "SELECIONE A DATA:
<form action=editar_ajustes.php method='post'>
  <TABLE>
   <TR>
    <TD>DATA</TD><TD><input type=month name='data' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
  </TABLE>
</form>
";
 
?>





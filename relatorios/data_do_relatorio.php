<?php


$tipo_relatorio = $_GET['tipo_relatorio'];

echo "<title>CONFERENCIA BANCO</title>";

  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";
 
echo "SELECIONE O PER&Iacute;ODO:
<form action=relatorio_sessao.php method='post'>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini_relat_bco' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin_relat_bco' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
   </TR>
   <tr><td><input type=hidden name='tipo_relatorio' value='"; echo "$tipo_relatorio"; echo "'></td></tr>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
  </TABLE>
</form>
";
 
?>





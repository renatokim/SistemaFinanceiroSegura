<?php

echo "<title>GRAFICOS</title>";

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";

echo "
 ESCOLHA O PERIODO
  <FORM METHOD=POST ACTION='../view/jpgraph/DESPESAS.php'>
   <TABLE>
	<TR>
	 <TD>DATA INICIAL:</TD><TD><INPUT TYPE='date' SIZE=20 NAME='dataini' value='"; echo "$data"; echo "' required></TD>
	</TR>
	<TR>
	<TR>
	 <TD>DATA FINAL:</TD><TD><INPUT TYPE='date' SIZE=20 NAME='datafin' value='"; echo "$datahoje"; echo "' required></TD>
	</TR>
	<TR>
	 <TD></TD><TD><INPUT TYPE='submit' value='GERAR GRAFICO'/></TD>
	</TR>
   </TABLE>
  </FORM>
  ";
  
  





?>
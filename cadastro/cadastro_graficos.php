<?php

echo "<title>CADASTRO DE GRAFICOS</title>";

require_once("../config/relatorios.class.php");

$cadastro = new Relatorio;
$cadastro->conexao();

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";


echo "
  CADASTRO DE GRAFICOS

  <FORM METHOD=post ACTION='cad_grafico_banco.php'>
   <TABLE>
   <TR>
    <TD>NOME GRAFICO:</TD>
	<TD><INPUT TYPE='text' SIZE=20 NAME='nomeconta' required></TD>
   </TR>

 
    <TD></TD>
	<TD><INPUT TYPE='submit' value='CADASTRAR'/></TD>
   </TR>
   </TABLE>
  </FORM>
";
  
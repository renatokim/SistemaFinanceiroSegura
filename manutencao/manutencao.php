<?php

echo "<title>MANUTENCAO</title>";
require_once("../config/caixa.class.php");

//echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

echo "
 MANUTENCAO
  <FORM METHOD=post ACTION='manutencao.php'>
   <TABLE>
   	<TR>
	 <TD ALIGN=CENTER>LOGIN:</TD><TD><INPUT TYPE='text' SIZE=20 NAME='login' required></TD>
	</TR>
	<TR>
	 <TD ALIGN=CENTER>SENHA:</TD><TD><INPUT TYPE='password' SIZE=20 NAME='senha' required></TD>
	</TR>
	<TR>
	 <TD><INPUT TYPE='reset' value='LIMPAR'/></TD><TD><INPUT TYPE='submit' value='OK'/></TD>
	</TR>
   </TABLE>
  </FORM>
  ";

    if(isset($_POST["login"]))
     {
      $login = $_POST["login"];
	  if (isset($_POST["senha"]))
	   {
	    $senha = $_POST["senha"];
		
		if ($login == 'root' && $senha == 'root')
		 echo "<a href='../cakephp/extratos'>MANUTENCAO</a></li>";
		else 
		 echo "LOGIN INVALIDO";
	   }
	 }
		 
?>

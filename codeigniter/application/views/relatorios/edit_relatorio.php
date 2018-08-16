<html><?php //print_r($relatorio); ?>
<BODY BGCOLOR = 'Lavender' </BODY>
<title>EDITAR RELATORIO</title>
	<form action=relatorios/cadastrar method=post>
		<table>
			<tr>
				<td>CADASTRO RELATORIO</td>
			</tr>			
			<tr>
				<td><input type=text name="relatorio" value=<?php echo $relatorio[0]['relatorio']; ?>></td>
			</tr>
			<tr>
				<td><input type=submit value=Cadastrar></td>
			</tr>			
		</table>

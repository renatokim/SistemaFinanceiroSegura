<html><?php //print_r($relatorio); ?>
<BODY BGCOLOR = 'Lavender' </BODY>
<title>EDITAR RELATORIO</title>
	<form action=/codeigniter/relatorios/editar method=post>
		<table>
			<tr>
				<td>CADASTRO RELATORIO</td>
			</tr>			
			<tr>
				<?php $id = $relatorio[0]['id']; ?>
				<?php $relat = $relatorio[0]['relatorio']; ?>
				<?php $relatorio = str_replace(' ', '_', $relat); ?>
				<input type=hidden name="id" value=<?php echo $id; ?>>
				<td><input type=text name="relatorio" value=<?php echo $relatorio; ?>></td>
			</tr>
			<tr>
				<td><input type=submit value=Alterar></td>
			</tr>			
		</table>

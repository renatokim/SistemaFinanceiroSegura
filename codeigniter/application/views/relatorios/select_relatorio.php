
<table BORDER="0" CELLSPACING="1">
	<tr  bgcolor="LightSteelBlue">
		<td>EXCLUIR</td><td>EDITAR</td><td>NOME</td>
	</tr>
<?php foreach ($relatorios as $key => $relatorio) { ?>

	<tr bgcolor="#ddd">
		<td ALIGN=CENTER><a href=relatorios/excluir/<?php echo  $relatorio['id']; ?>><img src=/codeigniter/assets/imgs/del.png></td>
		<td ALIGN=CENTER><a href=relatorios/form_editar/<?php echo $relatorio['id']; ?>><img src='/codeigniter/assets/imgs/edit.png'></td>
		<td><?php echo $relatorio['relatorio']; ?></td>
	</tr>

<?php } ?>	

</table>

</html>
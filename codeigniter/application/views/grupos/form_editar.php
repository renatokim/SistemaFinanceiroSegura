<?php //cho '<pre>'; print_r($grupos);  //die();?>
<table BORDER="0" CELLSPACING="1">
	<tr  bgcolor="LightSteelBlue">
		<td>EXCLUIR</td><td>EDITAR</td><td>RELATORIO</td><td>GRUPO</td>
	</tr>
<?php foreach ($grupos as $key => $grupo) { ?>

	<tr bgcolor="#ddd">
		<input type=hidden name=cad_rel value=<?php echo $grupo['cad_relatorio_id']?>>
		<td ALIGN=CENTER><a href=/codeigniter/grupos/excluir/<?php echo  $grupo['id_grupo']; ?>><img src=/codeigniter/assets/imgs/del.png></td>
		<td ALIGN=CENTER><a href=/codeigniter/grupos/editar/<?php echo  $grupo['id_grupo']; ?>><img src='/codeigniter/assets/imgs/edit.png'></td>
		<td><?php echo $grupo['relatorio']; ?></td>
		<td><?php echo $grupo['nome_grupo']; ?></td>
	</tr>

<?php } ?>	

</table>

</html>
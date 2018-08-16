<head>
	<meta charset="utf-8">
	<title>Cobranca</title>
</head>
<body>


<?php echo form_open('cobrancas/create'); ?>
	  
<table><tr>

		<td>
			<?php echo form_label('Data Credito'); ?><br>
			<input name=data_entrada type=date required>
		</td>
		<td>		
		
			<?php echo form_label('N&#186; Doc'); ?><br>
			<INPUT TYPE='text' SIZE=10 NAME='numero_doc' required>
		</td>				
		<td>
			<?php echo form_label('Cliente'); ?><br>
			<INPUT TYPE='text' SIZE=20 NAME='historico' required>
				</td>
		<td>
		<td>
		
			<?php echo form_label('Valor Credito'); ?><br>
			<INPUT TYPE='numeric' SIZE=10 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'>
				</td>			
		<td>
		
			<center><?php echo form_label('ContaCaixa'); ?><br>
			0</center>
					</td>
		<td width="25%">
		
			<center><?php echo form_label('Descricao'); ?><br>
			SEM CONTACAIXA</center>
					</td>					

		<td>
	
	<input name=id_conta_corrente value=17 type=hidden>
	<input name=conta_caixa value=0 type=hidden>
	<input name=data_inicial value=<?php echo $data_inicial ?> type=hidden>
	<input name=data_final value=<?php echo $data_final ?> type=hidden>
		
			<input type=submit value=INCLUIR>
		</td>
		</table>
	
<?php


?>


</body>
</html>
<head>
	<meta charset="utf-8">
	<title>Cobranca</title>
</head>
<body>


<?php echo form_open('cobrancas/update'); ?>
	  
<table><tr>

		<td>
			<?php echo form_label('Data Credito'); ?><br>
			<input name=data_emissao type=date value=<?php echo $cob[0]['data_emissao'] ?> required>
		</td>
		<td>		
		
			<?php echo form_label('N&#186; Doc'); ?><br>
			<INPUT TYPE='text' SIZE=10 NAME='numero_doc' value=<?php echo $cob[0]['numero_doc'] ?> required>
		</td>				
		<td>
			<?php echo form_label('Cliente'); ?><br>
			<INPUT TYPE='text' SIZE=20 value=<?php echo $cob[0]['historico'] ?> NAME='historico' required>
				</td>
		<td>
		<td>
		
			<?php echo form_label('Valor Credito'); ?><br>
			<INPUT TYPE='numeric' value=<?php echo $cob[0]['valor'] ?> SIZE=10 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'>
				</td>			
		<td>
		
			<center><?php echo form_label('ContaCaixa'); ?><br>
			<?php echo $cob[0]['conta_caixa'] ?></center>
					</td>
		<td width="25%">
		
			<center><?php echo form_label('Descricao'); ?><br>
			<?php echo $cob[0]['descricao'] ?></center>
					</td>					
		<td>
		
	<input name=conta_caixa value=<?php echo $cob[0]['conta_caixa'] ?> type=hidden>
	<input name=id_conta_corrente value=17 type=hidden>
	<input name=data_inicial value=<?php echo $data_inicial ?> type=hidden>
	<input name=data_final value=<?php echo $data_final ?> type=hidden>
    <input name=id value=<?php echo $cob[0]['id'] ?> type=hidden>
    		
			<input type=submit value=ALTERAR>
		</td></tr>
		</table>
	
<?php


?>


</body>
</html>
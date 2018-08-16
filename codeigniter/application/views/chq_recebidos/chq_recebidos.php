<head>
	<meta charset="utf-8">
	<title>Cheques Recebidos</title>
</head>
<body>


<?php echo form_open('chq_recebidos/create'); ?>
	  
<table><tr>

		<td>
			<?php echo form_label('Data Entrada'); ?><br>
			<input name=data_entrada type=date required>
		</td>
		<td>
		
			<?php echo form_label('Data B/Para'); ?><br>
			<input name=data_bom_p type=date required>
		</td>
		<td>		
		
			<?php echo form_label('N&#186; Doc'); ?><br>
			<INPUT TYPE='text' SIZE=10 NAME='numero_doc' required pattern='[j|J|l|L|u|U|n|N][0-9]*'>
		</td>				
		<td>
			<?php echo form_label('Cliente'); ?><br>
			<INPUT TYPE='text' SIZE=20 NAME='historico' required>
				</td>
		<td>
		<td>
			<?php echo form_label('Identificacao'); ?><br>
			<INPUT TYPE='text' SIZE=20 NAME='obs'>
				</td>		
		<td>
			<?php echo form_label('Destinacao'); ?><br>
			<select name=destinacao required>
				<option value=""></option>
				<option value="1-DEPOSITO">1-DEPOSITO</option>
				<option value=" 2-CUSTODIA"> 2-CUSTODIA</option>
				<option value=" 3-PGTO 3&#176;S"> 3-PGTO 3&#176;S</option>
			</select>
		</td>
		<td>
		
			<?php echo form_label('Valor'); ?><br>
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
		
			<?php echo form_label('Data Pagamento'); ?><br>
			<input name=data_emissao type=date>
				</td>
		<td>
	
	<input name=id_conta_corrente value=18 type=hidden>
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
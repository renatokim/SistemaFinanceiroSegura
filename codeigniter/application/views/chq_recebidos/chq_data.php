<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Cheques Recebidos</title>
</head>
<body>



<?php echo form_open('chq_recebidos/read'); 
	  echo form_fieldset("Relatorios Cheques Recebidos"); ?>
	  
<table>
	<tr>
		<td>
			<?php echo form_label('Data Inicial'); ?><br>
			<input value=<?php echo date('Y-m'); echo '-01'; ?> name=data_inicial type=date required>
		</td>
		<td>
		</td>	
		<td>
		</td>
		<td>
		</td>	
		<td>
		</td>		
		<td>
			<?php echo form_label('Data Final'); ?><br>
			<input value=<?php echo date('Y-m-d'); ?> name=data_final type=date required>
		</td>
	</tr>
	<tr>
		<td>
			<input type=submit value=BUSCAR>
		</td>
	</tr>
<?php


?>


</body>
</html>
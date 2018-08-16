<html><?php //echo '<pre>'; print_r($contacaixas);  die();?>
<BODY BGCOLOR = 'Lavender' </BODY>
<title>CADASTRO GRUPOS</title>
CADASTRO DE GRUPOS DE RELATORIOS
	<form action=grupos/cadastrar method=post>
		<table  BORDER="0" CELLSPACING="1">
			<tr   bgcolor="LightSteelBlue"><td>RELATORIO</td><td>GRUPO</td></tr>
			<tr>
				<td>
					<SELECT name='cad_relatorio_id'>";   
						<?php foreach ($relatorios as $key => $relatorio)  { ?>
			        		<option value=<?php print_r($relatorio['id']); ?>><?php print_r($relatorio['relatorio']); ?></option>
					     <?php } ?>
   					</SELECT>
				</td>
				<td><input type=text name="nome_grupo"></td>
			</tr>
			<tr>
				<td><input type=submit value=Cadastrar></td>
			</tr>			
		</table>
<?php $cor = 'Gainsboro'; ?>
		<TABLE BORDER=0 CELLSPACING=1 ALIGN=LEFT>
			<TR bgcolor='LightSteelBlue'>
				<TD></TD>
				<TD ALIGN=CENTER>CONTA CAIXA</TD>
				<TD ALIGN=CENTER>DESCRICAO</TD>
			</TR>
			<?php foreach ($contacaixas as $key => $contacaixa) { 
				 if($cor=='Gainsboro') $cor = 'white'; else $cor = 'Gainsboro'; ?>
			<TR  bgcolor=<?php echo $cor ?>>
        		<TD><input type=checkbox name=conta_caixa[<?php echo $key; ?>]; echo  value=<?php echo $contacaixa['num_conta_caixa']; ?>></TD>
        		<TD ALIGN=CENTER><?php echo $contacaixa['num_conta_caixa']; ?></TD>
        		<TD ALIGN=CENTER><?php echo $contacaixa['descricao']; ?></TD>
    		</TR>
    		<?php } ?>

    	</form>

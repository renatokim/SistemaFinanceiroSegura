<html><?php //echo '<pre>'; print_r($grupo);  die();?>
<BODY BGCOLOR = 'Lavender' </BODY>
<title>EDITAR GRUPOS</title>
EDITAR GRUPOS DE RELATORIOS
	<form action=/codeigniter/grupos/set_grupos method=post>
		<table  BORDER="0" CELLSPACING="1">
			<tr bgcolor="LightSteelBlue">
				<td>GRUPO</td><?php $grupo_nome = str_replace(' ', '_', $grupo[0]['nome_grupo']); ?>
				<input type=hidden name=id value=<?php echo $grupo[0]['id']; ?>>
				<input type=hidden name=id_relatorio value=<?php echo $grupo[0]['cad_relatorio_id']; ?>>
				<td><input type="text" name="nome_grupo" value=<?php echo $grupo_nome; ?>></td>
				<td><input type="submit" name="botao" value=Alterar></td>
			</tr>
		</table>



<?php $cor = 'Gainsboro'; ?>
		<TABLE BORDER=0 CELLSPACING=1 ALIGN=LEFT>
			<TR bgcolor='LightSteelBlue'>
				<TD></TD>
				<TD ALIGN=CENTER>CONTA CAIXA</TD>
				<TD ALIGN=CENTER>DESCRICAO</TD>
			</TR>
			<?php foreach ($conta_caixa as $key => $contacaixa) { 
				 if($cor=='Gainsboro') $cor = 'white'; else $cor = 'Gainsboro'; ?>
			<TR  bgcolor=<?php echo $cor ?>>
        		<TD>
        			<input type=checkbox 
        				<?php 
        					foreach ($ctcx as $i => $ct_cx) 
        					{

        						if($contacaixa['num_conta_caixa'] == $ct_cx['conta_caixa']) { ?> checked <?php }  

        					}
        				?>
        				name=conta_caixa[<?php echo $key; ?>]
        				value=<?php echo $contacaixa['num_conta_caixa']; ?>>
        			</TD>

        		<TD ALIGN=CENTER><?php echo $contacaixa['num_conta_caixa']; ?></TD>
        		<TD ALIGN=CENTER><?php echo $contacaixa['descricao']; ?></TD>
    		</TR>
    		<?php } ?>

    	</form>


		<!-- <table  BORDER="0" CELLSPACING="1">
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
		</table> -->
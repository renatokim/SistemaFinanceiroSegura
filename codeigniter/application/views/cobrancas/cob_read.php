<script>
function confirma_exclusao()
{
return confirm("Excluir?");
}
</script>

<?php //echo '<pre>'; print_r($cobrancas); die(); ?> 

<div id="content">
<?php 



?>

<br>

<TABLE BORDER=0 CELLSPACING=1 width=100%>

  <TR bgcolor='LightSteelBlue'><th class=td_center colspan=2>ACAO</th><th class=td_center>DATA CREDITO</th><th class=td_center>NUM DOC</th><th class=td_center>CLIENTE</th><th class=td_center>VALOR</th><th class=td_center>CONTA-CAIXA</th><th class=td_center>DESCRICAO</th></tr>
<?php
foreach($cobrancas as $key => $cobranca)
	{ ?> <tr <?php if ($key % 2 != 0) echo 'bgcolor=Gainsboro' ?> > <?php
	  ?> 
		<td> <center><a onclick="return confirma_exclusao()" href=/codeigniter/index.php/cobrancas/delete/<?php echo $cobranca['id'] ?>/<?php echo $data_inicial ?>/<?php echo $data_final ?> ><img src="<?php echo base_url().'/assets/imgs/xis.gif' ?>"></a></center></td> 
        <td> <center><a href=/codeigniter/index.php/cobrancas/editar/<?php echo $cobranca['id'] ?>/<?php echo $data_inicial ?>/<?php echo $data_final ?> ><img src="<?php echo base_url().'/assets/imgs/dot3.gif' ?>"></a></center></td>	  
	    <td><center> <?php echo $cobranca['data_emissao'] ?> </center></td> 
		<td> <?php echo $cobranca['numero_doc'] ?> </td> 
		<td><?php echo $cobranca['historico'] ?> </td> 
		<td><center> <?php echo $cobranca['valor'] ?> </center></td> 
		<td><center> <?php echo $cobranca['conta_caixa'] ?> </center></td> 
	    <td> <?php echo $cobranca['descricao'] ?> </td> 
 	  <?php
	} ?> </tr> <?php
?> </table>








<script>
function confirma_exclusao()
{
return confirm("Excluir cheque?");
}
</script>

<?php //echo '<pre>'; print_r($cheques); die(); ?> 

<div id="content">
<?php 



?>

<br>

<TABLE BORDER=0 CELLSPACING=1 width=100%>

  <TR bgcolor='LightSteelBlue'><th class=td_center colspan=2>ACAO</th><th class=td_center>DATA ENTRADA</td><th class=td_center>DATA B/PARA</td><th class=td_center>NUM DOC</th><th class=td_center>CLIENTE</th><th class=td_center>IDENTIFICACAO</th><th class=td_center>DESTINACAO</th><th class=td_center>VALOR</th><th class=td_center>CONTA-CAIXA</th><th class=td_center>DESCRICAO</th><th class=td_center>DATA PGTO</th></tr>
<?php
foreach($cheques as $key => $listachq)
	{ ?> <tr <?php if ($key % 2 != 0) echo 'bgcolor=Gainsboro' ?> > <?php
	  ?> 
		<td> <center><a onclick="return confirma_exclusao()" href=/codeigniter/index.php/chq_recebidos/delete/<?php echo $listachq['id'] ?>/<?php echo $data_inicial ?>/<?php echo $data_final ?> ><img src="<?php echo base_url().'/assets/imgs/xis.gif' ?>"></a></center></td> 
        <td> <center><a href=/codeigniter/index.php/chq_recebidos/editar/<?php echo $listachq['id'] ?>/<?php echo $data_inicial ?>/<?php echo $data_final ?> ><img src="<?php echo base_url().'/assets/imgs/dot3.gif' ?>"></a></center></td>	  
	    <td><center> <?php echo $listachq['data_entrada'] ?> </center></td> 
		<td><center> <?php echo $listachq['data_bom_p'] ?> </center></td> 
		<td> <?php echo $listachq['numero_doc'] ?> </td> 
	    <td> <?php echo $listachq['historico'] ?> </td> 
		<td><?php echo $listachq['obs'] ?> </td> 
		<td> <?php echo utf8_encode(utf8_decode($listachq['destinacao'])) ?> </td>
		<td><center> <?php echo $listachq['valor'] ?> </center></td> 
		<td><center> <?php echo $listachq['conta_caixa'] ?> </center></td> 
	    <td> <?php echo $listachq['descricao'] ?> </td> 
		<td> <center><?php if($listachq['data_emissao'] == '0000-00-00') echo ''; else echo $listachq['data_emissao']; ?> </center></td> 
 	  <?php
	} ?> </tr> <?php
?> </table>








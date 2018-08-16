<?php
echo "<title>AJUSTES</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;

$relatorio->conexao();




echo "<form action='edit_grupo.php' method=post>";

/*
$resultado = $relatorio->get_cad_grupos();


echo "
 GRUPO

   <TABLE>
   <tr>
  <td>
  <SELECT name='id_grafico'>";   
    foreach ($resultado as $key => $value) 
      {

        echo "<option value=$value[0]>$value[1]</option>";

      }
    echo "
   </SELECT>

<td></td>

  
	
   </TR>
   
";
*/

?>
<TABLE BORDER="0" CELLSPACING="1">
  <TR bgcolor="LightSteelBlue">
   <TD>EXCLUIR</TD>
   <TD>EDITAR</TD>
   <!-- <TD>DETALHAR</TD> -->
  
   <TD>GRAFICO</TD>
   <TD>ORDEM</TD>
   <TD>GRUPO</TD>
  </TR>	
  <?php
  
 $cor = 'pink';
 $corfonte = 'BLUE';
 $cont=0;
    
    $resultado = $relatorio->getAllGrupos(); 	//echo '<pre>';  print_r($resultado); die();

	
	//echo '<pre>'; print_r($resultado); die();
	
if(isset($resultado))
 {
  foreach($resultado as $grupos)
	 {
		 $id_grafico = $grupos['id_cadastro_grafico'];
		 $nome_grafico = $grupos['nome_grafico'];
		 $seq_grupo = $grupos['seq_grupo'];
		 $nome_grupo = $grupos['nome_grupo'];
		 $id_grupo = $grupos[0];
?>

  <TR bgcolor="#ddd">
   <TD ALIGN=CENTER>
	<?php echo "<a href='excluir_grupo.php?acao=excluir&id="; echo $id_grupo; echo "'><img src='../view/ico_close.png'>"; ?>
   </TD>
   <TD ALIGN=CENTER><a href="/codeigniter/index.php/grupoGraficos/getGrupos/<?php echo $id_grupo ?>/<?php echo $seq_grupo ?>/<?php echo $id_grafico ?>" href=''><img src='../view/edit.png'>
   <!-- <TD ALIGN=CENTER><?php if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\"></a>";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/plus.png'>";} ?></TD> -->
   
   <TD bgcolor="#ccc"><?php echo $nome_grafico;?></TD>
   <TD ALIGN=RIGHT><?php echo $seq_grupo;?></TD>
   <TD><?php if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=text required NAME=NOME VALUE="; echo str_replace(' ', '_', $nome_grupo); echo ">"; } else { echo $nome_grupo; } ?></TD>
   
   <INPUT TYPE='HIDDEN' VALUE=<?php if(isset($_GET['id'])) echo $_GET['id'] ?> NAME='id'>
  </TR>	
<?php
}
?>
</TABLE>
<?php



}




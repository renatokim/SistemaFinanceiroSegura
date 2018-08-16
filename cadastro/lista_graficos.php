<?php
echo "<title>AJUSTES</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();

echo "<form action='edit_grafico.php' method=post>";

?>
<TABLE BORDER="0" CELLSPACING="1">
  <TR bgcolor="LightSteelBlue">
   <TD>EXCLUIR</TD>
   <TD>EDITAR</TD>
   <TD>GRAFICO</TD>
  </TR>	
  <?php
  
 $cor = 'pink';
 $corfonte = 'BLUE';
 $cont=0;
    
    $resultado = $relatorio->getAllGraficos(); 	//echo '<pre>';  print_r($resultado); die();

	
if(isset($resultado))
 {
  foreach($resultado as $graficos)
	 {
	 

	 $id = $graficos['id'];
	 $descricao = $graficos['nome_grafico'];
	 
?>

  <TR bgcolor="#ddd">
   <TD ALIGN=CENTER><?php echo "<a href='excluir_grafico.php?acao=excluir&id="; echo $id; echo "'><img src='../view/ico_close.png'>"; ?></TD>
   <TD ALIGN=CENTER><?php if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\"></a>";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/edit.png'>";} ?></TD>
   <TD><?php if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=text required NAME=NOME VALUE="; echo str_replace(' ', '_', $descricao); echo ">"; } else { echo $descricao; } ?></TD>
   <INPUT TYPE='HIDDEN' VALUE=<?php if(isset($_GET['id'])) echo $_GET['id'] ?> NAME='id'>
  </TR>	
<?php
}
?>
</TABLE>
<?php



}




<?php
/*

CREATE TABLE IF NOT EXISTS `ajustes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cx_retira` int(6) NOT NULL,
  `descricao_cx_ret` text NOT NULL,
  `cx_inclui` int(6) NOT NULL,
  `descricao_cx_inc` text NOT NULL,
  `vlr_or_pecent` char(1) NOT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `ativo` int(1) NOT NULL,
  PRIMARY KEY (`id`)
)

*/

// RELATORIO DO CAIXA

echo "<title>AJUSTES</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


  // CABECALHO DA TABELA
?><TABLE BORDER="0" CELLSPACING="1">
  <TR bgcolor="LightSteelBlue">
   <TD>EXCLUIR</TD>
   <TD>EDITAR</TD>
   <TD>CX RETIRA</TD>
   <TD>DESCRICAO</TD>
   <TD>TIPO (% OU $)</TD>   
   <TD>VALOR</TD>   
   <TD>CX INCLUI</TD>
   <TD>DESCRICAO</TD>
  </TR>	
 
<?php
  
 $cor = 'pink';
 $corfonte = 'BLUE';
 $cont=0;
    
    $resultado = $relatorio->ajustes();
    $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
	
    for ($i=0; $i<$nlinhas; $i++)
	 {
	  $linha[] = $relatorio->fetch_array($resultado);
	 }	 
	 
if(isset($linha))
 {
  foreach($linha as $ajuste)
	 {
	 
	 if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
    
	  $id = $ajuste['id'];
    $cx_retira = $ajuste['cx_retira'];
    $descricao_cx_ret = $ajuste['descricao_cx_ret'];
    $cx_inclui = $ajuste['cx_inclui'];
    $descricao_cx_inc = $ajuste['descricao_cx_inc'];
    $vlr_or_pecent = $ajuste['vlr_or_pecent']; 
    $valor = $ajuste['valor'];
 
echo "
  <TR bgcolor=$cor>
   <TD ALIGN=CENTER><a href='../cadastro/excluir_ajustes.php?id=$id'><img src='../view/ico_close.png'></a></TD>
   <TD ALIGN=CENTER><a href='../cadastro/alterar_ajustes.php?id=$id'><img src='../view/edit.png'></a></TD>
   <!-- <TD ALIGN=CENTER>"; echo $id; echo "</TD> -->
   <TD ALIGN=CENTER>"; echo $cx_retira; echo "</TD>
   <TD>"; echo $descricao_cx_ret; echo "</TD>
   <TD ALIGN=CENTER>"; echo $vlr_or_pecent; echo "</TD>
   <TD ALIGN=RIGHT>"; echo $valor; echo "</TD>   
   <TD ALIGN=CENTER>"; echo $cx_inclui; echo "</TD>
   <TD>"; echo $descricao_cx_inc; echo "</TD>

  </TR>";
	  
	  $cont++;
}
 }
echo "</TABLE>";

?>
<BR>
<form action="../cadastro/cadastro_ajustes/contacaixa_ajustes/contacaixa_ajustes.php">
<input type="submit" value="INCLUIR AJUSTE">
</form>







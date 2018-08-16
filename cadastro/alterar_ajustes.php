<?php



//  EXCLUI UM AJUSTE
require_once('../config/relatorios.class.php');
$relatorio = new Relatorio;
$relatorio->conexao();
 
$registro = $_GET['id'];

$sql = "SELECT * FROM `ajustes` WHERE id = " . $registro;

$resultado = $relatorio->query($sql);
$r = $relatorio->fetch_array($resultado);


?>

<form method="POST" action="alterar_ajustes_post.php">
<table width="100%" border=1>
<tr>
<td>
CX RETIRA
</td>
<td>
DESCRICAO
</td>
<td>
TIPO
</td>
<td>
VALOR
</td>
<td>
CX INCLUI
</td>
<td>
DESCRICAO
</td>
</tr>

<tr>
<td>
<?php echo $r['cx_retira'] ?>
<input type="hidden" name="id" value="<?php echo $r['id']?>" >
</td>
<td>
<?php echo $r['descricao_cx_ret'] ?>
</td>
<td>
<input type="text" name="vlr_or_pecent" value="<?php echo $r['vlr_or_pecent']?>" >
</td>
<td>
<input type="text" name="valor" value="<?php echo $r['valor']?>" >
</td>
<td>
<?php echo $r['cx_inclui'] ?>
</td>
<td>
<?php echo $r['descricao_cx_inc'] ?>
</td>
</tr>
</table>

<input type="submit" value="ALTERAR">
</form>



<?php
	//header("location:../relatorios/relat_cad_ajustes.php");
?>








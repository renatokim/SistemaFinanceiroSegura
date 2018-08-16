 <?php 

require_once('cheque_class.php');
require_once('../config/relatorios.class.php');
require_once('../config/cheque.class.php');

$cheque = new Cheque;

$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta!=6';

$cheque->conexao();
$resultado = $cheque->query($sql);
$ncontas = $cheque->afect_rows($resultado);

$datahoje = date("Y/m/d");
$datahoje = str_replace('/', '-', $datahoje);
$dia = date("d"); $mes = date("m"); $ano = date("Y");
$dia = $dia - $dia + 1;
$dia = "0"."$dia";
$data = "$ano"."-"."$mes"."-"."$dia";

$tipo_relatorio = $_GET['tipo_relatorio'];
?>

SELECIONE A CONTA:<BR>
  <FORM METHOD=post ACTION="cheque_post_sessao.php">
   <SELECT name='conta_corrente_chq'>";   
    <?php for ($i=0; $i<$ncontas; $i++)
   {
    $linha = $cheque->fetch_array($resultado);

    echo "<option>$linha[0]</option>";

     }
?> 

   </SELECT>
<BR>
<BR>
<BR> 
<INPUT TYPE=HIDDEN NAME=TIPORELATORIO VALUE='<?php echo $tipo_relatorio ?>'></INPUT> 
SELECIONE O PER&IacuteODO:<BR>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini_chq' value='<?php echo "$data" ?>' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin_chq' value='<?php echo "$datahoje" ?>' REQUIRED></TD>
   </TR>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
  </TABLE>
</FORM>
 
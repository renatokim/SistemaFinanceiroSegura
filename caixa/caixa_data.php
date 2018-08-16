 <?php 

require_once('caixa_class.php');
require_once('../config/relatorios.class.php');

$caixa = new Caixa_relatorio;
$dados = $caixa->retorna_dados_conta(6);

$datahoje = date("Y/m/d");
$datahoje = str_replace('/', '-', $datahoje);
$dia = date("d"); $mes = date("m"); $ano = date("Y");
$dia = $dia - $dia + 1;
$dia = "0"."$dia";
$data = "$ano"."-"."$mes"."-"."$dia";
?>

<FORM ACTION="caixa_post_sessao.php" METHOD="POST">
SELECIONE O CAIXA:<BR>
<SELECT NAME="conta_corrente">
  <?php foreach ($dados as $valor) {
    echo "<OPTION VALUE=\""; echo $valor['id']; echo "\">"; echo $valor['descricao']; echo "</OPTION>"; ?>
  <?php } ?>
</SELECT>
<BR>
<BR>
<BR>

SELECIONE O PER&IacuteODO:<BR>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini' value='<?php echo "$data" ?>' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin' value='<?php echo "$datahoje" ?>' REQUIRED></TD>
   </TR>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
  </TABLE>
</FORM>
  
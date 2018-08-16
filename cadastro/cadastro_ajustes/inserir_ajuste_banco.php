<?php
//  CADASTRA AJUSTE
require_once("../../config/relatorios.class.php");

$addajuste = new Relatorio;
$addajuste->conexao();

if(isset($_POST['botao']))
 {

// inserir no banco
  //echo '<pre>';
 // print_r($_POST); 
 
   $cx_retirada = $_POST['cx_retira'];
   $descricao_cx_ret = $_POST['desc_ret'];
   $cx_inclui = $_POST['cx_inserir'];
   $descricao_cx_inc =  $_POST['desc_ins']; 
   $vlr_or_prec =  $_POST['tipo'];
   $valor =  $_POST['valor'];
   $valor = str_replace(',', '.', $valor);

  $addajuste->insere_ajuste($cx_retirada, 
                            $descricao_cx_ret, 
                            $cx_inclui, 
                            $descricao_cx_inc, 
                            $vlr_or_prec, 
                            $valor);

  header("location:../../relatorios/relat_cad_ajustes.php");


 } 

if(isset($_GET['cx_inserir'])) $cx_inserir = $_GET['cx_inserir'];

if(isset($_GET['cx_retirada'])) $cx_retirada = $_GET['cx_retirada'];

$resul_ins = $addajuste->desc_ajuste($cx_inserir);
$resul_ret = $addajuste->desc_ajuste($cx_retirada);

$desc_ins = $addajuste->fetch_array($resul_ins);
$desc_ret = $addajuste->fetch_array($resul_ret);

//print_r($_GET);
?>
<FORM METHOD="POST" action="">
<TABLE BORDER="0" CELLSPACING="1">
  <TR bgcolor="LightSteelBlue" ALIGN=CENTER>
   <!-- <TD>EXCLUIR</TD> -->
   <!-- <TD>REGISTRO</TD> -->
   <TD>CX RETIRA</TD>
   <TD>DESCRICAO</TD>
   <TD>CX INCLUI</TD>
   <TD>DESCRICAO</TD>
   <TD>VALOR</TD>
   <TD>TIPO ( % OU $ )</TD>
  </TR>



  <TR bgcolor="GhostWhite" ALIGN=CENTER>
   <!-- <TD>EXCLUIR</TD> -->
   <!-- <TD>REGISTRO</TD> -->
   <TD ><?php echo $cx_retirada ?></TD>
   <TD><?php echo $desc_ret[0] ?></TD>
   <TD><?php echo $cx_inserir ?></TD>
   <TD><?php echo $desc_ins[0] ?></TD>
   <TD><INPUT TYPE='numeric' SIZE=8 NAME='valor' required pattern='-*[0-9]*[,|.]?[0-9]*'></TD>
   <TD><INPUT TYPE='text' SIZE=3 NAME='tipo' required pattern='[$|%]'></TD>
  </TR>
</TABLE>

<input type="hidden" name="cx_retira" value="<?php echo $cx_retirada ?>">
<input type="hidden" name="desc_ret" value="<?php echo $desc_ret[0] ?>">
<input type="hidden" name="cx_inserir" value="<?php echo $cx_inserir ?>">
<input type="hidden" name="desc_ins" value="<?php echo $desc_ins[0] ?>">
<input type="submit" name="botao" value="INCLUIR">
</FORM>



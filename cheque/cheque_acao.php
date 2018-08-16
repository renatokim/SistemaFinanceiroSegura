<?php 
session_start();
require_once('cheque_class.php');

$id = $_GET['id'];
$acao = $_GET['acao'];

$cheque = new Cheque_relatorio;


switch ($acao) {
  case 'excluir':
    $cheque->delete_cheque($id);
    break;
  case 'editar':
    header("location:cheque_relatorio.php?edit=edit");
    break;
  default:
    echo "teste";
    print_r($_POST);
    break;
  
}





header("location:cheque_relatorio_numero.php");
 

die();


$caixa = new Caixa_relatorio;

$lancamentos = $caixa->dados_caixa($_SESSION['conta_corrente'], 
                                   $_SESSION['dataini'], 
                                   $_SESSION['datafin']);
?>




<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
   <TD>EXCLUIR</TD>
   <TD>EDITAR</TD>
   <TD>CONTA</TD>
   <TD>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD>
   <TD>VALOR</TD>
   <TD>IDENTIFICA&Ccedil;&Atilde;O</TD>
   <TD>CONTACAIXA</TD>
   <TD>DESC CONTACAIXA</TD>
  </TR>
<?php

  $corfonte = 'BLUE';
  $cont=0;
  $soma = 0.00;
  $soma = number_format($soma, 2,'.','');
  $valor = 0.00;
  $set = 0;   
  $cor = 'white';

foreach ($lancamentos as $value) {
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';

	echo "
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER><a href='#'><img src='../view/ico_close.png'></TD>
     <TD ALIGN=CENTER><a href='#'><img src='../view/edit.png'></TD>
     <TD ALIGN=CENTER>"; echo $value['id_conta_corrente']; echo "</TD>
     <TD>"; echo $value['data_emissao']; echo "</TD>
     <TD>"; echo $value['historico']; echo "</TD>
     <TD>"; echo $value['numero_doc']; echo "</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR="; echo $value['valor']<0?'RED':'BLUE'; echo "><INPUT TYPE=TEXT VALUE="; echo $value['valor']; echo ">"; echo $value['valor']; echo "</INPUT></font></TD>
     <TD>"; echo $value['obs']; echo "</TD>
     <TD>"; echo $value['conta_caixa']; echo "</TD>
     <TD ALIGN=CENTER>"; echo $value['descricao']; echo "</TD>
    </TR>";

    $cont++;

}


?>
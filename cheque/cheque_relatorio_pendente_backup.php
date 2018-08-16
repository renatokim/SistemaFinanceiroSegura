<?php 
session_start();
require_once('cheque_class.php');

$cheque = new Cheque_relatorio;

$lancamentos = $cheque->dados_caixa($_SESSION['conta_corrente_chq'], 
                                   $_SESSION['dataini_chq'], 
                                   $_SESSION['datafin_chq']);
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
  <TD>DESCRICAO</TD>    
</TR> <?php 

  $corfonte = 'BLUE';
  $cont=0;
  $soma = 0.00;
  $soma = number_format($soma, 2,'.','');
  $valor = 0.00;
  $set = 0;   
  $cor = 'white';

if($lancamentos)
foreach ($lancamentos as $value) {
	if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';

	echo "
  <FORM ACTION='caixa_editar.php' METHOD='POST'>
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER><a href='caixa_acao.php?acao=excluir&id="; echo $value['id']; echo "'><img src='../view/ico_close.png'></TD>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar>";} else { echo "<a href='?edit=edit&id="; echo $value['id']; echo "'><img src='../view/edit.png'>";} echo "</TD>
     <TD ALIGN=CENTER>"; echo $value['id_conta_corrente']; echo "</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=DATE NAME=DATA_EMISSAO VALUE="; echo $value['data_emissao']; echo "></INPUT>";
            }
            else 
              echo $value['data_emissao'];
     echo "</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=HISTORICO VALUE="; echo $value['historico']; echo "></INPUT>";
            }
            else 
              echo $value['historico'];
     echo "</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=DOC VALUE="; echo $value['numero_doc']; echo "></INPUT>";
            }
            else 
              echo $value['numero_doc'];
     echo "</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR="; echo $value['valor']<0?'RED':'BLUE'; echo ">"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT ALIGN=RIGHT NAME=VALOR TYPE=TEXT VALUE="; echo $value['valor']; echo "></INPUT>";
            }
            else 
              echo $value['valor'];
     echo "</FONT></TD>

     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=OBS VALUE="; echo $value['obs']; echo "></INPUT>";
            }
            else 
              echo $value['obs'];
     echo "</TD>
     <TD ALIGN=CENTER>"; echo $value['conta_caixa']; echo "</TD>
     <TD ALIGN=LEFHT>"; echo $value['descricao']; echo "</TD>
    </TR>
    "; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=HIDDEN NAME=ID VALUE="; echo $value['id']; echo "></INPUT>";
            }";
echo <FORM>";


    $soma += $value['valor'];

    $cont++;
// <INPUT TYPE=TEXT VALUE="; echo $value['valor']; echo "> </INPUT>
} $soma = number_format($soma, 2,'.',''); ?>

<TR bgcolor='LightSteelBlue'>
  <TD></TD>
  <TD></TD>
  <TD></TD>    
  <TD></TD>
  <TD></TD>
  <TD ALIGN=RIGHT>TOTAL</TD>
  <TD ALIGN=RIGHT><FONT COLOR=<?php echo $soma<0?'RED':'BLUE'; echo ">"; echo $soma; ?></FONT></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
</TR>
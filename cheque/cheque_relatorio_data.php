<?php 
session_start();
require_once('cheque_class.php');

$cheque = new Cheque_relatorio;

$lancamentos = $cheque->todos_chq_data($_SESSION['conta_corrente_chq'], 
                                   $_SESSION['dataini_chq'], 
                                   $_SESSION['datafin_chq']);
?>

<?php //print_r($lancamentos); die();


  $corfonte = 'BLUE';
  $cont=0;
  $soma = 0.00;
  $soma = number_format($soma, 2,'.','');
  $valor = 0.00;
  $set = 0;   
  $cor = 'white';

echo "<head><link rel=\"stylesheet\" href=\"formulario.css\"></head>
<TABLE BORDER=0 CELLSPACING=1>   
  <TR bgcolor='LightSteelBlue' ALIGN=CENTER>
   <TD>BANCO</TD>
   <TD ALIGN=CENTER>N. CHEQUE</TD>
   <TD ALIGN=CENTER>DATA</TD>
   <TD ALIGN=CENTER>FAVORECIDO</TD>
   <TD ALIGN=CENTER>VALOR</TD>
   <TD ALIGN=CENTER>DATA LIQUIDA&Ccedil;&Atilde;O</TD>
   <TD>CONTA CAIXA</TD>
   <TD>DESCRI&Ccedil;&Atilde;O</TD>
  </TR>
";

//print_r($lancamentos);  
if($lancamentos)
foreach ($lancamentos as $value) {
  if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';

$desc = $cheque->ret_desc_cntcx($value['conta_caixa']); 

   echo   "<TR bgcolor=$cor>
   <TD ALIGN=CENTER>"; echo $value['id_conta_corrente']; echo "</TD>
   <TD ALIGN=CENTER>"; echo $value['numero_doc']; echo "</TD>
   <TD>"; echo $value['data_vencimento']; echo "</TD>
   <TD>"; echo $value['historico']; echo "</TD>
   <TD ALIGN=RIGHT><FONT COLOR="; echo $value['valor']<0?'BLUE':'RED'; echo ">"; echo str_replace('.', ',', $value['valor']); echo "</TD>
   <TD>"; echo $value['data_baixa']; echo "</TD>
   <TD ALIGN=CENTER>0</TD>
   <TD>SEM CONTACAIXA</TD>  
  </TR>

  ";














    $soma += $value['valor'];

    $cont++;

} $soma = number_format($soma, 2,'.',''); ?>

<TR bgcolor='LightSteelBlue'>
  <TD></TD>
  <TD></TD>
  <TD></TD>    
  <TD ALIGN=RIGHT>TOTAL</TD>
  <TD ALIGN=RIGHT><FONT COLOR=<?php echo $soma<0?'RED':'BLUE'; echo ">"; echo str_replace('.', ',', $soma); ?></FONT></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
</TR>
</TABLE>

























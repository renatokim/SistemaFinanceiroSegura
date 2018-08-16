<?php 
session_start();
require_once('cheque_class.php');

$cheque = new Cheque_relatorio;

$lancamentos = $cheque->todos_chq_num($_SESSION['conta_corrente_chq'], 
                                   $_SESSION['dataini_chq'], 
                                   $_SESSION['datafin_chq']);
?>

<?php //echo '<pre>'; print_r($lancamentos); die();
echo "<head><link rel=\"stylesheet\" href=\"formulario.css\"></head>
<FORM METHOD=post ACTION='cheque_incluir_pelo_relatorio.php'>
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

   <TD <td colspan=2>A&Ccedil;&Atilde;O</TD>  
  </TR>
  <TR>
    
   <TD>"; echo $_SESSION['conta_corrente_chq']; echo "</TD>
   <TD ALIGN=RIGHT><INPUT TYPE='text' SIZE=20 NAME='doc' required pattern='[0-9]{6}' size=6 maxlength=6 ALIGN=RIGHT></TD>
   <TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
   <TD><INPUT TYPE='text' SIZE=20 NAME='descricao'></TD>
   <TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'></TD>
   <TD><INPUT TYPE='date' SIZE=10 NAME='data2'></TD>
   <INPUT TYPE=HIDDEN NAME=BANCO VALUE='"; echo $_SESSION['conta_corrente_chq']; echo "'></INPUT>
   <TD ALIGN=CENTER>0</TD>
   <TD>SEM CONTACAIXA</TD>  

   <TD <td colspan=2><INPUT TYPE='submit' value='INCLUIR'/></TD> 
  </TR>
</FORM>
  ";


// RELATORIO EM BAIXO - INCLUIR CHEQUE EM CIMA


if(isset($_POST["contas"])) 
 {
  $contas = $_POST["contas"];
  if(isset($_POST["historico"]))
   {
    $historico = $_POST["historico"];
    if(isset($_POST["data"]))
     {
      $data = $_POST["data"];
    if (isset($_POST["valor"]))
     {
     $valor = $_POST["valor"];
     $valor = str_replace(',', '.', $valor);
       if(isset($_POST["descricao"]))
        {
       $descricao = $_POST["descricao"];
    
$doc = $_POST["numero_doc"];
$deb_cred = $_POST["DEB_CRED"];
if($deb_cred == '-') $valor*=-1;
     // SELECIONA O ID DA DESCRICAO DA CONTA
     // NAO FOI POSSIVEL EXECUAR QUERY PELA VARIAVEL
     $result = $caixa->query("SELECT id FROM conta_corrente WHERE descricao='$contas'");
     $id_conta = $caixa->fetch_array($result);

     $id = $id_conta[0];
     $conta_caixa = 0;

     $obs = $descricao;
     // INSERE CAIXA NO EXTRATO
     $caixa->inserir($id, $data, $historico, $doc, $valor, 0, $obs);
    } 
     }    
   }
  }
 }




require_once('cheque_class.php');

//$caixa = new Caixa_relatorio;

//$lancamentos = $caixa->dados_caixa($_SESSION['conta_corrente'], 
  //                                 $_SESSION['dataini'], 
    //                               $_SESSION['datafin']);
?>

<script type="text/javascript">
function exclui(id){
 
resposta=confirm("Tem a certeza que deseja excluir?")
if(resposta==true){
location.href="cheque_acao.php?acao=excluir&id="+id;
}
}
</script>

 <?php 

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
     $cor = 'Gainsboro';
    else 
     $cor = 'white';

$desc = $cheque->ret_desc_cntcx($value['conta_caixa']); 

  echo "
  <FORM ACTION='cheque_editar.php' METHOD='POST' ALIGN=CENTER>
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>"; echo $value['id_conta_corrente']; echo "</TD>


     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=DOC VALUE="; echo $value['numero_doc']; echo "></INPUT>";
            }
            else 
              echo $value['numero_doc'];
     echo "</TD>

     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=DATE NAME=DATA_VENCIMENTO VALUE="; echo $value['data_vencimento']; echo "></INPUT>";
            }
            else 
              echo $value['data_vencimento'];
     echo "</TD>
     
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=HISTORICO VALUE="; echo str_replace(' ', '_', $value['historico']); echo "></INPUT>";
            }
            else 
              echo $value['historico'];
     echo "</TD>

     

     
     <TD ALIGN=RIGHT FONT=><FONT COLOR="; echo $value['valor']<0?'BLUE':'RED'; echo ">"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT ALIGN=RIGHT NAME=VALOR TYPE=TEXT VALUE="; echo $value['valor']; echo "></INPUT>";
            }
            else 
              echo str_replace('.', ',', $value['valor']);
     echo "</FONT></TD>

     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=date NAME=DTBX   VALUE="; echo $value['data_baixa']; echo "></INPUT>";
            }
            else 
              echo $value['data_baixa'];
     echo "</TD>
     <TD ALIGN=CENTER>"; echo $value['conta_caixa']; echo "</TD>
     <TD ALIGN=LEFHT>"; echo $desc['descricao']; echo "</TD>
     <TD ALIGN=CENTER><a href=\"javascript:exclui("; if(isset($value['id'])) echo $value['id'];echo ")\" /><img src='../view/ico_close.png'></TD>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar>";} else { echo "<a href='?edit=edit&id="; echo $value['id']; echo "'><img src='../view/edit.png'>";} echo "</TD>
    </TR>
    "; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=HIDDEN NAME=ID VALUE="; echo $value['id']; echo "></INPUT>";
            }";


echo </FORM>";


    $soma += $value['valor'];

    $cont++;

} $soma = number_format($soma, 2,'.',''); ?>

<TR bgcolor='LightSteelBlue'>
  <TD></TD>
  <TD></TD>
  <TD></TD>    
  <TD></TD>
  <TD></TD>
  <TD ALIGN=RIGHT>TOTAL</TD>
  <TD ALIGN=RIGHT><FONT COLOR=<?php echo $soma<0?'RED':'BLUE'; echo ">"; echo str_replace('.', ',', $soma); ?></FONT></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
</TR>


























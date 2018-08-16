<?php 
echo "<title>INCLUIR CAIXA</title>";
require_once("../config/caixa.class.php");
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


echo "<head><link rel=\"stylesheet\" href=\"formulario.css\"></head>";

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

$caixa = new Caixa;

$sql = 'SELECT descricao FROM conta_corrente WHERE id_tconta=6';
 
$caixa->conexao();
$resultado = $caixa->query($sql);
$ncontas = $caixa->afect_rows($resultado);

echo "
 
<FORM METHOD=post ACTION='caixa_incluir.php'>
<TABLE BORDER=0 CELLSPACING=1>   
  <TR bgcolor='LightSteelBlue' ALIGN=CENTER>
   <TD>CONTA</TD>
   <TD ALIGN=CENTER>DATA</TD>
   <TD ALIGN=CENTER>HISTORICO</TD>
   <TD ALIGN=CENTER>NUM DOC</TD>
   <TD ALIGN=CENTER>VALOR</TD>
   <TD ALIGN=CENTER>IDENTIFICA&Ccedil;&Atilde;O</TD>
   <TD>CONTA-CAIXA</TD>
   <TD>DESCRI&Ccedil;&Atilde;O</TD>
      <TD>D/C</TD>
   <TD>OPERA&Ccedil;&Atilde;O</TD>  
  </TR>
  <TR>
    
   <TD>   <SELECT name='contas'>";   
    for ($i=0; $i<$ncontas; $i++)
   {
    $linha = $caixa->fetch_array($resultado);
    //$conta = $linha[$i];
    echo "<option>$linha[0]</option>";
    //echo $linha[0];
     }
  echo "
   </SELECT></TD>


   <TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
   <TD><INPUT TYPE='text' SIZE=20 NAME='historico' ></TD>
   <TD><INPUT TYPE='text' SIZE=20 NAME='numero_doc'></TD>
   <TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'></TD>
   <TD><INPUT TYPE='text' SIZE=20 NAME='descricao' ></TD>

   
   <INPUT TYPE=HIDDEN NAME=VOLTACAIXA VALUE='1'></INPUT>
   <TD ALIGN=CENTER>0</TD>
   <TD>SEM CONTA CAIXA</TD>  
      <TD>
    <SELECT NAME='DEB_CRED'>
      <OPTION VALUE='+' SELECTED='+'>Entrada +</option>
      <OPTION VALUE='-''>Sa&iacute;da -</option>
    </select>
   </TD> 
   <TD><INPUT TYPE='submit' value='INCLUIR'/></TD> 


  </TR>

   
  </FORM>
  ";




// RELATORIO EM BAIXO - INCLUIR CAIXA EM CIMA






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



session_start();
require_once('caixa_class.php');

$caixa = new Caixa_relatorio;

$lancamentos = $caixa->dados_caixa($_SESSION['conta_corrente'], 
                                   $_SESSION['dataini'], 
                                   $_SESSION['datafin']);
?>

<script type="text/javascript">
function exclui(id){
 
resposta=confirm("Tem a certeza que deseja excluir?")
if(resposta==true){
location.href="caixa_acao.php?acao=excluir&id="+id;
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
     $cor = 'white';
    else 
     $cor = 'Gainsboro';

	echo "
  <FORM ACTION='caixa_editar.php' METHOD='POST' ALIGN=CENTER>
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>"; echo $value['id_conta_corrente']; echo "</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=DATE NAME=DATA_EMISSAO VALUE="; echo $value['data_emissao']; echo "></INPUT>";
            }
            else 
              echo $value['data_emissao'];
     echo "</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=HISTORICO VALUE="; echo str_replace(' ', '_', $value['historico']); echo "></INPUT>";
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
              echo str_replace('.', ',', $value['valor']);
     echo "</FONT></TD>

     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) {
              echo "<INPUT TYPE=TEXT NAME=OBS VALUE="; echo str_replace(' ', '_', $value['obs']); echo "></INPUT>";
            }
            else 
              echo $value['obs'];
     echo "</TD>
     <TD ALIGN=CENTER>"; echo $value['conta_caixa']; echo "</TD>
     <TD ALIGN=LEFHT>"; echo $value['descricao']; echo "</TD>
     <TD ALIGN=CENTER><a href=\"javascript:exclui("; if(isset($value['id'])) echo $value['id'];echo ")\" /><img src='../view/ico_close.png'></TD>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$value['id']) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar>";} else { echo "<a href='?edit=edit&id="; echo $value['id']; echo "'><img src='../view/edit.png'>";} echo "</TD>
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
  <TD ALIGN=RIGHT><FONT COLOR=<?php echo $soma<0?'RED':'BLUE'; echo ">"; echo str_replace('.', ',', $soma); ?></FONT></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
  <TD></TD>
</TR>
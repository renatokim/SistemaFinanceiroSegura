<?php

echo "<title>EXCLUIR DATA</title>";
require_once("../config/caixa.class.php");
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


echo "<head><link rel=\"stylesheet\" href=\"formulario.css\"></head>";

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

$caixa = new Caixa;

$sql = 'SELECT id,descricao FROM conta_corrente';
 
$caixa->conexao();
$resultado = $caixa->query($sql);
$ncontas = $caixa->afect_rows($resultado);

echo "
 
<FORM METHOD=post ACTION='excluir_data_extrato.php'>
<TABLE BORDER=0 CELLSPACING=1>   
  <TR bgcolor='LightSteelBlue' ALIGN=CENTER>
   <TD>CONTA</TD>
   <TD ALIGN=CENTER>DATA INICIAL</TD>
	<TD ALIGN=CENTER>DATA FINAL</TD>
   
	</TR>

<TR>
   <TD>
     <SELECT name='contas'>";   
        for ($i=0; $i<$ncontas; $i++)
       {
			$linha = $caixa->fetch_array($resultado);
			echo "<option value=$linha[0]>$linha[1]</option>";
        }
        echo "
     </SELECT>
   </TD>
   <TD><INPUT TYPE='date' SIZE=20 NAME='data_inicial' required></TD>
   <TD><INPUT TYPE='date' SIZE=20 NAME='data_final' required></TD>
   <TD><INPUT TYPE='submit' value='EXCLUIR'/></TD>
	</TR>
   </TABLE>
   
  </FORM>
  ";



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

if(isset($_POST['VOLTACAIXA'])) header("location:caixa_relatorio.php");



    } 
     }    
   }
  }
 }















?>

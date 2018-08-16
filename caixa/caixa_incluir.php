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
   <TD>D/C</TD>
   <TD>ACAO</TD>

	</TR>

<TR>
   <TD>
     <SELECT name='contas'>";   
        for ($i=0; $i<$ncontas; $i++)
       {
        $linha = $caixa->fetch_array($resultado);
        //$conta = $linha[$i];
        echo "<option>$linha[0]</option>";
        //echo $linha[0];
         }
        echo "
     </SELECT>
   </TD>
   <TD><INPUT TYPE='date' SIZE=20 NAME='data' required></TD>
   <TD><INPUT TYPE='text' SIZE=20 NAME='historico' ></TD>
   <TD><INPUT TYPE='text' SIZE=20 NAME='numero_doc'></TD>
	 <TD><INPUT TYPE='numeric' SIZE=20 NAME='valor' required pattern='-?[0-9]*[,|.][0-9]{2}'></TD>
	 <TD><INPUT TYPE='text' SIZE=20 NAME='descricao' ></TD>
   <TD>
    <SELECT NAME='DEB_CRED'>
      <OPTION VALUE='+' SELECTED='+'>Entrada +</option>
      <OPTION VALUE='-''>Sa&iacute;da -</option>
    </select>
   </TD>
	 <TD><INPUT TYPE='submit' value='INCLUIR'/></TD>	
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

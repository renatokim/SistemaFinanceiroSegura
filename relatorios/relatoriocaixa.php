<?php
// RELATORIO DO CAIXA

echo "<title>CAIXA</title>";
require_once('../config/relatorios.class.php');

echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
";

$relatorio = new Relatorio;
$relatorio->conexao();

if (!isset($_POST["dataini"]) && !isset($_POST["datafin"]))
 {
  $datahoje = date("Y/m/d");
  $datahoje = str_replace('/', '-', $datahoje);
  $dia = date("d"); $mes = date("m"); $ano = date("Y");
  $dia = $dia - $dia + 1;
  $dia = "0"."$dia";
  $data = "$ano"."-"."$mes"."-"."$dia";

echo "SELECIONE O PER�ODO:
<form action=relatoriocaixa.php method='post'>
  <TABLE>
   <TR>
    <TD>DATA INICIAL</TD><TD><input type=date name='dataini' value='"; echo "$data"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD>DATA FINAL</TD><TD><input type=date name='datafin' value='"; echo "$datahoje"; echo "' REQUIRED></TD>
   </TR>
   <TR>
    <TD></TD><TD><INPUT type='submit' value='OK' /></TD>
  </TABLE>
</form>
";
}


// VARIAVEIS RECEBEM O VALOR
if (isset($_POST['dataini']))
 {
  $dataini = $_POST['dataini'];
   if (isset($_POST['datafin']))
   {
    $datafin = $_POST['datafin'];


  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
   <TD>REGISTRO</TD>
   <TD>CONTA</TD>
   <TD>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD>
   <TD>VALOR</TD>
   <TD>IDENTIFICAÇÃO</TD>
   <TD>CONTA-CAIXA</TD>
   <TD>DESC CONTA-CAIXA</TD>
  </TR>";	

 $cor = 'pink';
 $corfonte = 'BLUE';
 $cont=0;
    
    $resultado = $relatorio->relatdata($dataini, $datafin);
    $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
	

    for ($i=0; $i<$nlinhas; $i++)
	 {
	 
	 if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
	 
	  $linha = $relatorio->fetch_array($resultado);
    
	$id = $linha['id'];
    $id_conta_corrente = $linha['id_conta_corrente'];
    $data_emissao = $linha['data_emissao'];
    $historico = $linha['historico'];
    $numero_doc = $linha['numero_doc'];
    $valor = $linha[5]; ($valor < 0)?$corfonte='RED':$corfonte='BLUE';
    $conta_caixa = $linha['conta_caixa'];
    $desc_conta_caixa = $linha['descricao'];
    $descricao = $linha['obs'];
	

	
	  
echo "
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>$id</TD>
     <TD ALIGN=CENTER>$id_conta_corrente</TD>
     <TD>$data_emissao</TD>
     <TD>$historico</TD>
     <TD>$numero_doc</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
     <TD><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$descricao</TD>
     <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style=text-decoration:none target='_BLANK'>$conta_caixa</TD> 
     <TD>$desc_conta_caixa</TD>
    </TR>";
	  
	  
	  $cont++;
	 }
	 
   }
}


/*
switch ($relatorio)
 {
  case 'DATA':
    // RELATORIO POR DATA
    $sql = "SELECT extratos.id, id_conta_corrente as conta, data_emissao, historico, numero_doc, valor, extratos.conta_caixa, conta_caixa.descricao, obs FROM extratos,conta_caixa  WHERE data_emissao>='$dataini' AND data_emissao<='$datafin' AND extratos.conta_caixa=conta_caixa.num_conta_caixa ORDER BY data_emissao, id_conta_corrente, id DESC";
    break;

  case 'CONTACAIXA':
    // RELATORIO POR CONTA CAIXA
   rel_contacaixa();
    break;

  case 'BANCO':
    // RELATORIO POR BANCO
    rel_banco();
    break;

  case 'CONCILIACAO':
    // RELATORIO CONCILIACAO
    conciliacao();
    break;
 }

// SE RELATORIO != DE CONCILIACAO
if ($relatorio == 'DATA')
 {
  $result = pg_query($conexao, $sql);

  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='gray81'>
   <TD>REGISTRO</TD>
   <TD>CONTA</TD>
   <TD>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD><TD>VALOR</TD>
   <TD>DESCRICAO</TD>
   <TD>CONTA-CAIXA</TD>
   <TD>DESC CONTA-CAIXA</TD>
  </TR>";

  $cont=0;



switch ($relatorio)
 {
  case 'CONTACAIXA':

    break;

  case 'BANCO':

    break;
 }


  $pri_linha = pg_fetch_array($result);










  while ($linha = pg_fetch_array($result)) 
   {
    if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'gray91';

    $corfonte='BLUE';

    $id = $linha[0];
    $id_conta = $linha[1];
    $data_emissao = $linha[2];
    $historico = $linha[3];
    $doc = $linha[4];
    $valor = $linha[5]; if ($valor < 0) $corfonte='RED';
    $conta_caixa = $linha[6];
    $desc_conta_caixa = $linha[7];
    $descricao = $linha[8];

    echo "
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>$id</TD>
     <TD ALIGN=CENTER>$id_conta</TD>
     <TD>$data_emissao</TD>
     <TD>$historico</TD>
     <TD>$doc</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>$valor</font></TD>
     <TD>$descricao</TD>
     <TD ALIGN=CENTER><a href='' onclick=\"window.open('page.html','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=100')\" style='text-decoration:none'>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
    </TR>";

    $cont++;
   }
  echo "</TABLE>";
 }
 
 */

?>





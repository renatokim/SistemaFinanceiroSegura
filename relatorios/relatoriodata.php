<HTML>
<body onload="location.href='#EDITAR'">
<?php

echo "<title>CONFERENCIA DATA</title>";

session_start();
require_once('../config/relatorios.class.php');

$dataini_relat_dt = $_SESSION['dataini_relat_dt'];
$datafin_relat_dt = $_SESSION['datafin_relat_dt'];


$relatorio = new Relatorio;
$relatorio->conexao();


// VARIAVEIS RECEBEM O VALOR
if (1)
 {
  $dataini = $dataini_relat_dt;
   if (1)
   {
    $datafin = $datafin_relat_dt;


  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1 width=100%>
  <TR bgcolor='LightSteelBlue'>
   <TD>REGISTRO</TD>
   <TD>CONTA</TD>
   <TD width='6%'>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD>
   <TD>VALOR</TD>
   <TD>IDENTIFICACAO</TD>
   <TD>CONTA-CAIXA</TD>
   <TD>DESC CONTA-CAIXA</TD>
   <TD>ACAO</TD>
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
    $valor = $linha['valor']; ($valor < 0)?$corfonte='RED':$corfonte='BLUE';
    $conta_caixa = $linha['conta_caixa'];
    $desc_conta_caixa = $linha['descricao'];
    $descricao = $linha['obs'];
	  
 
	  
	      echo "<FORM METHOD='POST' ACTION=alt_desc_data.php>
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>$id</TD>
     <TD>$id_conta_corrente</TD>
     <TD>$data_emissao</TD>
     <TD>$historico</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$id) {
              echo "<INPUT TYPE=TEXT NAME=NUMERO_DOC SIZE=30 VALUE="; echo str_replace(' ', '_', $numero_doc); echo "></INPUT>";
            }
            else 
              echo $numero_doc;
     echo "</TD>
     <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>"; echo str_replace('.', ',', $valor); echo "</font></TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$id) {
              echo "<INPUT TYPE=TEXT NAME=OBS SIZE=30 VALUE="; echo str_replace(' ', '_', $descricao); echo "></INPUT>";
            }
            else 
              echo $descricao;
     echo "</TD>
     <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar'
      TARGET=BLANK style='text-decoration:none'>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
     <INPUT TYPE=HIDDEN NAME=ID VALUE="; echo $id; echo "></INPUT>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\">";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/edit.png'>";} echo "</TD> 
    </TR>
    </FORM>";
	  
/*
<a href='' onclick="window.open('../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
     " style='text-decoration:none'>

*/

	  
	  $cont++;
	 }
	 
   }
}


?>





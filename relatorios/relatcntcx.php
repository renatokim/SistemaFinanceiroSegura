
<body onload="location.href='#EDITAR'">
<?php
session_start();
echo "<title>CONFERENCIA BANCO</title>";
require_once('../config/relatorios.class.php');

$dataini_relat_bco = $_SESSION['dataini_relat_cnt'];
$datafin_relat_bco = $_SESSION['datafin_relat_cnt'];

$relatorio = new Relatorio;
$relatorio->conexao();


echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
";
 
// VARIAVEIS RECEBEM O VALOR
if (1)
 {
  $dataini = $dataini_relat_bco;
   if (1)
   {
    $datafin = $datafin_relat_bco;

  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1  width=100%>
  <TR bgcolor='LightSteelBlue'>
   <TD>REGISTRO</TD>
   <TD>CONTA</TD>
   <TD width='6%'>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD>
   <TD>VALOR</TD>
   <TD>IDENTIFICAÇÃO</TD>
   <TD>CONTACAIXA</TD>
   <TD>DESC CONTACAIXA</TD>
   <TD>ACAO</TD>
  </TR>"; 

  $corfonte = 'BLUE';
  $cont=0;
  $soma = 0.00;
  $soma = number_format($soma, 2,'.','');
  $valor = 0.00;
  $set = 0;   
  $cor = 'white';  
    
  /* PRIMEIRA LINHA */
  $resultado = $relatorio->relatcntcx($dataini, $datafin);
  $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
  
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

	 $historico = utf8_encode($historico);
	 $descricao = utf8_encode($descricao);
	 
  // MOSTRA A PRIMEIRA LINHA
  echo "<FORM METHOD='POST' ACTION=alt_desc_cntc.php>
    <TR  bgcolor=$cor>
     <TD ALIGN=CENTER>$id</TD>
     <TD ALIGN=CENTER>$id_conta_corrente</TD>
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
     <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style='text-decoration:none' TARGET=BLANK>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
     <INPUT TYPE=HIDDEN NAME=ID VALUE="; echo $id; echo "></INPUT>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\">";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/edit.png'>";} echo "</TD>
    </TR>";  
   
     $subbanco = $conta_caixa; 
   $cont++;
   $soma += $valor;
   /* FIM PRIMEIRA LINHA */
   
  
  // INICIO DAS OUTRAS LINHAS
  for ($i = 0; $i < $nlinhas -1; $i++)
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

	 	 $historico = utf8_encode($historico);
	 $descricao = utf8_encode($descricao);
	 
   if ($subbanco == $conta_caixa)
    {
     echo "<FORM METHOD='POST' ACTION=alt_desc_cntc.php>
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$id</TD>
         <TD ALIGN=CENTER>$id_conta_corrente</TD>
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
     <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style='text-decoration:none' TARGET=BLANK>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
     <INPUT TYPE=HIDDEN NAME=ID VALUE="; echo $id; echo "></INPUT>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\">";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/edit.png'>";} echo "</TD>
        </TR></FORM>";  

     $soma += $valor;  
     $cont++;
   $soma = number_format($soma, 2,'.','');
   }
   
   


     else 
    {
    ($soma < 0)?$corfonte='RED':$corfonte='BLUE';
  // $soma /= 2;
  $soma = number_format($soma, 2,'.','');
       echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>"; echo str_replace('.', ',', $soma); echo "</font></TD>
         <TD></TD>
         <TD ALIGN=CENTER><a href='' onclick=\"window.open('page.html','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=100')\" style='text-decoration:none'></TD>
         <TD></TD>
         <td></td>
        </TR>"; 
    
       $subbanco = $conta_caixa;
       $soma = 0.00;
         $cor = 'white';
    
    ($valor < 0)?$corfonte='RED':$corfonte='BLUE';
    
         echo "
        <TR  bgcolor=$cor>
         <TD ALIGN=CENTER>$id</TD>
         <TD ALIGN=CENTER>$id_conta_corrente</TD>
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
     <TD ALIGN=CENTER><a href='../contacaixa/contacaixa.php?registro=$id&idconta=$id_conta_corrente&data_emissao=$data_emissao&historico=$historico&doc=$numero_doc&valor=$valor&descricao=$descricao&contacaixa=$conta_caixa&desccontacaixa=$desc_conta_caixa&acao=alterar' style='text-decoration:none' TARGET=BLANK>$conta_caixa</TD>
     <TD>$desc_conta_caixa</TD>
     <INPUT TYPE=HIDDEN NAME=ID VALUE="; echo $id; echo "></INPUT>
     <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\">";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/edit.png'>";} echo "</TD>

        </TR><FORM>"; 
    
    $cont++;
         $soma += $valor; 
    

    
    }


 } // fim do while

    ($soma < 0)?$corfonte='RED':$corfonte='BLUE';
    // $soma /= 2;
    $soma = number_format($soma, 2,'.','');
       echo "
        <TR  bgcolor=LightSteelBlue>
         <TD ALIGN=CENTER></TD>
         <TD ALIGN=CENTER></TD>
         <TD></TD>
         <TD></TD>
         <TD>SUBTOTAL</TD>
         <TD ALIGN=RIGHT FONT=><FONT COLOR=$corfonte>"; echo str_replace('.', ',', $soma); echo "</font></TD>
         <TD></TD>
         <TD ALIGN=CENTER><a href='' onclick=\"window.open('page.html','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=100,height=100')\" style='text-decoration:none'></TD>
         <TD></TD>
         <TD></TD>
        </TR>"; 


}



}





?>





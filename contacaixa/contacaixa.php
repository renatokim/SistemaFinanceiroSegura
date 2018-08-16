<HTML>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<?php 

$a=1;

?>


<!-- <BODY  <?php if(isset($_GET['closewin'])) echo "onload='javascript: window.close();'" ?> > -->
<?php 

//if(isset($_GET['closewin'])) die('teste'); 

echo "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
";



require_once("../config/contacaixa.class.php");

$contacaixa = new Contacaixa;
$contacaixa->conexao();

// CONTA CAIXA
if(isset($_GET["numcontacaixa"]))
 {
  $numcontacaixa = $_GET["numcontacaixa"];
  $reg = $_GET["reg"];
  $altdesc = $_GET["desc"];   
  $aca = $_GET["aca"];  
  
  if ($aca == "alterar")
   {
    $contacaixa->setcontacaixa($reg, $numcontacaixa);
	$contacaixa->setdescricao($reg, $altdesc);
   }
  
    echo "<script> window.close() </script>";
  }

// DESCRICAO
if(isset($_GET["botao"]))
 {
  $descricao = $_GET["descricao"];
  $registro = $_GET["registro"];
  $idconta = $_GET["idconta"];  
  $data_emissao = $_GET["data_emissao"];
  $historico = $_GET["historico"];
  $doc = $_GET["doc"];  
  $valor = $_GET["valor"];
  $descricao = $_GET["descricao"];  
  $conta_caixa = $_GET["contacaixa"];  
  $desccontacaixa = $_GET["desccontacaixa"];


 echo "<div>
         $descricao
        </div>";
  $contacaixa->setdescricao($registro, $descricao);
  //exit;
  //require_once("../relatorios/relatoriodata.php");
  

 }


echo "<title>CONTA CAIXA</title>";

if(isset($_GET["registro"]))
 {
  $registro = $_GET["registro"];
  $idconta = $_GET["idconta"];  
  $data_emissao = $_GET["data_emissao"];
  $historico = $_GET["historico"];
  $doc = $_GET["doc"];  
  $valor = $_GET["valor"];
  $descricao = $_GET["descricao"];  
  $contacaixa = $_GET["contacaixa"];  
  $desccontacaixa = $_GET["desccontacaixa"];    


  
if(isset($_GET["acao"])) $acao = $_GET["acao"];
 
echo " 

 <FORM METHOD=GET ACTION='contacaixa.php'>
 <TABLE BORDER=0 CELLSPACING=2>
  <TR bgcolor='LightSteelBlue'>
   <TD>REGISTRO</TD>
   <TD>CONTA</TD>
   <TD>DATA</TD>
   <TD>HISTORICO</TD>
   <TD>DOC</TD>
   <TD>VALOR</TD>
   <TD>IDENTIFICAÇÃO</TD>
   <TD></TD>
   <TD>CONTACAIXA</TD>
   <TD>DESC CONTACAIXA</TD>
  </TR>
  <TR>
   <TD  bgcolor='Gainsboro' align=center>$registro</TD>
   <TD  bgcolor='Gainsboro' align=center>$idconta</TD>	  
   <TD  bgcolor='Gainsboro'>$data_emissao</TD>   
   <TD  bgcolor='Gainsboro'>$historico</TD>   
   <TD  bgcolor='Gainsboro'>$doc</TD>
   <TD  bgcolor='Gainsboro'>$valor</TD>
   <TD><INPUT TYPE='text' SIZE=50 NAME='descricao' VALUE='$descricao'></TD> 
   <TD><INPUT TYPE='submit' NAME='botao' value='ALTERAR'/></TD>   
   <TD  bgcolor='Gainsboro' align=center>$contacaixa</TD>
   <TD  bgcolor='Gainsboro'>$desccontacaixa</TD>
   
   <INPUT TYPE='hidden' NAME='registro' VALUE=$registro>
   <INPUT TYPE='hidden' NAME='idconta' VALUE=$idconta>
   <INPUT TYPE='hidden' NAME='data_emissao' VALUE=$data_emissao>
   <INPUT TYPE='hidden' NAME='historico' VALUE=$historico>
   <INPUT TYPE='hidden' NAME='doc' VALUE=$doc>
   <INPUT TYPE='hidden' NAME='valor' VALUE=$valor>   
   <INPUT TYPE='hidden' NAME='contacaixa' VALUE=$contacaixa>
   <INPUT TYPE='hidden' NAME='desccontacaixa' VALUE=$desccontacaixa> 
   <INPUT TYPE='hidden' NAME='acao' VALUE=$acao> 

   </TR>
 </TABLE>
 </FORM>
";
	   
//echo "<P>";	   
	   
 }

 

function contacaixa($nivel, $anterior) # PARAMETROS 1-NIVEL  2-ANTERIOR
 {
 
   
   if (isset($_GET["registro"])) $registro = $_GET["registro"];
   if (isset($_GET["acao"])) $acao = $_GET["acao"];
   if (isset($_GET["descricao"])) $descricao = $_GET["descricao"];

 
   $sql = "select id, seq, anterior, valor, descricao, nivel, fim 
               from perguntas 
			   where nivel=$nivel+1 
			   and anterior>=$anterior*10+1 
			   and anterior<=$anterior*10+9
			   ORDER BY seq";
   
   $resultado = mysql_query($sql);

   $a=0;
   while ($linha = mysql_fetch_array($resultado)) //for($i=0; $i<5; $i++)
    {
	  //$linha = mysql_fetch_array($resultado);
	  if ("$linha[fim]" == 'S')
	  {
	    echo "<li><a href='?numcontacaixa=$linha[valor]&reg=$registro&aca=$acao&desc=$descricao&closewin=1'  method='GET'>$linha[descricao]</a></li>"; 
	  }
	  else 
	   {
	    //contacaixa("$linha[nivel]", "$linha[anterior]");
	    ?><li><a class='MenuBarItemSubmenu' href='#'><?php echo "$linha[descricao]"; ?></a>
                 <ul>
                  <?php contacaixa("$linha[nivel]", "$linha[anterior]"); ?>
                 </ul>
                </li>
			 <?php
		}

    }
 }

?>

<?php


  
 
if(!isset($_GET["botao"]))
 {
 	?>








<ul id="MenuBar1" class="MenuBarVertical">

  <li><a class="MenuBarItemSubmenu" href="#">ENTRADA</a>
    <ul>
      <li><a class="MenuBarItemSubmenu" href="#">PESSOA JURIDICA</a>
        <ul>
          <?php contacaixa(2, 11); ?>
        </ul>
      </li>
	  <li><a class="MenuBarItemSubmenu" href="#">PESSOA FISICA</a>
        <ul>
          <?php contacaixa(2, 12); ?>
        </ul>
      </li>
	  <li><a class="MenuBarItemSubmenu" href="#">CONCILIACAO</a>
        <ul>
          <?php contacaixa(2, 13); ?>
        </ul>
      </li>
    </ul>
  </li>
  
  <li><a class="MenuBarItemSubmenu" href="#">SAIDA</a>
    <ul>
      <li><a class="MenuBarItemSubmenu" href="#">PESSOA JURIDICA</a>
        <ul>
          <?php contacaixa(2, 21); ?>
        </ul>
      </li>
	  <li><a class="MenuBarItemSubmenu" href="#">PESSOA FISICA</a>
        <ul>
          <?php contacaixa(2, 22); ?>
        </ul>
      </li>
	  <li><a class="MenuBarItemSubmenu" href="#">CONCILIACAO</a>
        <ul>
          <?php contacaixa(2, 23); ?>
        </ul>
      </li>
    </ul>
  </li> 

    <li><a class="MenuBarItemSubmenu" href="#">SALDOS</a>
    <ul>
      <?php contacaixa(1, 3); ?>
    </ul>
  </li> 
  
</ul>

<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>

<?php

}
  
?>

</HTML>

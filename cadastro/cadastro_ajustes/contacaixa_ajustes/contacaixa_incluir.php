<HTML>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<?php 
require_once("../../../config/contacaixa.class.php");

session_start();

$contacaixa = new Contacaixa;
$contacaixa->conexao();

// CONTA CAIXA
echo "CONTA-CAIXA A INCLUIR";


if(isset($_GET["numcontacaixa"]))
  {
    $cx_inserir = $_GET["numcontacaixa"];
    $cx_retirada = $_SESSION['cx_retirada'];
    //print_r($cx_retirada);
    //print_r($_SESSION['cx_retirada']);
    //die();

    header("location:../inserir_ajuste_banco.php?cx_inserir=$cx_inserir&cx_retirada=$cx_retirada");
  }


echo "<title>CADASTRO AJUSTES</title>";



function contacaixa($nivel, $anterior) # PARAMETROS 1-NIVEL  2-ANTERIOR
 {

 
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
	    echo "<li><a href='?numcontacaixa=$linha[valor]'  method='GET'>$linha[descricao]</a></li>"; 
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



/*
<script type="text/javascript">
javascript:window.close();
</script>
//
*/
/*
if(isset($_POST["botao"]))
{
 $botao = isset($_POST["botao"]);
 $descricao = isset($_POST["descricao"]);
 echo "$botao";
 echo "$descricao";
 exit;
}
*/

  
// ALTERA A DESCRICAO "OBS" DO EXTRATO
//$descricao = 'teste';
//$contacaixa->setdescricao(5180, $descricao);

// ALTERA O CONTA CAIXA DO EXTRATO
//$conta = 1400000;
//$contacaixa->setcontacaixa(1414, $conta);
 
// INSERE NO EXTRATO COM CONTA CAIXA
//$id_conta = 1; $data = '2012-09-19'; $historico = 'teste'; $doc = '100'; $valor = 9999.99; $conta_caixa = 0; $obs = 'teste obs';
//$contacaixa->inserir($id_conta, $data, $historico, $doc, $valor, $conta_caixa, $obs);

// INSERE CHEQUES
//$id_conta_corrente = 1; $data = '2012-09-19'; $historico = 'chq teste'; $doc = '854000'; $valor = 100.45; $data_vencimento = '2012-09-19';
//$numcontacaixa = 0;
//$contacaixa->inserirchq($id_conta_corrente, $data, $historico, $doc, $valor, $data_vencimento, $numcontacaixa);
  
?>

</HTML>

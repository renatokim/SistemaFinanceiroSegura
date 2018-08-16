<script src="jquery-1.11.1.min.js" type="text/javascript"></script>
<script>
function marcardesmarcar(){ 
   if ($("#todos").val() == 'DESMARCAR'){
      $('.marcar').each(
         function(){
            $(this).attr("checked", false);
         }
      );
	$("#todos").val('MARCAR')  
   }else{ 
      $('.marcar').each(
         function(){
            $(this).attr("checked", true);
         }
      );
	  $("#todos").val('DESMARCAR')  
   }
}
</script>

<?php
echo "<title>AJUSTES</title>";
require_once('../config/relatorios.class.php');

$data = date("Y-m");

$relatorio = new Relatorio;
$relatorio->conexao();

echo "<form action='' method=post>";

echo "DATA: <input type=month name='data' value='"; echo "$data"; echo "' REQUIRED>";
echo "<BR><BR>";

 ?> <input type="button" name="todos" id="todos" value="MARCAR" onclick="marcardesmarcar();" /><br/> <?php

?><TABLE BORDER="0" CELLSPACING="1">
  <TR bgcolor="LightSteelBlue">
   <TD>SELECIONE</TD>
   <TD>CX RETIRA</TD>
   <TD>DESCRICAO</TD>
   <TD>TIPO (% OU $)</TD>   
   <TD>VALOR</TD>   
   <TD>CX INCLUI</TD>
   <TD>DESCRICAO</TD>
  </TR>	
 

 
<?php
  
 $cor = 'pink';
 $corfonte = 'BLUE';
 $cont=0;
    
    $resultado = $relatorio->ajustes();
    $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
	
    for ($i=0; $i<$nlinhas; $i++)
	 {
	  $linha[] = $relatorio->fetch_array($resultado);
	 }	 
	 
if(isset($linha))
 {
  foreach($linha as $ajuste)
	 {
	 
	 if($cont % 2 == 0)
     $cor = 'white';
    else 
     $cor = 'Gainsboro';
    
	  $id = $ajuste['id'];
    $cx_retira = $ajuste['cx_retira'];
    $descricao_cx_ret = $ajuste['descricao_cx_ret']; $descricao_cx_ret = str_replace(' ', '_', $descricao_cx_ret);
    $cx_inclui = $ajuste['cx_inclui'];
    $descricao_cx_inc = $ajuste['descricao_cx_inc']; $descricao_cx_inc = str_replace(' ', '_', $descricao_cx_inc);
    $vlr_or_pecent = $ajuste['vlr_or_pecent']; 
    $valor = $ajuste['valor'];
 
echo "
  <TR bgcolor=$cor>
   <TD ALIGN=CENTER><input type=checkbox class='marcar' name=option";echo $id; echo " value="; 
   echo $cx_retira; 
   echo '__=__'; echo $descricao_cx_ret; 
   echo '__=__'; echo $vlr_or_pecent; 
   echo '__=__'; echo $valor; 
   echo '__=__'; echo $cx_inclui; 
   echo '__=__'; echo $descricao_cx_inc;    
   echo "></TD>";

   $descricao_cx_ret = str_replace('_', ' ', $descricao_cx_ret); 
   $descricao_cx_inc = str_replace('_', ' ', $descricao_cx_inc);

echo "
   <TD ALIGN=CENTER>"; echo $cx_retira; echo "</TD>
   <TD>"; echo $descricao_cx_ret; echo "</TD>
   <TD ALIGN=CENTER>"; echo $vlr_or_pecent; echo "</TD>
   <TD ALIGN=RIGHT>"; echo $valor; echo "</TD>   
   <TD ALIGN=CENTER>"; echo $cx_inclui; echo "</TD>
   <TD>"; echo $descricao_cx_inc; echo "</TD>

  </TR>";
	  
	  $cont++;
}
 }
echo "</TABLE>";

?>
<BR>

<input type="submit" value="LANCAR AJUSTE">
</form>

<?php

if(isset($_POST) && !empty($_POST))
{
	$ajust = $_POST;
	$periodo = $_POST['data'];
	$ajust['data'] .= '-01'; 
	$i=0;

	$dt_ini = $periodo.'-01';
	$dt_fin = $periodo.'-31';

	//$relatorio->delete_ajustes_lacados($dt_ini, $dt_fin);
echo '<pre>';
	foreach ($ajust as $key => $value) 
	  {
		$i++;    // a primeira linha é a data
		if($i == 1) continue;

		$ajust_lancar = explode('__=__', $value);
		
		if($ajust_lancar[2] == '%')
		{
			$sql = "select sum(valor) as soma from extratos where conta_caixa = '".$ajust_lancar[0]."' and  month(data_emissao) = month('".$ajust['data']."') and year(data_emissao) = year('".$ajust['data']."') and id_conta_corrente != 15";
			$resultado = $relatorio->query($sql);
			$result = mysql_fetch_array($resultado);
			
			$valor = $result[0];
			$myValor = $valor * $ajust_lancar[3] / 100; $teste = $ajust_lancar[3];
			$ajust_lancar[3] = $myValor;
			$relatorio->insere_ajuste_caixa($ajust_lancar, $dt_ini);
			
			/*
			print_r($valor); echo ' ';
			print_r($teste); echo ' ';
			print_r($myValor);
	
			echo '------';
			*/
			
		}
		else
		{
			$relatorio->insere_ajuste_caixa($ajust_lancar, $dt_ini);
		}
	  } 

	  echo "AJUSTE LANCADO";
}



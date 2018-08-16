<?php
//echo '<pre>';
//print_r($grupo); die();

require_once("../config/relatorios.class.php");

$cadastro = new Relatorio;
$cadastro->conexao();

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";
 

$resultado = $cadastro->get_cad_grupos();


echo "
 GRUPO
  <FORM METHOD=post ACTION='/codeigniter/index.php/grupoGraficos/alterarGrupos'>
   <TABLE>
   <tr>

  <TD><INPUT TYPE='text' value='"; echo $grupo[0]['nome_grupo']; echo "' SIZE=20 NAME='nome_grupo' required></TD>
	<TD><INPUT TYPE='submit' value='ALTERAR'/></TD>
   </TR>
   </TABLE>
";
?>

<input type="hidden" name="grafico" value="<?php echo $grupo[0]['id_cadastro_grafico']; ?>">
<input type="hidden" name="sequencia" value="<?php echo $grupo[0]['seq_grupo']; ?>">
<input type="hidden" name="id_grupo" value="<?php echo $grupo[0]['id']; ?>">
<?php

  echo "<TABLE BORDER=0 CELLSPACING=1 ALIGN=LEFT>
  <TR bgcolor='LightSteelBlue'>
  <TD></TD>
   <TD ALIGN=CENTER>CONTA CAIXA</TD>
   <TD ALIGN=CENTER>DESCRICAO</TD>
  </TR>"; 

 $cont=0;
    
    $resultado = $cadastro->relatcadcontacaixa();
    $nlinhas = $cadastro->afect_rows($resultado); // N LINHA AFETADAS
  

    for ($i=0; $i<$nlinhas; $i++)
   {
    if($cont % 2 == 0)
       $cor = 'white';
      else 
       $cor = 'Gainsboro';
   
    $linha = $cadastro->fetch_array($resultado);
    
    $id = $linha['id'];
      $num_conta_caixa = $linha['num_conta_caixa'];
      $descricao = $linha['descricao'];
	  
    ?>
	
	<?php 
	
		//echo '<pre>';
		//print_r($contaCaixas);
		//die();
	$selected = '';	
		foreach($contaCaixas as $key => $cx)
		{
			if($cx['conta_caixa'] == $num_conta_caixa)
			{
				$selected = 'checked';
			}
		}
		
	
	?>

       <TR  bgcolor=<?php echo $cor; ?> >
         <TD><input type=checkbox name=opt[] value=<?php echo $num_conta_caixa; ?> <?php echo $selected; ?> ></TD>
        <TD ALIGN=CENTER><?php echo $num_conta_caixa ?></TD>
        <TD ALIGN=CENTER><?php echo $descricao ?></TD>
      </TR>
	  
	  <?php

      $cont++;
   }
   
echo " </FORM>";  
  
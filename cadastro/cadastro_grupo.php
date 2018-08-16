<?php



require_once("../config/relatorios.class.php");

$cadastro = new Relatorio;
$cadastro->conexao();

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";
 

$resultado = $cadastro->get_cad_grupos();


echo "
 GRUPO
  <FORM METHOD=post ACTION='cad_grupo_banco.php'>
   <TABLE>
   <tr>
  <td>
  <SELECT name='id_grafico'>";   
    foreach ($resultado as $key => $value) 
      {

        echo "<option value=$value[0]>$value[1]</option>";

      }
    echo "
   </SELECT>

<td></td>

  <TD><INPUT TYPE='text' SIZE=20 NAME='nome_grupo' required></TD>
	<TD><INPUT TYPE='submit' value='CADASTRAR'/></TD>
   </TR>
   </TABLE>
";


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
    
    echo "
       <TR  bgcolor=$cor>
         <TD><input type=checkbox name=opt[]"; echo " value=$num_conta_caixa></TD>
        <TD ALIGN=CENTER>$num_conta_caixa</TD>
        <TD ALIGN=CENTER>$descricao</TD>
      </TR>";

      $cont++;
   }
   
echo " </FORM>";  
  
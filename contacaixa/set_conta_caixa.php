<HTML>
<body onload="location.href='#EDITAR'">
<?php

echo "<title>CONTA CAIXA</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1 ALIGN=CENTER>
  <TR bgcolor='LightSteelBlue'>

          <TD>EDITAR</TD>
   <TD ALIGN=CENTER>CONTA CAIXA</TD>
   <TD ALIGN=CENTER>DESCRICAO</TD>
  </TR>";	

 $cont=0;
    
    $resultado = $relatorio->relatcadcontacaixa();
    $nlinhas = $relatorio->afect_rows($resultado); // N LINHA AFETADAS
 

    for ($i=0; $i<$nlinhas; $i++)
	 {
	  if($cont % 2 == 0)
       $cor = 'white';
      else 
       $cor = 'Gainsboro';

	  $linha = $relatorio->fetch_array($resultado);


    
	    $id = $linha['id'];
      $num_conta_caixa = $linha['num_conta_caixa'];
      $descricao = $linha['descricao'];
	     echo "<FORM METHOD='POST' ACTION=setcontacaixa.php>

       <TR  bgcolor=$cor>
  
       <TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar><a name=\"EDITAR\"></a>";} else { echo "<a href='?edit=edit&id="; echo $id; echo "'><img src='../view/edit.png'>";} echo "</TD>      
        <TD ALIGN=CENTER>$num_conta_caixa</TD>
        <TD>"; if(isset($_GET['edit']) && $_GET['id']==$id) { echo "<INPUT TYPE=text required NAME=NOME VALUE="; echo str_replace(' ', '_', $descricao); echo ">"; } else { echo $descricao; } echo "</TD>
           <INPUT TYPE=hidden name=ID value="; if(isset($_GET['id'])) echo $_GET['id']; echo ">  
      </TR>";

      $cont++;
	 }
	 
?>


</body>
</html>



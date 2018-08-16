<?php
session_start();

//print_r($_POST); die();

echo "<title>AJUSTES LANCADOS</title>";

require_once('../config/relatorios.class.php');


$relatorio = new Relatorio;
$relatorio->conexao();

if(isset($_POST['data'])) 
  {
    $data = explode('-', $_POST['data']);
    $data[2] = 01;
    $data = implode('-', $data);
    $data = $_POST;
    $_SESSION['data_set_ajust'] = $data;
  }
else 
  $data = $_SESSION['data_set_event'];

  $dados = $relatorio->eventuais_lancados();

  echo '<pre>';
  print_r($dados); die();
  
  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1>
  <TR bgcolor='LightSteelBlue'>
     <TD>ACAO</TD>
          <TD>ACAO</TD>
   <TD>DATA</TD>
   <TD>DESCRICAO</TD>
   <TD>VALOR</TD>
  </TR>";	

 $cor = 'pink';
 $corfonte = 'BLUE';
 $cont=0;
    

    foreach ($dados as $key => $value) {
       if($key % 2 == 0)
         $cor = 'white';
        else 
         $cor = 'Gainsboro';








	  
	      echo "<FORM METHOD='POST' ACTION=set_ajust_lanc.php>
    <TR  bgcolor=$cor>
   <TD ALIGN=CENTER><a href='excluir_ajuste_lancado.php?id=$value[0]'><img src='../view/ico_close.png'></a></TD>    

<TD ALIGN=CENTER>"; if(isset($_GET['edit']) && $_GET['id']==$value[0]) { echo "<INPUT TYPE=SUBMIT NAME=UPDATE VALUE=Editar>";} else { echo "<a href='?edit=edit&id="; echo $value[0]; echo "'><img src='../view/edit.png'>";} echo "</TD>      
          <TD ALIGN=CENTER>$value[1]</TD>
          <TD ALIGN=CENTER>$value[2]</TD>
     <TD>$value[3]</TD>
     <TD>$value[4]</TD>
     <TD>$value[5]</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value[0]) { echo "<INPUT TYPE=text required pattern='[$|%]' NAME=TIPO VALUE="; echo $value[6]; echo ">"; } else { echo $value[6]; } echo "</TD>
     <TD>"; if(isset($_GET['edit']) && $_GET['id']==$value[0]) { echo "<INPUT TYPE=text required pattern='[0-9]*[,|.][0-9]{2}' NAME=VALOR VALUE="; echo $value[7]; echo ">"; } else { echo $value[7]; } echo "</TD>
     <INPUT TYPE=hidden name=ID value="; echo "$value[0]"; echo ">         

     
    </TR>
    </FORM>";
	  
}



?>





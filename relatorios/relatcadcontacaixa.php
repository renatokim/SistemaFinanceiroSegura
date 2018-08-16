<?php

echo "<title>RELATORIO DE CONTA CAIXA</title>";
require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


  // CABECALHO DA TABELA
  echo "<TABLE BORDER=0 CELLSPACING=1 ALIGN=CENTER>
  <TR bgcolor='LightSteelBlue'>
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
	  
	  echo "
       <TR  bgcolor=$cor>
        <TD ALIGN=CENTER>$num_conta_caixa</TD>
        <TD ALIGN=CENTER>$descricao</TD>
      </TR>";

      $cont++;
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





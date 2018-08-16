<?php

echo "<title>CADASTRO DE CONTA CAIXA</title>";

require_once("../config/cadastro.class.php");

$cadastro = new Cadastro;
$cadastro->conexao();

echo "<BODY BGCOLOR = 'Lavender' </BODY>"; // INCLUIR
// ATERAR echo "<BODY BGCOLOR = 'PapayaWhip' </BODY>";
// EXCLUIR echo "<BODY BGCOLOR = '#FFCCCC' </BODY>";

echo "CADASTRO DE CONTA CAIXA";



// PRIMEIRA OPCAO, QUANDO NAO EXISTE NADA
if (!isset($_POST['BOTAO_1']) && !isset($_POST['BOTAO_2'])  
 && !isset($_POST['BOTAO_3']) && !isset($_POST['BOTAO_4']) 
 && !isset($_POST['BOTAO_5']) && !isset($_POST['BOTAO_6'])
 && !isset($_POST['BOTAO_7']) && !isset($_POST['BOTAO_N']))
 {   
  echo "<BR>";
  echo "<BR>";
 
  echo "
  <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>
   <SELECT name='nivel1'>
    <option value='100'>ENTRADA</option>
    <option value='200'>SAIDA</option>
   </SELECT>
   <BR>
   <BR>   
   <INPUT TYPE='submit' name=BOTAO_1 value='ENVIAR'/>
  </FORM>
  ";
 }

 
 
// O BOTAO E PRESSIONADO E VAI PARA SEGUNDA OPCAO 
 if (isset($_POST['BOTAO_1']))
  {
   $nivel1 = $_POST['nivel1'];

   switch ($nivel1)
    {
     case "100";
	 $mostra1 = 'ENTRADA';
	 break;
	
	 case "200";
	 $mostra1 = 'SAIDA';
	 break;
    }
	
	echo "<BR>";
	echo "<BR>";
	echo "$mostra1";
	echo "<BR>";
	echo "<BR>";
	
  echo "
  <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>
   <SELECT name='nivel2'>
    <option value='"; $nivel2 = $nivel1 + 10; echo "$nivel2"; echo "'>PESSOA JURIDICA</option>
    <option value='"; $nivel2 = $nivel1 + 20; echo "$nivel2"; echo "'>PESSOA FISICA</option>
   </SELECT>
   <INPUT TYPE=hidden name=mostra1 value="; echo "$mostra1"; echo ">
   <BR>
   <BR>   
   <INPUT TYPE='submit' name=BOTAO_2 value='ENVIAR'/>
  </FORM>
  ";
 }
 
 
 
// TERCEIRA OPCAO 
 if (isset($_POST['BOTAO_2']))
  {
   $mostra1 = $_POST['mostra1'];
   $nivel2 = $_POST['nivel2'];

   switch ($nivel2)
    {
     case "110";
	 $mostra2 = "PESSOA_JURIDICA";
	 break;
	
	 case "120";
	 $mostra2 = 'PESSOA_FISICA';
	 break;
	 
     case "210";
	 $mostra2 = 'PESSOA_JURIDICA';
	 break;
	
	 case "220";
	 $mostra2 = 'PESSOA_FISICA';
	 break;	 
	 
    }
	
	echo "<BR>";
	echo "<BR>";
	echo "$mostra1";
	echo "<BR>";
	echo "<BR>";
	echo "$mostra2";
	echo "<BR>";
	echo "<BR>";
	
	// COMENTAR DEPOIS DO TESTE
	//echo "$nivel2";
	
  echo "
  <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>
   <SELECT name='nivel3'>";
   
   if ($nivel2 == 110 || $nivel2 == 210)
    {
	 echo"   
     <option value='"; $nivel3 = $nivel2 + 1; echo "$nivel3"; echo "'>FISCAL</option>
     <option value='"; $nivel3 = $nivel2 + 2; echo "$nivel3"; echo "'>ORÇAMENTO</option>
     ";
	}
   else if ($nivel2 == 120 || $nivel2 == 220)
    {
	 echo"
	 <option value='"; $nivel3 = $nivel2 + 1; echo "$nivel3"; echo "'>NEGOCIO</option>
     <option value='"; $nivel3 = $nivel2 + 2; echo "$nivel3"; echo "'>FAMILIA</option>
     ";
    }
	
   echo "
	</SELECT>
	<INPUT TYPE=hidden name=mostra1 value="; echo "$mostra1"; echo ">
     <INPUT TYPE=hidden name=mostra2 value="; echo "$mostra2"; echo ">  
     <BR>
     <BR>   
     <INPUT TYPE='submit' name=BOTAO_3 value='ENVIAR'/>
     </FORM>";

  }

  // QUARTA OPCAO
   if (isset($_POST['BOTAO_3']))
    { 
	 $nivel3 = $_POST['nivel3'];
	 $mostra1 = $_POST['mostra1']; 
	 $mostra2 = $_POST['mostra2']; 
	  
	 switch ($nivel3)
     {
      case "111";
	  $mostra3 = "FISCAL";
	  break;
	 
	  case "211";
	  $mostra3 = "FISCAL";
	  break;
	 
      case "112";
	  $mostra3 = "ORÇAMENTO";
	  break;
	 
	  case "212";
	  $mostra3 = "ORÇAMENTO";
	  break;	 

	  case "121";
	  $mostra3 = 'NEGOCIO';
	  break;
	 
      case "221";
	  $mostra3 = 'NEGOCIO';
	  break;

	  case "122";
	  $mostra3 = 'FAMILIA';
	  break;	 
	 
	  case "222";
	  $mostra3 = 'FAMILIA';
	  break;	 
	 
     }
	  
   //  echo "<BR>";

  	 echo "<BR>";
  	 echo "<BR>";	 
	 echo $mostra1;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra2;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra3;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 
	    $sql = "select id, seq, anterior, valor, descricao, nivel, fim 
               from perguntas 
			   where nivel=4 
			   and anterior>=$nivel3*10+1 
			   and anterior<=$nivel3*10+9
			   ORDER BY seq";

    $resultado = mysql_query($sql); 
	 
    echo "  
     <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>   
	   <SELECT name='nivel4'>

	     ";
	   
	   while ($linha = mysql_fetch_array($resultado)) //for($i=0; $i<5; $i++)
       {
	    echo "<option value='$linha[anterior]'>$linha[descricao]</option>";
	   }
	echo "</SELECT>
          <BR>	 
		  	<INPUT TYPE=hidden name=mostra1 value="; echo "$mostra1"; echo ">
            <INPUT TYPE=hidden name=mostra2 value="; echo "$mostra2"; echo "> 
            <INPUT TYPE=hidden name=mostra3 value="; echo "$mostra3"; echo "> 
            <BR>
	      <INPUT TYPE='submit' name=BOTAO_4 value='ENVIAR'/>
	      </FORM>
		  ";	 
	}
  
  
  
  // QUINTA OPCAO
   if (isset($_POST['BOTAO_4']))
    {   
	 $nivel4 = $_POST['nivel4'];
	 $mostra1 = $_POST['mostra1']; 
	 $mostra2 = $_POST['mostra2']; 
	 $mostra3 = $_POST['mostra3']; 

     $nivelanterior = $_POST['nivel4'];	 
	 
  	 echo "<BR>";
  	 echo "<BR>";	 
	 echo $mostra1;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra2;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra3;
  	 echo "<BR>";
  	 echo "<BR>";

	 // SELECIONA A DESCRICAO COM O VALOR ANTERIOR
	 $sql = "SELECT descricao FROM perguntas WHERE anterior=$nivel4";
	 $resultado = mysql_query($sql);
	 
	 $linha = mysql_fetch_array($resultado);
	 
	 echo "$linha[descricao]";
     $mostra4 = "$linha[descricao]";
	
	    $sql = "select id, seq, anterior, valor, descricao, nivel, fim 
               from perguntas 
			   where nivel=5 
			   and anterior>=$nivel4*10+1 
			   and anterior<=$nivel4*10+9
			   ORDER BY seq";


	
	     $resultado = mysql_query($sql); 

  	 echo "<BR>";
  	 echo "<BR>";
		 
    echo "  
     <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>   
	   <SELECT name='nivel5'>
       <option >@ NOVO ITEM</option> 
	     ";
	   
	   while ($linha = mysql_fetch_array($resultado)) //for($i=0; $i<5; $i++)
       {
	    echo "<option value='$linha[anterior]'>$linha[descricao]</option>";
	   }
	echo "</SELECT>
          <BR>	 
		  	<INPUT TYPE=hidden name=mostra1 value="; echo "$mostra1"; echo ">
            <INPUT TYPE=hidden name=mostra2 value="; echo "$mostra2"; echo ">
            <INPUT TYPE=hidden name=mostra3 value="; echo "$mostra3"; echo "> 
            <INPUT TYPE=hidden name=mostra4 value="; echo "$mostra4"; echo "> 	
            <INPUT TYPE=hidden name=nivelanterior value="; echo "$nivelanterior"; echo "> 			
   		    <BR> 
	      <INPUT TYPE='submit' name=BOTAO_5 value='ENVIAR'/>
	      </FORM>
		  ";	
    }
  
  
  
  
  
    // SE ESCOLHEU NOVO, ABRE OPCAO PARA DIGITAR
	// NO NIVEL 5
	// SENAO, VAI PARA O NIVEL 6
   if (isset($_POST['BOTAO_5']))
    {   
	 $nivel5 = $_POST['nivel5'];
	 
	 $mostra1 = $_POST['mostra1']; 
	 $mostra2 = $_POST['mostra2']; 
	 $mostra3 = $_POST['mostra3']; 	 
	 $mostra4 = $_POST['mostra4'];

	 $nivelanterior = $_POST['nivelanterior'];
	 
  	 echo "<BR>";
  	 echo "<BR>";	 
	 echo $mostra1;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra2;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra3;
  	 echo "<BR>";
  	 echo "<BR>";
	 echo $mostra4;
  	 echo "<BR>";
  	 echo "<BR>";	 
	 
	 // SE "@ NOVO ITEM" ABRE CAMPO PRA DIGITAR
	 if ($nivel5 == '@ NOVO ITEM') 
	  {
  	   echo "
	     <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>
		  <TABLE>
		   <TR>
		    <TD>PERGUNTA</TD><TD><INPUT TYPE='text' SIZE=30 NAME='descricao' maxlength=30 required pattern='[A-Z| |0-9]*'></TD>
		   </TR>
		    <TD>CONTA CAIXA</TD><TD><INPUT TYPE='text' SIZE=30 NAME='nomecontacaixa' maxlength=30 required pattern='[A-Z| |0-9]*'></TD>
		   </TR>
		  </TABLE>
		  <BR>
          <INPUT TYPE=hidden name=nivelanterior value="; echo "$nivelanterior"; echo "> 		  
          <INPUT TYPE='submit' name=BOTAO_N value='CADASTRAR'>
         </FORM>";
	  }
     else
	  {
	    // SEXTA OPCAO
	    // --------------------------------------------------------------
	    if (isset($_POST['BOTAO_5']))
         {   

		  //$mostra5 = $_POST['mostra5'];	
     $nivelanterior = $_POST['nivel5'];

	      // SELECIONA A DESCRICAO COM O VALOR ANTERIOR
	      $sql = "SELECT descricao FROM perguntas WHERE anterior=$nivel5";
	      $resultado = mysql_query($sql);
	 
	      $linha = mysql_fetch_array($resultado);
	 
	      echo "$linha[descricao]";
          $mostra5 = "$linha[descricao]";
	
	      $sql = "select id, seq, anterior, valor, descricao, nivel, fim 
               from perguntas 
			   where nivel=6 
			   and anterior>=$nivel5*10+1 
			   and anterior<=$nivel5*10+9
			   ORDER BY seq";


	
	      $resultado = mysql_query($sql); 

  	       echo "<BR>";
  	       echo "<BR>";
		 
           echo "  
            <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>   
	        <SELECT name='nivel6'>
            <option >@ NOVO ITEM</option> 
	        ";
	   
	       while ($linha = mysql_fetch_array($resultado)) //for($i=0; $i<5; $i++)
            {
	         echo "<option value='$linha[anterior]'>$linha[descricao]</option>";
	        }
	       
		   echo "</SELECT>
           <BR>	 
		  	 <INPUT TYPE=hidden name=mostra1 value="; echo "$mostra1"; echo ">
             <INPUT TYPE=hidden name=mostra2 value="; echo "$mostra2"; echo ">
             <INPUT TYPE=hidden name=mostra3 value="; echo "$mostra3"; echo "> 
             <INPUT TYPE=hidden name=mostra4 value="; echo "$mostra4"; echo "> 	
             <INPUT TYPE=hidden name=mostra5 value="; echo "$mostra5"; echo "> 				 
             <INPUT TYPE=hidden name=nivelanterior value="; echo "$nivelanterior"; echo "> 			
   		     <BR> 
	       <INPUT TYPE='submit' name=BOTAO_6 value='ENVIAR'/>
	       </FORM>
		   ";
		  //==========================================================
	     }
      }
    }
	
	
// SENAO, VAI PARA O NIVEL 7
   if (isset($_POST['BOTAO_6']))
    {   
	 $nivel6 = $_POST['nivel6'];
	 
	 $mostra1 = $_POST['mostra1']; 
	 $mostra2 = $_POST['mostra2']; 
	 $mostra3 = $_POST['mostra3']; 	 
	 $mostra4 = $_POST['mostra4'];
	 $mostra5 = $_POST['mostra5'];	 

	 $nivelanterior = $_POST['nivelanterior'];
	 
  	 echo "<BR>";
  	 echo "<BR>";	 
	 echo $mostra1;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra2;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra3;
  	 echo "<BR>";
  	 echo "<BR>";
	 echo $mostra4;
  	 echo "<BR>";
  	 echo "<BR>";
	 echo "$mostra5";
  	 echo "<BR>";
  	 echo "<BR>";	 
	 
	 // SE "@ NOVO ITEM" ABRE CAMPO PRA DIGITAR
	 if ($nivel6 == '@ NOVO ITEM') 
	  {
  	   echo "
	     <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>
		  <TABLE>
		   <TR>
		    <TD>PERGUNTA</TD><TD><INPUT TYPE='text' SIZE=30 NAME='descricao' maxlength=30 required pattern='[A-Z| ]*'></TD>
		   </TR>
		    <TD>CONTA CAIXA</TD><TD><INPUT TYPE='text' SIZE=30 NAME='nomecontacaixa' maxlength=30 required pattern='[A-Z| ]*'></TD>
		   </TR>
		  </TABLE>
		  <BR>
          <INPUT TYPE=hidden name=nivelanterior value="; echo "$nivelanterior"; echo "> 		  
          <INPUT TYPE='submit' name=BOTAO_N value='CADASTRAR'>
         </FORM>";
	  }
     else
	  {
	    // SETIMA OPCAO
	    // --------------------------------------------------------------
	    if (isset($_POST['BOTAO_6']))
         {   
     $nivelanterior = $_POST['nivel6'];
	      // SELECIONA A DESCRICAO COM O VALOR ANTERIOR
	      $sql = "SELECT descricao FROM perguntas WHERE anterior=$nivel6";
	      $resultado = mysql_query($sql);
	 
	      $linha = mysql_fetch_array($resultado);
	 
	      echo "$linha[descricao]";
          $mostra6 = "$linha[descricao]";
	
	      $sql = "select id, seq, anterior, valor, descricao, nivel, fim 
               from perguntas 
			   where nivel=7 
			   and anterior>=$nivel6*10+1 
			   and anterior<=$nivel6*10+9
			   ORDER BY seq";


	
	      $resultado = mysql_query($sql); 

  	       echo "<BR>";
		 
           echo "  
            <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>   


	        ";
	   
       
		   echo "
           <BR>	 
		  	 <INPUT TYPE=hidden name=mostra1 value="; echo "$mostra1"; echo ">
             <INPUT TYPE=hidden name=mostra2 value="; echo "$mostra2"; echo ">
             <INPUT TYPE=hidden name=mostra3 value="; echo "$mostra3"; echo "> 
             <INPUT TYPE=hidden name=mostra4 value="; echo "$mostra4"; echo "> 	
             <INPUT TYPE=hidden name=mostra5 value="; echo "$mostra5"; echo "> 	
             <INPUT TYPE=hidden name=mostra6 value="; echo "$mostra6"; echo ">
		  <TABLE>
		   <TR>
		    <TD>PERGUNTA</TD><TD><INPUT TYPE='text' SIZE=30 NAME='descricao' maxlength=30 required pattern='[A-Z| ]*'></TD>
		   </TR>
		    <TD>CONTA CAIXA</TD><TD><INPUT TYPE='text' SIZE=30 NAME='nomecontacaixa' maxlength=30 required pattern='[A-Z| ]*'></TD>
		   </TR>
		  </TABLE>
             <INPUT TYPE=hidden name=nivelanterior value="; echo "$nivelanterior"; echo "> 			
   		     <BR> 
   		     <BR> 			 
	       <INPUT TYPE='submit' name=BOTAO_N value='CADASTRAR'/>
	       </FORM>
		   ";
	     }
      }
    }	
	
	
// TESTA SE ESTAR NO NIVEL 7
// SENAO, VAI PARA O NIVEL 7
   if (isset($_POST['BOTAO_7']))
    {   

	 
	 $mostra1 = $_POST['mostra1']; 
	 $mostra2 = $_POST['mostra2']; 
	 $mostra3 = $_POST['mostra3']; 	 
	 $mostra4 = $_POST['mostra4'];
	 $mostra5 = $_POST['mostra5'];
	 $mostra6 = $_POST['mostra6'];		 

	 $nivelanterior = $_POST['nivelanterior'];
	 
  	 echo "<BR>";
  	 echo "<BR>";	 
	 echo $mostra1;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra2;
  	 echo "<BR>";
  	 echo "<BR>";	 	 
	 echo $mostra3;
  	 echo "<BR>";
  	 echo "<BR>";
	 echo $mostra4;
  	 echo "<BR>";
  	 echo "<BR>";
	 echo "$mostra5";
  	 echo "<BR>";
  	 echo "<BR>";
	 echo "$mostra6";
  	 echo "<BR>";	
  	 echo "<BR>";
	 
	 

  	   echo "
	     <FORM METHOD=POST ACTION='cadastrocontacaixa.php'>
		  <INPUT TYPE='text' SIZE=30 NAME='descricao' maxlength=30 required pattern='[A-Z| ]*'>
          <INPUT TYPE=hidden name=nivelanterior value="; echo "$nivelanterior"; echo "> 		  
          <BR> 
		  <INPUT TYPE='submit' name=BOTAO_N value='CADASTRAR'>
         </FORM>

	        ";
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
  
  
     // DIGITOU A DESCRICAO NO NOVO ITEM - CADASTRAR CONTA CAIXA
     if (isset($_POST['BOTAO_N']))
      { 
       $nivelanterior = $_POST['nivelanterior'];
	   $descricao = $_POST['descricao'];
       $nomecontacaixa = $_POST['nomecontacaixa'];
	   
       $valor = strlen($nivelanterior) + 1;
	   
	   $sql_select = "SELECT seq 
	            FROM perguntas 
				WHERE anterior>=$nivelanterior*10+1 
				AND anterior<=$nivelanterior*10+9";
	   
	   $resultado = mysql_query($sql_select);	
	
	   $i = 1;
	   $flag = array(1=>1, 2=>1, 3=>1, 4=>1, 5=>1, 6=>1, 7=>1, 8=>1, 9=>1);
	   while ($linha = mysql_fetch_array($resultado)) 
	    {
		 $flag[$linha['seq']] = 0;
	     $i++;
		}
		
	   if ($i > 9) exit;
	
	   for ($b = 1; $b < 10; $b++)
	    {
		 if ($flag[$b] == 1)
		 {
		  $i = $b;
          break;
		 }
		}



	   
 
	   
	   $tamtotal = 1;
	   for ($a = 0; $a < 7 - $valor; $a++)
	    $tamtotal *= 10;

	   
	   $sql_update_perguntas = "UPDATE perguntas 
	                   SET fim='N' 
				       WHERE anterior=$nivelanterior";	   
	   
	   $sql_insert_perguntas = "INSERT INTO perguntas 
	            VALUES ('', $i, $nivelanterior*10+$i, 
				        ($nivelanterior*10+$i)*$tamtotal, '$descricao', 
						$valor, 'S')";
						
       $sql_insert_cntcx = "INSERT INTO conta_caixa 
                             VALUES ('', ($nivelanterior*10+$i)*$tamtotal, '$nomecontacaixa')";

       $resultado = mysql_query($sql_insert_cntcx);							 
							 
       $resultado = mysql_query($sql_update_perguntas);
  	   
	   $resultado = mysql_query($sql_insert_perguntas);
  
       
	   $contacaixa =  ($nivelanterior*10+$i)*$tamtotal;
	   echo "<BR>";
	   echo "CONTA CAIXA $contacaixa $nomecontacaixa INCLUIDO!!!";
  	   header("location:cadastrocontacaixa.php");
      }
  
  


?>
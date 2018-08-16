<?php

echo "<title>LANCAMENTO EXTRATO</title>";

require_once("../config/bancodados.class.php");
require_once("../config/bbpessoajurica.class.php");
require_once("../config/bbpessoafisica.class.php");
require_once("../config/poup_bb_pfisica.class.php");
require_once("../config/ItauPessoaFisica.class.php");
require_once("../config/cartaovisa.class.php");
require_once("../config/cartaoitau.class.php");
require_once("../config/bradpessoafisica.class.php");
require_once("../config/santander.class.php");
require_once("../config/datavalida.php");
require_once("../config/cobranca.class.php");
require_once("../config/cefcc.class.php");
require_once("../config/bradcartao.class.php");
require_once("../config/santanderpj.class.php");
require_once("../config/santanderCob.class.php");
require_once("../config/itauCob.class.php");

// OBJETO EXTRATO
// CONEXAO COM O BANCO
// SELECT TODAS AS CONTAS CADASTRADAS
// RETORNO DAS CONTAS CADASTRADAS 
// RETORNO DE NUMERO DE CONTAS CADASTRADAS
$extratos = new Banco;
$conexao = $extratos->conexao();
$sql = 'SELECT id, id_tconta, numero_conta, descricao, obs FROM conta_corrente';
$resultado = $extratos->query($sql);
$numlinhas = $extratos->afect_rows($resultado);

// QUANTIDADE DE CONTAS CADASTRADAS
for ($i=0; $i<$numlinhas; $i++)
 {
  $linha = $extratos->fetch_array($resultado);

  $id_conta = $linha[0];
  $tipo_conta = $linha[1];
  $numero_conta = $linha[2];
  $nome_conta = $linha[3];
  $obs_conta = $linha[4];
  
// EXECUTA O TIPO DA CONTA
  switch ($tipo_conta) {
    case 1:
	    $bbpesjur = new BbPesJur();
        $bbpesjur->filetipo($id_conta, $obs_conta);
        break;
    case 2:
	    $bbpesfis = new BbPesFis();
        $bbpesfis->filetipo($id_conta, $obs_conta);	
        break;
    case 3:
	    $ppbbpesfis = new BbPoupPesFis();
        $ppbbpesfis->filetipo($id_conta, $obs_conta);	
        break;
    case 4:
	    $itaupesfis = new ItauPessoaFisica();
        $itaupesfis->filetipo($id_conta, $obs_conta);		
        break;
    case 5:
	    $bradpesfis = new BradPessoaFisica();
        $bradpesfis->filetipo($id_conta, $obs_conta);
        break;
    case 6:
        // CAIXA
        break;
    case 7:
	    // CARTAO VISA/MASTER BB
		$cartaovisa = new CartaoVisa();
        //$cartaovisa->filetipo($id_conta, $obs_conta);
        break;		
    case 8:
		$cartaoitau = new CartaoItau();
        //$cartaoitau->filetipo($id_conta, $obs_conta);    
        break;
    case 9:
		$santpf = new Santander();
        $santpf->filetipo($id_conta, $obs_conta);    
        break;
    case 10:
		$cefcc = new CefCc();
        $cefcc->filetipo($id_conta, $obs_conta);    
        break;		
    case 11:
		$brdcrt = new BrdCrt();
        $brdcrt->filetipo($id_conta, $obs_conta);    
        break;	
	case 12:
		$santpj = new SantanderPj();
        $santpj->filetipo($id_conta, $obs_conta);    
        break;	
	case 13:
		$santCob = new SantanderCob();
		$santCob->filetipo($id_conta, $obs_conta);    
        break;	
	case 14:
		$itauCob = new ItauCob();
		$itauCob->filetipo($id_conta, $obs_conta);    
        break;			
}  


 

  
  }
 
 
		$cob = new Cob();
        $cob->filetipo(17, 'COBRANCA');  
 
  echo "<script> alert('PRONTO!!!')</script>";
  echo "<script> window.close()</script>";
  
  

	 









	 //$file = fopen('c:\EXTRATOS\BBS\BANCO_DADOS.txt', 'r');







?>
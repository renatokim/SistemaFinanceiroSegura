<!DOCTYPE html>

<html lang="en">
<head>
<link href="menu_assets/styles.css" rel="stylesheet" type="text/css">	
</head>
<body align="center" bgcolor="">
<img src="top.jpg">
<!-- <img src="logo.png"> -->
<div id='cssmenu'>
<ul>

   <li class='has-sub '><a href='#'><span>DINHEIRO</span></a>
      <ul>
         <li class='has-sub '><a href='../caixa/caixa_data.php' TARGET='_BLACK'><span>LISTAR</span></a></li>
		<!--  <li class='has-sub '><a href='../caixa/caixa_incluir.php' TARGET='_BLACK'><span>INCLUIR</span></a></li> -->
  <!--       <li class='has-sub '><a href='../caixa/caixa.php' TARGET='_BLACK'><span>INCLUIR</span></a></li>		 -->
  <!--       <li class='has-sub '><a href='#'><span>Incluir</span></a>
            <ul>
               <li><a href='#'><span>Sub Product</span></a></li>
               <li><a href='#'><span>Sub Product</span></a></li>
            </ul>
         </li> -->
      </ul>
   </li>
   
   <li class='has-sub '><a href='#'><span>CHEQUE</span></a>
      <ul>
         <li class='has-sub '><a href='#'><span>EMITIDOS</span></a>
            <ul>
               <!-- <li><a href='#'><span>Por Data Emiss�o</span></a></li> -->
               <li><a href='' onclick="window.open('../cheque/cheque_data.php?tipo_relatorio=cheque_relatorio_data',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
     " style='text-decoration:none'><span>Por Data</span></a></li>
               <li><a href='' onclick="window.open('../cheque/cheque_data.php?tipo_relatorio=cheque_relatorio_numero',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
	   " style='text-decoration:none'><span>Por N� Cheque</span></a></li>	
               <li><a href='' onclick="window.open('../cheque/cheque_relatorio_pendente.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
     " style='text-decoration:none'><span>Por Cheque Pendente</span></a></li>				   
            </ul>
         </li>
    
	     <li class='has-sub '><a href='#'><span>RECEBIDOS</span></a>
	              <ul>
               <li><a href='' onclick="window.open('../codeigniter',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
     " style='text-decoration:none'><span>Incluir</span></a></li>
               <li><a href='' onclick="window.open('../codeigniter/chq_recebidos/read',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
	   " style='text-decoration:none'><span>Manter</span></a></li>	

             </ul>
	  
	  
	  
	  </li>
	
      </ul>
    </li> 

   <li class='has-sub '><a href='#'><span>CART�O CR�DITO</span></a>
      <ul>
         <li class='has-sub '><a href='' onclick="window.open('../extratos/cartao.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
     " style='text-decoration:none'><span>IMPORTAR</span></a></li>
		 <li class='has-sub '><a href='#'><span>EXCLUIR DATA</span></a></li>		 
      </ul>
   </li>

   <li class='has-sub '><a href='#'><span>EXTRATOS</span></a>
      <ul>
         <li class='has-sub '><a href='' onclick="window.open('../extratos/extratos.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
     " style='text-decoration:none'><span>IMPORTAR</span></a></li>
		 <li class='has-sub '><a href='#'><span>EXCLUIR DATA</span></a></li>	
         <li class='has-sub '><a href='../extratos/addsaldoinicial.php' TARGET='_BLACK'><span>SALDO INICIAL</span></a></li>		 
      </ul>
   </li>
	
   <li class='has-sub '><a href='#'><span>IDENTIFICA��O</span></a>
      <ul>
     <li class='has-sub '><a href='../relatorios/data_do_relatorio.php?tipo_relatorio=relatoriodata' TARGET='_BLACK'><span>POR DATA</span></a></li>	
     <li class='has-sub '><a href='../relatorios/data_do_relatorio.php?tipo_relatorio=relatbanco' TARGET='_BLACK'><span>POR BANCO</span></a></li>
     <li class='has-sub '><a href='../relatorios/data_do_relatorio.php?tipo_relatorio=relatcntcx' TARGET='_BLACK'><span>POR CONTA-CAIXA</span></a></li>	 
      </ul>
    </li>   
   
   <li class='has-sub '><a href='#'><span>DRE</span></a>
      <ul>
         <li class='has-sub '><a href='../relatorios/relatcntcxgroupby.php' TARGET='_BLACK'><span>RESUMO CONTA-CAIXA</span></a>
		 <li class='has-sub '><a href=''><span>AJUSTES</span></a>
                    <ul>
               <!-- <li><a href='#'><span>Por Data Emiss�o</span></a></li> -->
               <li><a href='../relatorios/relat_cad_ajustes.php' TARGET='_BLACK'><span>Cadastro</span></a></li>
               <li><a href='../ajustes/lancar_ajustes.php' TARGET='_BLACK'><span>Lan�ar</span></a></li>
               <li><a href='../ajustes/data_ajust_lanc.php' TARGET='_BLACK'><span>Editar</span></a></li>                 
            </ul>
         </li>
     <li class='has-sub '><a href='' onclick="window.open('../dre/groupby_cx.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=YES,width=1300,height=900, top=50, left=50')
     " style='text-decoration:none'><span>EVENTUAL/MENSAL</span></a>
     <!-- <li class='has-sub '><a href='' onclick="window.open('../relatorios/final.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=1000, top=100, left=300')
     " style='text-decoration:none'><span>MENSAL</span></a> -->
		 <li class='has-sub '><a href='#'><span>RELAT�RIOS</span></a>
        <ul>
           <li><a href=''><span>DRE Pessoa Jur�dica</span></a>
              <ul>
                 <li><a href=''><span>M�s</span></a></li>
                 <li><a href=''><span>Per�odo</span></a></li> 
              </ul>
           </li>
           <li><a href=''><span>DRE Pessoa F�sica</span></a></li> 
        </ul>
    </li>
		 <li class='has-sub '><a href='' onclick="window.open('../dre/grafico.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
     " style='text-decoration:none'><span>GR�FICOS</span></a>
            <!-- <ul>
               <li><a href='#'><span>Lista Totais</span></a></li>
               <li><a href='#'><span>?</span></a></li>
               <li><a href='#'><span>?</span></a></li>	
               <li><a href='#'><span>?</span></a>
					<ul>
						<li><a href='#'><span>Lista Totais</span></a></li>
						<li><a href='#'><span>?</span></a></li>
					</ul>
			   </li>				   
            </ul> -->
         </li>
    <!-- <li class='has-sub '><a href='' onclick="window.open('../relatorios/final.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=1000,height=700, top=100, left=300')
     " style='text-decoration:none'><span>EVENTUAL MENSAL</span></a>         
        <!--  <li class='has-sub '><a href='#'><span>ACUMULADO</span></a> 
            <ul>
               <li><a href='#'><span>Por Data Emiss�o</span></a></li>
               <li><a href='#'><span>Por Data Vencimento</span></a>
					<ul>
						<li><a href='#'><span>Lista Totais</span></a></li>
						<li><a href='#'><span>?</span></a></li>
					</ul>			   
			   </li>
				   
            </ul>
         </li>	-->	 
      </ul>
    </li>  
 
 <li class='has-sub '><a href='#'><span>CADASTRO</span></a>
      <ul>
         <li class='has-sub '><a href='#'><span>CONTA BANC�RIA</span></a>
            <ul>
			   <li><a href='' onclick="window.open('../relatorios/relatorioconta.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
	   " style='text-decoration:none'><span>Listar</span></a></li>
               <li><a href='' onclick="window.open('../cadastro/cadastro.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
	   " style='text-decoration:none'><span>Incluir</span></a></li>
               <li><a href='#'><span>Alterar</span></a></li>
               <li><a href='#'><span>Excluir</span></a></li>	
            </ul>
         </li>

         <li class='has-sub '><a href='#'><span>CONTA-CAIXA</span></a>
            <ul>
               <li><a href='' onclick="window.open('../relatorios/relatcadcontacaixa.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
	   " style='text-decoration:none'><span>Listar</span></a></li>
               <li><a href='' onclick="window.open('../cadastro/cadastrocontacaixa.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
     " style='text-decoration:none'>Incluir</span></a></li>	 
     <li><a href='' onclick="window.open('../contacaixa/set_conta_caixa.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
     " style='text-decoration:none'>Editar</span></a></li>   
            </ul>
         </li>	

         <li class='has-sub '><a href='#'><span>GRAFICOS</span></a>
            <ul>
               <li><a href='' onclick="window.open('../cadastro/cadastro_graficos.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
	   " style='text-decoration:none'><span>Incluir</span></a></li>
               <li><a href='' onclick="window.open('../cadastro/lista_graficos.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
     " style='text-decoration:none'>Listar</span></a></li>	 
                 </ul>
         </li>	 
         <li class='has-sub '><a href='#'><span>GRUPOS</span></a>
            <ul>
               <li><a href='' onclick="window.open('../cadastro/cadastro_grupo.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
	   " style='text-decoration:none'><span>Incluir</span></a></li>
               <li><a href='' onclick="window.open('../cadastro/lista_grupos.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=500, top=100, left=300')
     " style='text-decoration:none'>Listar</span></a></li>	 
                 </ul>
         </li>	 
		 
      </ul>
    </li>

	<li class='has-sub '><a href="../manutencao/manutencao.php" TARGET='_BLACK'><span>MANUTEN��O</span></a>
     <!--  <ul>
     <li class='has-sub '><a href='' onclick="window.open('../manutencao/backup.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
	   " style='text-decoration:none'><span>BACKUP</span></a></li>	
     <li class='has-sub '><a href="../manutencao/manutencao.php" TARGET='_BLACK'><span>MANUTEN��O</span></a></li>		 
      </ul> -->
    </li>	
  
</ul>
</div>

<div style="position:absolute;  width: 1319px;  height: 200px; top:120px; left:1;">



<table align="right" style="position:absolute;  width: 1319px;  height: 200px; top:120px; left:1;">
<tr>
	<td>INCLUIR NO CAIXA</td>
	<td>INCLUIR CHEQUE</td>
	<td>IMPORTAR CART�O</td>	
	<td>IMPORTAR EXTRATO</td>	
	<td>BACKUP</td>
</tr>
<tr>
	<td><a href='../caixa/caixa_incluir.php' TARGET='_BLACK'><img style="top:100px ; left:1;  width: 200px;" src="cifrao.jpg" ></a></td>
	<td><a href='../cheque/cheque_incluir.php' TARGET='_BLACK'><img style="top:100px ; left:1;  width: 200px;" src="cheque.jpg" ></a></td>
	<td><a href='' onclick="window.open('../extratos/cartao.php',
     'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
     " style='text-decoration:none'><img style="top:100px ; left:1;  width: 200px;" src="cartao.jpg" ></a></td>
	<td><a href='' onclick="window.open('../extratos/extratos.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
	   " style='text-decoration:none'><img style="top:100px ; left:1;  width: 150px;" src="extrato.jpeg" ></a></td>	
	<td><a href='' onclick="window.open('../manutencao/backup.php',
	   'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=300, top=100, left=300')
	   " style='text-decoration:none'><img style="top:100px ; left:1;  width: 200px;" src="backup.png" ></a></td>	
</tr>
</table>

</div>



<img style="display:box; position:absolute; top:10px ; left:1;" src="logo.png" >

 <strong size="20" align="center" style="font-size: 25px; color:#FFF; position:absolute; top:20px ; left:750px;">SISTEMA FINANCEIRO <br><font >2013</font></strong>

</body>
 
</html>	
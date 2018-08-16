<?php
/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @version 0.2b
 */

//
// Database `catalogo_de_produtos`
//

// `catalogo_de_produtos`.`mg`
$mg = array(
  array('id' => '60369','cidade' => 'Patos de Minas','logradouro' => 'Zeca Filgueira','bairro' => 'Nossa Senhora das Graças','cep' => '38701-264','tp_logradouro' => 'Rua'),
array('id' => '60497','cidade' => 'Contagem','logradouro' => 'Zurick','bairro' => 'Santa Cruz Industrial','cep' => '32340-420','tp_logradouro' => 'Rua'),
  array('id' => '60498','cidade' => 'Contagem','logradouro' => 'Zurique','bairro' => 'Europa','cep' => '32043-030','tp_logradouro' => 'Rua'),
  array('id' => '60499','cidade' => 'Montes Claros','logradouro' => 'Zuza Engraxate','bairro' => 'Dona Gregória','cep' => '39403-049','tp_logradouro' => 'Rua'),
  array('id' => '60500','cidade' => 'Belo Horizonte','logradouro' => 'Zuzu Angel','bairro' => 'Belvedere','cep' => '30320-460','tp_logradouro' => 'Rua'),
  array('id' => '60501','cidade' => 'Santa Luzia','logradouro' => 'ZZ','bairro' => 'Frimisa','cep' => '33045-790','tp_logradouro' => 'Rua')
);

require_once('../config/relatorios.class.php');

$relatorio = new Relatorio;
$relatorio->conexao();


foreach ($mg as $cep)
{
 $cep_antigo = $cep['cep'];
 $cep_novo = str_replace('-', '', $cep['cep']); 
 
 $link = mysql_connect('localhost', 'root', '');
 mysql_select_db('catalogo_de_produtos ');
 

 
 $sql = "update mg 
 set cep='$cep_novo' 
 where cep='$cep_antigo'";


 
$result = $relatorio->query($sql);




}
echo 'aaaaaaaaa';
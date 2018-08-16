<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("example.xls");
?>

<?php 
echo '<pre>';

//var_dump($data->sheets[0]["cells"]);  


for($i = 6; $i <= count($data->sheets[0]["cells"]); $i++)
{
	//var_dump($data->sheets[0]["cells"][$i]); 
	
	$valor = $data->sheets[0]["cells"][$i][5];
	echo $valor; echo '<br>';
	
	
}



 ?>


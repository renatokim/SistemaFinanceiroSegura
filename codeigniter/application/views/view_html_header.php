<?php
echo doctype('html5');
echo "<html>";
echo "<head>";
echo "<title>Cheques</title>";
	echo meta('Content-type', 'text/html; charset=utf-8', 'equiv');
	$meta = array(
	    array('name' => 'robots', 'content' => 'no-cache'),
	    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
	);
	echo meta($meta); 	
		
	echo link_tag(array('href' => 'assets/css/bootstrap.css','rel' => 'stylesheet','type' => 'text/css'));	
echo "</head>";
echo "<body>";
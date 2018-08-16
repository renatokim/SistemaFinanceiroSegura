<?php

	$arquivo = fopen ("ler.pdf", "r");
	$conteudo = fgets ($arquivo, 5000); 
	var_dump($conteudo);

?>
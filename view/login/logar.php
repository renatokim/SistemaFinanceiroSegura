<?php

session_start(); 

$login = $_POST['login'];
$senha = $_POST['senha'];
$botao = $_POST['btn'];



if($login == 'segura' && $senha == 'admin' && $botao == 'botao')
{
	$_SESSION['logado'] = true;
	header("location:../index.php");
}
else
{
	header("location:/");
}








?>
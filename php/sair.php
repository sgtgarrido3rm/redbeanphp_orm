<?php
require_once('../inc/config.php');

$_SESSION['login'] = 9;
$_SESSION['logado'] = false;

//Redireciona para a página de login
header("location: ../index.php");
?>
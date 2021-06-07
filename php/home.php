<?php
require_once('../inc/config.php');
require_once('mensagens.php');
require_once(CAMINHO_INCLUDE . 'Classe.Garrido.php'); //Classe que separa o html do php

if(!$_SESSION['logado']){
	$_SESSION['login'] = 1;
	header("location: ".DOMINIO."index.php");
}

$tpl = new Classe_Garrido('../htm/home.htm');
$tpl->atribuirInclude('_Cabecalho','../htm/_Cabecalho.htm');
$tpl->atribuirInclude('_Navbar','../htm/_Navbar.htm');
$tpl->atribuirInclude('_Rodape','../htm/_Rodape.htm');

$tpl->preparar();

###########################
## Manipulação de dados  ##
//Seleciona os dados do usuário consultando por ID obtido pelo dado gravado em sessão

$rsUsuarios = R::getAll( 'select * from usuarios');

foreach ($rsUsuarios as $usuarios){
	$UsuarioID	= $usuarios['id'];
	$Usuario	= $usuarios['usuario'];
	$Email		= $usuarios['email'];
	$Senha		= $usuarios['senha'];

	$tpl->novoBloco('usuarios');
	$tpl->atribuir('uid', $UsuarioID);
	$tpl->atribuir('uusuario', $Usuario);
	$tpl->atribuir('uemail', $Email);
	$tpl->atribuir('usenha', $Senha);
}

if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
	$tpl->atribuir('_RAIZ.sucessoCadastro', $_SESSION['success']);
	$tpl->atribuir('_RAIZ.block_none', 'block');
	$_SESSION['success'] = '';
}else{
	$_SESSION['success'] = '';
	$tpl->atribuir('_RAIZ.block_none', 'none');
}

$usuario = R::load( 'usuarios', $_SESSION["idUsuario"]);

$tpl->atribuir('_RAIZ.titulo', TITULO);
$tpl->atribuir('_RAIZ.id',$usuario->id);
$tpl->atribuir('_RAIZ.usuario',$usuario->usuario);
$tpl->atribuir('_RAIZ.email',$usuario->email);

$tpl->atribuir('_RAIZ.titulo',TITULO);
//$tpl->atribuir('_RAIZ.titulo_formulario',TITULO_FORMULARIO);
$tpl->atribuir('_RAIZ.ano',ANO);
$tpl->gotoBlock('_RAIZ'); //Vai para o bloco raiz. Fora dos outros blocks.
###########################

$tpl->Debug(true);
$tpl->ExibeTela();
?>
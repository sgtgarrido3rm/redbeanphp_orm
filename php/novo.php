<?php
require_once('../inc/config.php');
require_once('mensagens.php');
require_once(CAMINHO_INCLUDE . 'Classe.Garrido.php'); //Classe que separa o html do php
//debugl($_SESSION);
if(!$_SESSION['logado']){
	$_SESSION['login'] = 1;
	header("location: ".DOMINIO."index.php");
}
  

$tpl = new Classe_Garrido('../htm/novo.htm');
$tpl->atribuirInclude('_Cabecalho','../htm/_Cabecalho.htm');
$tpl->atribuirInclude('_Navbar','../htm/_Navbar.htm');
$tpl->atribuirInclude('_Rodape','../htm/_Rodape.htm');

$tpl->preparar();

###########################
## Manipulação de dados  ##
//Seleciona os dados do usuário consultando por ID obtido pelo dado gravado em sessão
$usuario = R::load( 'usuarios', $_SESSION["idUsuario"]);

$tpl->atribuir('_RAIZ.titulo', TITULO);
$tpl->atribuir('_RAIZ.usuario',$usuario->usuario);
$tpl->atribuir('_RAIZ.foto', '../dist/img/user2-160x160.jpg');

$tpl->atribuir('_RAIZ.titulo',TITULO);
$tpl->atribuir('_RAIZ.ano',ANO);
$tpl->gotoBlock('_RAIZ'); //Vai para o bloco raiz. Fora dos outros blocks.
###########################

$tpl->Debug(true);
$tpl->ExibeTela();
?>
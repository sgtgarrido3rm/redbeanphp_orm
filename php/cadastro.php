<?php
require_once('../inc/config.php');
require_once('mensagens.php');
require_once(CAMINHO_INCLUDE . 'Classe.Garrido.php'); //Classe que separa o html do php

$tpl = new Classe_Garrido('../htm/cadastro.htm');
$tpl->atribuirInclude('_Cabecalho','../htm/_Cabecalho.htm');
$tpl->atribuirInclude('_Navbar','../htm/_Navbar.htm');
$tpl->atribuirInclude('_Rodape','../htm/_Rodape.htm');

$tpl->preparar();

###########################
## Manipulação de dados  ##
//Seleciona os dados do usuário consultando por ID obtido pelo dado gravado em sessão

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
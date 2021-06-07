<?php
require_once('inc/config.php');
require_once('php/mensagens.php');
require_once(CAMINHO_INCLUDE . 'Classe.Garrido.php'); //Classe que separa o html do php

$tpl = new Classe_Garrido('htm/login.htm');

$tpl->preparar();

//debugl($_SESSION['login']);
###########################
## Manipulação de dados  ##
if (isset($_SESSION['login']) && $_SESSION['login'] != '') {
	if ( $_SESSION['login'] == 1 ) {
		$tpl->atribuir('_RAIZ.display', 'style="display: block;"');
		$tpl->atribuir('_RAIZ.h5', 'Sucesso!');
		$tpl->atribuir('_RAIZ.texto', 'Você não está autorizado. Faça o login.');
		$tpl->atribuir('_RAIZ.alert', 'danger');

		$_SESSION['login'] = '';
	}
	
	if ( $_SESSION['login'] == 9 ) {
		$tpl->atribuir('_RAIZ.display', 'style="display: block;"');
		$tpl->atribuir('_RAIZ.h5', 'Sucesso!');
		$tpl->atribuir('_RAIZ.texto', 'Sua sessão foi encerrada com sucesso.');
		$tpl->atribuir('_RAIZ.alert', 'success');

		$_SESSION['login'] = '';
	}
	
	if ( $_SESSION['login'] == 4 ) {
		$tpl->atribuir('_RAIZ.display', 'style="display: block;"');		
		$tpl->atribuir('_RAIZ.h5', 'Erro!');
		$tpl->atribuir('_RAIZ.texto', 'Usuário/Senha inválido.');
		$tpl->atribuir('_RAIZ.alert', 'danger');

		$_SESSION['login'] = '';
	}
}else{
	$tpl->atribuir('_RAIZ.display', 'style="display: none;"');
	$tpl->atribuir('_RAIZ.display_erro', 'style="display: none;"');
}
$tpl->atribuir('_RAIZ.titulo',TITULO);
$tpl->gotoBlock('_RAIZ'); //Vai para o bloco raiz. Fora dos outros blocks.
###########################

$tpl->Debug(false);
$tpl->ExibeTela();
?>
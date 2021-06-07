<?php
require_once('../inc/config.php');
require_once('mensagens.php');
require_once('../inc/rb.php');

if (isset($_POST['acao'])) {
	$acao = $_POST['acao'];	
	switch ($acao) {
		case 'atualizar':
			if (isset($_POST['quero']) && $_POST['quero'] == 1) {
				$sql = "UPDATE usuarios SET usuario = '".$_POST['txtUsuario']."', email = '".$_POST['txtEmail']."', senha = '".$_POST['txtSenha']."' WHERE id = ".$_SESSION["idUsuario"];
				R::exec($sql);	

				header("<script>alert('Dados alterados com sucesso!')</script>");
				header("location: perfil.php");	
			}else{
				header("location: javascript:alert('Não foi possível alterar os dados!')");
				header("location: perfil.php");	
			}
		break;	

		case 'cadastrar':
			//Criando a tabela para o RedBeanPHP
			$usuario = R::dispense('usuarios');

			#Adicionando dados do formulário ao objeto
			$usuario->usuario 	= $_POST['txtUsuario'];
			$usuario->email 	= $_POST['txtEmail'];
			$usuario->senha 	= $_POST['txtSenha'];

			//Gravando os dados do objeto no banco de dados
			$id = R::store($usuario);

			$_SESSION["success"] = 'Usuário cadastrado com sucesso!';
			header("location: home.php");
		break;	

		case 'excluir':
			$usuario = R::findOne('usuarios', 'id = ?', array($_POST['id']));	
			//O método trash apaga a linha selecionada
			R::trash($usuario);

			return true; 
		break;	
	}
}

$user = R::findOne('usuarios', 'email = :email AND senha = :pass', [':email' => $_POST['email'], ':pass' => $_POST['senha']]);

if ($user->id != '') {
	$_SESSION['usuario'] 	= $user->usuario;
	$_SESSION['idUsuario'] 	= $user->id;
	$_SESSION['logado'] 	= true;		

	header("location: home.php");
}
?>
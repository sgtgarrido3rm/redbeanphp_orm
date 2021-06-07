<?php
	/**
	* Criado em 28/05/2021.
	* 
	* Arquivo de configuracao da aplicacao.
	* 
	* @author Luis Olavo GARRIDO (sgtgarrido3rm@gmail.com)
	* @version 0.0.1	
	*/
	@session_start();
	error_reporting(E_ALL);
	// @header("Content-type: text/html; charset=utf-8");

	/**
	 * Define o ano
	 *
	 * @name ANO
	 * ex = "aaaa"
	 */
	define("ANO",date('Y'));
		
	/**
	 * Define o tipo de banco de dados da aplicacao
	 *
	 * @name TIPO_BANCO
	 */	
	define("TIPO_BANCO","mysql");
	
	/**
	 * Define o titulo do projeto
	 *
	 * @name TITULO
	 */
	define("TITULO","MeuPortfólio");
	
	/**
	 * Define a mensagem de acesso negado
	 *
	 * @name MSG_ACESSO_NEGADO
	 */
	define("MSG_ACESSO_NEGADO",'Você não está autorizado. Faça o login');

	/**
	 * Define a mensagem de erro de conexao com o bd
	 *
	 * @name MSG_ACESSO_NEGADO_BD
	 */
	define("MSG_ACESSO_NEGADO_BD",'ERRO DE CONEXÃO. FAVOR CONTACTAR O ADMINISTRADOR');

	/**
	 * Define a mensagem de erro de gravação dos dados no bd
	 *
	 * @name MSG_ERRO_GRAVAR_BD
	 */
	define("MSG_ERRO_GRAVAR_BD",'ERRO AO GRAVAR OS DADOS. FAVOR CONTACTAR O ADMINISTRADOR');

	/**
	 * Define a mensagem de consulta vazia
	 *
	 * @name MSG_CONSULTA_VAZIA
	 */
	define("MSG_CONSULTA_VAZIA",'ESTA CONSULTA NÃO RETORNOU RESULTADO');

	/**
	 * Define a mensagem de usuario/senha inválido
	 *
	 * @name MSG_CONSULTA_VAZIA
	 */
	define("MSG_USUARIO_SENHA",'USUÁRIO/SENHA INVÁLIDO');

	/**
	 * Define a mensagem de dados gravados com sucesso
	 *
	 * @name MSG_SUCESSO
	 */
	define("MSG_SUCESSO",'DADOS GRAVADOS COM SUCESSO');

	/**
	 * Define a mensagem de dados atualizados com sucesso
	 *
	 * @name MSG_ATUALIZACAO_SUCESSO
	 */
	define("MSG_ATUALIZACAO_SUCESSO",'DADOS ATUALIZADOS COM SUCESSO');

	/**
	 * Define a mensagem de cpf inválido
	 *
	 * @name MSG_CPF_INVALIDO
	 */
	define("MSG_CPF_INVALIDO",'Usuário/senha inválidos');

/**
	 * Define a mensagem de logoff
	 *
	 * @name MSG_LOGOFF_SUCESSO
	 */
	define("MSG_LOGOFF_SUCESSO",'Logoff realizado com sucesso!');

	/**
	 * Define o e-mail do administrador
	 *
	 * @name EMAIL
	 */	
	define("EMAIL","sgtgarrido3rm@gmail.com");
	
	/**
	 * Define o asssunto do e-mail
	 *
	 * @name ASSUNTO
	 */

	define("ASSUNTO","MeuPortfólio - E-Mail do Sistema");
	
	/**
	 * Define o nome que aparecera no remetente dos e-mails
	 *
	 * @name NOME_EMAIL
	 */
	define("NOME_EMAIL","MeuPortfólio - E-mail Garrido");
	
	/**
	 * Define o caminho dos logs do sistema
	 *
	 * @name ARQUIVO_LOGS
	 */
	define("ARQUIVO_LOGS",$_SERVER['DOCUMENT_ROOT'].'/meuportfolio/logs/log_'.date('d-m-y').'.log');

	/**
	 * Define o dominio do site
	 *
	 * @name DOMINIO
	 */
	define("DOMINIO","http://".$_SERVER['HTTP_HOST']."/meuportfolio/");

	/**
	 * Define o caminho dos arquivos
	 *
	 * @name PATH
	 */
	define("PATH",$_SERVER['DOCUMENT_ROOT']."/meuportfolio/");
	
	/**
	 * Define o tipo de telefone para exibição
	 *
	 * @name TIPO_TELEFONE
	 */
	define("TIPO_TELEFONE","Coml");
	
	/**
	* DEFINIÇÃO DINÂMICA DA CONSTANTE DO DIRETÓRIO DAS CLASSES
	* 
	* @name CAMINHO_CLASSE
	*/
	if(is_dir("classe"))	
	{	
	 	define("CAMINHO_CLASSE","classe/");
	}
	elseif(is_dir("../classe"))
	{
	 	define("CAMINHO_CLASSE","../classe/");
	}
	elseif(is_dir("../../classe"))
	{
	 	define("CAMINHO_CLASSE","../../classe/");
	}elseif(is_dir("../../../classe"))
	{
	 	define("CAMINHO_CLASSE","../../../classe/");
	}

	/**
	* DEFINIÇÃO DINÂMICA DA CONSTANTE DO DIRETÓRIO DE INCLUDES
	* 
	* @name CAMINHO_INCLUDE
	*/
	if(is_dir("inc"))
	{	
	 	define("CAMINHO_INCLUDE","inc/");
	}
	elseif(is_dir("../inc"))
	{
	 	define("CAMINHO_INCLUDE","../inc/");
	}
	elseif(is_dir("../../inc"))
	{
	 	define("CAMINHO_INCLUDE","../../inc/");
	}elseif(is_dir("../../../inc"))
	{
	 	define("CAMINHO_INCLUDE","../../../inc/");
	}

	// Includes necessarios
	require_once(CAMINHO_INCLUDE . 'Funcao.php');
	require_once(CAMINHO_INCLUDE . 'rb.php');
/*
	$db = R::setup('mysql:host=localhost;dbname=meuportfolio','root','');
	
	if (!$db){
		die(MSG_ACESSO_NEGADO_BD);
    }
*/
    try{
        R::setup('mysql:host=localhost;dbname=meuportfolio','root','');
    } catch(PDOException $e){
        echo $e->getmessage();
    }
	// Funcao padrao que trata todos os tipos de excecoes que ocorrerem
	set_error_handler('TratarErro');
?>
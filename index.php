<?php

/**
 * Arquivo controlador de requisicoes. Todas as requisicoes passam por este arquivo aquivo
 * Criado em: 22/11/2006
 * Autor: Daniel Ribeiro <daniel@danielribeiro.com>
 *
 * Esta aplicacao usa a metodologia de MVC criada por mim. A estrutura da aplicacao eh dividida por modulos e acoes
 * Um modulo eh carregado atraves desse arquivo index recebendo como parametro via GET a variavel
 * module = modulo a ser carregado
 * action = acao a ser executada no modulo
 * Ao executar essa pagina (index.php) o controlador (Controller - includes/Controller) executa o metodo doAction
 * que verifica qual modulo foi chamado (se nao informado nenhum modulo, carrga o modulo default) e a action (se
 * nao informado a action, carrega a action default), da um require_once do arquivo de controller do modulo,
 * instancia o objeto do modulo e executa a acao.
 * Todo modulo eh uma classe e toda acao eh um metodo publico da classe.
 *
 */

 
// requisita o arquivo de configuacao
require_once('config.php');

// requisita as bibliotecas model, view, controller
require_once('includes/Model.php');
require_once('includes/View.php');
require_once('includes/Controller.php');

// executa o controller
$module = Controller::loadModule();
$module->display();

die('daniel');

function print_rr($var, $exit = 1 ) 
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';
	if( $exit ) {
		exit;
	}
}

function mylog( $content ) {
	$fp = fopen('log.txt', 'a+');
	fwrite( $fp, print_r($content, true) );
	fclose( $fp );
}
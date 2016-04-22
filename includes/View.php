<?php

/**
 * Classe view, usada para exibir as informacoes do sistema na tela.
 *
 */

require_once('includes/Smarty-2.6.14/libs/Smarty.class.php');

class View{

	/**
	 * Objeto smarty template
	 *
	 * @var Smarty
	 */
	private $smarty;

	/**
	 * Define o arquivo de template
	 *
	 * @var string
	 */
	private $template_file;

	/**
	 * Metodo construtor da classe
	 *
	 */
	public function __construct(){
		global $appConfig;
		$this->smarty = new Smarty;
		$this->smarty->debugging = false;
		$this->smarty->template_dir = $appConfig['template_dir'];
		$this->smarty->compile_dir = $appConfig['template_dir'] . 'includes/templates_c/';
	}

	/**
	 * Define o valor de uma variavel no template
	 *
	 * @param string $variable
	 * @param mixed $value
	 * @return void
	 */
	public function assign( $variable, $value ){
		$this->smarty->assign( $variable, $value );
	}

	/**
	 * Define a mensagem de retorno
	 *
	 * @param string $message
	 * @param string $link
	 * @param string $class
	 */
	public function setMessage( $message, $link = null, $class = null, $template = null ){
		$link = $link ? $link : 'javascript: history.back();';
		$template = $template ? $template : 'includes/message.tpl';
		$this->assign('message', $message);
		$this->assign('link', $link);
		$this->assign('class', $class);
		$this->setTemplate( $template );
	}

	/**
	 * Define o template a ser exibido
	 *
	 * @param string $template
	 */
	public function setTemplate( $template ){
		$this->template_file = $template;
	}

	/**
	 * Retorna o template que esta definido no objeto
	 *
	 * @return string;
	 */
	public function getTemplate(){
		return $this->template_file;
	}

	/**
	 * Define a exibicao de uma mensagem de confirmacao
	 *
	 * @param string $message
	 * @param string $link
	 * @param string $class
	 */
	public function setConfirmation( $message, $link = null, $clas = null ){

		// se nao informado o link, crio o link com os parametros obtidos via $_REQUEST
		if(!$link){
			$link = '?';
			foreach ( $_REQUEST as $key => $value ){
				if($key != 'PHPSESSID'){
					$link.= $key . '=' . $value . '&';
				}
			}
			$link.='confirm=1';
		}

		$this->assign('message', $message);
		$this->assign('link', $link);
		$this->assign('class', $class);
		$this->setTemplate('includes/confirm.tpl');
	}

	/**
	 * Exibe as informacoes na tela
	 *
	 * @param string $template
	 */
	public function display( $template = null ){
		global $appConfig;

		// obtem o template
		$template = $template ? $template : $this->template_file;

		// se caso o template nao for encontrado, aborto a aplicacao
		if( !$template ){
			Controller::error('template nao informado', true, true);
		}

		// assign das variaveis de configuracao
		$this->smarty->assign('appConfig', $appConfig);

		// define o header com o encoding correto e diretivas para nao gerar cache
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header('Content-Type: text/html; charset=UTF-8');

		// exibe o template
		$this->smarty->display( $appConfig['template_dir'] . $template );
		exit;
	}

	/**
	 * Retorna as informacoes do template
	 *
	 * @param string $template
	 */
	public function fetch( $template = null ){
		global $appConfig;

		// obtem o template
		$template = $template ? $template : $this->template_file;

		// se caso o template nao for encontrado, aborto a aplicacao
		if( !$template ){
			Controller::error('template nao informado', true, true);
		}

		$this->smarty->assign('appConfig', $appConfig);
		return $this->smarty->fetch( $appConfig['template_dir'] . $template );
	}

	/**
	 * Cria uma nova chave no array (selected), marcando em itens os itens encontrados em itens_selected
	 * eh utilizado para o template identificar quais itens serao marcados como selecionados ou nao
 	 *
	 * @param array $itens
	 * @param string/array $itens_selected array(1, 2, 3) ou '1, 2, 3'
	 * @return array
	 */
	public function markSelected( $itens, $itens_selected = null){
		$itens_selected = $itens_selected ? $itens_selected : array();
		$itens_selected = is_array( $itens_selected ) ? $itens_selected : split(',', str_replace(' ', '', $itens_selected));
		$keys = @array_keys($itens[0]);
		for( $i=0; $i < count($itens); $i++){
				$itens[$i]['selected'] = in_array($itens[$i][$keys[0]], $itens_selected) ? 1 : 0;
		}
		return $itens;
	}

}

?>
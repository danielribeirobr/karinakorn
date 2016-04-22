<?php

/**
 * controller.php Classe controladora, aqui tem os metodos principais do controlador
 * @since 2006-12-21
 * Autor: Daniel Ribeiro <daniel@danielribeiro.com>
 */

abstract class Controller {

	/**
	 * Valor de retorno da acao / metodo executado pelo controller
	 *
	 * @var mixed
	 */
	private $return;

	/**
	 * Url que o browser sera redirecionado...
	 *
	 * @var string
	 */
	private $redirect_url;

	/**
	 * Configuration array
	 *
	 * @var array
	 */
	protected $appConfig;

	/**
	 * Execute a module / action
	 *
	 * @param string $custom_module
	 * @param string $custom_action
	 * @param object $db
	 * @param array $arguments
	 * @return mixed object
	 */
	public static function loadModule( $custom_module = null, $custom_action = null, $db_con = null, $arguments = null, $view = null ) {
		global $appConfig;

		$module = $custom_module ? $custom_module : (isset($_REQUEST['module']) ? $_REQUEST['module'] : 'content');
		$action = $custom_action ? $custom_action : (isset($_REQUEST['action']) ? $_REQUEST['action'] : '_default');

		if( $module != 'login' ){
			if( !self::loadModule('login', 'loginCheckPermission', $db_con, array( $module ))->getValue() ){
				foreach ( $_GET as $key => $item ){
					if( $key != 'PHPSESSID'){
						$redirect[] = $key . '=' . $item;
					}
				}
				header('Location: ?module=login' . (count($redirect) ? '&redirect=' . urlencode('?' . join('&amp;', $redirect)) : ''));
				exit;
			}
		}

		$instance = self::loadInstance( $module, $db_con, $view );

		$variables = array();
				
		for($count = 0; $count < count($arguments); $count++ ){
			eval('$arg'.$count.' = isset($arguments[$count]) ? $arguments[$count] : null;');
			$variables[] = '$arg'.$count;
		}


		if( !method_exists( $instance, $action ) ){
			self::error('Module or action not found', false, true);
		}

		// Assign the configuration variable to the controller
		eval('$instance->appConfig = $appConfig;');

		eval('$instance->return = $instance->$action( '.implode(',', $variables).' );');

		// retorna a instancia do objeto
		return $instance;
	}

	/**
	 * Load a instance of the module
	 *
	 * @param string $module
	 * @param object $db_con
	 * @return object
	 */
	private static function loadInstance( $module, $db_con = null, $view = null ){
		global $appConfig;

		$classPrefix = 'modules/'. $module .'/'. $module;
		$classController = $classPrefix .'_controller.php';

		if (file_exists($classController)) {
			require_once($classController);
			try {
				$constructor = $module ."Controller";
				return new $constructor( $db_con, $view );
			} catch (Exception $error) {
				self::error( $error->getMessage() );
			}
		} else {
			self::error( 'Module not found: ' . $classController, false, true);
		}
	}

	/**
	 * Display proccessed content
	 *
	 */
	public function display(){

		if( property_exists($this, 'view') ){
			if( is_object($this->view) ){
				if( method_exists( $this->view, 'display') ){
					if( $this->view->getTemplate() ){

						// verify if the user is logget and define the user var
						$user_id = $this->loadModule('login', 'loginGetUser', isset($this->db) ? $this->db : null)->getValue();
						if( $user_id ){

							// set the user id
							$globals['user']['user_id'] = $user_id;

							// set the user levels
							$user_levels = $this->loadModule('login', 'loginGetUserLevels', isset($this->db) ? $this->db : null)->getValue();
							foreach ( $user_levels as $item ){
								$globals['user']['level'][$item] = true;
							}

						}

						// atribui no template as variaveis globais
						if( isset($globals) ) {
							$this->view->assign('globals', $globals);
						}						

						// exibe o template
						$this->view->display();

					}
				}
			}
		}

		if( $this->redirect_url ){
			header('Location: ' . $this->redirect_url);
			exit;
		}

	}

	/**
	 * Return the processed value by a module
	 *
	 */
	public function getValue(){
		return $this->return;
	}

	/**
	 * Retirect the user for the module / action
	 *
	 * @param string $module
	 * @param string $action
	 */
	public function redirect( $module, $action = null, $parameters = null ){
		$this->redirect_url = self::getLinkModule( $module, $action, $parameters);
	}

	/**
	 * Show a error
	 *
	 * @param string $msg Mensagem de Erro
	 * @param bool $log Define se loga o erro
	 * @param bool $die Define se aborta o script
	 */
	public static function error( $msg, $log = false, $die = false ){

		// se informado para logar, logo a mensagem
		if( $log ){
			self::log( $msg );
		}
		else{
			echo $msg;
		}

		// se informado para abortar o script, aborto
		if ( $die ){
			die();
		}

	}

	/**
	 * Log a information
	 *
	 * @param string $msg Mensagem a ser logada
	 * @param string $logfile Arquivo de log
	 * @return bool
	 */
	public static function log( $msg, $logfile = null ){
		global $appConfig;

		// define o arquivo de log
		$logfile = $logfile ? $logfile : $appConfig['error_log'];

		// faz o backtrace
		$backtrace = debug_backtrace();
		for( $i = 3; $i <= count($backtrace) - 4; $i++ ){
			$backtrace_log[] = str_replace($appConfig['base'], '', $backtrace[$i]['file']) . ':' . $backtrace[$i]['line'] . '-' . $backtrace[$i]['function'] . '()';
		}
		$backtrace = join(', ', $backtrace_log);

		// log de dados
		$log_data = date('Y-m-d H:i:s ') . ' ' . $msg . ' - ' . $backtrace . "\n";

		// escreve no arquivo
		$file = @fopen( $logfile, 'a+');
		@fwrite( $file, $log_data );
		@fclose( $file );

	}

	/**
	 * Return a link to execute a module / action
	 *
	 * @param string $module
	 * @param string $action
	 * @param array $parameters
	 * @return string
	 */
	public static function getLinkModule( $module, $action = null, $parameters = null ){
		if ($parameters && is_array($parameters)){
			foreach ( $parameters as $key => $item ){
				$_parameters[] = $key . '=' . $item;
			}
		}
		return '?module=' . $module . ($action ? '&action=' . $action : '') . (isset($_parameters) ? '&' . join('&', $_parameters) : '');
	}

	/**
	 * Return a array with the associative valye informed by a key
	 *
	 * @param array $array
	 * @param string $key
	 */
	public function arrayKeyValues( $array, $key ){
		foreach ($array as $item ){
			if( $item[$key] ){
				$array_return[] = $item[$key];
			}
		}
		return $array_return;
	}

	/**
	 * Return a rand string
	 *
	 * @param int $length
	 * @return string
	 */
	public function randomString( $length = 10 ){
		$chars = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';
		$string = '';
		while( strlen( $string ) < $length ){
			$string .= substr( $chars, rand( 0, strlen( $chars ) - 1 ), 1 );
		}
		return $string;
	}

	/**
	 * Transform fields with a prefix to array
	 *
	 * @param array $parameters
	 * @param string $prefix
	 * @return array
	 */
	protected function fieldToArray( $parameters, $prefix ){
		foreach ( $parameters as $key => $item ){
			if( substr($key, 0, strlen($prefix) ) == $prefix ){
				$arr[ str_replace($prefix, '', $key) ] = $item;
			}
		}
		return (array) $arr;
	}

	/**
	 * Transform a array to a field with prefix
	 *
	 * @param array $array
	 * @param string $prefix
	 * @return array
	 */
	protected function arrayToField( $parameters, $prefix ){
		if(!$parameters) return array();
		foreach ( $parameters as $key => $item ){
			$arr[$prefix . $key] = $item;
		}
		return (array) $arr;
	}

	/**
	 * Print a array
	 *
	 * @param array $array
	 * @param bool exit
	 */
	public static function print_r( $array, $exit = false ){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
		if( $exit ){
			exit;
		}
	}

}

?>
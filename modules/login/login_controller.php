<?php

/**
 * login_controller.php - Login Module
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2007-10-01
 */

require_once('Model.php');
require_once('View.php');

class loginController extends Controller {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var View
	 */
	public $view;

	/**
	 * Contructor Method
	 *
	 * @param MDB2 $db Objeto MDB2 to use a databse
	 *
	 */
	public function __construct( $db = null ){

		$this->model = new Model( $db );
		$this->view = new View();

		// start a session, becaus de user control is managment by session
		if( !isset($_SESSION) ) {
			session_start();
		}
		
	}

	/**
	 * Default method
	 *
	 */
	public function _default(){
		$this->loginFormLogin();
	}

	/**
	 * Show login screen
	 *
	 */
	public function loginFormLogin( $parameters = null ){
		$parameters = $parameters ? $parameters : $_POST;

		$this->view->assign('login', isset($parameters['login']) ? $parameters['login'] : null);
		$this->view->assign('password', isset($parameters['password']) ? $parameters['password'] : null);
		$this->view->assign('error', isset($parameters['error']) ? $parameters['error'] : null);
		$this->view->assign('redirect', isset($parameters['redirect']) ? $parameters['redirect'] : null );
		$this->view->setTemplate(isset($parameters['template']) ? $parameters['template'] : 'login/login.tpl');
	}

	/**
	 * User login
	 *
	 * @param array $parameters array('login'=>, 'senha'=>)
	 */
	public function loginDoLogin(){
		$parameters = $_POST;

		// verify the login exists and if it is enable
		$query = "SELECT user_id FROM user
					WHERE login = " . $this->model->quote( $parameters['login'] ) . "
					AND password = " . $this->model->quote( $parameters['password'] ) . "
					AND status = 1 ";
		$result = $this->model->queryToArray( $query );

		// if user found, i save the login session
		if( isset($result[0]['user_id']) ){
			$_SESSION['user_id'] = $result[0]['user_id'];

			// adiciona um incremento ao acesso do usuario
			$this->model->query("
				UPDATE user SET acessos = acessos + 1
				WHERE user_id = " . $this->model->quote( $result[0]['user_id'] )
			);

			// verifica se foi inforamdo o redirect
			if( $parameters['redirect'] ){
				header('Location: ' . $parameters['redirect']);
				exit;
			}

			// se nao, redireciona para o modulo admin
			else {
				$this->redirect('admin');
				return $result[0]['user_id'];
			}
		}

		// caso contrario, exibe o formulario de login e retorna false
		else{

			// se caso foi informado o redirect no caso de falha, mando o usuario pra la
			if( $parameters['redirect'] ){
				header('Location: ' . $parameters['redirect'] . '&failed=1' );
				exit;
			}
			else {
				$parameters['error'] = 'Usu&aacute;rio ou senha inv&aacute;lidos';
				$this->loginFormLogin( $parameters );
				return false;
			}
		}

	}

	/**
	 * Logout user
	 *
	 */
	public function loginDoLogout(){
		$parameters = $_REQUEST;

		//destroy a sessao
		session_destroy();

		//remove a sessao
		$_SESSION['user_id'] = null;

		// se caso informado o redirect, redireciono o usuario pra la
		if( isset($parameters['redirect']) ){
			header('Location: ' . $parameters['redirect']);
			exit;
		}

		// exibe o formulario de login
		$this->loginFormLogin();
	}

	/**
	 * Retorna o id do usuario logado
	 *
	 * @return int id do usuario logado
	 */
	public function loginGetUser(){
		$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
		return $user_id;
	}

	/**
	 * Return if the user has access to the module
	 *
	 * @param string $module
	 * @param int $usuario_id (if null, check the current user)
	 * @return bool
	 */
	public function loginCheckPermission( $module, $user_id = null ){
		$user_id = $user_id ? $user_id : $this->loginGetUser();

		if( in_array( $module, $this->loginPermissionModules( $user_id ) ) ){
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Return a array with user levels
	 *
	 * @param int $user_id
	 * @return array
	 */
	public function loginGetUserLevels( $user_id = null ){
		$user_id = $user_id ? $user_id : $this->loginGetUser();

		$result = $this->model->queryToArray("SELECT levels FROM user WHERE user_id = " . $this->model->quote( $user_id ));
		if( count($result) ) {
			$user_levels = $result[0]['levels'];
			$user_levels = explode('|', $user_levels);
			foreach ( $user_levels as $item ){
				if($item){
					$levels[] = $item;
				}
			}		
		}

		return isset($levels) ? $levels : array();
	}

	/**
	 * Return a array with ne modules user has access
	 *
	 * @param int $user_id (if is null, return all public modules)
	 * @return array
	 */
	public function loginPermissionModules( $user_id = null ){
		$user_id = $user_id ? $user_id : $this->loginGetUser();

		// get user levels
		$levels = $this->loginGetUserLevels( $user_id );

		// query que retorna todos os modulos que o usuario tem acesso, + modulos publicos...
		if( $user_id ){

			foreach ( $levels as $item ){
				$where_levels[] = "access_level LIKE " . $this->model->quote('%|' . $item . '|%');
			}

			$query = "SELECT module FROM module
						WHERE (access_level IS NULL OR access_level = '')
						OR " . join(" OR ", $where_levels);
		}
		else {
			$query = "SELECT module FROM module
						WHERE access_level IS NULL OR access_level = ''";
		}

		$result = $this->model->queryToArray( $query );

		if( $result ){
			foreach ( $result as $item ){
				$modules[] = $item['module'];
			}
		}

		return $modules ? $modules : array();
	}

	// --------------------------------------------------------
	// Forgot password methods

	/**
	 * Show form to user fill information to retrieve the password
	 *
	 */
	public function loginForgotPasswordForm( $parameters = null ){
		$this->view->assign('form', $parameters['form']);
		$this->view->assign('error', $parameters['error']);
		$this->view->setTemplate('login/forgot_password_form.tpl');
	}

	/**
	 * Show send link to user change the password
	 *
	 */
	public function loginForgotPasswordSendPassword( $parameters = null ){
		$parameters = $parameters ? $parameters : $_POST;

		// check all users with this email address
		$result = $this->model->queryToArray("
			SELECT * FROM user WHERE email = " . $this->model->quote( $parameters['email'] )
		);
		if( !count($result) ){
			$this->loginForgotPasswordForm(
				array(
					'form' => $parameters,
					'error'	=> 'Sorry, this email was not found in our system.'
				)
			);
			return false;
		}

		// build the email body
		$body = 'Seu endereco de email contem as seguintes senhas:' . "<br/><br/>";
		foreach ( $result as $item ){
			$body.= "Login: " . $item['login'] . "<br/>";
			$body.= "Senha: " . $item['password'] . "<br/><br/>";
		}

		// build the headers
		//$headers = "From: " . $this->appConfig['app_email'] . "\r\n";

		// send email with passords and logins
		//mail( $parameters['email'], 'Login information', $body, $headers);

		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: " . $this->appConfig['app_email'] . "\n";
		$headers .= "Return-Path: " . $this->appConfig['app_email'] . "\n";
		mail($parameters['email'], "Senha para acesso", $body, $headers);


		$this->view->setMessage('The password was sent to your mail.', '?');
		return true;
	}

}

?>
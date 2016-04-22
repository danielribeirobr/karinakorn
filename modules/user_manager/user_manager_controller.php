<?php

/**
 * user_manager_controller.php - User managment
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2007-10-04
 */

require_once('Model.php');
require_once('View.php');

class user_managerController extends Controller {

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

	}

	/**
	 * Default method
	 *
	 */
	public function _default(){
		$this->user_managerList();
	}

	/**
	 * Listing users of the system
	 *
	 * @param array $parameters
	 */
	public function user_managerList( $parameters = null ){
		$parameters = $_REQUEST;

		// select the users
		if( $parameters['name'] || $parameters['list_all']){
			$users = $this->model->queryToArray("
				SELECT
					user.*
				FROM user
				WHERE
					(
						user.name LIKE " . $this->model->quote('%' . $parameters['name'] . '%') . "
						OR user.email LIKE " . $this->model->quote('%' . $parameters['name'] . '%') . "
						OR user.login LIKE " . $this->model->quote('%' . $parameters['name'] . '%') . "
					)
					AND user.levels LIKE " . $this->model->quote('%|cliente|%') . "
				ORDER BY user.name
			");
		}
    
		$this->view->assign('users', $users);
		$this->view->assign('form', $parameters);
		$this->view->setTemplate('user_manager/list.tpl');
	}

	/**
	 * Add a new user
	 *
	 * @param array $parameters
	 */
	public function user_managerAdd( $parameters = null )	{
		$parameters = $parameters ? $parameters : $_REQUEST;

		// display form to add new user
		$this->user_managerDisplayForm(
			array(
				'form' => $parameters
			)
		);

	}

	/**
	 * Save a user on the database
	 *
	 * @param array $parameters
	 */
	public function user_managerSave( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		// validate form
		$error = $this->user_managerValidateForm( $parameters );

		if( $error ){
			$this->user_managerDisplayForm(
				array(
					'form' => $parameters,
					'error' => $error
				)
			);
			return false;
		}

		// make a query body
		$query_body = "
			name = " . $this->model->quote( $parameters['name'] ) . ",
			login = " . $this->model->quote( $parameters['login'] ) . ",
			email = " . $this->model->quote( $parameters['email'] ). ",
			password = " . ($parameters['password'] ? $this->model->quote( $parameters['password'] ) : " password ") . ",
			levels = " . $this->model->quote( '|cliente|' ) . ",
			status = " . $this->model->quote( $parameters['status'] ) . "
		";

		// update user
		if( $parameters['user_id'] ){
			$this->model->query("UPDATE user SET " . $query_body . " WHERE user_id = " . $this->model->quote( $parameters['user_id'] ));
			$parameters['user_id'] = $this->model->lastInsertId('user');
		}

		// add user
		else{
			$this->model->query("INSERT INTO user SET " . $query_body);
		}

		// list authors
		$this->user_managerList();

		return $parameters['user_id'];
	}

	/**
	 * Delete a user
	 *
	 * @param array $parameters
	 * @return bool
	 */
	public function user_managerDelete( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		if( !$parameters['confirm'] ){
			$this->view->setConfirmation('Deseja realmente excluir este registro?');
			return false;
		}
		else{
			$this->model->query("DELETE FROM user WHERE user_id = " . $this->model->quote( $parameters['user_id']) );
			$this->view->setMessage('Registro removido.', $this->getLinkModule('user_manager'));
			return true;
		}

		// list the author again
		$this->user_managerList();
	}

	/**
	 * Validate form parameters
	 *
	 * @param array $parameters
	 * @return array (with errors)
	 */
	private function user_managerValidateForm( $parameters ){

		// validate required fields
			$requiredFields = array('name', 'login', 'email');
			foreach ( $requiredFields as $item ){
				if(!trim($parameters[$item])){
					$error[$item] = 'Campo requerido!';
				}
			}

			// if not user_id is informed, so its a new user, so the password should be supply
			if( !$parameters['user_id'] ){
				$requiredFields[] = 'password';
			}

			foreach ( $requiredFields as $item ){
				if( !trim($parameters[$item]) ){
					$error[$item] = 'Campo requerido!';
				}
			}

		// validate password
		if( $parameters['password'] ){
			// check match
			if( array_key_exists('password_check', $parameters) ){
				if( $parameters['password'] != $parameters['password_check'] ){
					$error['password_check'] = 'Senhas n&atilde; conferem';
				}
			}
		}

		// validate email
		if( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $parameters['email']) ){
			$error['email'] = 'Email digitado n&atilde; &eacute; v&acute;lido.';
		}

		// check if login exists
		if( $parameters['login'] ){
			$result = $this->model->queryToArray("
				SELECT user_id FROM user
					WHERE login = " . $this->model->quote( $parameters['login'] ) . "
					" . ($parameters['user_id'] ?
							" AND user_id <> "  . $this->model->quote( $parameters['user_id'] )
							:
							"")
			);
			if( $result[0]['user_id'] ){
				$error['login'] = 'Este login j&aacute; existe!';
			}
		}

		return (array) $error;
	}

	/**
	 * Show form to edit a user
	 *
	 * @param array $parameters
	 */
	public function user_managerEdit( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		// load the user data
		$result = $this->model->queryToArray("
			SELECT * FROM user WHERE user_id = " . $this->model->quote( $parameters['user_id'] )
		);
		$user = $result[0];

		// display the form
		$this->user_managerDisplayForm(
			array(
				'form' => $user
			)
		);
	}

	/**
	 * Display form with user information
	 *
	 * @param array $parameters
	 */
	private function user_managerDisplayForm( $parameters ){
		$this->view->assign('form', $parameters['form']);
		$this->view->assign('error', $parameters['error']);
		$this->view->setTemplate('user_manager/form.tpl');
	}

}

?>
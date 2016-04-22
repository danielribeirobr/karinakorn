<?php

/**
 * my_account_controller.php - User managment
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2007-10-04
 */

require_once('Model.php');
require_once('View.php');

class my_accountController extends Controller {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var View
	 */
	public $view;

	/**
	 * Current user id
	 *
	 * @var int
	 */
	private $user_id;

	/**
	 * Contructor Method
	 *
	 * @param MDB2 $db Objeto MDB2 to use a databse
	 *
	 */
	public function __construct( $db = null ){

		$this->model = new Model( $db );
		$this->view = new View();
		$this->user_id = $this->loadModule('login', 'loginGetUser', $this->model->db)->getValue();

	}

	/**
	 * Default method
	 *
	 */
	public function _default(){
		$this->my_accountShowForm();
	}

	/**
	 * Save information on my account
	 *
	 */
	public function my_accountSave( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		// validate form data
		if($error = $this->my_accountValidate( $parameters )){
			$this->my_accountShowForm(
				array(
					'form'	=> $parameters,
					'error'	=> $error
				)
			);
			return;
		}

		// save
		$this->model->query("
			UPDATE user SET
				name = " . $this->model->quote( $parameters['name'] ) . ",
				email = " . $this->model->quote( $parameters['email'] ) . ",
				password = " . ($parameters['password'] ? $this->model->quote( $parameters['password']) : 'password') . ",
				email_type = " . $this->model->quote( $parameters['email_type'] ) . ",
				website = " . $this->model->quote( $parameters['website'] ) . ",
				logo_url = " . $this->model->quote( $parameters['logo_url'] ) . "
			WHERE user_id = " . $this->model->quote( $this->user_id )
		);

		$this->my_accountShowForm(
			array(
				'info' => 'Save successfull!'
			)
		);

	}

	/**
	 * Validate my account form parameters
	 *
	 * @param array $parameters
	 * @return array
	 */
	private function my_accountValidate( $parameters ){

		// check for required fields
		$requiredFields = array('login', 'name', 'email', 'email_type');
		foreach ( $requiredFields as $item ){
			if(!trim($parameters[$item])){
				$error[$item] = 'This field is required!';
			}
		}

		// check email sintax
		if( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $parameters['email']) ){
			$error['email'] = 'Email address not valid.';
		}

		// check if login exists
		$result = $this->model->queryToArray("
			SELECT user_id FROM user
				WHERE login = " . $this->model->quote( $parameters['login'] ) . "
				AND user_id <> "  . $this->model->quote( $this->user_id )
		);
		if( $result[0]['user_id'] ){
			$error['login'] = 'Login already exists';
		}

		return (array) $error;
	}

	/**
	 * Show form with my account
	 *
	 * @param array $parameters
	 *
	 */
	private function my_accountShowForm( $parameters = null ){

		// load information about current user
		if( !$parameters['form'] ){
			$result = $this->model->queryToArray("
				SELECT * FROM user WHERE user_id = " . $this->model->quote( $this->user_id )
			);
			$parameters['form'] = $result[0];
		}

		$this->view->assign('form', $parameters['form']);
		$this->view->assign('error', $parameters['error']);
		$this->view->assign('info', $parameters['info']);
		$this->view->setTemplate('my_account/form.tpl');
	}

}

?>
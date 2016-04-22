<?php

/**
 * admin_controller.php - User managment
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2007-10-04
 */

require_once('Model.php');
require_once('View.php');

class adminController extends Controller {

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
		$this->view->setTemplate('admin/admin.tpl');
	}

}

?>
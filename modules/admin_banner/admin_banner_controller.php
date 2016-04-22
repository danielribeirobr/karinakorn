<?php

class admin_bannerController extends Controller {

	/**
	 * @var ContentModel
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
		$this->admin_bannerList();
	}

	/**
	 * @param array $parameters
	 */
	public function admin_bannerList( $parameters = null ){
		$parameters = $_REQUEST;

		$banners = $this->model->queryToArray("SELECT * FROM banner ORDER BY status DESC, titulo");
		foreach( $banners as $k => $item ) {
			$query = $this->model->queryToArray("
				SELECT COUNT(*) AS n FROM banner_log
				WHERE type = 1 AND banner_id = " . $this->model->quote( $item['banner_id'] ) . "
			");
			$banners[$k]['views'] = $query[0]['n'];
			$query = $this->model->queryToArray("
				SELECT COUNT(*) AS n FROM banner_log
				WHERE type = 2 AND banner_id = " . $this->model->quote( $item['banner_id'] ) . "
			");
			$banners[$k]['clicks'] = $query[0]['n'];
		}

		$this->view->assign('form', $parameters);
		$this->view->assign('banners', $banners );
		$this->view->setTemplate('admin_banner/list.tpl');
	}

	/**
	 *
	 * @param array $parameters
	 */
	public function admin_bannerAdd( $parameters = null )	{
		$parameters = $parameters ? $parameters : $_REQUEST;
		$this->admin_bannerDisplayForm( $parameters );
	}

	/**
	 * Save on the database
	 *
	 * @param array $parameters
	 */
	public function admin_bannerSave( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		// validate form
		$error = $this->admin_bannerValidateForm( $parameters );

		if( $error ){
			$this->admin_bannerDisplayForm(
				array(
				    'form' => $parameters,
				    'error' => $error
				)
			);
			return false;
		}

		$querybody = "
		    titulo = " . $this->model->quote($parameters['titulo']) . ",
		    texto = " . $this->model->quote($parameters['texto']) . ",
		    link = " . $this->model->quote($parameters['link']) . ",
		    tipo = " . $this->model->quote($parameters['tipo']) . ",
		    status = " . $this->model->quote($parameters['status']) . ",
		    pagina = " . $this->model->quote( '|' . join('|', $parameters['pagina']) . '|' ) . "
		";

		if( $parameters['banner_id'] ) {
		    $query = "UPDATE banner SET " . $querybody . " WHERE banner_id = " . $this->model->quote( $parameters['banner_id'] );
		} else {
		    $query = "INSERT INTO banner SET " . $querybody;
		}

		$this->model->query($query);

		if( !$parameters['banner_id'] ) {
		    $parameters['banner_id'] = $this->model->lastInsertId('banner');
		}

		if( $_FILES['arquivo']['tmp_name'] ) {
		    $record = $this->model->queryToArray("SELECT img FROM banner WHERE banner_id = " . $this->model->quote( $parameters['banner_id'] ) );
		    $record = $record[0];
		    if( $record['img'] ) {
		        @unlink( $this->appConfig['db_banners'] . '/' . $parameters['banner_id'] . '-' . $record['img'] );
		    }
		    move_uploaded_file($_FILES['arquivo']['tmp_name'], $this->appConfig['db_banners'] . $parameters['banner_id'] . '-' . $_FILES['arquivo']['name']);
		    $this->model->query("UPDATE banner SET img = " . $this->model->quote( $_FILES['arquivo']['name'] ) . " WHERE banner_id = " . $this->model->quote( $parameters['banner_id']));
		}

		$this->view->setMessage('Dados salvos com sucesso', $this->getLinkModule('admin_banner'));
	}

	/**
	 *
	 * @param array $parameters
	 * @return bool
	 */
	public function admin_bannerDelete( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;
		if( !$parameters['confirm'] ){
			$this->view->setConfirmation('Deseja realmente excluir este registro?');
			return false;
		}
		else{

			$record = $this->model->queryToArray("SELECT img FROM banner WHERE banner_id = " . $this->model->quote( $parameters['banner_id'] ) );
			$record = $record[0];
			if( $record['img'] ) {
				@unlink( $this->appConfig['db_banners'] . '/' . $parameters['banner_id'] . '-' . $record['img'] );
			}

			$this->model->query("DELETE FROM banner WHERE banner_id = " . $this->model->quote( $parameters['banner_id'] ) );
			$this->view->setMessage('Registro removido.', $this->getLinkModule('admin_banner'));
			return true;
		}
	}

	/**
	 * Validate form parameters
	 *
	 * @param array $parameters
	 * @return array (with errors)
	 */
	private function admin_bannerValidateForm( $parameters ){

		// validate required fields
		$requiredFields = array('titulo', 'tipo', 'pagina');
		foreach ( $requiredFields as $item ){
			if(!trim($parameters[$item])){
				$error[$item] = 'Campo requerido!';
			}
		}

		return (array) $error;
	}

	/**
	 *
	 * @param array $parameters
	 */
	public function admin_bannerEdit( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		$results = $this->model->queryToArray("SELECT * FROM banner WHERE banner_id = " . $this->model->quote( $parameters['banner_id'] ));
		$banner = $results[0];

		// display the form
		$this->admin_bannerDisplayForm(
			array(
				'form' => $banner
			)
		);
	}

	/**
	 *
	 * @param array $parameters
	 */
	private function admin_bannerDisplayForm( $parameters = null ){

		// paginas que podem conter os banners
		require_once( dirname(__FILE__) . '/../content/ContentModel.php' );
		$contentModel = new ContentModel( $this->model->db );
		$paginas = $contentModel->getBannersPaginas();
		asort($paginas);

		$arrPaginasSelecionadas = explode('|', substr($parameters['form']['pagina'], 1, strlen($parameters['form']['pagina']) -2)) ;

		foreach( $paginas as $item ) {
			$fpaginas[] = array(
			    'pagina'		=> $item,
			    'selecionada'	=> in_array($item, $arrPaginasSelecionadas)
			);
		}

		$this->view->assign('form', $parameters['form']);
		$this->view->assign('error', $parameters['error']);
		$this->view->assign('paginas', $fpaginas);
		$this->view->setTemplate('admin_banner/form.tpl');
	}

}
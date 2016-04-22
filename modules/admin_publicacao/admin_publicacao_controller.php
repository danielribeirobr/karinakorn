<?php

/**
 * admin_publicacao_controller.php - User managment
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2007-10-04
 */

require_once('Publicacao.php');
require_once('View.php');

class admin_publicacaoController extends Controller {

	/**
	 * @var Publicacao
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
	public function __construct( $db = null, $view = null ){

		$this->model = new Publicacao( $db );
		$this->view = $view ? $view : new View();

	}

	/**
	 * Default method
	 *
	 */
	public function _default(){
		$this->admin_publicacaoList();
	}

	/**
	 * @param array $parameters
	 */
	public function admin_publicacaoList( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;
		$this->view->assign('form', $parameters);
		$this->view->assign('publicacoes', $this->model->getPublicacao( $parameters ) );
		$this->view->assign('publicacao_tipo', $this->model->getPublicacaoTipo( $parameters['publicacao_tipo_id'] ));
		$this->view->setTemplate('admin_publicacao/list.tpl');
	}

	/**
	 *
	 * @param array $parameters
	 */
	public function admin_publicacaoAdd( $parameters = null )	{
		$parameters = $parameters ? $parameters : $_REQUEST;

		// se nao informado o tipo da publicacao, alerto o usuario
		if( !$parameters['publicacao_tipo_id'] ){
			$this->view->setMessage('Tipo de publicacao não informado');
			return;
		}

		$publicacao_tipo = $this->model->getPublicacaoTipo( $parameters['publicacao_tipo_id'] );
		$publicacao_id = $this->model->salvarPublicacao(array(
			'titulo'				=> 'Nova publicação ' . $publicacao_tipo['tipo'],
			'publicacao_tipo_id'	=> $parameters['publicacao_tipo_id']
		));

		// abre o registro
		$this->admin_publicacaoEdit(array(
			'publicacao_id' => $publicacao_id
		));
	}

	/**
	 * Save on the database
	 *
	 * @param array $parameters
	 */
	public function admin_publicacaoSave( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		// validate form
		$error = $this->admin_publicacaoValidateForm( $parameters );

		if( $error ){
			$this->admin_publicacaoDisplayForm(
				array(
					'form' => $parameters,
					'error' => $error
				)      
			);
			return false;
		}

		$this->model->salvarPublicacao($parameters);

		if( $parameters['afterSave'] ){
			$this->loadModule('admin_publicacao', $parameters['afterSave'], $this->model->db, $parameters, $this->view );
			return;
		}

		$this->view->setMessage(
				'Dados salvos com sucesso',
				$this->getLinkModule(
						'admin_publicacao',
						null,
						array(
							'publicacao_tipo_id' => $parameters['publicacao_tipo_id']
						)
				)
		);
	}

	/**
	 *
	 * @param array $parameters
	 * @return bool
	 */
	public function admin_publicacaoDelete( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		if( !$parameters['confirm'] ){
			$this->view->setConfirmation('Deseja realmente excluir este registro?');
			return false;
		}
		else{
			$publicacao = $this->model->getPublicacao(array('publicacao_id' => $parameters['publicacao_id']));
			$this->model->excluiPublicacao($parameters['publicacao_id']);
			$this->view->setMessage('Registro removido.', $this->getLinkModule('admin_publicacao', null, array('publicacao_tipo_id' => $publicacao['publicacao_tipo_id'])));
			return true;
		}

		// list the author again
		$this->admin_publicacaoList();
	}

	public function admin_publicacaoSetOrder( $parameters = null ) {
		$parameters = $_GET;
		if($parameters['direction'] == 'down') $n = '1';
		if($parameters['direction'] == 'up') $n = '-1';

		// carrega informacoes da publicacao
		$publicacao = $this->model->getPublicacao(array('publicacao_id' => $parameters['publicacao_id']));

		$result = $this->model->queryToArray("
			SELECT publicacao_id, ordem FROM publicacao
			WHERE publicacao_tipo_id = " . $this->model->quote( $publicacao['publicacao_tipo_id'] ) . "
			ORDER BY ordem
		");

		foreach ( $result as $key => $value ){		
			if( $parameters['publicacao_id'] == $value['publicacao_id'] ){
				if( $key + $n > count($result) -1 || $key + $n < 0){
					break;
				}
				$this->model->query("
					UPDATE publicacao SET
					ordem = " . $this->model->quote( $result[$key + $n]['ordem'] ) . "
					WHERE publicacao_id = " . $this->model->quote( $parameters['publicacao_id'] )
				);
				$this->model->query("
					UPDATE publicacao SET
					ordem = " . $this->model->quote( $value['ordem'] ) . "
					WHERE publicacao_id = " . $this->model->quote( $result[$key + $n]['publicacao_id'] )
				);
				break;
			}
		}
		
		// lista novamente
		$this->admin_publicacaoList( array('publicacao_tipo_id' => $publicacao['publicacao_tipo_id'] ) );
	}

	/**
	 * Validate form parameters
	 *
	 * @param array $parameters
	 * @return array (with errors)
	 */
	private function admin_publicacaoValidateForm( $parameters ){

		// validate required fields
		$error = array();
		$requiredFields = array('titulo', 'identificacao');
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
	public function admin_publicacaoEdit( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;

		// display the form
		$this->admin_PublicacaoDisplayForm(
			array(
				'form' => $this->model->getPublicacao(array('publicacao_id' => $parameters['publicacao_id']))
			)
		);
	}

	/**
	 *
	 * @param array $parameters
	 */
	private function admin_publicacaoDisplayForm( $parameters ){
		if( isset($parameters['form']) ) {
			$this->view->assign('form', $parameters['form']);
		}
		if( isset($parameters['error']) ) {
			$this->view->assign('error', $parameters['error']);
		}
		$this->view->setTemplate('admin_publicacao/form.tpl');
	}


	// ----------------------------------------------------------------------
	// METODOS RELATIVOS AO TRATAMENTO DE IMAGENS

	/**
	 * Salva imagem da obra
	 *
	 */
	public function admin_publicacaoImagemSalvar(){
		global $appConfig;
		$parameters = $_POST;

		// realiza a validacao do formulario
		$parameters['file'] = $_FILES;
		$error = $this->admin_publicacaoImagemValidateForm($parameters);

		if( $error ){
			$this->admin_publicacaoImagemShowForm(array('form' => $parameters, 'error' => $error));
			return;
		}

		// caso nao informado o id da imagem, entao o usuario esta adicionando uma nova imagem no sistema
		if( !$parameters['imagem_id'] ) {
			// requisita a biblioteca de redimensionamento de imagem e cria o objeto para redimensionamento
			require_once('includes/ResizeImage.class.php');
			$objImg = new ResizeImage();

			// define aqui o diretorio raiz onde serao armazenados as imagens
			$image_dir = $appConfig['base'] . $appConfig['db_imagens'];

			// obtem os dados de tamanho da imagem
			$result = $this->model->queryToArray("
				SELECT largura, altura
				FROM imagem_tipo
				WHERE imagem_tipo_id = " . $this->model->quote( $parameters['imagem_tipo_id'] )
			);
			$tamanho = $result[0];

			// define aqui um nome para a imagem
			while ( true ){
				$nome = $this->randomString() . '.jpg';
				if( !file_exists($image_dir . $nome ) ){
					break;
				}
			}

			// salva a imagem
			$objImg->setWidth((int) $tamanho['largura']);
			$objImg->setHeight((int) $tamanho['altura']);
			$objImg->setProportions(true);
			$objImg->setSource($_FILES['arquivo']['tmp_name']);
			$objImg->setDestination( $image_dir . $nome );
			$objImg->Resize();

			// grava os dados da imagem e realiza o relacionamento da imagem com a obra
			$this->model->query("
				INSERT INTO imagem SET
					titulo = " . $this->model->quote( $parameters['titulo'] ) . ",
					descricao = " . $this->model->quote( $parameters['descricao'] ) . ",
					arquivo = " . $this->model->quote( $nome )
			);
			$imagem_id = $this->model->lastInsertId('imagem');

			// obtem a proxima ordem da imagem
			$result = $this->model->queryToArray("
				SELECT
					MAX(ordem) AS ordem
				FROM publicacao_imagem
				WHERE
					publicacao_id = " . $this->model->quote( $parameters['publicacao_id'] ) . "
					AND imagem_tipo_id = " . $this->model->quote( $parameters['imagem_tipo_id'] )
			);
			$ordem = $result[0]['ordem'] ? ($result[0]['ordem'] + 1) : 1;

			$this->model->query("
				INSERT INTO publicacao_imagem SET
					publicacao_id = " . $this->model->quote( $parameters['publicacao_id'] ) . ",
					imagem_id = " . $this->model->quote( $imagem_id ) . ",
					imagem_tipo_id = " . $this->model->quote( $parameters['imagem_tipo_id'] ) . ",
					ordem = " . $this->model->quote( $ordem )
			);
		}

		// caso informado o id da imagem, entao eh apenas uma modificacao no cadastro
		else {
			$this->model->query("
				UPDATE imagem SET
					titulo = " . $this->model->quote( $parameters['titulo'] ) . ",
					descricao = " . $this->model->quote( $parameters['descricao'] ) . "
				WHERE imagem_id = " . $this->model->quote( $parameters['imagem_id'])
			);
		}

		// exibo a mensagem de que o registro foi salvo com sucesso
		$this->view->setMessage('Registro salvo com sucesso.', $this->getLinkModule('admin_publicacao', 'admin_publicacaoImagemListar', array('publicacao_id' => $parameters['publicacao_id'])));
	}

	/**
	 * Set order of the question
	 *
	 */
	public function admin_publicacaoImagemSetOrder(){
		$parameters = $_GET;
		if($parameters['direction'] == 'down') $n = '1';
		if($parameters['direction'] == 'up') $n = '-1';

		// carrega informacoes da imagem
		$imagem = $this->model->getImagem($parameters['publicacao_id'], $parameters['imagem_id']);

		$result = $this->model->queryToArray("
			SELECT imagem_id, ordem FROM publicacao_imagem
			WHERE publicacao_id = " . $this->model->quote($imagem['publicacao_id']) . "
			AND imagem_tipo_id = " . $this->model->quote( $imagem['imagem_tipo_id'] ) . "
			ORDER BY ordem
		");

		foreach ( $result as $key => $value ){
			if( $parameters['imagem_id'] == $value['imagem_id'] ){
				if( $key + $n > count($result) -1 || $key + $n < 0){
					break;
				}
				$this->model->query("
					UPDATE publicacao_imagem SET
					ordem = " . $this->model->quote( $result[$key + $n]['ordem'] ) . "
					WHERE imagem_id = " . $this->model->quote( $parameters['imagem_id'] )
				);
				$this->model->query("
					UPDATE publicacao_imagem SET
					ordem = " . $this->model->quote( $value['ordem'] ) . "
					WHERE imagem_id = " . $this->model->quote( $result[$key + $n]['imagem_id'] )
				);
				break;
			}
		}

		// lista novamente
		$this->admin_publicacaoImagemListar( array('publicacao_id' => $parameters['publicacao_id'] ) );
	}

	public function admin_publicacaoImagemListar( $parameters = null ){
		$parameters = $parameters ? $parameters : $_REQUEST;
		$this->view->assign('imagens', $this->model->getImagem( $parameters['publicacao_id'] ));
		$this->view->assign('parameters', $parameters);
		$this->view->assign('publicacao', $this->model->getPublicacao(array('publicacao_id' => $parameters['publicacao_id'])));
		$this->view->setTemplate('admin_publicacao/imagens/list.tpl');
	}

	public function admin_publicacaoImagemExcluir(){
		$parameters = $_REQUEST;

		if( !$parameters['confirm'] ){
			$this->view->setConfirmation('Deseja realmente excluir este registro?');
			return false;
		}
		else {

			require_once('modules/admin_publicacao/PublicacaoImagem.php');
			$objPublicacaoImagem = new PublicacaoImagem($this->model->db);
			$objPublicacaoImagem->excluiImagem($parameters['imagem_id']);

			// exibe a mensagem de exclusao
			$this->view->setMessage('Registro excluido com sucesso.', $this->getLinkModule('admin_publicacao', 'admin_publicacaoImagemListar', array('publicacao_id' => $parameters['publicacao_id'])));
		}
	}

	public function admin_publicacaoImagemAbrir(){
		$parameters = $_GET;

		$imagem = $this->model->getImagem($parameters['publicacao_id'], $parameters['imagem_id']);
		$this->admin_publicacaoImagemShowForm(array('form' => $imagem));
	}

	/**
	 * Exibe formulario para adicionar nova imagem
	 *
	 */
	public function admin_publicacaoImagemNovo(){
		$parameters = $_GET;
		$this->admin_publicacaoImagemShowForm( array('form' => $parameters) );
	}

	/**
	 * Realiza a validacao do formulario da imagem enviada
	 *
	 * @param array $parameters
	 * @return array
	 */
	private function admin_publicacaoImagemValidateForm( $parameters = null ){

		// se caso nao informado o id da imagem, entao o usuario esta tentando adicionar a imagem
		if( !$parameters['imagem_id'] ){

			// testa se foi informado o tipo da imagem
			if( !$parameters['imagem_tipo_id']){
				$error['imagem_tipo_id'] = 'Campo requerido';
			}

			// testa se o tipo de arquivo eh um tipo de arquivo valido
			if(
				   $parameters['file']['arquivo']['type'] != 'image/jpeg'
				&& $parameters['file']['arquivo']['type'] != 'image/pjpeg'
			){
				$error['arquivo'] = 'Tipo de arquivo invalido.';
			}
		}

		if( !$parameters['titulo'] ){
			$error['titulo'] = 'Campo requerido';
		}

		return (array) $error;
	}

	/**
	 * Exibe o formulari para cadastro de imagem
	 *
	 */
	private function admin_publicacaoImagemShowForm( $parameters ){

		// carrega os tipo de imagem
		// obtem o tipo de obra (para listar somente as imagens relativas)
		$publicacao = $this->model->getPublicacao(array('publicacao_id' => $parameters['form']['publicacao_id']));
		$result = $this->model->queryToArray("
			SELECT tipo_id_imagens FROM publicacao_tipo
			WHERE publicacao_tipo_id = " . $this->model->quote( $publicacao['publicacao_tipo_id'] )
		);

		$parameters['form']['imagem_tipo'] = $this->model->queryToArray("
			SELECT * FROM imagem_tipo
			WHERE imagem_tipo_id IN (".$result[0]['tipo_id_imagens'].")
			ORDER BY tipo
		");

		$this->view->assign('form', $parameters['form']);
		if( isset($parameters['error']) ) {
			$this->view->assign('error', $parameters['error']);
		}			
		$this->view->assign('publicacao', $this->model->getPublicacao(array('publicacao_id' => $parameters['form']['publicacao_id'])));
		$this->view->setTemplate('admin_publicacao/imagens/form.tpl');
	}

	// ----------------------------------------------------------------------
	// METODOS RELATIVOS AO DETALHAMENTO DA PUBLICACAO

	public function admin_publicacaoDetalhesEditar(){
		$parameters = $_GET;

		$publicacao = $this->model->getPublicacao(array('publicacao_id' => $parameters['publicacao_id']));
		$campos = $this->model->getCampos( $parameters['publicacao_id'] );

		foreach ( $campos as $campo ){
			$form['campo_' . $campo['campo_id']] = $this->model->getCampoValor($parameters['publicacao_id'], $campo['campo_id']);
		}

		// atribui os valores obtidos para o template
		$this->view->assign('publicacao', $publicacao);
		$this->view->assign('campos', $campos);
		$this->view->assign('form', $form);
		$this->view->setTemplate('admin_publicacao/detalhes/form.tpl');
	}

	public function admin_publicacaoDetalhesSalvar(){
		$parameters = $_POST;

		foreach ( $parameters as $key => $item ){
			if( substr($key, 0, 6) == 'campo_') {
				$this->model->setCampoValor( $parameters['publicacao_id'], str_replace('campo_', '', $key), $item);
			}
		}

		$this->view->setMessage(
			'Dados salvos com sucesso',
			$this->getLinkModule('admin_publicacao', 'admin_publicacaoEdit', array('publicacao_id' => $parameters['publicacao_id']))
		);
	}

	// ----------------------------------------------------------------------
	// METODOS RELATIVOS AO ANEXOS DA PUBLICACAO

	/**
	 * Realiza o download do arquivo
	 *
	 */
	public function downloadAnexo(){
		global $appConfig;
		$parameters = $_REQUEST;

		$result = $this->model->queryToArray("
			SELECT * FROM anexo WHERE anexo_id = " . $this->model->quote( $parameters['anexo_id'] )
		);
		$anexo = $result[0];

		require_once('LocalFS.php');
		LocalFS::showFile($appConfig['db_arquivos'] . $anexo['arquivo'], true, 'application/force-download', $anexo['nome_original']);
	}

	public function admin_publicacaoAnexoListar(){
		$parameters = $_REQUEST;

		$anexos = $this->model->getAnexo( $parameters['publicacao_id'] );
		$publicacao = $this->model->getPublicacao(array('publicacao_id' => $parameters['publicacao_id']));

		// atruibui os valores as variaveis e exibe o template listando os documentos
		$this->view->assign('anexos', $anexos);
		$this->view->assign('parameters', $parameters);
		$this->view->assign('publicacao', $publicacao);
		$this->view->setTemplate('admin_publicacao/anexo/list.tpl');
	}

	/**
	 * Exibe o registro do documento para edicao
	 *
	 */
	public function admin_publicacaoAnexoAbrir(){
		$parameters = $_GET;
		$anexo = $this->model->getAnexo(null, $parameters['anexo_id']);
		$this->admin_publicacaoAnexoDisplayForm(array('form' => $anexo));
	}

	/**
	 * Exibe o formulario para adicionar nova obra
	 *
	 */
	public function admin_publicacaoAnexoNovo(){
		$parameters = $_GET;
		$this->admin_publicacaoAnexoDisplayForm( array('form' => $parameters ) );
	}

	public function admin_publicacaoAnexoExcluir(){
		$parameters = $_REQUEST;

		if( !$parameters['confirm'] ){
			$this->view->setConfirmation('Deseja realmente excluir este registro?');
			return false;
		}
		else {

			require_once('modules/admin_publicacao/PublicacaoAnexo.php');
			$objAnexo = new PublicacaoAnexo($this->model->db);
			$objAnexo->excluiAnexo($parameters['anexo_id']);

			// exibe a mensagem de exclusao
			$this->view->setMessage('Registro excluido com sucesso.', $this->getLinkModule('admin_publicacao', 'admin_publicacaoAnexoListar', array('publicacao_id' => $parameters['publicacao_id'])));
		}
	}

	/**
	 * Salva os dados do documento e tbm o anexo
	 *
	 */
	public function admin_publicacaoanexoSalvar(){
		global $appConfig;
		$parameters = $_REQUEST;

		// realiza a validacao do formulario
		$parameters['file'] = $_FILES;
		$error = $this->admin_publicacaoAnexoValidateForm($parameters);

		if( $error ){
			$this->admin_publicacaoAnexoDisplayForm(array('form' => $parameters, 'error' => $error));
			return;
		}

		// caso nao informado o id da imagem, entao o usuario esta adicionando uma nova imagem no sistema
		if( !$parameters['anexo_id'] ) {

			// define aqui o diretorio raiz onde serao armazenados os documentos
			$anexo_dir = $appConfig['db_arquivos'];

			// define aqui um nome para o arquivo
			while ( true ){
				$nome = $this->randomString();
				if( !file_exists($anexo_dir . $nome ) ){
					break;
				}
			}

			// salva o arquivo
			move_uploaded_file($_FILES['arquivo']['tmp_name'], $anexo_dir . $nome);

			// grava os dados do arqivo
			$this->model->query("
				INSERT INTO anexo SET
					publicacao_id = " . $this->model->quote( $parameters['publicacao_id'] ) . ",
					titulo = " . $this->model->quote( $parameters['titulo'] ) . ",
					arquivo = " . $this->model->quote( $nome ) . ",
					nome_original = " . $this->model->quote( $_FILES['arquivo']['name'] ) . ",
					data = NOW(),
					status = 1
			");
		}

		// caso informado o id do arquivo, entao eh apenas uma modificacao no cadastro
		else {
			$this->model->query("
				UPDATE anexo SET
					publicacao_id = " . $this->model->quote( $parameters['publicacao_id'] ) . ",
					titulo = " . $this->model->quote( $parameters['titulo'] ) . ",
					data = " . $this->model->quote($this->model->mysqlDate( $parameters['data'] )) . ",
					status = 1
				WHERE anexo_id = " . $this->model->quote( $parameters['anexo_id'])
			);
		}

		// exibo a mensagem de que o registro foi salvo com sucesso
		$this->view->setMessage('Registro salvo com sucesso.', $this->getLinkModule('admin_publicacao', 'admin_publicacaoAnexoListar', array('publicacao_id' => $parameters['publicacao_id'])));
	}

	/**
	 * Realiza a validacao do formulario do documento
	 *
	 * @param array $parameters
	 * @return array
	 */
	private function admin_publicacaoAnexoValidateForm( $parameters ){
		// se caso nao informado o id do documeto, entao o usuario esta tentando adicionar um NOVO documento
		if( !$parameters['anexo_id'] ){

			// testa se o tipo de arquivo eh um tipo de arquivo valido
			if( !$parameters['file']['arquivo']['name'] ){
				$error['arquivo'] = 'Informe um arquivo para upload.';
			}

		}

		// campos obrigatorios
		$requiredFields = array('titulo');
		foreach ( $requiredFields as $item ){
			if( !$parameters[$item] ){
				$error[$item] = 'Campo requerido';
			}
		}

		// testa se a data informada eh uma data valida
		/*
		$arr_data = explode('/', $parameters['data']);
		if(!checkdate($arr_data[1], $arr_data[0], $arr_data[2])){
			$error['data'] = 'Data informada e invalida';
		}
		 */

		return (array) $error;
	}

	/**
	 * Exibe o formulario com os dados passados em parametros
	 *
	 * @param array $parameters
	 */
	private function admin_publicacaoAnexoDisplayForm( $parameters = null ){

		// obtem os dados da obra
		$publicacao = $this->model->getPublicacao( array('publicacao_id' => $parameters['form']['publicacao_id']) );

		// Atribui os valores nas variaveis e define o template de exibicao do formulario
		$this->view->assign('publicacao', $publicacao);
		if( isset($parameters['form'] ) ) {
			$this->view->assign('form', $parameters['form']);
		}		
		if( isset($parameters['error'] )) {
			$this->view->assign('error', $parameters['error']);
		}
		$this->view->setTemplate('admin_publicacao/anexo/form.tpl');
	}
}

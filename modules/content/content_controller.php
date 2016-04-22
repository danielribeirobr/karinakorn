<?php

/**
 * content_controller.php - Gerenciamento de conteudo do site
 * @author Daniel Ribeiro <daniel@danielribeiro.com>
 * @since 2008-04-27
 */

require_once('ContentModel.php');
require_once(dirname(__FILE__) . '/../admin_publicacao/Publicacao.php');

class contentController extends Controller {

	/**
	 * @var ContentModel
	 */
	private $model;


	/**
	 * @var Publicacao
	 */
    private $modelPublicacao;

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

		$this->model = new ContentModel( $db );
		$this->modelPublicacao = new Publicacao( $db );
		$this->view = new View();

	}

	/**
	 * Default method
	 *
	 */
	public function _default(){
		$parameters = $_REQUEST;
		$parameters['page'] = isset($parameters['page']) ? $parameters['page'] : 'home';

		if( $parameters['page'] ){
			$this->showPage($parameters);
		}
	}

	/**
	 * Enviar mensagem de contato
	 *
	 */
	public function enviarMensagemContato(){
		$parameters = $_REQUEST;

		$camposEnviar = array('empresa', 'contato', 'endereco', 'bairro', 'cep', 'cidade', 'uf', 'ddd_telefone', 'mensagem');
		foreach ( $camposEnviar as $campo ){
			$value = $parameters[$campo];
			if( $campo == 'mensagem' ){
				$value = nl2br($value);
			}
			$body.= "<b>" . ucfirst($campo) . ": </b>" . $value . "<br/>";
		}

		// envia a mensagem para o dono do site
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: " . $parameters['email'] . "\n";
		$headers .= "Return-Path: " . $parameters['email'] . "\n";
		mail($parameters['departamento'] . "@thinkengenharia.com.br", "Contato atraves do site", $body, $headers);

		// define as configuracoes do template
		$template_confs = $this->getTemplateConfs('contato_ok');
		$this->view->assign('template_conf', $template_confs);
		$this->view->assign('parameters', $parameters);
		$this->view->assign('lateral_lancamento', $this->model->getLancamento($obra['obra_id'])); // define a lateral direita com os lancamentos
		$this->view->setTemplate($template_confs['template']);
	}

	/**
	 * Exibe a pagina correnpondente
	 *
	 * @param array $parameters
	 */
	public function showPage( $parameters = null ){
		$template_confs['template'] = 'content/home.tpl';

		switch ( $parameters['page'] ){

			// -------------- HOME ------------
			case 'home':
				$template_confs['template'] = 'content/home.tpl';
				break;

           // -------------- PROJETOS ------------
           case 'projetos':

                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);
		$publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
                $publicacao['CAMPOS'] = $this->modelPublicacao->loadCampos( $parameters['p_id'] );
		$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );

                $parameters['p_tipo_id'] = isset($parameters['p_tipo_id']) ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];
                $parameters['p_cat'] = isset($parameters['p_cat']) ? $parameters['p_cat'] : $publicacao['CAMPOS']['CATEGORIA'];
                $parameters['p_ano'] = isset($parameters['p_ano']) ? $parameters['p_ano'] : $publicacao['CAMPOS']['ANO'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id'],
                  'CAMPOS'             => array(
                    'ANO'              => $parameters['p_ano'],
                    'CATEGORIA'        => $parameters['p_cat']
                  )
                ));

                $this->view->assign('categorias', $this->model->getCampoValues(1, false, true));
                $this->view->assign('anos', $this->model->getCampoValues(3, false, true));
                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/projetos.tpl';
				break;

          // -------------- MOSTRAS ------------
           case 'mostras':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);
                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
                $publicacao['CAMPOS'] = $this->modelPublicacao->loadCampos( $parameters['p_id'] );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );

                $parameters['p_tipo_id'] = isset($parameters['p_tipo_id']) ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];
                $parameters['p_ano'] = isset($parameters['p_ano']) ? $parameters['p_ano'] : $publicacao['CAMPOS']['ANO'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id'],
                  'CAMPOS'             => array(
                    'ANO'              => $parameters['p_ano']
                  )
                ));

                $this->view->assign('anos', $this->model->getCampoValues(4));
                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/mostras.tpl';
				break;

			// -------------- MIDIA ------------
			case 'midia':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);
                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
                $publicacao['CAMPOS'] = $this->modelPublicacao->loadCampos( $parameters['p_id'] );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );
				$publicacao['ANEXOS'] = $this->modelPublicacao->getAnexo( $parameters['p_id'] );

                $parameters['p_tipo_id'] = isset($parameters['p_tipo_id']) ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];
                $parameters['p_cat'] = isset($parameters['p_cat']) ? $parameters['p_cat'] : $publicacao['CAMPOS']['CATEGORIA'];
                $parameters['p_ano'] = isset($parameters['p_ano']) ? $parameters['p_ano'] : $publicacao['CAMPOS']['ANO'];
				$parameters['p_mes'] = isset($parameters['p_mes']) ? $parameters['p_mes'] : $publicacao['CAMPOS']['MES'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id'],
                  'CAMPOS'             => array(
                    'ANO'              => $parameters['p_ano'],
					'MES'			   => $parameters['p_mes'],
                    'CATEGORIA'        => $parameters['p_cat']
                  )
                ));

                $this->view->assign('categorias', $this->model->getCampoValues(5));
                $this->view->assign('anos', $this->model->getCampoValues(7));
				$this->view->assign('meses', $this->model->getCampoValues(6));
                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/midia.tpl';
				break;

			// -------------- VIDEOS ------------
			case 'videos':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);
                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );				
				$publicacao['CAMPOS'] = $this->modelPublicacao->loadCampos( $parameters['p_id'] );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );

				$parameters['p_tipo_id'] = isset($parameters['p_tipo_id']) ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id']
                ));
				foreach( $publicacoes as $k => $item ) {
					if( $publicacao['publicacao_id'] == $item['publicacao_id'] ) {
						unset($publicacoes[$k]);
						continue;
					}
					$publicacoes[$k]['CAMPOS'] = $this->modelPublicacao->loadCampos( $item['publicacao_id'] );
					$publicacoes[$k]['IMAGENS'] = $this->modelPublicacao->loadImagens( $item['publicacao_id'] );
				}

                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/videos.tpl';
				break;

			// -------------- DICAS DECORACAO ------------
			case 'dicas_decoracao':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);

                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );

				$parameters['p_tipo_id'] = isset($parameters['p_tipo_id']) ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id']
                ));
				foreach( $publicacoes as $k => $item ) {
					if( $publicacao['publicacao_id'] == $item['publicacao_id'] ) {
						unset($publicacoes[$k]);
						continue;
					}
					$publicacoes[$k]['IMAGENS'] = $this->modelPublicacao->loadImagens( $item['publicacao_id'] );
				}

                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);

                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/dicas_decoracao.tpl';
				break;

			// -------------- RESPONSABILIDADE SOCIAL ------------
			case 'responsabilidade_social':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);

                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );

				$parameters['p_tipo_id'] = isset($parameters['p_tipo_id']) ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id']
                ));
				foreach( $publicacoes as $k => $item ) {
					if( $publicacao['publicacao_id'] == $item['publicacao_id'] ) {
						unset($publicacoes[$k]);
						continue;
					}
					$publicacoes[$k]['IMAGENS'] = $this->modelPublicacao->loadImagens( $item['publicacao_id'] );
				}

                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/responsabilidade_social.tpl';
				break;

			// -------------- PERSONALIDADES ------------
			case 'personalidades':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);

                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );

				$parameters['p_tipo_id'] = $parameters['p_tipo_id'] ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id']
                ));
				foreach( $publicacoes as $k => $item ) {
					if( $publicacao['publicacao_id'] == $item['publicacao_id'] ) {
						unset($publicacoes[$k]);
						continue;
					}
					$publicacoes[$k]['IMAGENS'] = $this->modelPublicacao->loadImagens( $item['publicacao_id'] );
				}

                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/personalidades.tpl';
				break;

			// -------------- NEWS ------------
			case 'news':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);

                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );
				$publicacao['ANEXOS'] = $this->modelPublicacao->getAnexo( $parameters['p_id'] );

				$parameters['p_tipo_id'] = $parameters['p_tipo_id'] ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id']
                ));
				foreach( $publicacoes as $k => $item ) {
					if( $publicacao['publicacao_id'] == $item['publicacao_id'] ) {
						unset($publicacoes[$k]);
						continue;
					}
					$publicacoes[$k]['IMAGENS'] = $this->modelPublicacao->loadImagens( $item['publicacao_id'] );
				}

                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/news.tpl';
				break;

			// -------------- AGENDA ------------
			case 'agenda':
                $parameters['p_id'] = isset($parameters['p_id']) ? $parameters['p_id'] : $this->model->getPublicacaoDefault($parameters);

                $publicacao = $this->modelPublicacao->getPublicacao( array('publicacao_id' => $parameters['p_id']) );
				$publicacao['IMAGENS'] = $this->modelPublicacao->loadImagens( $parameters['p_id'] );
				$publicacao['CAMPOS'] = $this->modelPublicacao->loadCampos( $parameters['p_id'] );

				$parameters['p_tipo_id'] = $parameters['p_tipo_id'] ? $parameters['p_tipo_id'] : $publicacao['publicacao_tipo_id'];

                $publicacoes = $this->modelPublicacao->getPublicacao(array(
                  'publicacao_tipo_id' => $parameters['p_tipo_id']
                ));
				foreach( $publicacoes as $k => $item ) {
					if( $publicacao['publicacao_id'] == $item['publicacao_id'] ) {
						unset($publicacoes[$k]);
						continue;
					}
					$publicacoes[$k]['IMAGENS'] = $this->modelPublicacao->loadImagens( $item['publicacao_id'] );
					$publicacoes[$k]['CAMPOS'] = $this->modelPublicacao->loadCampos( $item['publicacao_id'] );
				}

                $this->view->assign('publicacao', $publicacao);
                $this->view->assign('publicacoes', $publicacoes);
                $this->view->assign('parameters', $parameters);

				$template_confs['template'] = 'content/agenda.tpl';
				break;
		}

		$this->view->assign('banners', $this->model->loadBanners($parameters['page']) );
		$this->view->assign('destaques', $this->model->getDestaques() );
		$this->view->assign('parameters', $parameters);
		$this->view->setTemplate($template_confs['template']);
	}

	public function bannerClick()
	{
		$parameters = $_REQUEST;
		$result = $this->model->queryToArray("SELECT banner_id, link FROM banner WHERE banner_id = " . $this->model->quote( $parameters['banner_id'] ) );
		$banner = $result[0];
		if( $banner ){
			$this->model->query("
				INSERT INTO banner_log SET
				type = 2,
				banner_id = " . $this->model->quote( $banner['banner_id'] ) . ",
				ip = " . $this->model->quote($_SERVER['REMOTE_ADDR']) . "
			");
			header('Location: ' . $banner['link'] );
			exit;
		} else {
			echo 'banner nao encontrado';
			exit;
		}
	}

	/**
	 * Exibe uma imagem de acordo com o id informado
	 *
	 */
	public function showImg(){
		$parameters = $_REQUEST;

		// verifica se existe o arquivo no diretorio temp (para nao precisar redimensionar novamente)
		$tempFile = 'temp/' . $parameters['imagem_id'] . '_' . $parameters['l'] . '_' . $parameters['a'];
		if( !file_exists( $tempFile ) ) {

			// obtem o registro da imagem
			$img = $this->model->getImagem($parameters['imagem_id']);
			if(!$img){
				die('imagem nao encontrada no sistema');
			}

			// resize da imagem
			// requisita a biblioteca de redimensionamento de imagem e cria o objeto para redimensionamento
			require_once('includes/ResizeImage.class.php');
			$objImg = new ResizeImage();

			// salva a imagem
			if( $parameters['l'] ){
				$objImg->setWidth((int) $parameters['l']);
			}
			if( $parameters['a'] ){
				$objImg->setHeight((int) $parameters['a']);
			}
			$objImg->setProportions(true);
			$objImg->setSource($this->appConfig['base'] . $this->appConfig['db_imagens'] . $img['arquivo']);
			$objImg->setDestination( $tempFile );
			$objImg->Resize();
		}

		header('Content-Type: image/jpeg');
		readfile( $tempFile );
	}

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

}

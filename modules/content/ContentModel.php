<?php

/**
 * Classe modelo de conteudo
 *
 */

require_once('Model.php');

class ContentModel extends Model {

	/**
	 * Metodo construtor
	 *
	 */
	public function __construct( $db ){
		parent::__construct( $db );
	}

    public function getCampoValues( $campo_id, $allValues = false, $inverse = false )
    {
	  $result = $this->queryToArray("SELECT * FROM campo WHERE campo_id = " . $this->quote( $campo_id ) );
	  $campo = $result[0];
	  if( $campo ) {
		if( $campo['campo_tipo'] == 'combo') {
			$values = explode(',', $campo['values']);
		} else {
			$results = $this->queryToArray("SELECT distinct(valor) FROM publicacao_campo WHERE campo_id = " . $campo['campo_id'] . " ORDER BY valor " . ($inverse ? " DESC " : " ASC "));
			foreach( $results as $item ) {
			  $values[] = $item['valor'];
			}
		}
	  }
		return isset($values) ? $values : array();
    }

	/**
	 * Retorna a imagem pelo ID
	 *
	 * @param int $imagem_id
	 * @return array
	 */
	public function getImagem($imagem_id){
		$result = $this->queryToArray("SELECT * FROM imagem WHERE imagem_id = " . $this->quote($imagem_id));
		if( !$result[0]['imagem_id'] ){
			return false;
		}
		else {
			return $result[0];
		}
	}

	public function getPublicacaoDefault( $parameters = null ) {
		if(
			$parameters['page'] == 'projetos'
			|| $parameters['page'] == 'mostras'
			|| $parameters['page'] == 'midia'
			|| $parameters['page'] == 'videos'
			|| $parameters['page'] == 'dicas_decoracao'
			| $parameters['page'] == 'responsabilidade_social'
			|| $parameters['page'] == 'personalidades'
			|| $parameters['page'] == 'news'
			|| $parameters['page'] == 'agenda'
		) {
			$publicacaoTiposIdsPorPagina = array(
				'projetos'			=> 1,
				'mostras'			=> 2,
				'midia'				=> 9,
				'videos'			=> 10,
				'dicas_decoracao'		=> 11,
				'responsabilidade_social'	=> 12,
				'personalidades'		=> 13,
				'news'				=> 14,
				'agenda'			=> 15,
			);

			// Filtro pelos campos adicionais da publicacao (se caso informados)
			$parametrosBuscaCampos = array();
			if( $parameters['p_cat'] ) {
				$parametrosBuscaCampos['CATEGORIA'] = $parameters['p_cat'];
			}
			if( $parameters['p_ano'] ) {
				$parametrosBuscaCampos['ANO'] = $parameters['p_ano'];
			}
			if( $parameters['p_mes'] ) {
				$parametrosBuscaCampos['MES'] = $parameters['p_mes'];
			}

			$objPublicacao = new Publicacao();
			$publicacoes = $objPublicacao->getPublicacao(array(
				'publicacao_tipo_id'	=> $publicacaoTiposIdsPorPagina[$parameters['page']],
				'CAMPOS' 		=> $parametrosBuscaCampos
			));
			return $publicacoes[0]['publicacao_id'];
		}
	}

	public function loadBanners( $page )
	{
		$bannersPaginas = $this->getBannersPaginas();
		if( in_array( $page, $bannersPaginas ) ) {
			$filter = true;
		} else {
			$filter = false;
		}

		$query = "SELECT * FROM banner WHERE status = 1 ";
		if( $filter ) {
			$query.= " AND pagina LIKE '%". $page ."%'";
		}
		$query.= "ORDER BY RAND() LIMIT 10";
		$banners = $this->queryToArray($query);

		foreach( $banners as $item ) {
			$this->query("
				INSERT INTO banner_log SET
					type = 1,
					banner_id = " . $this->quote( $item['banner_id']) . ",
					ip = " . $this->quote($_SERVER['REMOTE_ADDR']) . "
			");
		}

		return $banners;
	}

	public function getDestaques()
	{
		$modelPublicacao = new Publicacao( $this->db );
		$destaques = array(
			'DICAS_DECORACAO'	=> $modelPublicacao->getPublicacao( array('publicacao_id' => $this->getPublicacaoDefault( array('page' => 'dicas_decoracao') ))),
			'AGENDA'			=> $modelPublicacao->getPublicacao( array('publicacao_id' => $this->getPublicacaoDefault( array('page' => 'agenda') ))),
			'PERSONALIDADES'	=> $modelPublicacao->getPublicacao( array('publicacao_id' => $this->getPublicacaoDefault( array('page' => 'personalidades'))))
		);
		foreach( $destaques as $k => $destaque ) {
			$destaques[$k]['IMAGENS'] = $modelPublicacao->getImagem( $destaque['publicacao_id'] );
		}
		return $destaques;
	}

	/**
	 *
	 * @return array
	 */
	public function getBannersPaginas(){
		return array(
			'home',
			'perfil',
			'projetos',
			'mostras',
			'midia',
			'videos',
			'dicas_decoracao',
			'responsabilidade_social',
			'parceiros',
			'personalidades',
			'news',
			'agenda'
		);
	}

}

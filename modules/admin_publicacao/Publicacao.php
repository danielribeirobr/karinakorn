<?php

/**
 * Classe modelo de publicacao
 *
 */

require_once('Model.php');

class Publicacao extends Model {

	/**
	 * Metodo construtor
	 *
	 */
	public function __construct( $db = null ){
		parent::__construct( $db );
	}

	/**
	 * Retorna um array com detalhes da publicacao passado nos parametros
	 *
	 * @param array $parameters
	 * @return array
	 */
	public function getPublicacao( $parameters = null ){

		// Se nao passado nada, entao retorno tdo
		$query = "SELECT * FROM publicacao";

		// Filtro padrao
		$filters[] = " WHERE 1 ";
      
		// Filtro pelo ID
		if( isset($parameters['publicacao_id']) && $parameters['publicacao_id']){
			$filters[] = " publicacao.publicacao_id = " . $this->quote( $parameters['publicacao_id'] );
		}

		// se passado a identificacao devo localizar as publicacoes com essa identificacao
		if( isset($parameters['identificacao']) &&  $parameters['identificacao'] ){
			$filters[] = " identificacao LIKE " . $this->quote('%' . $parameters['identificacao'] . '%');
		}
      
		// filtrando por tipo
		if( isset($parameters['publicacao_tipo_id']) && $parameters['publicacao_tipo_id'] ) {
			$filters[] = " publicacao.publicacao_tipo_id = " . $this->quote($parameters['publicacao_tipo_id']);
		}

		// aplica os filtros
		$query.= join(" AND ", $filters );

		// criando os filtros de campos
		if( isset($parameters['CAMPOS']) && $parameters['CAMPOS'] && is_array( $parameters['CAMPOS'] ) ) {
			foreach( $parameters['CAMPOS'] as $campo => $valor ) {
				if( !$valor ) {
					continue;
				}
				$queryCampos[] = "
					SELECT publicacao_id FROM
						publicacao_campo
					INNER JOIN campo USING (campo_id)
					WHERE
						campo.tag = " . $this->quote( $campo ) . "
						AND publicacao_campo.valor = " . $this->quote( $valor ) . "
				";
			}
			if( isset( $queryCampos ) ) {
				$query.= " AND publicacao_id IN (" . join (") AND publicacao_id IN (", $queryCampos) . ')';
			}
		}
		$query.= " ORDER BY publicacao.ordem DESC, publicacao.publicacao_id DESC ";

		$results = $this->queryToArray( $query );
		if( isset($parameters['publicacao_id']) && count($results) ) {
		  $results = $results[0];
		}

		return $results;
	}

	public function getPublicacaoTipo( $publicacao_tipo_id )
	{
		$result = $this->queryToArray("SELECT * from publicacao_tipo WHERE publicacao_tipo_id = " . $this->quote( $publicacao_tipo_id ));
		return $result[0];
	}

	/**
	 * Salva uma publicacao no banco
	 *
	 * @param array $parameters
	 * @return int retorna o id da publicacao salva
	 */
	public function salvarPublicacao($parameters){
		if( isset($parameters['publicacao_id']) ){
			$query = "
				UPDATE publicacao SET
					identificacao = " . $this->quote( $parameters['identificacao'] ) . ",
					titulo = " . $this->quote( $parameters['titulo'] ) . ",
					titulo_2 = " . $this->quote( isset($parameters['titulo_2']) ? $parameters['titulo_2'] : '' ) . ",
					descricao = " . $this->quote( $parameters['descricao'] ) . ",
					descricao_2 = " . $this->quote( isset($parameters['descricao_2']) ? $parameters['descricao_2'] : '' ) . ",
					date_update = NOW(),
					user_id = " . $this->quote( isset($parameters['user_id']) ? $parameters['user_id'] : '' ) . "
				WHERE
					publicacao_id = " . $this->quote( $parameters['publicacao_id'] ) . "
			";
			$this->query($query);
		}
		else {

			// obtem a proxima ordem da publicacao
			$result = $this->queryToArray("
				SELECT
					MAX(ordem) AS ordem
				FROM publicacao
				WHERE
					publicacao_tipo_id = " . $this->quote( $parameters['publicacao_tipo_id'] )
			);
			$ordem = $result[0]['ordem'] ? ($result[0]['ordem'] + 1) : 1;

			// query de insercao no banco
			$query = "
				INSERT INTO publicacao SET
					identificacao = " . $this->quote( $parameters['identificacao'] ) . ",
					titulo = " . $this->quote( $parameters['titulo'] ) . ",
					publicacao_tipo_id = " . $this->quote( $parameters['publicacao_tipo_id'] ) . ",
					date_update = NOW(),
					descricao = " . $this->quote( $parameters['descricao'] ) . ",
					ordem = " . $this->quote( $ordem ) . "
			";
			$this->query($query);
			$parameters['publicacao_id'] = $this->lastInsertId('publicacao');
		}

		return $parameters['publicacao_id'];
	}

	/**
	 * Exclui a publicacao do sistema (e tdo relacionado a ela)
	 *
	 */
	public function excluiPublicacao( $publicacao_id ){

		// elimina as imagens da publicacao
		require_once('modules/admin_publicacao/PublicacaoImagem.php');
		$imagens = $this->getImagem($publicacao_id);
		foreach( $imagens as $imagem ) {
			$objImg = new PublicacaoImagem( $this->db );
			$objImg->excluiImagem( $imagem['imagem_id'] );
		}

		// elimina os anexos da publicacao
		require_once('modules/admin_publicacao/PublicacaoAnexo.php');
		$anexos = $this->getAnexo($publicacao_id);
		foreach( $anexos as $anexo ) {
			$objAnexo = new PublicacaoAnexo( $this->db );
			$objAnexo->excluiAnexo( $anexo['anexo_id'] );
		}

		// elimina os dados de campos adicinoais
		$this->query("DELETE FROM publicacao_campo WHERE publicacao_id = " . $this->quote( $publicacao_id ) );

		// elimina a publicacao
		$this->query("DELETE FROM publicacao WHERE publicacao_id = " . $this->quote( $publicacao_id ) );
	}

	/**
	 * Retorna um array com as imagens da publicacao (se informado o id da imagem entao retorno
	 * os dados de uma imagem especifica
	 *
	 * @param int $publicacao_id
	 * @param int $imagem_id
	 * @return array
	 */
	public function getImagem( $publicacao_id = null , $imagem_id = null, $tag = null){
		if( $imagem_id && !$publicacao_id) {
			$query = "
				SELECT
					*.imagem
				FROM imagem
				WHERE
					imagem_id = " . $this->quote( $imagem_id )
			;
			$result = $this->queryToArray( $query );
			return $result[0];
		}
		elseif ($publicacao_id && !$imagem_id ) {
			$query = "
				SELECT
					imagem.*,
					imagem_tipo.tipo AS imagem_tipo,
					imagem_tipo.tag AS TAG
				FROM imagem
				INNER JOIN publicacao_imagem USING (imagem_id)
				INNER JOIN imagem_tipo USING (imagem_tipo_id)
				WHERE
					publicacao_imagem.publicacao_id = "  . $this->quote( $publicacao_id ) . "
					" . ( $tag ? " imagem_tipo.tag = " . $this->quote( $tag ) : '' ) . "
				ORDER BY imagem_tipo.tipo, publicacao_imagem.ordem
			";
			return $this->queryToArray( $query );
		}
		elseif ( $publicacao_id && $imagem_id ){
			$query = "
				SELECT
					imagem.*,
					imagem_tipo.tipo AS imagem_tipo,
					publicacao_imagem.*
				FROM imagem
				INNER JOIN publicacao_imagem USING (imagem_id)
				INNER JOIN imagem_tipo USING (imagem_tipo_id)
				WHERE
					publicacao_imagem.publicacao_id = "  . $this->quote( $publicacao_id ) . "
					AND imagem.imagem_id = " . $this->quote( $imagem_id );
			$result = $this->queryToArray( $query );
			return $result[0];
		}
	}

	/**
	 * Retorna os campos que podem ser preenchidos em uma publicacao
	 *
	 * @param int $publicacao_id
	 * @return array
	 */
	public function getCampos( $publicacao_id ){
		// obtem o tipo da publicacao
		$result = $this->queryToArray("SELECT publicacao_tipo_id FROM publicacao WHERE publicacao_id = " . $this->quote( $publicacao_id ) );
		$publicacao_tipo_id = $result[0]['publicacao_tipo_id'];

		// realiza a busca trazendo somente os campos que estao associados a este tipo de publicacao
		$query = "
			SELECT * FROM campo
			WHERE publicacao_tipo_id LIKE " . $this->quote('%|' . $publicacao_tipo_id . '|%') . "
			ORDER BY ordem, campo
		";
		$results = $this->queryToArray( $query );

		foreach( $results as $i => $result ) {
			if( $result['campo_tipo'] == 'combo' ) {
				$results[$i]['values'] = explode(',', $result['values']);
			}
		}

		return $results;
	}

    public function loadCampos( $publicacao_id ) {
      $query = "
         SELECT
            campo.tag, publicacao_campo.valor
         FROM publicacao_campo
         INNER JOIN campo USING (campo_id)
         WHERE publicacao_id = " . $this->quote( $publicacao_id ) . "
      ";
      $result = $this->queryToArray( $query );
      $campos = array();
      foreach( $result as $item ) {
        $campos[$item['tag']] = $item['valor'];
      }
      return $campos;
    }

	public function loadImagens( $publicacao_id ) {
		$query = "
			SELECT imagem.*, imagem_tipo.tag FROM imagem
			INNER JOIN publicacao_imagem USING (imagem_id)
			INNER JOIN imagem_tipo USING (imagem_tipo_id)
			WHERE publicacao_imagem.publicacao_id = " . $this->quote( $publicacao_id ) . "
			ORDER BY publicacao_imagem.ordem, imagem.imagem_id
		";
		return $this->queryToArray( $query );
	}
	
	/**
	 * Retorna os dados de um anexo da publicacao
	 *
	 * @param int $publicacao_id
	 * @param int $anexo_id
	 */
	public function getAnexo($publicacao_id, $anexo_id = null){
		if( $anexo_id ){
			$query = "
				SELECT
					anexo.*
				FROM anexo
				WHERE anexo_id = " . $this->quote( $anexo_id ) . "
				ORDER BY anexo.titulo";
			$result = $this->queryToArray( $query );
			return  $result[0];
		}
		else {
			$query = "
				SELECT
					anexo.*
				FROM anexo
				WHERE publicacao_id = " . $this->quote( $publicacao_id ) . "
				ORDER BY anexo.titulo";
			return $this->queryToArray( $query );
		}
	}

	/**
	 * Obtem o valor de um campo de acordo com a tag
	 *
	 * @param int $publicacao_id
	 * @param int $tag
	 * @return string
	 */
	public function getCampoValor( $publicacao_id, $campo_id ){
		$query = "
			SELECT
				valor
			FROM publicacao_campo
			WHERE
				publicacao_id = " . $this->quote( $publicacao_id ) . "
				AND campo_id = " . $this->quote( $campo_id )
		;
		$result = $this->queryToArray( $query);
		return $result[0]['valor'];
	}

	/**
	 * Define o valor do campo de uma publicacao
	 *
	 * @param int $publicacao_id
	 * @param int $campo_id
	 * @param string $valor
	 */
	public function setCampoValor( $publicacao_id, $campo_id, $valor ){

		//$valor = stripslashes($valor);

		// se caso valor nao esteja definido, entao apago o registro d banco
		if( !$valor ) {
			$this->query("DELETE FROM publicacao_campo WHERE campo_id = " . $this->quote($campo_id) . " AND publicacao_id = " . $this->quote($publicacao_id));
			return;
		}

		// verifica se o registro ja existe, pois se ja existir, devo fazer um update, se nao existir, devo fazer um include
		$result = $this->queryToArray("
			SELECT COUNT(*) AS n FROM publicacao_campo
			WHERE
				publicacao_id = " . $this->quote( $publicacao_id ) . "
				AND campo_id = " . $this->quote( $campo_id )
		);

		// se ja existe (UPDATE)
		if( $result[0]['n'] ){
			$query = "
				UPDATE publicacao_campo SET
					valor = " . $this->quote( $valor ) . "
				WHERE
					publicacao_id = " . $this->quote( $publicacao_id ) . "
					AND campo_id = " . $this->quote( $campo_id )
			;
		}
		// se nao existe (INSERT)
		else{
			$query = "
				INSERT INTO publicacao_campo SET
					valor = " . $this->quote( $valor ) . ",
					publicacao_id = " . $this->quote( $publicacao_id ) . ",
					campo_id = " . $this->quote( $campo_id )
			;
		}
		$this->query( $query );
	}  

}

?>

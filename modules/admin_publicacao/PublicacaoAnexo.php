<?php

class PublicacaoAnexo {

	/**
	 * Objecto modelo
	 *
	 * @var Model
	 */
	public $model;

	/**
	 * @var Publicacao
	 */
	public $anexo_model;

	public function __construct( $db ){
		$this->model = new Model($db);
		$this->anexo_model = new Publicacao($db);
	}

	/**
	 *
	 * @param int $imagem_id
	 */
	public function excluiAnexo($anexo_id){
		global $appConfig;

		// obtem dados do registro
		$anexo = $this->getAnexo($anexo_id);

		// exclui o arquivo
		unlink($appConfig['db_arquivos'] . $anexo['arquivo']);

		// exclui o registro
		$this->model->query("DELETE FROM anexo WHERE anexo_id = " . $this->model->quote( $anexo_id ) );
	}

	/**
	 *
	 * @param int $anexo_id
	 * @return array
	 */
	public function getAnexo($anexo_id){
		$result = $this->model->queryToArray("
			SELECT * FROM anexo
			WHERE anexo_id = " . $this->model->quote( $anexo_id )
		);
		return $result[0];
	}

}

?>
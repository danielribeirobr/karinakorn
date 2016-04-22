<?php

class PublicacaoImagem {

	/**
	 * Objecto modelo
	 *
	 * @var Model
	 */
	public $model;

	/**
	 *
	 */
	public $publicacao_model;

	public function __construct( $db ){
		$this->model = new Model($db);
		$this->publicacao_model = new Publicacao($db);
	}

	/**
	 * @param int $imagem_id
	 */
	public function excluiImagem($imagem_id){
		global $appConfig;

		$parameters['imagem_id'] = $imagem_id;

		$result = $this->model->queryToArray("
			SELECT publicacao_id FROM publicacao_imagem
			WHERE imagem_id = " . $this->model->quote($imagem_id)
		);
		$parameters['publicacao_id'] = $result[0]['publicacao_id'];

		// obtem dados do registro
		$imagem = $this->publicacao_model->getImagem($parameters['publicacao_id'], $parameters['imagem_id']);

		// exclui o arquivo
		unlink($appConfig['db_imagens'] . $imagem['arquivo']);

		// exclui o registro
		$this->model->query("DELETE FROM imagem WHERE imagem_id = " . $this->model->quote( $parameters['imagem_id'] ) );
		$this->model->query("DELETE FROM publicacao_imagem WHERE imagem_id = " . $this->model->quote( $parameters['imagem_id'] ) );
	}

}

?>
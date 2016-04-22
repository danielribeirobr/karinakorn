<?php

/**
 * Author: Daniel Ribeiro <daniel@danielribeiro.com>
 */

// requista o pacote MDB2 da PEAR
require_once('MDB2.php');

class Model{

	/**
	 * Connection link
	 *
	 * @var MDB2
	 */
	public $db;

	/**
	 * Class constructor
	 *
	 * @return Model
	 */
	function __construct( $db = null, $dsn = null ){
		global $appConfig;
		$this->db = $db;

		// if not informed the link, open a new connection
		if ( !$this->db ){
			$this->startDb( $dsn ? $dsn : $appConfig['dsn'] );
		}

	}

	/**
	 * Return the id of the last record inserted
	 *
	 * @param string $table
	 * @param string $field
	 * @return int
	 */
	public function lastInsertId( $table = null, $field = null ){
		return $this->db->lastInsertID( $table, $field );
	}

	/**
	 * Execute a query and return the data in array format
	 *
	 * @param string $query
	 * @return array
	 */
	public function queryToArray( $query ){
		return $this->resultToArray( $this->query( $query ) );
	}

	/**
	 * Exectute a query returning:
	 * 	resource (if a query)
	 * 	int if a command to affect rows (return number of affect rows)
	 *	false a error ocuurs
	 *
	 * @param string $strSql
	 * @param string type ('query' ou 'exec') to force execution
	 */
	public function query( $query, $type = null ){

		// verifica se eh uma query um um comando
		if( strtoupper(substr(trim($query), 0, 6)) == 'SELECT' || $type == 'query'){
			$result = $this->db->query( $query );
		}

		// se for um comando executo com o exec
		else{
			$result = $this->db->exec( $query );
		}

		if (PEAR::isError($result)) {
			Controller::error($result->userinfo, false, true);
		    return false;
		}

		return $result;
	}

	/**
	 * Return a number of affectrows
	 *
	 * @param MDB2 result
	 * @return int
	 */
	public function getAffectedRows( $result ){
		return $result->db->supported['affected_rows'];
	}

	/**
	 * Return a array with a query result
	 *
	 * @param result $result
	 * @param constant $fetch_mode
	 * @return @array
	 */
	public function resultToArray( $result, $fetch_mode = MDB2_FETCHMODE_ASSOC){
		$arrResult = array();

		while ($row = $result->fetchRow( $fetch_mode )) {
		    $arrResult[] = $row;
		}

		return $arrResult;
	}

	/**
	 * Quote a string
	 *
	 * @param mixed $string
	 * @return mixed
	 */
	public function quote( $string ){
		return $this->db->quote( $string );
	}

	/**
	 * Recebe como parametro um array associativo com os dados e retorna um array associativo
	 * usando chave o valor em $key_index e value o valor em $key_value
	 *
	 * @param array $array
	 * @param string $key_index se nao informado, cria indices numericos (0, 1, 2...)
	 * @param string $key_value se nao informado, obtem o valor do primeiro indice de @array
	 * @return array
	 */
	public function arrayGetAssoc( $array, $key_index = null, $key_value = null){

		// se o item do array informado nao houver chaves, retorno vazio
		if(!$array[0]) return array();
		$keys = array_keys( $array[0] );
		if(!count($keys)) return array();

		// verifica se o key_index informado tem no elemento
		if( $key_index and !in_array($key_index, $keys) ){
			return array();
		}

		// verifica se o key_value informado tem no elemento
		if( $key_value and !in_array($key_value, $keys) ){
			return array();
		}

		// cria o array de resultado
		foreach ( $array as $value){
			$arr_result[ $key_index ? $key_index : count($arr_result) ] = $key_value ? $value[ $key_value ] : $value[$keys[0]];
		}

		return $arr_result;
	}

	/**
	 * Abre uma conexao com o banco usando MDB2 e retorna o objeto MDB2
	 *
	 * @param array $dsn
	 * @param array $options
	 *
	 */
	private function startDb( $dsn, $options = null ){
		$this->db =& MDB2::connect($dsn, $options);
		if (PEAR::isError($this->db)) {
			Controller::error('Error connection to database. ' . $this->db->userinfo, false, true);
		}

		/**
		 * Quando inicia a conexao com o banco de dados, eh necessario rodar essa query pq os dados estavam vindo com charset ISO8851-1
		 * e o correto eh vir com charset utf8, rodando a query no momento da conexao, resolve o problema
		 * Problema que deu muito trabalho pra resolver, inclusive fui em busca de foruns mas eu mesmo consegui achar a solucao
		 * (http://forum.imasters.com.br/index.php?showtopic=208140&st=0&gopid=703008)
		 */
		if( $dsn['phptype'] == 'mysql' ){
			$this->query("SET NAMES 'utf8'");
		}
	}

	/**
	 * Converte uma data em formato brasileiro para formato mysql
	 *
	 * @param string $date
	 * @return string
	 */
	public function mysqlDate( $date ){
		$arr = explode('/', $date);
		return $arr['2'] . '-' . $arr[1] . '-' . $arr[0];
	}

}

?>
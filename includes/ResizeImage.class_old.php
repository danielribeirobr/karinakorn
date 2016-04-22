<?php
/**
 * Classe: ResizeImage
 * Criado em: 2007-08-27
 * Autor: Daniel Ribeiro <daniel@danielribeiro.com>
 * Descricao: Redimensionamento de Imagens
 *
 * Como utilizar:
 *
 * // Aqui ira redidimensionar o arquivo imagem_origem.jpg para 200px de largura (altura calculada proporcionalmente)
 * $objResize = new ResizeImage();
 * $objResize->setSource('imagem_origem.jpg');
 * $objResize->setWidth(200);
 * $objResize->resize();
 *
 * //Aqui ira redidimensionar o arquivo imagem_origem para 200px de altura (largura calculada proporcionalmente)
 * $objResize = new ResizeImage();
 * $objResize->setSource('imagem_origem.jpg');
 * $objResize->setHeight(200);
 * $objResize->resize();
 *
 * //Os exemplos acima realizam a criacao do thumnail exibindo o resultado direto no browser, se caso for necessario
 * //que o thumbnail seja gravado em algum arquivo, entao use o metodo setDestination para especificar o arquivo:
 *
 * $objResize = new ResizeImage();
 * $objResize->setSource('imagem_origem.jpg');
 * $objResize->setDestination('imagem_thumb.jpg');
 * $objResize->setHeight(200);
 * $objResize->resize();
 *
 * A biblioteca funciona com imagens do tipo GIF, JPG, JPEG, PNG. Os resultados (thumbnails) gerados sempre serao em jpg
 * independente que qual for o tipo do arquivo de origem
 *
 * Por padrao todo redimensionamento de imagem eh feito usando larguras e alturas proporcionais. Se caso o redimensionamento
 * nao for proporcional, entao deve-se utilizar o metodo setProportions para desligar o redimensionamento proprorcional
 * $objResize->setProportions( false );
 *
 */

class ResizeImage {

	private $source;
	private $target;
	private $height;
	private $width;
	private $proportions;
	private $l1;
	private $a1;
	private $l2;
	private $a2;

	public function __construct(){
		$this->height = 0;
		$this->width = 0;
		$this->proportions = true;
	}

	/**
	 * Define a largura da imagem de destino (em pixels)
	 *
	 * @param int $int
	 */
	public function setWidth( $width ){
		if(!is_int($width)){
			die('A largura da imagem deve ser um numero inteiro');
		}
		$this->width = $width;
	}

	/**
	 * Define se o redimensionamento deve ser proporcional ou nao
	 *
	 * @param bool $bool
	 */
	public function setProportions( $bool ){
		$this->proportions = $bool;
	}

	/**
	 * Define a altura da imagem de destino (em pixels)
	 *
	 * @param int $height
	 */
	public function setHeight( $height ){
		if(!is_int($height)){
			die('A algura da imagem deve ser um numero inteiro');
		}
		$this->height = $height;
	}

	/**
	 * Define o arquivo que sera utilizado para redimensionamento
	 *
	 * @param string $source
	 */
	public function setSource( $source ){
		$this->source = $source;
	}

	/**
	 * Define o arquivo no qual sera armazenada a imagem redimensionada
	 *
	 * @param string $dest
	 */
	public function setDestination( $dest ){
		$this->target = $dest;
	}

	/**
	 * Realiza o redimensionamento da imagem
	 *
	 */
	public function Resize(){

		// Verifica a imagem
		$this->checkImage();

		// Calcula o novo tamanho da imagem
		$this->calculateNewSize();

		// Abre o arquivo da imagem
		if ($fp = @fopen($this->source, 'rb')) {
			$OriginalImageData = fread($fp, filesize($this->source));
			fclose($fp);
		}

		// Obtem o conteudo da imagem
		$src = @ImageCreateFromString($OriginalImageData);
		if(!$src){
			$fp = @fopen($this->source_error, 'rb');
			$OriginalImageData = fread($fp, filesize($this->source_error));
			fclose($fp);
			$src = @ImageCreateFromString($OriginalImageData);
		}

		// Realiza o redimensionamento
		if (function_exists('ImageCreateTrueColor')) {
			$im  = ImageCreateTrueColor($this->l2,$this->a2);
			@ImageCopyResampled($im, $src, 0, 0, 0, 0, $this->l2, $this->a2, imagesx($src), imagesy($src));
		} else {
			$im  = ImageCreate($newwidth, $newheight);
			ImageCopyResized($im, $src, 0, 0, 0, 0, $this->l2, $this->a2, imagesx($src), imagesy($src));
		}

		// gera a imagem redimensionada (se caso foi informado o arquivo de destino)
		if( $this->target ){
			if(!imagejpeg($im, $this->target, 70)){
				die('Nao foi possivel gravar a imagem de destino.');
			}
		}
		// ou entao, se nao foi informado nada, eu apenas exibo a imagem no browser
		else{
			header("Content-type: image/jpeg");
			imagejpeg($im, null, 70);
		}

	}

	/**
	 * Verifica o arquivo da imagem pra ver se eh um arquivo valido
	 * Se caso eh um arquivo valido o sistema ja obtem as dimensoes da imagem
	 *
	 */
	private function checkImage(){

		// Verifica se foi informado um arquivo para origem da imagem
		if(!file_exists($this->source) or !strlen($this->source)){
			die('Erro ao ler o arquivo de origem da imagem');
		}

		// Abre o arquivo da imagem
		if ($fp = @fopen($this->source, 'rb')) {
			$OriginalImageData = fread($fp, filesize($this->source));
			fclose($fp);
			$image = @ImageCreateFromString($OriginalImageData);

			// e caso nao conseguiu identificar que o arquivo eh uma imagem
			if(!$image){
				die('Arquivo de origem nao eh um arquivo de imagem valido.');
			}

			// obtem as dimensoes da imagem
			$this->l1 = @imagesx($image);
			$this->a1 = @imagesy($image);
		}
		else{
			die('Nao foi possivel ler o arquivo de origem da imagem');
		}

	}

	/**
	 * Calcula o tamanho da nova imagem para redimensionamento
	 *
	 */
	private function calculateNewSize(){

		// Se caso nao definido as medidas do thumbnail, usa as mesmas medidas da imagem original
		if(!$this->width) $this->width = $this->l1;
		if(!$this->height) $this->height = $this->a1;

		// Se caso for informado para manter as proporcoes da imagem,
		if($this->proportions){

			// Calcula primeiramente a largura
			$this->l2 = $this->width;
			@$this->a2 = ($this->a1 * $this->l2)/$this->l1;

			// Compara se a altura atribuida automaticamente eh maior do que a estipulada, caso for, tenho que redimensionar a altura
			if($this->a2>$this->height){
				$this->a2 = $this->height;
				$this->l2 = ($this->l1 * $this->a2)/$this->a1;
			}
		}

		// Se caso nah tiver que manter as proporcoes, entao redimensiono do jeito que foi solicitado
		else{
			$this->l2 = $this->width;
			$this->a2 = $this->height;
		}

		// Usado para obter somente a parte inteira do valor obtido
		$this->l2 = intval($this->l2);
		$this->a2 = intval($this->a2);

	}

}
?>
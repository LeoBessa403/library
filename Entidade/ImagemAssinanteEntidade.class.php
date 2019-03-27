<?php

/**
 * ImagemAssinante.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class ImagemAssinanteEntidade extends AbstractEntidade
{
	const TABELA = 'TB_IMAGEM_ASSINANTE';
	const ENTIDADE = 'ImagemAssinanteEntidade';
	const CHAVE = CO_IMAGEM_ASSINANTE;

	private $co_imagem_assinante;
	private $co_assinante;
	private $co_imagem;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_IMAGEM_ASSINANTE,
			CO_ASSINANTE,
			CO_IMAGEM,
		];
    }

	/**
	* @return array $relacionamentos
    */
	public static function getRelacionamentos() 
    {
    	$relacionamentos = Relacionamentos::getRelacionamentos();
		return $relacionamentos[static::TABELA];
	}


	/**
	* @return int $co_imagem_assinante
    */
	public function getCoImagemAssinante()
    {
        return $this->co_imagem_assinante;
    }

	/**
	* @param $co_imagem_assinante
    * @return mixed
    */
	public function setCoImagemAssinante($co_imagem_assinante)
    {
        return $this->co_imagem_assinante = $co_imagem_assinante;
    }

	/**
	* @return AssinanteEntidade $co_assinante
    */
	public function getCoAssinante()
    {
        return $this->co_assinante;
    }

	/**
	* @param $co_assinante
    * @return mixed
    */
	public function setCoAssinante($co_assinante)
    {
        return $this->co_assinante = $co_assinante;
    }

	/**
	* @return ImagemEntidade $co_imagem
    */
	public function getCoImagem()
    {
        return $this->co_imagem;
    }

	/**
	* @param $co_imagem
    * @return mixed
    */
	public function setCoImagem($co_imagem)
    {
        return $this->co_imagem = $co_imagem;
    }

}
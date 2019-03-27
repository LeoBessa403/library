<?php

/**
 * Anotacao.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class AnotacaoEntidade extends AbstractEntidade
{
	const TABELA = 'TB_ANOTACAO';
	const ENTIDADE = 'AnotacaoEntidade';
	const CHAVE = CO_ANOTACAO;

	private $co_anotacao;
	private $dt_cadastro;
	private $ds_observacao;
	private $ds_titulo;
	private $co_historia;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_ANOTACAO,
			DT_CADASTRO,
			DS_OBSERVACAO,
			DS_TITULO,
			CO_HISTORIA,
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
	* @return int $co_anotacao
    */
	public function getCoAnotacao()
    {
        return $this->co_anotacao;
    }

	/**
	* @param $co_anotacao
    * @return mixed
    */
	public function setCoAnotacao($co_anotacao)
    {
        return $this->co_anotacao = $co_anotacao;
    }

	/**
	* @return mixed $dt_cadastro
    */
	public function getDtCadastro()
    {
        return $this->dt_cadastro;
    }

	/**
	* @param $dt_cadastro
    * @return mixed
    */
	public function setDtCadastro($dt_cadastro)
    {
        return $this->dt_cadastro = $dt_cadastro;
    }

	/**
	* @return mixed $ds_observacao
    */
	public function getDsObservacao()
    {
        return $this->ds_observacao;
    }

	/**
	* @param $ds_observacao
    * @return mixed
    */
	public function setDsObservacao($ds_observacao)
    {
        return $this->ds_observacao = $ds_observacao;
    }

	/**
	* @return mixed $ds_titulo
    */
	public function getDsTitulo()
    {
        return $this->ds_titulo;
    }

	/**
	* @param $ds_titulo
    * @return mixed
    */
	public function setDsTitulo($ds_titulo)
    {
        return $this->ds_titulo = $ds_titulo;
    }

	/**
	* @return HistoriaEntidade $co_historia
    */
	public function getCoHistoria()
    {
        return $this->co_historia;
    }

	/**
	* @param $co_historia
    * @return mixed
    */
	public function setCoHistoria($co_historia)
    {
        return $this->co_historia = $co_historia;
    }

}
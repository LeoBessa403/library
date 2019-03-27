<?php

/**
 * Sessao.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class SessaoEntidade extends AbstractEntidade
{
	const TABELA = 'TB_SESSAO';
	const ENTIDADE = 'SessaoEntidade';
	const CHAVE = CO_SESSAO;

	private $co_sessao;
	private $no_sessao;
	private $dt_cadastro;
	private $co_modulo;
	private $co_historia;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_SESSAO,
			NO_SESSAO,
			DT_CADASTRO,
			CO_MODULO,
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
	* @return int $co_sessao
    */
	public function getCoSessao()
    {
        return $this->co_sessao;
    }

	/**
	* @param $co_sessao
    * @return mixed
    */
	public function setCoSessao($co_sessao)
    {
        return $this->co_sessao = $co_sessao;
    }

	/**
	* @return mixed $no_sessao
    */
	public function getNoSessao()
    {
        return $this->no_sessao;
    }

	/**
	* @param $no_sessao
    * @return mixed
    */
	public function setNoSessao($no_sessao)
    {
        return $this->no_sessao = $no_sessao;
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
	* @return ModuloEntidade $co_modulo
    */
	public function getCoModulo()
    {
        return $this->co_modulo;
    }

	/**
	* @param $co_modulo
    * @return mixed
    */
	public function setCoModulo($co_modulo)
    {
        return $this->co_modulo = $co_modulo;
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
<?php

/**
 * Funcionalidade.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class FuncionalidadeEntidade extends AbstractEntidade
{
	const TABELA = 'TB_FUNCIONALIDADE';
	const ENTIDADE = 'FuncionalidadeEntidade';
	const CHAVE = CO_FUNCIONALIDADE;

	private $co_funcionalidade;
	private $no_funcionalidade;
	private $st_status;
	private $co_perfil_funcionalidade;
	private $co_ajuda;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_FUNCIONALIDADE,
			NO_FUNCIONALIDADE,
			ST_STATUS,
		];
    }

	/**
	* @return array $relacionamentos
     */
	public static function getRelacionamentos() {
    	$relacionamentos = Relacionamentos::getRelacionamentos();
		return $relacionamentos[static::TABELA];
	}


	/**
	* @return int $co_funcionalidade
     */
	public function getCoFuncionalidade()
    {
        return $this->co_funcionalidade;
    }

	/**
	* @param $co_funcionalidade
     * @return mixed
     */
	public function setCoFuncionalidade($co_funcionalidade)
    {
        return $this->co_funcionalidade = $co_funcionalidade;
    }

	/**
	* @return mixed $no_funcionalidade
     */
	public function getNoFuncionalidade()
    {
        return $this->no_funcionalidade;
    }

	/**
	* @param $no_funcionalidade
     * @return mixed
     */
	public function setNoFuncionalidade($no_funcionalidade)
    {
        return $this->no_funcionalidade = $no_funcionalidade;
    }

	/**
	* @return mixed $st_status
     */
	public function getStStatus()
    {
        return $this->st_status;
    }

	/**
	* @param $st_status
     * @return mixed
     */
	public function setStStatus($st_status)
    {
        return $this->st_status = $st_status;
    }

	/**
	* @return PerfilFuncionalidadeEntidade $co_perfil_funcionalidade
     */
	public function getCoPerfilFuncionalidade()
    {
        return $this->co_perfil_funcionalidade;
    }

	/**
     * @param $co_perfil_funcionalidade
     * @return mixed
     */
	public function setCoPerfilFuncionalidade($co_perfil_funcionalidade)
    {
        return $this->co_perfil_funcionalidade = $co_perfil_funcionalidade;
    }

    /**
     * @return mixed
     */
    public function getCoAjuda()
    {
        return $this->co_ajuda;
    }

    /**
     * @param mixed $co_ajuda
     */
    public function setCoAjuda($co_ajuda)
    {
        $this->co_ajuda = $co_ajuda;
    }



}
<?php

/**
 * Perfil.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class PerfilEntidade extends PerfilEntidadeExtends
{
	const TABELA = 'TB_PERFIL';
	const ENTIDADE = 'PerfilEntidade';
	const CHAVE = CO_PERFIL;

	private $co_perfil;
	private $no_perfil;
	private $st_status;
	private $co_perfil_funcionalidade;
	private $co_usuario_perfil;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_PERFIL,
			NO_PERFIL,
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
	* @return int $co_perfil
     */
	public function getCoPerfil()
    {
        return $this->co_perfil;
    }

	/**
	* @param $co_perfil
     * @return mixed
     */
	public function setCoPerfil($co_perfil)
    {
        return $this->co_perfil = $co_perfil;
    }

	/**
	* @return mixed $no_perfil
     */
	public function getNoPerfil()
    {
        return $this->no_perfil;
    }

	/**
	* @param $no_perfil
     * @return mixed
     */
	public function setNoPerfil($no_perfil)
    {
        return $this->no_perfil = $no_perfil;
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
	* @return UsuarioPerfilEntidade $co_usuario_perfil
     */
	public function getCoUsuarioPerfil()
    {
        return $this->co_usuario_perfil;
    }

	/**
     * @param $co_usuario_perfil
     * @return mixed
     */
	public function setCoUsuarioPerfil($co_usuario_perfil)
    {
        return $this->co_usuario_perfil = $co_usuario_perfil;
    }

}
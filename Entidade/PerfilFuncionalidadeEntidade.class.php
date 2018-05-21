<?php

/**
 * PerfilFuncionalidade.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class PerfilFuncionalidadeEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PERFIL_FUNCIONALIDADE';
	const ENTIDADE = 'PerfilFuncionalidadeEntidade';
	const CHAVE = CO_PERFIL_FUNCIONALIDADE;

	private $co_perfil_funcionalidade;
	private $co_perfil;
	private $co_funcionalidade;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_PERFIL_FUNCIONALIDADE,
			CO_PERFIL,
			CO_FUNCIONALIDADE,
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
	* @return int $co_perfil_funcionalidade
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
	* @return PerfilEntidade $co_perfil
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
	* @return FuncionalidadeEntidade $co_funcionalidade
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

}
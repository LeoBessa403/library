<?php

/**
 * PerfilAssinante.Entidade [ ENTIDADE ]
 * @copyright (c) 2019, Leo Bessa
 */

class PerfilAssinanteEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PERFIL_ASSINANTE';
	const ENTIDADE = 'PerfilAssinanteEntidade';
	const CHAVE = CO_PERFIL_ASSINANTE;

	private $co_perfil_assinante;
	private $no_perfil;
	private $st_status;
	private $co_assinante;
	private $co_usuario_perfil;
	private $co_perfil_funcionalidade;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_PERFIL_ASSINANTE,
			NO_PERFIL,
			ST_STATUS,
			CO_ASSINANTE,
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
	* @return int $co_perfil_assinante
    */
	public function getCoPerfilAssinante()
    {
        return $this->co_perfil_assinante;
    }

	/**
	* @param $co_perfil_assinante
    * @return mixed
    */
	public function setCoPerfilAssinante($co_perfil_assinante)
    {
        return $this->co_perfil_assinante = $co_perfil_assinante;
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
     * @return mixed
     */
    public function getCoUsuarioPerfil()
    {
        return $this->co_usuario_perfil;
    }

    /**
     * @param UsuarioPerfilEntidade $co_usuario_perfil
     */
    public function setCoUsuarioPerfil($co_usuario_perfil)
    {
        $this->co_usuario_perfil = $co_usuario_perfil;
    }

    /**
     * @return mixed
     */
    public function getCoPerfilFuncionalidade()
    {
        return $this->co_perfil_funcionalidade;
    }

    /**
     * @param PerfilFuncionalidadeEntidade $co_perfil_funcionalidade
     */
    public function setCoPerfilFuncionalidade($co_perfil_funcionalidade)
    {
        $this->co_perfil_funcionalidade = $co_perfil_funcionalidade;
    }

}
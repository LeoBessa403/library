<?php

/**
 * UsuarioPerfil.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class UsuarioPerfilEntidade extends AbstractEntidade
{
	const TABELA = 'TB_USUARIO_PERFIL';
	const ENTIDADE = 'UsuarioPerfilEntidade';
	const CHAVE = CO_USUARIO_PERFIL;

	private $co_usuario_perfil;
	private $co_usuario;
	private $co_perfil;
	private $co_perfil_assinante;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_USUARIO_PERFIL,
			CO_USUARIO,
			CO_PERFIL,
            CO_PERFIL_ASSINANTE,
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
	* @return int $co_usuario_perfil
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

	/**
	* @return UsuarioEntidade $co_usuario
     */
	public function getCoUsuario()
    {
        return $this->co_usuario;
    }

	/**
	* @param $co_usuario
     * @return mixed
     */
	public function setCoUsuario($co_usuario)
    {
        return $this->co_usuario = $co_usuario;
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
     * @return mixed
     */
    public function getCoPerfilAssinante()
    {
        return $this->co_perfil_assinante;
    }

    /**
     * @param PerfilAssinanteEntidade $co_perfil_assinante
     */
    public function setCoPerfilAssinante($co_perfil_assinante)
    {
        $this->co_perfil_assinante = $co_perfil_assinante;
    }

}
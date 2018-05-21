<?php

/**
 * Usuario.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class UsuarioEntidade extends UsuarioEntidadeExtends
{
	const TABELA = 'TB_USUARIO';
	const ENTIDADE = 'UsuarioEntidade';
	const CHAVE = CO_USUARIO;

	private $co_usuario;
	private $ds_senha;
	private $ds_code;
	private $st_status;
	private $dt_cadastro;
	private $co_imagem;
	private $co_pessoa;
	private $co_acesso;
	private $co_auditoria;
	private $co_usuario_perfil;


	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_USUARIO,
			DS_SENHA,
			DS_CODE,
			ST_STATUS,
			DT_CADASTRO,
			CO_IMAGEM,
			CO_PESSOA,
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
	* @return int $co_usuario
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
	* @return mixed $ds_senha
     */
	public function getDsSenha()
    {
        return $this->ds_senha;
    }

	/**
	* @param $ds_senha
     * @return mixed
     */
	public function setDsSenha($ds_senha)
    {
        return $this->ds_senha = $ds_senha;
    }

	/**
	* @return mixed $ds_code
     */
	public function getDsCode()
    {
        return $this->ds_code;
    }

	/**
	* @param $ds_code
     * @return mixed
     */
	public function setDsCode($ds_code)
    {
        return $this->ds_code = $ds_code;
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

	/**
	* @return PessoaEntidade $co_pessoa
     */
	public function getCoPessoa()
    {
        return $this->co_pessoa;
    }

	/**
	* @param $co_pessoa
     * @return mixed
     */
	public function setCoPessoa($co_pessoa)
    {
        return $this->co_pessoa = $co_pessoa;
    }

	/**
	* @return AcessoEntidade $co_acesso
     */
	public function getCoAcesso()
    {
        return $this->co_acesso;
    }

	/**
     * @param $co_acesso
     * @return mixed
     */
	public function setCoAcesso($co_acesso)
    {
        return $this->co_acesso = $co_acesso;
    }

	/**
	* @return AuditoriaEntidade $co_auditoria
     */
	public function getCoAuditoria()
    {
        return $this->co_auditoria;
    }

	/**
     * @param $co_auditoria
     * @return mixed
     */
	public function setCoAuditoria($co_auditoria)
    {
        return $this->co_auditoria = $co_auditoria;
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
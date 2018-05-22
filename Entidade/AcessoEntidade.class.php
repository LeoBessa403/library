<?php

/**
 * Acesso.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class AcessoEntidade extends AbstractEntidade
{
	const TABELA = 'TB_ACESSO';
	const ENTIDADE = 'AcessoEntidade';
	const CHAVE = CO_ACESSO;

	private $co_acesso;
	private $ds_session_id;
	private $dt_inicio_acesso;
	private $dt_fim_acesso;
	private $tp_situacao;
	private $co_usuario;
	private $co_trafego;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_ACESSO,
			DS_SESSION_ID,
			DT_INICIO_ACESSO,
			DT_FIM_ACESSO,
            TP_SITUACAO,
			CO_USUARIO,
			CO_TRAFEGO,
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
	* @return int $co_acesso
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
	* @return mixed $ds_session_id
     */
	public function getDsSessionId()
    {
        return $this->ds_session_id;
    }

	/**
	* @param $ds_session_id
     * @return mixed
     */
	public function setDsSessionId($ds_session_id)
    {
        return $this->ds_session_id = $ds_session_id;
    }

	/**
	* @return mixed $dt_inicio_acesso
     */
	public function getDtInicioAcesso()
    {
        return $this->dt_inicio_acesso;
    }

	/**
	* @param $dt_inicio_acesso
     * @return mixed
     */
	public function setDtInicioAcesso($dt_inicio_acesso)
    {
        return $this->dt_inicio_acesso = $dt_inicio_acesso;
    }

	/**
	* @return mixed $dt_fim_acesso
     */
	public function getDtFimAcesso()
    {
        return $this->dt_fim_acesso;
    }

	/**
	* @param $dt_fim_acesso
     * @return mixed
     */
	public function setDtFimAcesso($dt_fim_acesso)
    {
        return $this->dt_fim_acesso = $dt_fim_acesso;
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
     * @return mixed
     */
    public function getTpSituacao()
    {
        return $this->tp_situacao;
    }

    /**
     * @param mixed $tp_situacao
     */
    public function setTpSituacao($tp_situacao)
    {
        $this->tp_situacao = $tp_situacao;
    }

    /**
     * @return TrafegoEntidade $co_trafego
     */
    public function getCoTrafego()
    {
        return $this->co_trafego;
    }

    /**
     * @param mixed $co_trafego
     */
    public function setCoTrafego($co_trafego)
    {
        $this->co_trafego = $co_trafego;
    }

}
<?php

/**
 * Trafego.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class TrafegoEntidade extends AbstractEntidade
{
	const TABELA = 'TB_TRAFEGO';
	const ENTIDADE = 'TrafegoEntidade';
	const CHAVE = CO_TRAFEGO;

	private $co_trafego;
	private $ds_navegador;
	private $ds_sistema_operacional;
	private $ds_dispositivo;
	private $nu_ip;
	private $ds_pais;
	private $ds_code_pais;
	private $ds_uf;
	private $ds_cidade;
	private $ds_agente;
	private $ds_estado;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
            CO_TRAFEGO,
			NU_IP,
			DS_PAIS,
			DS_CODE_PAIS,
			DS_NAVEGADOR,
            DS_SISTEMA_OPERACIONAL,
            DS_DISPOSITIVO,
            DS_UF,
			DS_AGENTE,
			DS_ESTADO,
			DS_CIDADE,
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
     * @return int mixed
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

    /**
     * @return mixed
     */
    public function getNuIp()
    {
        return $this->nu_ip;
    }

    /**
     * @param mixed $nu_ip
     */
    public function setNuIp($nu_ip)
    {
        $this->nu_ip = $nu_ip;
    }

    /**
     * @return mixed
     */
    public function getDsPais()
    {
        return $this->ds_pais;
    }

    /**
     * @param mixed $ds_pais
     */
    public function setDsPais($ds_pais)
    {
        $this->ds_pais = $ds_pais;
    }

    /**
     * @return mixed
     */
    public function getDsCodePais()
    {
        return $this->ds_code_pais;
    }

    /**
     * @param mixed $ds_code_pais
     */
    public function setDsCodePais($ds_code_pais)
    {
        $this->ds_code_pais = $ds_code_pais;
    }

    /**
     * @return mixed
     */
    public function getDsUf()
    {
        return $this->ds_uf;
    }

    /**
     * @param mixed $ds_uf
     */
    public function setDsUf($ds_uf)
    {
        $this->ds_uf = $ds_uf;
    }

    /**
     * @return mixed
     */
    public function getDsEstado()
    {
        return $this->ds_estado;
    }

    /**
     * @param mixed $ds_estado
     */
    public function setDsEstado($ds_estado)
    {
        $this->ds_estado = $ds_estado;
    }

    /**
     * @return mixed
     */
    public function getDsCidade()
    {
        return $this->ds_cidade;
    }

    /**
     * @param mixed $ds_cidade
     */
    public function setDsCidade($ds_cidade)
    {
        $this->ds_cidade = $ds_cidade;
    }

    /**
     * @return mixed
     */
    public function getDsAgente()
    {
        return $this->ds_agente;
    }

    /**
     * @param mixed $ds_agente
     */
    public function setDsAgente($ds_agente)
    {
        $this->ds_agente = $ds_agente;
    }

    /**
     * @return mixed
     */
    public function getDsNavegador()
    {
        return $this->ds_navegador;
    }

    /**
     * @param mixed $ds_navegador
     */
    public function setDsNavegador($ds_navegador)
    {
        $this->ds_navegador = $ds_navegador;
    }

    /**
     * @return mixed
     */
    public function getDsSistemaOperacional()
    {
        return $this->ds_sistema_operacional;
    }

    /**
     * @param mixed $ds_sistema_operacional
     */
    public function setDsSistemaOperacional($ds_sistema_operacional)
    {
        $this->ds_sistema_operacional = $ds_sistema_operacional;
    }

    /**
     * @return mixed
     */
    public function getDsDispositivo()
    {
        return $this->ds_dispositivo;
    }

    /**
     * @param mixed $ds_dispositivo
     */
    public function setDsDispositivo($ds_dispositivo)
    {
        $this->ds_dispositivo = $ds_dispositivo;
    }

}
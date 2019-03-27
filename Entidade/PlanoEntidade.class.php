<?php

/**
 * Plano.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class PlanoEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PLANO';
	const ENTIDADE = 'PlanoEntidade';
	const CHAVE = CO_PLANO;

	private $co_plano;
	private $dt_cadastro;
	private $no_plano;
	private $nu_mes_ativo;
	private $st_status;
	private $co_plano_modulo;
	private $co_plano_assinante;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_PLANO,
			DT_CADASTRO,
			NO_PLANO,
			NU_MES_ATIVO,
			ST_STATUS,
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
	* @return int $co_plano
    */
	public function getCoPlano()
    {
        return $this->co_plano;
    }

	/**
	* @param $co_plano
    * @return mixed
    */
	public function setCoPlano($co_plano)
    {
        return $this->co_plano = $co_plano;
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
	* @return mixed $no_plano
    */
	public function getNoPlano()
    {
        return $this->no_plano;
    }

	/**
	* @param $no_plano
    * @return mixed
    */
	public function setNoPlano($no_plano)
    {
        return $this->no_plano = $no_plano;
    }

	/**
	* @return mixed $nu_mes_ativo
    */
	public function getNuMesAtivo()
    {
        return $this->nu_mes_ativo;
    }

	/**
	* @param $nu_mes_ativo
    * @return mixed
    */
	public function setNuMesAtivo($nu_mes_ativo)
    {
        return $this->nu_mes_ativo = $nu_mes_ativo;
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
	* @return PlanoPacoteEntidade $co_plano_pacote
     */
	public function getCoPlanoPacote()
    {
        return $this->co_plano_pacote;
    }

	/**
     * @param $co_plano_pacote
     * @return mixed
     */
	public function setCoPlanoPacote($co_plano_pacote)
    {
        return $this->co_plano_pacote = $co_plano_pacote;
    }

	/**
	* @return PlanoAssinanteEntidade $co_plano_assinante
     */
	public function getCoPlanoAssinante()
    {
        return $this->co_plano_assinante;
    }

	/**
     * @param $co_plano_assinante
     * @return mixed
     */
	public function setCoPlanoAssinante($co_plano_assinante)
    {
        return $this->co_plano_assinante = $co_plano_assinante;
    }

    /**
     * @return PlanoAssinanteEntidade $co_plano_assinante
     */
    public function getCoUltimoPlanoAssinante()
    {
        return $this->ultimo($this->getCoPlanoAssinante());
    }

}
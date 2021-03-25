<?php

/**
 * Crons.Entidade [ ENTIDADE ]
 * @copyright (c) 2019, Leo Bessa
 */

class CronsEntidade extends AbstractEntidade
{
	const TABELA = SCHEMA . '.TB_CRONS';
	const ENTIDADE = 'CronsEntidade';
	const CHAVE = CO_CRON;

	private $co_cron;
	private $no_cron;
	private $dt_cadastro;
	private $ds_sql;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_CRON,
			DT_CADASTRO,
            NO_CRON,
			DS_SQL,
		];
    }

	/**
	* @return array $relacionamentos
    */
	public static function getRelacionamentos() 
    {
		return [];
	}


	/**
	* @return int $co_cron
    */
	public function getCoCron()
    {
        return $this->co_cron;
    }

	/**
	* @param $co_cron
    * @return mixed
    */
	public function setCoCron($co_cron)
    {
        return $this->co_cron = $co_cron;
    }

    /**
     * @return mixed
     */
    public function getNoCron()
    {
        return $this->no_cron;
    }

    /**
     * @param mixed $no_cron
     */
    public function setNoCron($no_cron)
    {
        $this->no_cron = $no_cron;
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
	* @return mixed $ds_sql
    */
	public function getDsSql()
    {
        return $this->ds_sql;
    }

	/**
	* @param $ds_sql
    * @return mixed
    */
	public function setDsSql($ds_sql)
    {
        return $this->ds_sql = $ds_sql;
    }

}
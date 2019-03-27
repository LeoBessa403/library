<?php

/**
 * HistoricoHistoria.Entidade [ ENTIDADE ]
 * @copyright (c) 2019, Leo Bessa
 */

class HistoricoHistoriaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_HISTORICO_HISTORIA';
	const ENTIDADE = 'HistoricoHistoriaEntidade';
	const CHAVE = CO_HISTORICO_HISTORIA;

	private $co_historico_historia;
	private $nu_esforco;
	private $nu_esforco_restante;
	private $dt_cadastro;
	private $co_historia;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_HISTORICO_HISTORIA,
			NU_ESFORCO,
			NU_ESFORCO_RESTANTE,
			DT_CADASTRO,
			CO_HISTORIA,
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
	* @return int $co_historico_historia
    */
	public function getCoHistoricoHistoria()
    {
        return $this->co_historico_historia;
    }

	/**
	* @param $co_historico_historia
    * @return mixed
    */
	public function setCoHistoricoHistoria($co_historico_historia)
    {
        return $this->co_historico_historia = $co_historico_historia;
    }

	/**
	* @return mixed $nu_esforco
    */
	public function getNuEsforco()
    {
        return $this->nu_esforco;
    }

	/**
	* @param $nu_esforco
    * @return mixed
    */
	public function setNuEsforco($nu_esforco)
    {
        return $this->nu_esforco = $nu_esforco;
    }

	/**
	* @return mixed $nu_esforco_restante
    */
	public function getNuEsforcoRestante()
    {
        return $this->nu_esforco_restante;
    }

	/**
	* @param $nu_esforco_restante
    * @return mixed
    */
	public function setNuEsforcoRestante($nu_esforco_restante)
    {
        return $this->nu_esforco_restante = $nu_esforco_restante;
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
	* @return HistoriaEntidade $co_historia
    */
	public function getCoHistoria()
    {
        return $this->co_historia;
    }

	/**
	* @param $co_historia
    * @return mixed
    */
	public function setCoHistoria($co_historia)
    {
        return $this->co_historia = $co_historia;
    }

}
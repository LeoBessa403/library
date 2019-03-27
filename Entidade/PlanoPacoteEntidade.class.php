<?php

/**
 * PlanoPacote.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class PlanoPacoteEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PLANO_PACOTE';
	const ENTIDADE = 'PlanoPacoteEntidade';
	const CHAVE = CO_PLANO_PACOTE;

	private $co_plano_pacote;
	private $co_plano;
	private $co_pacote;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_PLANO_PACOTE,
			CO_PLANO,
			CO_PACOTE,
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
	* @return int $co_plano_pacote
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
	* @return PlanoEntidade $co_plano
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
	* @return PacoteEntidade $co_pacote
    */
	public function getCoPacote()
    {
        return $this->co_pacote;
    }

	/**
	* @param $co_pacote
    * @return mixed
    */
	public function setCoPacote($co_pacote)
    {
        return $this->co_pacote = $co_pacote;
    }

}
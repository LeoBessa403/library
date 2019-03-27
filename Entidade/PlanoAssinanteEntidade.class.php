<?php

/**
 * PlanoAssinante.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class PlanoAssinanteEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PLANO_ASSINANTE';
	const ENTIDADE = 'PlanoAssinanteEntidade';
	const CHAVE = CO_PLANO_ASSINANTE;

	private $co_plano_assinante;
	private $nu_valor;
	private $dt_cadastro;
	private $ds_observacao;
	private $co_plano;
	private $co_plano_assinante_assinatura;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_PLANO_ASSINANTE,
			NU_VALOR,
			DT_CADASTRO,
			DS_OBSERVACAO,
			CO_PLANO,
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
	* @return int $co_plano_assinante
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
	* @return mixed $nu_valor
    */
	public function getNuValor()
    {
        return $this->nu_valor;
    }

	/**
	* @param $nu_valor
    * @return mixed
    */
	public function setNuValor($nu_valor)
    {
        return $this->nu_valor = $nu_valor;
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
	* @return mixed $ds_observacao
    */
	public function getDsObservacao()
    {
        return $this->ds_observacao;
    }

	/**
	* @param $ds_observacao
    * @return mixed
    */
	public function setDsObservacao($ds_observacao)
    {
        return $this->ds_observacao = $ds_observacao;
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
     * @return PlanoAssinanteAssinaturaEntidade $co_plano
     */
    public function getCoPlanoAssinanteAssinatura()
    {
        return $this->co_plano_assinante_assinatura;
    }

    /**
     * @param $co_plano_assinante_assinatura
     * @return mixed
     */
    public function setCoPlanoAssinanteAssinatura($co_plano_assinante_assinatura)
    {
        $this->co_plano_assinante_assinatura = $co_plano_assinante_assinatura;
    }


}
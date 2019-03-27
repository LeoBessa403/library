<?php

/**
 * PlanoAssinanteAssinatura.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class PlanoAssinanteAssinaturaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PLANO_ASSINANTE_ASSINATURA';
	const ENTIDADE = 'PlanoAssinanteAssinaturaEntidade';
	const CHAVE = CO_PLANO_ASSINANTE_ASSINATURA;

	private $co_plano_assinante_assinatura;
	private $dt_cadastro;
	private $dt_expiracao;
	private $nu_valor_assinatura;
	private $nu_profissionais;
	private $nu_filiais;
	private $co_assinante;
	private $co_plano_assinante;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_PLANO_ASSINANTE_ASSINATURA,
			DT_CADASTRO,
			DT_EXPIRACAO,
			NU_VALOR_ASSINATURA,
            NU_FILIAIS,
			NU_PROFISSIONAIS,
			CO_ASSINANTE,
			CO_PLANO_ASSINANTE,
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
	* @return int $co_plano_assinante_assinatura
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
        return $this->co_plano_assinante_assinatura = $co_plano_assinante_assinatura;
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
	* @return mixed $dt_expiracao
    */
	public function getDtExpiracao()
    {
        return $this->dt_expiracao;
    }

	/**
	* @param $dt_expiracao
    * @return mixed
    */
	public function setDtExpiracao($dt_expiracao)
    {
        return $this->dt_expiracao = $dt_expiracao;
    }

	/**
	* @return mixed $nu_valor_assinatura
    */
	public function getNuValorAssinatura()
    {
        return $this->nu_valor_assinatura;
    }

	/**
	* @param $nu_valor_assinatura
    * @return mixed
    */
	public function setNuValorAssinatura($nu_valor_assinatura)
    {
        return $this->nu_valor_assinatura = $nu_valor_assinatura;
    }

	/**
	* @return mixed $nu_profissionais
    */
	public function getNuProfissionais()
    {
        return $this->nu_profissionais;
    }

	/**
	* @param $nu_profissionais
    * @return mixed
    */
	public function setNuProfissionais($nu_profissionais)
    {
        return $this->nu_profissionais = $nu_profissionais;
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
     * @return mixed
     */
    public function getNuFiliais()
    {
        return $this->nu_filiais;
    }

    /**
     * @param mixed $nu_filiais
     */
    public function setNuFiliais($nu_filiais)
    {
        $this->nu_filiais = $nu_filiais;
    }

}
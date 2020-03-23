<?php

/**
 * HistoricoPagAssinatura.Entidade [ ENTIDADE ]
 * @copyright (c) 2020, Leo Bessa
 */

class HistoricoPagAssinaturaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_HISTORICO_PAG_ASSINATURA';
	const ENTIDADE = 'HistoricoPagAssinaturaEntidade';
	const CHAVE = CO_HISTORICO_PAG_ASSINATURA;

	private $co_historico_pag_assinatura;
	private $dt_cadastro;
	private $ds_acao;
	private $ds_usuario;
	private $st_pagamento;
	private $co_plano_assinante_assinatura;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_HISTORICO_PAG_ASSINATURA,
			DT_CADASTRO,
			DS_ACAO,
			DS_USUARIO,
			ST_PAGAMENTO,
			CO_PLANO_ASSINANTE_ASSINATURA,
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
	* @return int $co_historico_pag_assinatura
    */
	public function getCoHistoricoPagAssinatura()
    {
        return $this->co_historico_pag_assinatura;
    }

	/**
	* @param $co_historico_pag_assinatura
    * @return mixed
    */
	public function setCoHistoricoPagAssinatura($co_historico_pag_assinatura)
    {
        return $this->co_historico_pag_assinatura = $co_historico_pag_assinatura;
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
	* @return mixed $ds_acao
    */
	public function getDsAcao()
    {
        return $this->ds_acao;
    }

	/**
	* @param $ds_acao
    * @return mixed
    */
	public function setDsAcao($ds_acao)
    {
        return $this->ds_acao = $ds_acao;
    }

	/**
	* @return mixed $ds_usuario
    */
	public function getDsUsuario()
    {
        return $this->ds_usuario;
    }

	/**
	* @param $ds_usuario
    * @return mixed
    */
	public function setDsUsuario($ds_usuario)
    {
        return $this->ds_usuario = $ds_usuario;
    }

	/**
	* @return mixed $st_pagamento
    */
	public function getStPagamento()
    {
        return $this->st_pagamento;
    }

	/**
	* @param $st_pagamento
    * @return mixed
    */
	public function setStPagamento($st_pagamento)
    {
        return $this->st_pagamento = $st_pagamento;
    }

	/**
	* @return PlanoAssinanteAssinaturaEntidade $co_plano_assinante_assinatura
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

}
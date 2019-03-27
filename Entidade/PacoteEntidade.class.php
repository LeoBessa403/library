<?php

/**
 * Pacote.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class PacoteEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PACOTE';
	const ENTIDADE = 'PacoteEntidade';
	const CHAVE = CO_PACOTE;

	private $co_pacote;
	private $no_pacote;
	private $ds_descricao;
	private $dt_cadastro;
	private $dt_lancamento;
	private $co_plano_pacote;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_PACOTE,
			NO_PACOTE,
			DS_DESCRICAO,
			DT_CADASTRO,
			DT_LANCAMENTO,
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
	* @return int $co_pacote
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

	/**
	* @return mixed $no_pacote
    */
	public function getNoPacote()
    {
        return $this->no_pacote;
    }

	/**
	* @param $no_pacote
    * @return mixed
    */
	public function setNoPacote($no_pacote)
    {
        return $this->no_pacote = $no_pacote;
    }

	/**
	* @return mixed $ds_descricao
    */
	public function getDsDescricao()
    {
        return $this->ds_descricao;
    }

	/**
	* @param $ds_descricao
    * @return mixed
    */
	public function setDsDescricao($ds_descricao)
    {
        return $this->ds_descricao = $ds_descricao;
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
	* @return mixed $dt_lancamento
    */
	public function getDtLancamento()
    {
        return $this->dt_lancamento;
    }

	/**
	* @param $dt_lancamento
    * @return mixed
    */
	public function setDtLancamento($dt_lancamento)
    {
        return $this->dt_lancamento = $dt_lancamento;
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

}
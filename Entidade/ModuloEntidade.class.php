<?php

/**
 * Modulo.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class ModuloEntidade extends AbstractEntidade
{
	const TABELA = 'TB_MODULO';
	const ENTIDADE = 'ModuloEntidade';
	const CHAVE = CO_MODULO;

	private $co_modulo;
	private $no_modulo;
	private $dt_cadastro;
	private $co_projeto;
	private $co_sessao;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_MODULO,
			NO_MODULO,
			DT_CADASTRO,
			CO_PROJETO,
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
	* @return int $co_modulo
    */
	public function getCoModulo()
    {
        return $this->co_modulo;
    }

	/**
	* @param $co_modulo
    * @return mixed
    */
	public function setCoModulo($co_modulo)
    {
        return $this->co_modulo = $co_modulo;
    }

	/**
	* @return mixed $no_modulo
    */
	public function getNoModulo()
    {
        return $this->no_modulo;
    }

	/**
	* @param $no_modulo
    * @return mixed
    */
	public function setNoModulo($no_modulo)
    {
        return $this->no_modulo = $no_modulo;
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
	* @return ProjetoEntidade $co_projeto
    */
	public function getCoProjeto()
    {
        return $this->co_projeto;
    }

	/**
	* @param $co_projeto
    * @return mixed
    */
	public function setCoProjeto($co_projeto)
    {
        return $this->co_projeto = $co_projeto;
    }

	/**
	* @return SessaoEntidade $co_sessao
     */
	public function getCoSessao()
    {
        return $this->co_sessao;
    }

	/**
     * @param $co_sessao
     * @return mixed
     */
	public function setCoSessao($co_sessao)
    {
        return $this->co_sessao = $co_sessao;
    }

}
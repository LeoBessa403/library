<?php

/**
 * AuditoriaTabela.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class AuditoriaTabelaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_AUDITORIA_TABELA';
	const ENTIDADE = 'AuditoriaTabelaEntidade';
	const CHAVE = CO_AUDITORIA_TABELA;

	private $co_auditoria_tabela;
	private $no_tabela;
	private $tp_operacao;
	private $co_registro;
	private $co_auditoria;
	private $co_auditoria_itens;


	/**
     * @return array
     */
	public static function getCampos() 
        {
    	return [
			CO_AUDITORIA_TABELA,
			NO_TABELA,
			TP_OPERACAO,
			CO_REGISTRO,
			CO_AUDITORIA,
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
	* @return int $co_auditoria_tabela
     */
	public function getCoAuditoriaTabela()
    {
        return $this->co_auditoria_tabela;
    }

	/**
	* @param $co_auditoria_tabela
     * @return mixed
     */
	public function setCoAuditoriaTabela($co_auditoria_tabela)
    {
        return $this->co_auditoria_tabela = $co_auditoria_tabela;
    }

	/**
	* @return mixed $no_tabela
     */
	public function getNoTabela()
    {
        return $this->no_tabela;
    }

	/**
	* @param $no_tabela
     * @return mixed
     */
	public function setNoTabela($no_tabela)
    {
        return $this->no_tabela = $no_tabela;
    }

	/**
	* @return mixed $tp_operacao
     */
	public function getTpOperacao()
    {
        return $this->tp_operacao;
    }

	/**
	* @param $tp_operacao
     * @return mixed
     */
	public function setTpOperacao($tp_operacao)
    {
        return $this->tp_operacao = $tp_operacao;
    }

	/**
	* @return mixed $co_registro
     */
	public function getCoRegistro()
    {
        return $this->co_registro;
    }

	/**
	* @param $co_registro
     * @return mixed
     */
	public function setCoRegistro($co_registro)
    {
        return $this->co_registro = $co_registro;
    }

	/**
	* @return AuditoriaEntidade $co_auditoria
     */
	public function getCoAuditoria()
    {
        return $this->co_auditoria;
    }

	/**
	* @param $co_auditoria
     * @return mixed
     */
	public function setCoAuditoria($co_auditoria)
    {
        return $this->co_auditoria = $co_auditoria;
    }

	/**
	* @return AuditoriaItensEntidade $co_auditoria_itens
     */
	public function getCoAuditoriaItens()
    {
        return $this->co_auditoria_itens;
    }

	/**
     * @param $co_auditoria_itens
     * @return mixed
     */
	public function setCoAuditoriaItens($co_auditoria_itens)
    {
        return $this->co_auditoria_itens = $co_auditoria_itens;
    }

}
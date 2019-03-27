<?php

/**
 * AuditoriaItens.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class AuditoriaItensEntidade extends AbstractEntidade
{
	const TABELA = 'TB_AUDITORIA_ITENS';
	const ENTIDADE = 'AuditoriaItensEntidade';
	const CHAVE = CO_AUDITORIA_ITENS;

	private $co_auditoria_itens;
	private $ds_item_anterior;
	private $ds_item_atual;
	private $ds_campo;
	private $co_auditoria_tabela;


	/**
     * @return array
     */
	public static function getCampos() 
        {
    	return [
			CO_AUDITORIA_ITENS,
			DS_ITEM_ANTERIOR,
			DS_ITEM_ATUAL,
			DS_CAMPO,
			CO_AUDITORIA_TABELA,
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
	* @return int $co_auditoria_itens
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

	/**
	* @return mixed $ds_item_anterior
     */
	public function getDsItemAnterior()
    {
        $tipo = strtolower(substr($this->getDsCampo(), 0, 2));
        if($tipo == 'dt' && $this->ds_item_anterior){
            return Valida::DataShow($this->ds_item_anterior, "d/m/Y H:i");
        }
        return $this->ds_item_anterior;
    }

	/**
	* @param $ds_item_anterior
     * @return mixed
     */
	public function setDsItemAnterior($ds_item_anterior)
    {
        return $this->ds_item_anterior = $ds_item_anterior;
    }

	/**
	* @return mixed $ds_item_atual
     */
	public function getDsItemAtual()
    {
        $tipo = strtolower(substr($this->getDsCampo(), 0, 2));
        if($tipo == 'dt' && $this->ds_item_atual){
            return Valida::DataShow($this->ds_item_atual, "d/m/Y H:i");
        }
        return $this->ds_item_atual;
    }

	/**
	* @param $ds_item_atual
     * @return mixed
     */
	public function setDsItemAtual($ds_item_atual)
    {
        return $this->ds_item_atual = $ds_item_atual;
    }

	/**
	* @return mixed $ds_campo
     */
	public function getDsCampo()
    {
        return $this->ds_campo;
    }

	/**
	* @param $ds_campo
     * @return mixed
     */
	public function setDsCampo($ds_campo)
    {
        return $this->ds_campo = $ds_campo;
    }

	/**
	* @return AuditoriaTabelaEntidade $co_auditoria_tabela
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

}
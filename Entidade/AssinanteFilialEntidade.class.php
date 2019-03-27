<?php

/**
 * AssinanteFilial.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class AssinanteFilialEntidade extends AbstractEntidade
{
	const TABELA = 'TB_ASSINANTE_FILIAL';
	const ENTIDADE = 'AssinanteFilialEntidade';
	const CHAVE = CO_ASSINANTE_FILIAL;

	private $co_assinante_filial;
	private $dt_cadastro;
	private $co_assinante;
    private $co_assinante_matriz;


	/**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_ASSINANTE_FILIAL,
			DT_CADASTRO,
			CO_ASSINANTE,
            CO_ASSINANTE_MATRIZ,
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
	* @return int $co_assinante_filial
    */
	public function getCoAssinanteFilial()
    {
        return $this->co_assinante_filial;
    }

	/**
	* @param $co_assinante_filial
    * @return mixed
    */
	public function setCoAssinanteFilial($co_assinante_filial)
    {
        return $this->co_assinante_filial = $co_assinante_filial;
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
     * @return AssinanteMatrizEntidade $co_assinante_matriz
     */
    public function getCoAssinanteMatriz()
    {
        return $this->co_assinante_matriz;
    }

    /**
     * @param $co_assinante_matriz
     * @return mixed
     */
    public function setCoAssinanteMatriz($co_assinante_matriz)
    {
        $this->co_assinante_matriz = $co_assinante_matriz;
    }

}
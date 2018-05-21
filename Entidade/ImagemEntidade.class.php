<?php

/**
 * Imagem.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class ImagemEntidade extends ImagemEntidadeExtends
{
	const TABELA = 'TB_IMAGEM';
	const ENTIDADE = 'ImagemEntidade';
	const CHAVE = CO_IMAGEM;

	private $co_imagem;
	private $ds_caminho;
    private $co_usuario;
    private $co_pessoa;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_IMAGEM,
			DS_CAMINHO,
		];
    }

	/**
	* @return array $relacionamentos
     */
	public static function getRelacionamentos() {
    	$relacionamentos = Relacionamentos::getRelacionamentos();
		return $relacionamentos[static::TABELA];
	}


	/**
	* @return int $co_imagem
     */
	public function getCoImagem()
    {
        return $this->co_imagem;
    }

	/**
	* @param $co_imagem
     * @return mixed
     */
	public function setCoImagem($co_imagem)
    {
        return $this->co_imagem = $co_imagem;
    }

	/**
	* @return mixed $ds_caminho
     */
	public function getDsCaminho()
    {
        return $this->ds_caminho;
    }

	/**
	* @param $ds_caminho
     * @return mixed
     */
	public function setDsCaminho($ds_caminho)
    {
        return $this->ds_caminho = $ds_caminho;
    }

	/**
	* @return UsuarioEntidade $co_usuario
     */
	public function getCoUsuario()
    {
        return $this->co_usuario;
    }

	/**
     * @param $co_usuario
     * @return mixed
     */
	public function setCoUsuario($co_usuario)
    {
        return $this->co_usuario = $co_usuario;
    }

    /**
     * @return PessoaEntidade $co_pessoa
     */
    public function getCoPessoa()
    {
        return $this->co_pessoa;
    }

    /**
     * @param $co_pessoa
     * @return mixed
     */
    public function setCoPessoa($co_pessoa)
    {
        return $this->co_pessoa = $co_pessoa;
    }

}
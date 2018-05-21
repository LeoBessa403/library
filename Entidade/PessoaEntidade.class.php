<?php

/**
 * Pessoa.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class PessoaEntidade extends PessoaEntidadeExtends
{
	const TABELA = 'TB_PESSOA';
	const ENTIDADE = 'PessoaEntidade';
	const CHAVE = CO_PESSOA;

	private $co_pessoa;
	private $nu_cpf;
	private $no_pessoa;
	private $nu_rg;
	private $dt_cadastro;
	private $dt_nascimento;
	private $st_sexo;
	private $co_endereco;
	private $co_usuario;
    private $co_contato;

    /**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_PESSOA,
			NU_CPF,
			NO_PESSOA,
			NU_RG,
			DT_CADASTRO,
			DT_NASCIMENTO,
			ST_SEXO,
			CO_CONTATO,
			CO_ENDERECO,
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
	* @return int $co_pessoa
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

	/**
	* @return mixed $nu_cpf
     */
	public function getNuCpf()
    {
        return $this->nu_cpf;
    }

	/**
	* @param $nu_cpf
     * @return mixed
     */
	public function setNuCpf($nu_cpf)
    {
        return $this->nu_cpf = $nu_cpf;
    }

	/**
	* @return mixed $no_pessoa
     */
	public function getNoPessoa()
    {
        return $this->no_pessoa;
    }

	/**
	* @param $no_pessoa
     * @return mixed
     */
	public function setNoPessoa($no_pessoa)
    {
        return $this->no_pessoa = $no_pessoa;
    }

	/**
	* @return mixed $nu_rg
     */
	public function getNuRg()
    {
        return $this->nu_rg;
    }

	/**
	* @param $nu_rg
     * @return mixed
     */
	public function setNuRg($nu_rg)
    {
        return $this->nu_rg = $nu_rg;
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
	* @return mixed $dt_nascimento
     */
	public function getDtNascimento()
    {
        return $this->dt_nascimento;
    }

	/**
	* @param $dt_nascimento
     * @return mixed
     */
	public function setDtNascimento($dt_nascimento)
    {
        return $this->dt_nascimento = $dt_nascimento;
    }

	/**
	* @return mixed $st_sexo
     */
	public function getStSexo()
    {
        return $this->st_sexo;
    }

	/**
	* @param $st_sexo
     * @return mixed
     */
	public function setStSexo($st_sexo)
    {
        return $this->st_sexo = $st_sexo;
    }

	/**
	* @return EnderecoEntidade $co_endereco
     */
	public function getCoEndereco()
    {
        return $this->co_endereco;
    }

	/**
	* @param $co_endereco
     * @return mixed
     */
	public function setCoEndereco($co_endereco)
    {
        return $this->co_endereco = $co_endereco;
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
     * @return ContatoEntidade $co_contato
     */
    public function getCoContato()
    {
        return $this->co_contato;
    }

    /**
     * @param $co_contato
     * @return mixed
     */
    public function setCoContato($co_contato)
    {
        return $this->co_contato = $co_contato;
    }

    /**
     * @return InscricaoEntidade $co_inscricao
     */
    public function getUltimaCoInscricao()
    {
        return $this->ultimo($this->getCoInscricao());
    }
}
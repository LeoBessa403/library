<?php

/**
 * Empresa.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class EmpresaEntidade extends AbstractEntidade
{
    const TABELA = 'TB_EMPRESA';
    const ENTIDADE = 'EmpresaEntidade';
    const CHAVE = CO_EMPRESA;

    private $co_empresa;
    private $no_empresa;
    private $no_fantasia;
    private $dt_cadastro;
    private $nu_cnpj;
    private $nu_insc_estadual;
    private $ds_observacao;
    private $st_status;
    private $co_pessoa;
    private $co_endereco;
    private $co_contato;
    private $co_imagem;
    private $co_assinante;


    /**
     * @return array
     */
    public static function getCampos()
    {
        return [
            CO_EMPRESA,
            NO_EMPRESA,
            NO_FANTASIA,
            DT_CADASTRO,
            NU_CNPJ,
            NU_INSC_ESTADUAL,
            DS_OBSERVACAO,
            ST_STATUS,
            CO_PESSOA,
            CO_ENDERECO,
            CO_CONTATO,
            CO_IMAGEM,
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
     * @return int $co_empresa
     */
    public function getCoEmpresa()
    {
        return $this->co_empresa;
    }

    /**
     * @param $co_empresa
     * @return mixed
     */
    public function setCoEmpresa($co_empresa)
    {
        return $this->co_empresa = $co_empresa;
    }

    /**
     * @return mixed $no_empresa
     */
    public function getNoEmpresa()
    {
        return $this->no_empresa;
    }

    /**
     * @param $no_empresa
     * @return mixed
     */
    public function setNoEmpresa($no_empresa)
    {
        return $this->no_empresa = $no_empresa;
    }

    /**
     * @return mixed $no_fantasia
     */
    public function getNoFantasia()
    {
        return $this->no_fantasia;
    }

    /**
     * @param $no_fantasia
     * @return mixed
     */
    public function setNoFantasia($no_fantasia)
    {
        return $this->no_fantasia = $no_fantasia;
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
     * @return mixed $nu_cnpj
     */
    public function getNuCnpj()
    {
        return $this->nu_cnpj;
    }

    /**
     * @param $nu_cnpj
     * @return mixed
     */
    public function setNuCnpj($nu_cnpj)
    {
        return $this->nu_cnpj = $nu_cnpj;
    }

    /**
     * @return mixed $nu_insc_estadual
     */
    public function getNuInscEstadual()
    {
        return $this->nu_insc_estadual;
    }

    /**
     * @param $nu_insc_estadual
     * @return mixed
     */
    public function setNuInscEstadual($nu_insc_estadual)
    {
        return $this->nu_insc_estadual = $nu_insc_estadual;
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
     * @return mixed $st_status
     */
    public function getStStatus()
    {
        return $this->st_status;
    }

    /**
     * @param $st_status
     * @return mixed
     */
    public function setStStatus($st_status)
    {
        return $this->st_status = $st_status;
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
     * @return ImagemEntidade $co_imagem
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
     * @return mixed
     */
    public function getCoAssinante()
    {
        return $this->co_assinante;
    }

    /**
     * @param mixed $co_assinante
     */
    public function setCoAssinante($co_assinante)
    {
        $this->co_assinante = $co_assinante;
    }

}
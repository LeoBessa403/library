<?php

/**
 * Contato.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class ContatoEntidade extends ContatoEntidadeExtends
{
    const TABELA = 'TB_CONTATO';
    const ENTIDADE = 'ContatoEntidade';
    const CHAVE = CO_CONTATO;

    private $co_contato;
    private $nu_tel1;
    private $nu_tel2;
    private $nu_tel3;
    private $nu_tel_0800;
    private $ds_email;
    private $ds_site;
    private $ds_facebook;
    private $ds_twitter;
    private $ds_instagram;
    private $co_pessoa;

    /**
     * @return array
     */
    public static function getCampos()
    {
        return [
            CO_CONTATO,
            NU_TEL1,
            NU_TEL2,
            NU_TEL3,
            NU_TEL_0800,
            DS_EMAIL,
            DS_SITE,
            DS_FACEBOOK,
            DS_TWITTER,
            DS_INSTAGRAM,
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
     * @return int $co_contato
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
     * @return mixed $nu_tel1
     */
    public function getNuTel1()
    {
        return $this->nu_tel1;
    }

    /**
     * @param $nu_tel1
     * @return mixed
     */
    public function setNuTel1($nu_tel1)
    {
        return $this->nu_tel1 = $nu_tel1;
    }

    /**
     * @return mixed $nu_tel2
     */
    public function getNuTel2()
    {
        return $this->nu_tel2;
    }

    /**
     * @param $nu_tel2
     * @return mixed
     */
    public function setNuTel2($nu_tel2)
    {
        return $this->nu_tel2 = $nu_tel2;
    }

    /**
     * @return mixed $nu_tel3
     */
    public function getNuTel3()
    {
        return $this->nu_tel3;
    }

    /**
     * @param $nu_tel3
     * @return mixed
     */
    public function setNuTel3($nu_tel3)
    {
        return $this->nu_tel3 = $nu_tel3;
    }

    /**
     * @return mixed
     */
    public function getNuTel0800()
    {
        return $this->nu_tel_0800;
    }

    /**
     * @param mixed $nu_tel_0800
     */
    public function setNuTel0800($nu_tel_0800)
    {
        $this->nu_tel_0800 = $nu_tel_0800;
    }

    /**
     * @return mixed $ds_email
     */
    public function getDsEmail()
    {
        return $this->ds_email;
    }

    /**
     * @param $ds_email
     * @return mixed
     */
    public function setDsEmail($ds_email)
    {
        return $this->ds_email = $ds_email;
    }

    /**
     * @return mixed $ds_site
     */
    public function getDsSite()
    {
        return $this->ds_site;
    }

    /**
     * @param $ds_site
     * @return mixed
     */
    public function setDsSite($ds_site)
    {
        return $this->ds_site = $ds_site;
    }

    /**
     * @return mixed
     */
    public function getDsFacebook()
    {
        return $this->ds_facebook;
    }

    /**
     * @param mixed $ds_facebook
     */
    public function setDsFacebook($ds_facebook)
    {
        $this->ds_facebook = $ds_facebook;
    }

    /**
     * @return mixed
     */
    public function getDsTwitter()
    {
        return $this->ds_twitter;
    }

    /**
     * @param mixed $ds_twitter
     */
    public function setDsTwitter($ds_twitter)
    {
        $this->ds_twitter = $ds_twitter;
    }

    /**
     * @return mixed
     */
    public function getDsInstagram()
    {
        return $this->ds_instagram;
    }

    /**
     * @param mixed $ds_instagram
     */
    public function setDsInstagram($ds_instagram)
    {
        $this->ds_instagram = $ds_instagram;
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
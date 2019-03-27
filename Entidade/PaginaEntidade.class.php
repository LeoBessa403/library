<?php

/**
 * Pagina.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class PaginaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PAGINA';
	const ENTIDADE = 'PaginaEntidade';
	const CHAVE = CO_PAGINA;

	private $co_pagina;
    private $dt_cadastro;
    private $ds_titulo_url_amigavel;
    private $nu_visualizacao;
    private $nu_usuario;
    private $co_pagina_visita;

    /**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_PAGINA,
			DT_CADASTRO,
			DS_TITULO_URL_AMIGAVEL,
            NU_USUARIO,
            NU_VISUALIZACAO,
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
     * @return int
     */
    public function getCoPagina()
    {
        return $this->co_pagina;
    }

    /**
     * @param mixed $co_pagina
     */
    public function setCoPagina($co_pagina)
    {
        $this->co_pagina = $co_pagina;
    }

    /**
     * @return mixed
     */
    public function getDtCadastro()
    {
        return $this->dt_cadastro;
    }

    /**
     * @param mixed $dt_cadastro
     */
    public function setDtCadastro($dt_cadastro)
    {
        $this->dt_cadastro = $dt_cadastro;
    }

    /**
     * @return mixed
     */
    public function getDsTituloUrlAmigavel()
    {
        return $this->ds_titulo_url_amigavel;
    }

    /**
     * @param mixed $ds_titulo_url_amigavel
     */
    public function setDsTituloUrlAmigavel($ds_titulo_url_amigavel)
    {
        $this->ds_titulo_url_amigavel = $ds_titulo_url_amigavel;
    }

    /**
     * @return mixed
     */
    public function getNuVisualizacao()
    {
        return $this->nu_visualizacao;
    }

    /**
     * @param mixed $nu_visualizacao
     */
    public function setNuVisualizacao($nu_visualizacao)
    {
        $this->nu_visualizacao = $nu_visualizacao;
    }

    /**
     * @return mixed
     */
    public function getNuUsuario()
    {
        return $this->nu_usuario;
    }

    /**
     * @param mixed $nu_usuario
     */
    public function setNuUsuario($nu_usuario)
    {
        $this->nu_usuario = $nu_usuario;
    }

    /**
     * @return PaginaVisitaEntidade $co_pagina_visita
     */
    public function getCoPaginaVisita()
    {
        return $this->co_pagina_visita;
    }

    /**
     * @param mixed $co_pagina_visita
     */
    public function setCoPaginaVisita($co_pagina_visita)
    {
        $this->co_pagina_visita = $co_pagina_visita;
    }

}
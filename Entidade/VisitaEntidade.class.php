<?php

/**
 * Visita.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class VisitaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_VISITA';
	const ENTIDADE = 'VisitaEntidade';
	const CHAVE = CO_VISITA;

	private $co_visita;
    private $dt_realizado;
    private $dt_atualizado;
    private $nu_visitas;
    private $co_trafego;
    private $co_pagina_visita;

    /**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_VISITA,
			DT_REALIZADO,
			DT_ATUALIZADO,
			NU_VISITAS,
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
     * @return mixed
     */
    public function getCoVisita()
    {
        return $this->co_visita;
    }

    /**
     * @param mixed $co_visita
     */
    public function setCoVisita($co_visita)
    {
        $this->co_visita = $co_visita;
    }

    /**
     * @return mixed
     */
    public function getDtRealizado()
    {
        return $this->dt_realizado;
    }

    /**
     * @param mixed $dt_realizado
     */
    public function setDtRealizado($dt_realizado)
    {
        $this->dt_realizado = $dt_realizado;
    }

    /**
     * @return mixed
     */
    public function getDtAtualizado()
    {
        return $this->dt_atualizado;
    }

    /**
     * @param mixed $dt_atualizado
     */
    public function setDtAtualizado($dt_atualizado)
    {
        $this->dt_atualizado = $dt_atualizado;
    }

    /**
     * @return mixed
     */
    public function getNuVisitas()
    {
        return $this->nu_visitas;
    }

    /**
     * @param mixed $nu_visitas
     */
    public function setNuVisitas($nu_visitas)
    {
        $this->nu_visitas = $nu_visitas;
    }

    /**
     * @return TrafegoEntidade $co_trafego
     */
    public function getCoTrafego()
    {
        return $this->co_trafego;
    }

    /**
     * @param mixed $co_trafego
     */
    public function setCoTrafego($co_trafego)
    {
        $this->co_trafego = $co_trafego;
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
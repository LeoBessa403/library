<?php

/**
 * PaginaVisita.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class PaginaVisitaEntidade extends AbstractEntidade
{
	const TABELA = 'TB_PAGINA_VISITA';
	const ENTIDADE = 'PaginaVisitaEntidade';
	const CHAVE = CO_PAGINA_VISITA;

	private $co_pagina_visita;
	private $co_pagina;
	private $co_visita;

	/**
     * @return array
     */
	public static function getCampos() {
    	return [
			CO_PAGINA_VISITA,
			CO_PAGINA,
			CO_VISITA,
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
     * @return int mixed
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

    /**
     * @return PaginaEntidade $co_pagina
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
     * @return VisitaEntidade $co_visita
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

}
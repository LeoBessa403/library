<?php

/**
 * PaginaVisitaService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  PaginaVisitaService extends AbstractService
{

    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(PaginaVisitaEntidade::ENTIDADE);
        $this->ObjetoModel = New PaginaVisitaModel();
    }

    public function salvaPaginaVisita($paginaVisita)
    {
        /** @var PaginaVisitaEntidade $paginaVisitaPesquisa */
        $paginaVisitaPesquisa = $this->PesquisaUmQuando([
            CO_VISITA => $paginaVisita[CO_VISITA],
            CO_PAGINA => $paginaVisita[CO_PAGINA]
        ]);

        if (!count($paginaVisitaPesquisa)) {
            return $this->Salva($paginaVisita);
        }
        return true;
    }
}
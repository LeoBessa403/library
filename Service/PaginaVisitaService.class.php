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
        /** @var PaginaService $paginaService */
        $paginaService = $this->getService(PAGINA_SERVICE);
        /** @var PaginaVisitaEntidade $paginaVisitaPesquisa */
        $paginaVisitaPesquisa = $this->PesquisaUmQuando([
            CO_VISITA => $paginaVisita[CO_VISITA],
            CO_PAGINA => $paginaVisita[CO_PAGINA]
        ]);

        if (!count($paginaVisitaPesquisa)) {
            /** @var PaginaEntidade $pagina */
            $pagina = $paginaService->PesquisaUmRegistro($paginaVisita[CO_PAGINA]);
            $paginaEdita[NU_USUARIO] = $pagina->getNuUsuario() + 1;
            $paginaService->Salva($paginaEdita, $paginaVisita[CO_PAGINA]);
            return $this->Salva($paginaVisita);
        }
        return false;
    }
}
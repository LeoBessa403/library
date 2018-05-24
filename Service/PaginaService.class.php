<?php

/**
 * PaginaService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  PaginaService extends AbstractService
{
    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(PaginaEntidade::ENTIDADE);
        $this->ObjetoModel = New PaginaModel();
    }

    public function salvaPagina($coVisita)
    {
        $url = $_GET['url'];
        /** @var PaginaVisitaService $paginaVisitaService */
        $paginaVisitaService = $this->getService(PAGINA_VISITA_SERVICE);
        /** @var PaginaEntidade $paginaPesquisa */
        $paginaPesquisa = $this->PesquisaUmQuando([
            DS_TITULO_URL_AMIGAVEL => $url
        ]);

        if (count($paginaPesquisa)) {
            // Edição da Página
            $pagina[NU_VISUALIZACAO] = $paginaPesquisa->getNuVisualizacao() + 1;
            $this->Salva($pagina, $paginaPesquisa->getCoPagina());
            $coPagina = $paginaPesquisa->getCoPagina();
        } else {
            // Cadastra página
            $pagina[DT_CADASTRO] = Valida::DataHoraAtualBanco();
            $pagina[DS_TITULO_URL_AMIGAVEL] = $url;
            $pagina[NU_VISUALIZACAO] = 1;
            $pagina[NU_USUARIO] = 0;
            $coPagina = $this->Salva($pagina);
        }
        $paginaVisita[CO_PAGINA] = $coPagina;
        $paginaVisita[CO_VISITA] = $coVisita;
        $paginaVisitaService->salvaPaginaVisita($paginaVisita);
        if($coPagina){
            return $coPagina;
        }else{
            return false;
        }
    }

}
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
        $pacote = strtolower(substr($url, 0, strlen(SITE)));
        if ($pacote == SITE) {
            $strpos = strrpos(substr($url, 0, strlen($url)), '.');
            $extArq = strtolower(substr($url, $strpos + 1, strlen($url)));
            $arrNotExt = [
                'jpg', 'jpeg', 'ico', 'xml', 'png', 'php', 'js', 'css', 'phtml', 'html', 'htm', 'sql', 'json', 'pdf',
                'txt', 'map', 'git', 'env', 'ini', 'asp', 'api', 'zip', 'rar', 'tar', '7z', 'gz'
            ];
            if(!in_array($extArq, $arrNotExt)){
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
                $coPaginaVisita = $paginaVisitaService->salvaPaginaVisita($paginaVisita);
                if ($coPagina && $coPaginaVisita) {
                    return $coPagina;
                }
            }
        }
        return false;
    }

}
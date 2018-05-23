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

    public function salvaPagina($usuarioExistente = true)
    {
        $url = $_GET['url'];
        /** @var PaginaEntidade $paginaPesquisa */
        $paginaPesquisa = $this->PesquisaUmQuando([
            DS_TITULO_URL_AMIGAVEL => $url
        ]);
        $paginaVisita = null;

        if (count($paginaPesquisa)) {
            // Edição da Página
            $pagina[NU_VISUALIZACAO] = $paginaPesquisa->getNuVisualizacao() + 1;
            if ($usuarioExistente)
                $pagina[NU_USUARIO] = $paginaPesquisa->getNuUsuario() + 1;
            $this->Salva($pagina, $paginaPesquisa->getCoPagina());
            $paginaVisita = $paginaPesquisa->getCoPagina();
        } else {
            // Cadastra página
            $pagina[DT_CADASTRO] = Valida::DataHoraAtualBanco();
            $pagina[ST_EDICAO] = SimNaoEnum::NAO;
            $pagina[DS_TITULO_URL_AMIGAVEL] = $url;
            $pagina[NU_VISUALIZACAO] = 1;
            $pagina[NU_USUARIO] = 1;
            $paginaVisita = $this->Salva($pagina);
        }
        return $paginaVisita;
    }

}
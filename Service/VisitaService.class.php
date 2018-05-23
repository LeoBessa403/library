<?php

/**
 * VisitaService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  VisitaService extends AbstractService
{

    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(VisitaEntidade::ENTIDADE);
        $this->ObjetoModel = New VisitaModel();
    }

    public function gestaoVisita()
    {
        $session = new Session();
        /** @var PaginaService $paginaService */
        $paginaService = $this->getService(PAGINA_SERVICE);
        /** @var PaginaVisitaService $paginaVisitaService */
        $paginaVisitaService = $this->getService(PAGINA_VISITA_SERVICE);
        /** @var TrafegoService $trafegoService */
        $trafegoService = $this->getService(TRAFEGO_SERVICE);

        $noCookie = Valida::ValNome(DESC . '-user');
        if ($session::CheckCookie($noCookie)) {
            $coVisita = $session::getCookie($noCookie);
            /** @var VisitaEntidade $visitaPesquisa */
            $visitaPesquisa = $this->PesquisaUmRegistro($coVisita);

            if (count($visitaPesquisa)) {
                // Edição da Página
                $visita[NU_VISITAS] = $visitaPesquisa->getNuVisitas() + 1;
                $paginaService->Salva($visita, $visitaPesquisa->getCoVisita());
            }else{
                $coTrafego = $trafegoService->salvaTrafego();
                $paginaVisita[CO_VISITA] = $this->salvaVisita($coTrafego);
            }
        } else {
            /** @var PDO $PDO */
            $PDO = $this->getPDO();
            $retorno = [
                SUCESSO => false
            ];

            $PDO->beginTransaction();
            $coTrafego = $trafegoService->salvaTrafego();

            $paginaVisita[CO_VISITA] = $this->salvaVisita($coTrafego);
            $paginaVisita[CO_PAGINA] = $paginaService->salvaPagina();

            $retorno[SUCESSO] = $paginaVisitaService->salvaPaginaVisita($paginaVisita);

            $session::setCookie($noCookie, $paginaVisita[CO_VISITA] , 24 * 60);
            if ($retorno[SUCESSO]) {
                $PDO->commit();
            } else {
                $PDO->rollBack();
            }

        }
    }

    public function salvaVisita($coTrafego)
    {
        $visita[CO_TRAFEGO] = $coTrafego;
        $visita[DT_REALIZADO] = Valida::DataHoraAtualBanco();
        $visita[DT_ATUALIZADO] = Valida::DataHoraAtualBanco();
        $visita[NU_VISITAS] = 1;
        return $this->Salva($visita);
    }


}
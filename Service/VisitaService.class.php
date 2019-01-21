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
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $retorno = [
            SUCESSO => false
        ];
        /** @var PaginaService $paginaService */
        $paginaService = $this->getService(PAGINA_SERVICE);
        /** @var TrafegoService $trafegoService */
        $trafegoService = $this->getService(TRAFEGO_SERVICE);
        $PDO->beginTransaction();
        $noCookie = Valida::ValNome(DESC . '-user');

        if ($session::CheckCookie($noCookie)) {
            $coVisita = $session::getCookie($noCookie);
            /** @var VisitaEntidade $visitaPesquisa */
            $visitaPesquisa = $this->PesquisaUmRegistro($coVisita);
            // Edição da Página
            $visita[NU_VISITAS] = $visitaPesquisa->getNuVisitas() + 1;
            $visita[DT_ATUALIZADO] = Valida::DataHoraAtualBanco();
            $this->Salva($visita, $visitaPesquisa->getCoVisita());
            $retorno[SUCESSO] = $paginaService->salvaPagina($visitaPesquisa->getCoVisita());
        } else {
            $coTrafego = $trafegoService->salvaTrafego();
            $coVisita = $this->salvaVisita($coTrafego);
            $retorno[SUCESSO] = $paginaService->salvaPagina($coVisita);
            $session::setCookie($noCookie, $coVisita, 24 * 60);
        }
        if ($retorno[SUCESSO]) {
            $PDO->commit();
        } else {
            $PDO->rollBack();
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

    public function visitasDispositivo()
    {
        return $this->ObjetoModel->visitasDispositivo();
    }

    public function visitasSO()
    {
        return $this->ObjetoModel->visitasSO();
    }

    public function visitasNavegador()
    {
        return $this->ObjetoModel->visitasNavegador();
    }

    public function visitasCidade()
    {
        return $this->ObjetoModel->visitasCidade();
    }

    public function visitasEstado()
    {
        return $this->ObjetoModel->visitasEstado();
    }

    public function visitasPagina()
    {
        return $this->ObjetoModel->visitasPagina();
    }


    public function totalVisitas()
    {
        return $this->ObjetoModel->totalVisitas();
    }


    public function totalVisitasMesAtual()
    {
        return $this->ObjetoModel->totalVisitasMesAtual();
    }


}
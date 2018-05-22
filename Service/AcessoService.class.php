<?php

/**
 * AcessoService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  AcessoService extends AbstractService
{
    private $ObjetoModel;

    /**
     * AcessoService constructor.
     */
    public function __construct()
    {
        parent::__construct(AcessoEntidade::ENTIDADE);
        $this->ObjetoModel = New AcessoModel();
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

    /**
     * @param $coUsuario
     */
    public function salvarAcesso($coUsuario)
    {
        /** @var TrafegoService $trafegoService */
        $trafegoService = $this->getService(TRAFEGO_SERVICE);

        $acesso[DS_SESSION_ID] = session_id();
        $acesso[CO_USUARIO] = $coUsuario;
        $acesso[TP_SITUACAO] = StatusAcessoEnum::ATIVO;

        /** @var AcessoEntidade $meuAcesso */
        $meuAcesso = $this->PesquisaUmQuando($acesso);
        if ($meuAcesso) {
            $novoAcesso[DT_FIM_ACESSO] = $this->geraDataFimAcesso();
            $this->Salva($novoAcesso, $meuAcesso->getCoAcesso());
        } else {
            $acesso[CO_TRAFEGO] = $trafegoService->salvaTrafego();
            $acesso[DT_FIM_ACESSO] = $this->geraDataFimAcesso();
            $acesso[DT_INICIO_ACESSO] = Valida::DataHoraAtualBanco();
            $this->Salva($acesso);
        }
    }

    /**
     * @return false|string
     */
    public function geraDataFimAcesso()
    {
        return date("Y-m-d H:i:s", strtotime(Valida::DataHoraAtualBanco() . " + " . INATIVO . " minutes"));
    }

    /**
     * @param $coUsuario
     */
    public function terminaAcesso($coUsuario)
    {
        $acesso[DS_SESSION_ID] = session_id();
        $acesso[CO_USUARIO] = $coUsuario;
        $acesso[TP_SITUACAO] = StatusAcessoEnum::ATIVO;

        /** @var AcessoEntidade $meuAcesso */
        $meuAcesso = $this->PesquisaUmQuando($acesso);

        if ($meuAcesso) {
            $terminaAcesso[TP_SITUACAO] = StatusAcessoEnum::FINALIZADO;
            $terminaAcesso[DT_FIM_ACESSO] = Valida::DataHoraAtualBanco();
            $this->Salva($terminaAcesso, $meuAcesso->getCoAcesso());
        }
    }

    /**
     * @param $coUsuario
     * @return bool
     */
    public function verificaAcesso($coUsuario)
    {
        $permitido = false;
        $acesso[DS_SESSION_ID] = session_id();
        $acesso[CO_USUARIO] = $coUsuario;
        $acesso[TP_SITUACAO] = StatusAcessoEnum::ATIVO;

        /** @var AcessoEntidade $meuAcesso */
        $meuAcesso = $this->PesquisaUmQuando($acesso);

        if ($meuAcesso) {
            $ultimo_acesso = strtotime($meuAcesso->getDtFimAcesso());
            $agora = strtotime(Valida::DataHoraAtualBanco());
            if ($ultimo_acesso > $agora) {
                $novoAcesso[DT_FIM_ACESSO] = $this->geraDataFimAcesso();
                $this->Salva($novoAcesso, $meuAcesso->getCoAcesso());
                $permitido = true;
            }
        }
        return $permitido;
    }

    /**
     *
     */
    public function finalizaAcessos()
    {
        return $this->ObjetoModel->finalizaAcessos();
    }

}
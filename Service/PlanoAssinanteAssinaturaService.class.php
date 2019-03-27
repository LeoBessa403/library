<?php

/**
 * PlanoAssinanteAssinaturaService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoAssinanteAssinaturaService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PlanoAssinanteAssinaturaEntidade::ENTIDADE);
        $this->ObjetoModel = New PlanoAssinanteAssinaturaModel();
    }

    public function salvaPagamentoAssinante($dados)
    {
        /** @var PlanoService $PlanoService */
        $PlanoService = $this->getService(PLANO_SERVICE);
        /** @var AssinanteService $AssinanteService */
        $AssinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $session = new Session();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        /** @var PlanoAssinanteAssinaturaValidador $planoAssinanteAssinaturaValidador */
        $planoAssinanteAssinaturaValidador = new PlanoAssinanteAssinaturaValidador();
        $validador = $planoAssinanteAssinaturaValidador->validarPlanoAssinanteAssinatura($dados);
        if ($validador[SUCESSO]) {
            /** @var PlanoEntidade $plano */
            $plano = $PlanoService->PesquisaUmRegistro($dados[CO_PLANO][0]);
            /** @var AssinanteEntidade $assinante */
            $assinante = $AssinanteService->PesquisaUmRegistro($dados[CO_ASSINANTE]);

            $planoAssinanteAssinatura[CO_PLANO_ASSINANTE] = $plano->getCoUltimoPlanoAssinante()->getCoPlanoAssinante();
            $planoAssinanteAssinatura[CO_ASSINANTE] = $dados[CO_ASSINANTE];
            $planoAssinanteAssinatura[NU_PROFISSIONAIS] = $dados[NU_PROFISSIONAIS];
            $planoAssinanteAssinatura[NU_FILIAIS] = $dados[NU_FILIAIS];
            $planoAssinanteAssinatura[DT_CADASTRO] = Valida::DataHoraAtualBanco();
            $planoAssinanteAssinatura[DT_EXPIRACAO] = Valida::DataDBDate(Valida::CalculaData(
                Valida::DataShow($assinante->getDtExpiracao()),
                $plano->getNuMesAtivo(),
                "+",
                'm'
            ));
            if ($dados[NU_PROFISSIONAIS] <= ConfiguracoesEnum::PROFISSIONAIS_BAIXA) {
                $profACobrar = 0;
            } else if ($dados[NU_PROFISSIONAIS] <= ConfiguracoesEnum::PROFISSIONAIS_MEDIA) {
                $profACobrar = ($dados[NU_PROFISSIONAIS] - ConfiguracoesEnum::PROFISSIONAIS_BAIXA) *
                    ConfiguracoesEnum::TAXA_PROFISSIONAIS_BAIXA;
            } else if ($dados[NU_PROFISSIONAIS] <= ConfiguracoesEnum::PROFISSIONAIS_ALTA) {
                $profACobrar = ($dados[NU_PROFISSIONAIS] - ConfiguracoesEnum::PROFISSIONAIS_BAIXA) *
                    ConfiguracoesEnum::TAXA_PROFISSIONAIS_MEDIA;
            } else {
                $profACobrar = ($dados[NU_PROFISSIONAIS] - ConfiguracoesEnum::PROFISSIONAIS_BAIXA) *
                    ConfiguracoesEnum::TAXA_PROFISSIONAIS_ALTA;
            }
            $valorFiliais = ($plano->getCoUltimoPlanoAssinante()->getNuValor() / 2) * $dados[NU_FILIAIS];
            $valorAssinatura = $profACobrar + $valorFiliais + $plano->getCoUltimoPlanoAssinante()->getNuValor();
            $valorAssinatura = $valorAssinatura * $plano->getNuMesAtivo();
            $planoAssinanteAssinatura[NU_VALOR_ASSINATURA] =
                Valida::FormataMoedaBanco(str_replace(".", ",", $valorAssinatura));

            $PDO->beginTransaction();
            $this->Salva($planoAssinanteAssinatura);
            $retorno[SUCESSO] = $this->atualizaDtExpiracaoMatrizFilias($assinante, $planoAssinanteAssinatura[DT_EXPIRACAO]);
            if ($retorno[SUCESSO]) {
                $session->setSession(MENSAGEM, CADASTRADO);
                $retorno[SUCESSO] = true;
                $PDO->commit();
            } else {
                $session->setSession(MENSAGEM, 'Não foi possível realizar a ação');
                $retorno[SUCESSO] = false;
                $PDO->rollBack();
            }
        } else {
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }
        return $retorno;
    }

    /**
     * @param $assinante AssinanteEntidade
     * @param $dtExpiracao
     * @return bool|INT
     */
    public function atualizaDtExpiracaoMatrizFilias($assinante, $dtExpiracao)
    {
        /** @var AssinanteService $AssinanteService */
        $AssinanteService = $this->getService(ASSINANTE_SERVICE);
        $filiais = $assinante->getFiliaisMatriz();
        $assFilial[DT_EXPIRACAO] = $dtExpiracao;
        if(!empty($filiais)){
            /** @var AssinanteFilialEntidade $filial */
            foreach ($filiais as $filial) {
                $AssinanteService->Salva($assFilial, $filial->getCoAssinante());
            }
        }
        return $AssinanteService->Salva($assFilial, $assinante->getCoAssinante());
    }

    public function salvaPlanoPadrao($coAssinante)
    {
        $planoAssinanteAssinatura[CO_PLANO_ASSINANTE] = 1;
        $planoAssinanteAssinatura[CO_ASSINANTE] = $coAssinante;
        $planoAssinanteAssinatura[NU_PROFISSIONAIS] = 3;
        $planoAssinanteAssinatura[NU_FILIAIS] = 0;
        $planoAssinanteAssinatura[DT_CADASTRO] = Valida::DataHoraAtualBanco();
        $planoAssinanteAssinatura[DT_EXPIRACAO] = Valida::DataDBDate(Valida::CalculaData(date('d/m/Y'),
            ConfiguracoesEnum::DIAS_EXPERIMENTAR, "+"));
        $planoAssinanteAssinatura[NU_VALOR_ASSINATURA] = '0.00';
        return $this->Salva($planoAssinanteAssinatura);
    }
}
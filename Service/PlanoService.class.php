<?php

/**
 * PlanoService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PlanoEntidade::ENTIDADE);
        $this->ObjetoModel = New PlanoModel();
    }

    public function salvaPlano($dados)
    {
        /** @var PlanoPacoteService $PlanoPacoteService */
        $PlanoPacoteService = $this->getService(PLANO_PACOTE_SERVICE);
        /** @var PlanoAssinanteService $PlanoAssinanteService */
        $PlanoAssinanteService = $this->getService(PLANO_ASSINANTE_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $session = new Session();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $planoValidador = new PlanoValidador();
        /** @var PlanoValidador $validador */
        $validador = $planoValidador->validarPlano($dados);
        if ($validador[SUCESSO]) {
            $plano[NO_PLANO] = trim($dados[NO_PLANO]);
            $plano[NU_MES_ATIVO] = $dados[NU_MES_ATIVO][0];
            $plano[ST_STATUS] = (!empty($dados[ST_STATUS])) ? StatusUsuarioEnum::ATIVO : StatusUsuarioEnum::INATIVO;
            $planoAssinante[DS_OBSERVACAO] = trim($dados[DS_OBSERVACAO]);
            $planoAssinante[NU_VALOR] = Valida::FormataMoedaBanco($_POST[NU_VALOR]);
            $planoAssinante[DT_CADASTRO] = Valida::DataHoraAtualBanco();

            $PDO->beginTransaction();
            if (!empty($_POST[CO_PLANO])):
                $coPlano = $dados[CO_PLANO];
                $this->Salva($plano, $coPlano);
                $session->setSession(MENSAGEM, ATUALIZADO);
            else:
                $plano[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $coPlano = $this->Salva($plano);
                $session->setSession(MENSAGEM, CADASTRADO);
            endif;

            $planoPacote[CO_PLANO] = $coPlano;
            $planoAssinante[CO_PLANO] = $coPlano;
            $ok = $PlanoPacoteService->DeletaQuando($planoPacote);
            if ($ok) {
                if (!empty($dados[CO_PACOTE])) {
                    foreach ($dados[CO_PACOTE] as $modulo) {
                        $planoPacote[CO_PACOTE] = $modulo;
                        $PlanoPacoteService->Salva($planoPacote);
                    }
                }
            }
            $retorno[SUCESSO] = $PlanoAssinanteService->Salva($planoAssinante);
            if ($retorno[SUCESSO]) {
                $retorno[SUCESSO] = true;
                $PDO->commit();
            } else {
                Notificacoes::geraMensagem(
                    'Não foi possível realizar a ação',
                    TiposMensagemEnum::ERRO
                );
                $retorno[SUCESSO] = false;
                $PDO->rollBack();
            }
        } else {
            Notificacoes::geraMensagem(
                $validador[MSG],
                TiposMensagemEnum::ALERTA
            );
            $retorno = $validador;
        }
        return $retorno;
    }

    public static function montaComboMesesAtivos()
    {
        $todosMesAt = [
            1 => '1 Mês',
            3 => '3 Meses',
            6 => '6 Meses',
            12 => '12 Meses',
            24 => '24 Meses',
            36 => '36 Meses',
        ];
        return $todosMesAt;
    }

    public static function montaComboPlanosAtivos()
    {
        /** @var PlanoService $planoService */
        $planoService = new PlanoService();

        $planos = $planoService->PesquisaTodos([
            ST_STATUS => StatusAcessoEnum::ATIVO
        ]);
        $planos = array_reverse($planos);
        $todosPlanos = [
            '' => 'Escolher Plano'
        ];
        /** @var PlanoEntidade $plano */
        foreach ($planos as $plano) :
            if ($plano->getCoPlano() != 1) {
                $meses = ($plano->getNuMesAtivo() == 1) ? ' Mês' : ' Meses';
                $todosPlanos[$plano->getCoPlano()] = $plano->getNoPlano() .
                    ' - R$ ' . Valida::FormataMoeda($plano->getCoUltimoPlanoAssinante()->getNuValor()) . ' - ' .
                    $plano->getNuMesAtivo() . $meses;
            }
        endforeach;
        return $todosPlanos;
    }

    /**
     * @param $coPlano
     * @return array|mixed
     */
    public function getValorPlano($coPlano)
    {
        /** @var PlanoService $planoService */
        $planoService = new PlanoService();
        /** @var PlanoEntidade $plano */
        $plano = $planoService->PesquisaUmRegistro($coPlano);

        return [NU_VALOR_ASSINATURA => $plano->getCoUltimoPlanoAssinante()->getNuValor()];
    }

}
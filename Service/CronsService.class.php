<?php

/**
 * CronsService.class [ SEVICE ]
 * @copyright (c) 2019, Leo Bessa
 */
class  CronsService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(CronsEntidade::ENTIDADE);
        $this->ObjetoModel = New CronsModel();
    }


    public function salvaCron($dados)
    {
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        /** @var Session $session */
        $session = new Session();

        $cronValidador = new CronValidador();
        /** @var CronValidador $validador */
        $validador = $cronValidador->validarCron($dados);
        if ($validador[SUCESSO]) {
            $cron[NO_CRON] = trim($dados[NO_CRON]);
            $cron[DS_SQL] = trim($dados[DS_SQL]);

            if (!empty($_POST[CO_CRON])):
                $coCron = $dados[CO_CRON];
                $retorno[SUCESSO] = $this->Salva($cron, $coCron);
                $session->setSession(MENSAGEM, ATUALIZADO);
            else:
                $cron[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $retorno[SUCESSO] = $this->Salva($cron);
                $session->setSession(MENSAGEM, CADASTRADO);

            endif;
        } else {
            Notificacoes::geraMensagem(
                $validador[MSG],
                TiposMensagemEnum::ALERTA
            );
            $retorno = $validador;
        }
        return $retorno;
    }


}
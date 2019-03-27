<?php

/**
 * AnotacaoService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AnotacaoService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(AnotacaoEntidade::ENTIDADE);
        $this->ObjetoModel = New AnotacaoModel();
    }

    public function salvaAnotacao($dados)
    {
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $anotacaoValidador = new AnotacaoValidador();
        /** @var AnotacaoValidador $validador */
        $validador = $anotacaoValidador->validarAnotacao($dados);
        if ($validador[SUCESSO]) {
            $anotacao[DS_TITULO] = trim($dados[DS_TITULO]);
            $anotacao[CO_HISTORIA] = $dados[CO_HISTORIA];
            $anotacao[DS_OBSERVACAO] = trim($dados[DS_OBSERVACAO]);

            if (!empty($_POST[CO_ANOTACAO])):
                $coAnotacao = $dados[CO_ANOTACAO];
                $retorno[SUCESSO] = $this->Salva($anotacao, $coAnotacao);
            else:
                $anotacao[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $retorno[SUCESSO] = $this->Salva($anotacao);
            endif;
        } else {
            $session = new Session();
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }
        return $retorno;
    }
}
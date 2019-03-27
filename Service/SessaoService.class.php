<?php

/**
 * SessaoService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  SessaoService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(SessaoEntidade::ENTIDADE);
        $this->ObjetoModel = New SessaoModel();
    }

    public function salvaSessao($dados)
    {
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $sessaoValidador = new SessaoValidador();
        /** @var SessaoValidador $validador */
        $validador = $sessaoValidador->validarSessao($dados);
        if ($validador[SUCESSO]) {
            $sessao[NO_SESSAO] = trim($dados[NO_SESSAO]);
            $sessao[CO_MODULO] = $dados[CO_MODULO];

            if (!empty($_POST[CO_SESSAO])):
                $coSessao = $dados[CO_SESSAO];
                $retorno[SUCESSO] = $this->Salva($sessao, $coSessao);
            else:
                $sessao[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $retorno[SUCESSO] = $this->Salva($sessao);
            endif;
        } else {
            $session = new Session();
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }
        return $retorno;
    }

}
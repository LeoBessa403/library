<?php

/**
 * ValidaUsuario.class [ HELPER ]
 * @copyright (c) 2016, Leo Bessa
 */
class ValidaUsuario extends AbstractController
{

    function __construct()
    {
        $url = (isset($_GET['url']) && $_GET['url'] != "" ? $_GET['url'] : "");
        $explode = explode('/', $url);
        $session = new Session();
        if (!$session->CheckSession(SESSION_USER)):
            if (!isset($_POST['logar_sistema'])):
                if (isset($explode[3]) && $explode[3] == "PrimeiroAcesso"):
                    Redireciona(ADMIN . LOGIN);
                    die;
                else:
                    Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/R"));
                    die;
                endif;
            else:
                Index::logar();
            endif;
        else:
            if (isset($explode[3]) && $explode[3] == "desloga"):
                $session->FinalizaSession(SESSION_USER);
                Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/D"));
                die;
            else:
                $us = $_SESSION[SESSION_USER];
                /** @var Session $us */
                $user = $us->getUser();

                $ultimo_acesso = intval(strtotime($user[md5(DT_FIM_ACESSO)]) + (60 * INATIVO));
                $agora = strtotime(Valida::DataAtualBanco());
                if ($agora > $ultimo_acesso):
                    $session->FinalizaSession(SESSION_USER);
                    Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/E"));
                    die;
                else:
                    $acessoService = $this->getService(ACESSO_SERVICE);
                    $us->setUserUltimoAcesso(Valida::DataAtualBanco());
                    $pesquisaAcesso[CO_USUARIO] = $user[md5(CO_USUARIO)];
                    $pesquisaAcesso[DS_SESSION_ID] = session_id();
                    $meuAcesso = $acessoService->PesquisaUmQuando($pesquisaAcesso);
                    $acesso[DT_FIM_ACESSO] = Valida::DataAtualBanco();
                    if($meuAcesso):
                        $acessoService->Salva($acesso, $meuAcesso->getCoAcesso());
                    else:
                        $pesquisaAcesso[DT_INICIO_ACESSO] = Valida::DataAtualBanco();
                        $pesquisaAcesso[DT_FIM_ACESSO] = Valida::DataAtualBanco();
                        $acessoService->Salva($pesquisaAcesso);
                    endif;
                    if ($session->CheckSession(CADASTRADO)):
                        $session->FinalizaSession(CADASTRADO);
                    endif;
                if ($session->CheckSession(ATUALIZADO)):
                    $session->FinalizaSession(ATUALIZADO);
                endif;
            endif;
        endif;
        endif;
    }

}

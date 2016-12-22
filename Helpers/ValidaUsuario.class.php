<?php

/**
 * ValidaUsuario.class [ HELPER ]
 * @copyright (c) 2016, Leo Bessa
 */
class ValidaUsuario
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

                $ultimo_acesso = intval(strtotime($user[md5(Constantes::DT_FIM_ACESSO)]) + (60 * INATIVO));
                $agora = strtotime(Valida::DataAtualBanco());
                if ($agora > $ultimo_acesso):
                    $session->FinalizaSession(SESSION_USER);
                    Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/E"));
                    die;
                else:
                    $acessoModel = new AcessoModel();
                    $us->setUserUltimoAcesso(Valida::DataAtualBanco());
                    $pesquisaAcesso[Constantes::CO_USUARIO] = $user[md5(Constantes::CO_USUARIO)];
                    $pesquisaAcesso[Constantes::DS_SESSION_ID] = session_id();
                    $meuAcesso = $acessoModel->PesquisaUmQuando($pesquisaAcesso);
                    $acesso[Constantes::DT_FIM_ACESSO] = Valida::DataAtualBanco();
                    $acessoModel->Salva($acesso, $meuAcesso->getCoAcesso());
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

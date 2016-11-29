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
                    Index::Acessar();
                endif;
            else:
                Index::logar();
            endif;
        else:
            if (isset($explode[3]) && $explode[3] == "desloga"):
                $session->FinalizaSession(SESSION_USER);
                Redireciona(ADMIN . LOGIN . "?o=sucesso2");
                die();
            else:
                $us = $_SESSION[SESSION_USER];
                $user = $us->getUser();

                $ultimo_acesso = intval($user[md5("ultimo_acesso")] + (60 * INATIVO));
                $agora = strtotime(Valida::DataDB(Valida::DataAtual()));
                if ($agora > $ultimo_acesso):
                    $session->FinalizaSession(SESSION_USER);
                    Redireciona(ADMIN . LOGIN . "?o=deslogado");
                    die();
                else:
                    $us->setUserUltimoAcesso(strtotime(Valida::DataDB(Valida::DataAtual())));
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

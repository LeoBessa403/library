<?php

/**
 * ValidaUsuario.class [ HELPER ]
 * @copyright (c) 2016, Leo Bessa
 */
class ValidaUsuario extends AbstractController
{

    public function validacao()
    {
        $link = UrlAmigavel::getLink();
        $url = (isset($link) && $link != "" ? $link : "");
        $explode = explode('/', $url);
        /** @var Session $session */
        $session = new Session();
        if (!$session->CheckSession(SESSION_USER)) {
            if (!isset($_POST['logar_sistema'])):
                if (isset($explode[2]) && $explode[2] == "PrimeiroAcesso"):
                    Redireciona(ADMIN . LOGIN);
                    die;
                else:
                    Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/R"));
                    die;
                endif;
            else:
                $index = new Index();
                $index->Logar();
            endif;
        } else {
            /** @var AcessoService $AcessoSevice */
            $AcessoSevice = $this->getService(ACESSO_SERVICE);
            /** @var Session $us */
            $us = $_SESSION[SESSION_USER];
            $user = $us->getUser();
            $coUsuario = $user[md5(CO_USUARIO)];

            if (isset($explode[3]) && $explode[3] == "desloga"):
                $AcessoSevice->terminaAcesso($coUsuario);

                $session->FinalizaSession(SESSION_USER);
                Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/D"));
                die;
            else:
                if (!$AcessoSevice->verificaAcesso($coUsuario)):
                    $AcessoSevice->terminaAcesso($coUsuario);
                    $session->FinalizaSession(SESSION_USER);
                    Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/E"));
                    die;
                else:
                    $AcessoSevice->salvarAcesso($coUsuario);
                    if ($session->CheckSession(CADASTRADO)):
                        $session->FinalizaSession(CADASTRADO);
                    endif;
                    if ($session->CheckSession(ATUALIZADO)):
                        $session->FinalizaSession(ATUALIZADO);
                    endif;
                endif;
            endif;
        }
    }

}

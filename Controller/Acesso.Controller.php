<?php

class Acesso extends AbstractController
{
    public $result;

    public function ListarAcesso()
    {
        /** @var AcessoService $acessoService */
        $acessoService = $this->getService(ACESSO_SERVICE);

        if (!empty($_POST)) {
            $this->result = $acessoService->PesquisaAvancada($_POST);
        } else {
            $this->result = [];
        }

    }

    public function ListarAcessoPesquisaAvancada()
    {
        echo AcessoForm::Pesquisar();
    }

}

<?php

class Auditoria extends AbstractController
{
    public $result;

    function ListarAuditoria()
    {
        if (!empty($_POST)) {
            /** @var AuditoriaService $auditoriaService */
            $auditoriaService = $this->getService(AUDITORIA_SERVICE);
            $this->result = $auditoriaService->PesquisaAvancada($_POST);
        } else {
            $this->result = [];
        }

    }

    public function ListarAuditoriaPesquisaAvancada()
    {
        echo AuditoriaForm::Pesquisar();
    }

}

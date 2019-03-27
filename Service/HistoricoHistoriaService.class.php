<?php

/**
 * HistoricoHistoriaService.class [ SEVICE ]
 * @copyright (c) 2019, Leo Bessa
 */
class  HistoricoHistoriaService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(HistoricoHistoriaEntidade::ENTIDADE);
        $this->ObjetoModel = New HistoricoHistoriaModel();
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

}
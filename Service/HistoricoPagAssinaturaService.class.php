<?php

/**
 * HistoricoPagAssinaturaService.class [ SEVICE ]
 * @copyright (c) 2020, Leo Bessa
 */
class  HistoricoPagAssinaturaService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(HistoricoPagAssinaturaEntidade::ENTIDADE);
        $this->ObjetoModel = New HistoricoPagAssinaturaModel();
    }


}
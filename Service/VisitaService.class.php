<?php

/**
 * VisitaService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  VisitaService extends AbstractService
{

    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(VisitaEntidade::ENTIDADE);
        $this->ObjetoModel = New VisitaModel();
    }


}
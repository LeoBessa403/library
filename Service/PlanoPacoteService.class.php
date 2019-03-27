<?php

/**
 * PlanoPacoteService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoPacoteService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PlanoPacoteEntidade::ENTIDADE);
        $this->ObjetoModel = New PlanoPacoteModel();
    }


}
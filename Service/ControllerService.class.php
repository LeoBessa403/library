<?php

/**
 * ControllerService.class [ SEVICE ]
 * @copyright (c) 2019, Leo Bessa
 */
class  ControllerService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(ControllerEntidade::ENTIDADE);
        $this->ObjetoModel = New ControllerModel();
    }


}
<?php

/**
 * AuditoriaItensService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AuditoriaItensService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(AuditoriaItensEntidade::ENTIDADE);
        $this->ObjetoModel = New AuditoriaItensModel();
    }


}
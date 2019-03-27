<?php

/**
 * AssinanteFilialService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AssinanteFilialService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(AssinanteFilialEntidade::ENTIDADE);
        $this->ObjetoModel = New AssinanteFilialModel();
    }


}
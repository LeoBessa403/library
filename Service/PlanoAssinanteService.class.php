<?php

/**
 * PlanoAssinanteService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoAssinanteService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PlanoAssinanteEntidade::ENTIDADE);
        $this->ObjetoModel = New PlanoAssinanteModel();
    }


}
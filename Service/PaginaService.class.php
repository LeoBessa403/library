<?php

/**
 * PaginaService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  PaginaService extends AbstractService
{
    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(PaginaEntidade::ENTIDADE);
        $this->ObjetoModel = New PaginaModel();
    }


}
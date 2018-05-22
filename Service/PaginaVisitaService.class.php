<?php

/**
 * PaginaVisitaService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  PaginaVisitaService extends AbstractService
{

    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(PaginaVisitaEntidade::ENTIDADE);
        $this->ObjetoModel = New PaginaVisitaModel();
    }


}
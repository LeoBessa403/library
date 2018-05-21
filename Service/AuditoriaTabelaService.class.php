<?php

/**
 * AuditoriaTabelaService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AuditoriaTabelaService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(AuditoriaTabelaEntidade::ENTIDADE);
        $this->ObjetoModel = New AuditoriaTabelaModel();
    }


}
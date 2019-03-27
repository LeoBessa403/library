<?php

/**
 * ModuloService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PacoteService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PacoteEntidade::ENTIDADE);
        $this->ObjetoModel = New PacoteModel();
    }

    public static function montaComboModulos()
    {
        /** @var PacoteService $pacoteService */
        $pacoteService = new PacoteService();

        $pacotes = $pacoteService->PesquisaTodos();
        $todosPcts = array();
        /** @var PacoteEntidade $pacote */
        foreach ($pacotes as $pacote) :
            $todosPcts[$pacote->getCoPacote()] = $pacote->getNoPacote();
        endforeach;
        return $todosPcts;
    }
}
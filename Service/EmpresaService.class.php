<?php

/**
 * EmpresaService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  EmpresaService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(EmpresaEntidade::ENTIDADE);
        $this->ObjetoModel = New EmpresaModel();
    }

    public function salvaEmpressaAssinante($dados)
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var AssinanteEntidade $assinante */
        $assinante = $assinanteService->getAssinanteLogado();
        $empresa[NO_EMPRESA] = (!empty($dados[NO_EMPRESA])) ? strtoupper(trim($dados[NO_EMPRESA])) : null;
        $empresa[NO_FANTASIA] = (!empty($dados[NO_FANTASIA])) ? strtoupper(trim($dados[NO_FANTASIA])) : null;
        $empresa[NU_CNPJ] = (!empty($dados[NU_CNPJ])) ? Valida::RetiraMascara($dados[NU_CNPJ]) : null;
        $empresa[NU_INSC_ESTADUAL] = (!empty($dados[NU_INSC_ESTADUAL])) ? $dados[NU_INSC_ESTADUAL] : null;
        $empresa[DS_OBSERVACAO] = (!empty($dados[DS_OBSERVACAO])) ? trim($dados[DS_OBSERVACAO]) : null;
        $empresa[NO_EMPRESA] = (!empty($dados[NO_EMPRESA])) ? strtoupper(trim($dados[NO_EMPRESA])) : null;

        $retorno[SUCESSO] = $this->Salva($empresa, $assinante->getCoEmpresa()->getCoEmpresa());

        return $retorno;
    }


}
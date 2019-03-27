<?php

/**
 * AssinanteMatrizService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AssinanteMatrizService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(AssinanteMatrizEntidade::ENTIDADE);
        $this->ObjetoModel = New AssinanteMatrizModel();
    }

    public function salvaAssinanteMatriz($dados, $coAssinante)
    {
        /** @var AssinanteMatrizService $assinanteMatrizService */
        $assinanteMatrizService = $this->getService(ASSINANTE_MATRIZ_SERVICE);
        /** @var AssinanteFilialService $assinanteFilialService */
        $assinanteFilialService = $this->getService(ASSINANTE_FILIAL_SERVICE);
        if (!empty($dados[CO_ASSINANTE])):
            if (!empty($dados[CO_ASSINANTE_MATRIZ][0])):
                $coMatriz = $dados[CO_ASSINANTE_MATRIZ][0];
                /** @var AssinanteMatrizEntidade $matriz */
                $matriz = $assinanteMatrizService->PesquisaUmQuando([
                    CO_ASSINANTE => $coMatriz
                ]);
                if (empty($matriz)):
                    $assinMatriz[CO_ASSINANTE] = $coMatriz;
                    $assinMatriz[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                    $assinFilial[CO_ASSINANTE_MATRIZ] = $this->Salva($assinMatriz);
                else:
                    $assinFilial[CO_ASSINANTE_MATRIZ] = $matriz->getCoAssinanteMatriz();
                endif;
                $assinFilial[CO_ASSINANTE] = $coAssinante;
                $assinFilial[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $retorno[SUCESSO] = $assinanteFilialService->Salva($assinFilial);
            else:
                $retorno[SUCESSO] = $assinanteFilialService->DeletaQuando([
                    CO_ASSINANTE => $dados[CO_ASSINANTE]
                ]);
            endif;
        endif;
    }
}
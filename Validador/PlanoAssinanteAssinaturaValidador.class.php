<?php

/**
 * PlanoAssinanteAssinaturaValidador [ VALIDATOR ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoAssinanteAssinaturaValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarPlanoAssinanteAssinatura($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoSelectObrigatorio(
            $dados[CO_PLANO], 'Plano'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoSelectObrigatorio(
            $dados[TP_PAGAMENTO],  'Tipo de Pagamento'
        );

        return $this->MontaRetorno($this->retorno);
    }
}
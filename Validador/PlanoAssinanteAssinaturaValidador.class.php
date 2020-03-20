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
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_CPF], AbstractValidador::VALIDACAO_CPF, 'CPF do Comprador'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_TEL1],AbstractValidador::VALIDACAO_TEL, 'Celular do Comprador'
        );

        return $this->MontaRetorno($this->retorno);
    }
}
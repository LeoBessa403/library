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
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_FILIAIS], AbstractValidador::VALIDACAO_MOEDA, 'Número de Filiais'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_PROFISSIONAIS], AbstractValidador::VALIDACAO_MOEDA, 'Número de Profissionais'
        );

        return $this->MontaRetorno($this->retorno);
    }
}
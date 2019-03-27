<?php

/**
 * PlanoValidador [ VALIDATOR ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarPlano($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[NO_PLANO], 1, 'Plano'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoSelectObrigatorio(
            $dados[NU_MES_ATIVO], 'Meses Ativo'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoSelectObrigatorio(
            $dados[CO_MODULO], 'Módulos do plano'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_VALOR], AbstractValidador::VALIDACAO_MOEDA, 'Valor R$'
        );

        return $this->MontaRetorno($this->retorno);
    }
}
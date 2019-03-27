<?php

/**
 * AnotacaoValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  AnotacaoValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarAnotacao($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[DS_TITULO], 2, 'Título da Anotação'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
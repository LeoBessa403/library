<?php

/**
 * ModuloValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  ModuloValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarModulo($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[NO_MODULO], 2, 'Nome do Modulo'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
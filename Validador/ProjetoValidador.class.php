<?php

/**
 * ProjetoValidador [ VALIDATOR ]
 * @copyright (c) 2018, Leo Bessa
 */
class  ProjetoValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarProduto($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[NO_PROJETO], 2, 'Nome do Projeto'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
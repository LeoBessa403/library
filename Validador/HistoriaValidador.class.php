<?php

/**
 * HistoriaValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  HistoriaValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarHistoria($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[DS_TITULO], 2, 'Título da Historia'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
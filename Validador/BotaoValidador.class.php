<?php

/**
 * BotaoValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  BotaoValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarBotao($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[NO_BOTAO], 3, 'Texto do Botão'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[DS_BOTAO], 5, 'Descrição do Botão'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
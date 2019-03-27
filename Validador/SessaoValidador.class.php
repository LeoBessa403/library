<?php

/**
 * SessaoValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  SessaoValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarSessao($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[NO_SESSAO], 1, 'Nome da Sessao'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
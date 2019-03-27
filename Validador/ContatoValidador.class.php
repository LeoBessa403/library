<?php

/**
 * ContatoValidador [ VALIDATOR ]
 * @copyright (c) 2018, Leo Bessa
 */
class  ContatoValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarContato($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoValido(
            $dados[NU_TEL1], AbstractValidador::VALIDACAO_TEL, 'Telefone Responsável'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoValido(
            $dados[NU_TEL2], AbstractValidador::VALIDACAO_TEL, 'Telefone do Estabelecimento'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoValido(
            $dados[DS_EMAIL], AbstractValidador::VALIDACAO_EMAIL, 'E-mail'
        );
        return $this->MontaRetorno($this->retorno);
    }

}
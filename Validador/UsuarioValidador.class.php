<?php

/**
 * AcessoService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  UsuarioValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarUsuario($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NO_PESSOA], AbstractValidador::VALIDACAO_NOME, 'Nome', 10
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_CPF], AbstractValidador::VALIDACAO_CPF, 'CPF'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[DT_NASCIMENTO], AbstractValidador::VALIDACAO_DATA, 'Nascimento'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoSelectObrigatorio(
            $dados[ST_SEXO], 'Sexo'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[DS_EMAIL], AbstractValidador::VALIDACAO_EMAIL, 'E-mail'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NU_TEL1], AbstractValidador::VALIDACAO_TEL, 'Celular'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[DS_ENDERECO], 5, 'Endereço'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[DS_SENHA], AbstractValidador::VALIDACAO_SENHA, 'Senha', 6
        );

        return $this->MontaRetorno($this->retorno);
    }
}
<?php

/**
 * EmpresaValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  EmpresaValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarEmpresa($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[NO_PESSOA], 2, 'Nome Fantasia'
        );
        if(empty($dados[NU_CNPJ])){
            $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
                $dados[NU_CNPJ], AbstractValidador::VALIDACAO_CNPJ, 'CNPJ'
            );
        }
        return $this->MontaRetorno($this->retorno);
    }

}
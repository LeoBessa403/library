<?php

class AbstractValidador
{
    const VALIDACAO_CPF = 1;
    const VALIDACAO_CNPJ = 2;
    const VALIDACAO_EMAIL = 3;
    const VALIDACAO_CEP = 4;
    const VALIDACAO_TEL = 5;
    const VALIDACAO_NOME = 6;
    const VALIDACAO_DATA = 7;

    /**
     * @param $dados
     * @param int $qtdCaracteres
     * @return bool
     */
    public function validaCampoDescricao($dados, $qtdCaracteres = 1)
    {
        $validador = Valida::LimpaVariavel($dados);
        if (strlen($validador) > $qtdCaracteres) {
            return true;
        }
        return false;
    }

    /**
     * @param $dado
     * @param $tipoValidacao
     * @return bool
     */
    public function validaCampoMascara($dado, $tipoValidacao)
    {
        $validador = false;
        switch ($tipoValidacao) {
            case 1:
                $validador = Valida::ValCPF(Valida::RetiraMascara($dado));
                break;
            case 2:
                $validador = Valida::ValCNPJ(Valida::RetiraMascara($dado));
                break;
            case 3:
                $validador = Valida::ValEmail($dado);
                break;
            case 4:
                $validador = Valida::RetiraMascara($dado);
                if (strlen($validador) == 7) {
                    $validador = true;
                } else {
                    $validador = false;
                }
                break;
            case 5:
                $validador = Valida::RetiraMascara($dado);
                if (strlen($validador) >= 10) {
                    $validador = true;
                } else {
                    $validador = false;
                }
                break;
            case 6:
                $validador = preg_replace('/[^0-9]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = true;
                } else {
                    $validador = false;
                }
                break;
            case 7:
                $validador = Valida::DataValida($dado);
                break;
        }
        if ($validador) {
            return true;
        }
        return false;
    }

    /**
     * @param $arquivo
     * @return bool
     */
    public function validaCampoArquivo($arquivo)
    {
        if ($arquivo["tmp_name"]) {
            return true;
        }
        return false;
    }
}
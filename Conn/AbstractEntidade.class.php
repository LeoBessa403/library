<?php

class AbstractEntidade
{
    public function primeiro(array $valor)
    {
        return $valor[0];
    }

    public function ultimo(array $valor)
    {
        return $valor[(count($valor) - 1)];
    }

    public function getDados($dados, $entidade)
    {
        $camposRetiraMascara = [NU_TEL1, NU_TEL2, NU_TEL3, NU_CPF, NU_CEP];
        $resultado = array();
        $campos = $entidade::getCampos();
        foreach ($campos as $campo) {
            $resultado[$campo] = (!empty($dados[$campo])) ? $dados[$campo] : null;
            if ($campo == DT_CADASTRO) {
                $resultado[$campo] = Valida::DataHoraAtualBanco();
            }
            if (strstr($campo, 'co_')) {
                unset($resultado[$campo]);
            }
            if (strstr($campo, 'ds_')) {
                $resultado[$campo] = (!empty($resultado[$campo])) ? trim($resultado[$campo]) : null;
            }
            if (in_array($campo, $camposRetiraMascara)) {
                $resultado[$campo] = trim(Valida::RetiraMascara($resultado[$campo]));
            }
        }
        return $resultado;
    }

}
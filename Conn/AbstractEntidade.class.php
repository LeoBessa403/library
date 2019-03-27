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
        $camposRetiraMascara = [NU_TEL1, NU_TEL2, NU_TEL3, NU_TEL_0800, NU_CPF, NU_CEP, NU_TEL_RESPONSAVEL];
        $resultado = array();
        $campos = $entidade::getCampos();
        foreach ($campos as $campo) {
            $resultado[$campo] = (!empty($dados[$campo])) ? $dados[$campo] : null;
            if (strstr($campo, 'ds_')) {
                $resultado[$campo] = (!empty($resultado[$campo])) ? trim($resultado[$campo]) : null;
            }
            if (in_array($campo, $camposRetiraMascara)) {
                $resultado[$campo] = trim(Valida::RetiraMascara($resultado[$campo]));
            }
            if (is_array($resultado[$campo])) {
                $resultado[$campo] = implode(', ',$resultado[$campo]);
            }
            if ($campo == DT_CADASTRO) {
                $resultado[$campo] = Valida::DataHoraAtualBanco();
            }
            if (strstr($campo, 'co_') && (empty($dados[$campo]))) {
                unset($resultado[$campo]);
            }
        }
        return $resultado;
    }

}
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
        $resultado = array();
        $campos = $entidade::getCampos();
        foreach ($campos as $campo) {
            $resultado[$campo] = (!empty($dados[$campo])) ? $dados[$campo] : null;
            if ($campo == DT_CADASTRO) {
                $resultado[$campo] = Valida::DataHoraAtualBanco();
            }

        }
        return $resultado;
    }

}
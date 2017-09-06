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

}
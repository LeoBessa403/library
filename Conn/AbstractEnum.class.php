<?php

class AbstractEnum
{

    private static $descricao = [];

    public static function getDescricaoValor($value)
    {
        //Replace para tirar a quebra de linha, caso a descricao seja grande demais.
        return str_replace("\n", "", static::$descricao[$value]);
    }

    public function getDescricao($value = null)
    {
        if (!empty($value)) {
            return static::$descricao[$value];
        }
        return static::$descricao;
    }

    public static function getValorDescricao($descricao = null)
    {
        if (!empty($descricao)) {
            foreach (static::$descricao as $chave => $desc){
                if($descricao == $desc)
                return $chave;
            }
        }
        return static::$descricao;
    }

}
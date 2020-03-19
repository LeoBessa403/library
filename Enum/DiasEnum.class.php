<?php

/**
 * Class FuncionamentoEnum
 */
class DiasEnum extends AbstractEnum
{
    const SEGUNDA = 1;
    const TERCA = 2;
    const QUARTA = 3;
    const QUINTA = 4;
    const SEXTA = 5;
    const SABADO = 6;
    const DOMINGO = 7;
    const FERIADO = 8;

    public static $descricao = [
        DiasEnum::SEGUNDA => 'Segunda',
        DiasEnum::TERCA => 'Terça',
        DiasEnum::QUARTA => 'Quarta',
        DiasEnum::QUINTA => 'Quinta',
        DiasEnum::SEXTA => 'Sexta',
        DiasEnum::SABADO => 'Sábado',
        DiasEnum::DOMINGO => 'Domingo',
        DiasEnum::FERIADO => 'Feriado',
    ];

    public static $montaCombo = [
        "" => Mensagens::MSG_SEM_ITEM_SELECIONADO,
        DiasEnum::SEGUNDA => 'Segunda',
        DiasEnum::TERCA => 'Terça',
        DiasEnum::QUARTA => 'Quarta',
        DiasEnum::QUINTA => 'Quinta',
        DiasEnum::SEXTA => 'Sexta',
        DiasEnum::SABADO => 'Sábado',
        DiasEnum::DOMINGO => 'Domingo',
        DiasEnum::FERIADO => 'Feriado',
    ];

    public static $montaComboMes = [
        "" => Mensagens::MSG_SEM_ITEM_SELECIONADO,
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];
}

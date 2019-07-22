<?php

/**
 * CronValidador [ VALIDATOR ]
 * @copyright (c) 2017, Leo Bessa
 */
class  CronValidador extends AbstractValidador
{
    private $retorno = [
        SUCESSO => true,
        MSG => [],
        DADOS => []
    ];

    public function validarCron($dados)
    {
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioValido(
            $dados[NO_CRON], AbstractValidador::VALIDACAO_NOME, 'Nome da Cron'
        );
        $this->retorno[DADOS][] = $this->ValidaCampoObrigatorioDescricao(
            $dados[DS_SQL], 5, 'Sql'
        );
        return $this->MontaRetorno($this->retorno);
    }
}
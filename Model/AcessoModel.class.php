<?php

/**
 * AcessoModel.class [ MODEL ]
 * @copyright (c) 2017, Leo Bessa
 */
class  AcessoModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(AcessoEntidade::ENTIDADE);
    }

    public function finalizaAcessos()
    {
        $pesquisa = new Pesquisa();
        $where = "where tp_situacao = '" . StatusAcessoEnum::ATIVO . "' and dt_fim_acesso < '" . Valida::DataHoraAtualBanco() . "'";
        $pesquisa->Pesquisar(AcessoEntidade::TABELA, $where);
        /** @var AcessoEntidade $acesso */
        foreach ($pesquisa->getResult() as $acesso) {
            $terminaAcesso[TP_SITUACAO] = StatusAcessoEnum::FINALIZADO;
            $this->Salva($terminaAcesso, $acesso['co_acesso']);
        }
    }

    public function PesquisaAvancada($Condicoes)
    {
        $tabela = PessoaEntidade::TABELA . " pes" .
            " inner join " . UsuarioEntidade::TABELA . " usu" .
            " on pes." . PessoaEntidade::CHAVE . " = usu." . PessoaEntidade::CHAVE .
            " inner join " . AcessoEntidade::TABELA . " ace" .
            " on ace." . UsuarioEntidade::CHAVE . " = usu." . UsuarioEntidade::CHAVE;

        $campos = "DISTINCT ace.*";
        $pesquisa = new Pesquisa();
        $where = 'where 1 = 1';
        if (!empty($Condicoes[CO_USUARIO])) {
            $where = $where . " and usu." . CO_USUARIO . " in (" . implode(', ', $Condicoes[CO_USUARIO]) . ")";
        }
        if (!empty($Condicoes[NU_CPF])) {
            $where = $where . " and pes." . NU_CPF . " = '" . $Condicoes[NU_CPF] . "'";
        }
        if (!empty($Condicoes[DT_INICIO_ACESSO])) {
            $where = $where . " and ace." . DT_INICIO_ACESSO . " >= '" .
                Valida::DataDBDate($Condicoes[DT_INICIO_ACESSO]) . " 00:00:00'";
        }
        if (!empty($Condicoes[DT_FIM_ACESSO])) {
            $where = $where . " and ace." . DT_FIM_ACESSO . " <= '" .
                Valida::DataDBDate($Condicoes[DT_FIM_ACESSO]) . " 23:59:59'";
        }
        $where = $where . ' ORDER BY ' . AcessoEntidade::CHAVE . ' DESC';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        $acessos = [];
        /** @var AcessoEntidade $acesso */
        foreach ($pesquisa->getResult() as $acesso) {
            $ace[0] = $acesso;
            $acessos[] = $this->getUmObjeto(AcessoEntidade::ENTIDADE, $ace);
        }
        return $acessos;
    }

    /**
     * @param $data
     * @return bool
     */
    public function limpaDadosAcessos($data)
    {
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $retorno[SUCESSO] = false;
        /** @var TrafegoService $trafegoService */
        $trafegoService = new TrafegoService();

        $pesquisa = new Pesquisa();
        $where = "where " . TP_SITUACAO . " = '" . StatusAcessoEnum::FINALIZADO .
            "' and " . DT_FIM_ACESSO . " <= '" . Valida::DataDBDate($data) . " 23:59:59'";
        $pesquisa->Pesquisar(AcessoEntidade::TABELA, $where);
        $PDO->beginTransaction();
        foreach ($pesquisa->getResult() as $acesso) {
            $trafegoService->Deleta($acesso['co_trafego']);
            $retorno[SUCESSO] = $this->Deleta($acesso['co_acesso']);
        }
        if ($retorno[SUCESSO]) {
            $retorno[SUCESSO] = true;
            $PDO->commit();
        } else {
            $PDO->rollBack();
        }
        return $retorno[SUCESSO];
    }


}
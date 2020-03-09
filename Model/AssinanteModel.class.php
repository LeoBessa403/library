<?php

/**
 * AssinanteModel.class [ MODEL ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AssinanteModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(AssinanteEntidade::ENTIDADE);
    }

    public function PesquisaAvancadaAssinatura($Condicoes)
    {
        $tabela = AssinanteEntidade::TABELA . " ass" .
            " inner join " . PlanoAssinanteAssinaturaEntidade::TABELA . " tpaa" .
            " on ass." . AssinanteEntidade::CHAVE . " = tpaa." . AssinanteEntidade::CHAVE;

        $campos = "max(tpaa." . NU_VALOR_ASSINATURA . ") as max_valor, min(tpaa." . NU_VALOR_ASSINATURA . ") as min_valor";
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($Condicoes);
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult()[0];
    }
}
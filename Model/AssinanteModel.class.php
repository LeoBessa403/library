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
        $tabela = $this->getJoinPesquisa();

        $campos = "max(tpaa." . NU_VALOR_ASSINATURA . ") as max_valor, min(tpaa." . NU_VALOR_ASSINATURA . ") as min_valor";
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($Condicoes);
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult()[0];
    }

    public function PesquisaAvancada($Condicoes)
    {
        $tabela = $this->getJoinPesquisa();
        $campos = "ass.*";
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($Condicoes);
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        $assinantes = [];
        /** @var AssinanteEntidade $assinante */
        foreach ($pesquisa->getResult() as $assinante) {
            $ass[0] = $assinante;
            $assinantes[] = $this->getUmObjeto(AssinanteEntidade::ENTIDADE, $ass);
        }
        return $assinantes;
    }

    private function getJoinPesquisa()
    {
        $tabela = AssinanteEntidade::TABELA . " ass" .
            " inner join " . PlanoAssinanteAssinaturaEntidade::TABELA . " tpaa" .
            " on ass." . AssinanteEntidade::CHAVE . " = tpaa." . AssinanteEntidade::CHAVE .
            " inner join " . EmpresaEntidade::TABELA . " te" .
            " on ass." . EmpresaEntidade::CHAVE . " = te." . EmpresaEntidade::CHAVE .
            " left join " . ContatoEntidade::TABELA . " tc" .
            " on tc." . ContatoEntidade::CHAVE . " = te." . ContatoEntidade::CHAVE .
            " left join " . PessoaEntidade::TABELA . " tp" .
            " on ass." . PessoaEntidade::CHAVE . " = tp." . PessoaEntidade::CHAVE .
            " left join " . EnderecoEntidade::TABELA . " tend" .
            " on te." . EnderecoEntidade::CHAVE . " = tend." . EnderecoEntidade::CHAVE;

        return $tabela;
    }
}
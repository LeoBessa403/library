<?php

/**
 * HistoricoHistoriaModel.class [ MODEL ]
 * @copyright (c) 2019, Leo Bessa
 */
class  HistoricoHistoriaModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(HistoricoHistoriaEntidade::ENTIDADE);
    }

    public function PesquisaAvancada($Condicoes)
    {
        $tabela = HistoricoHistoriaEntidade::TABELA." hh" .
            " inner join ".HistoriaEntidade::TABELA." hi" .
            " on hh.".HistoriaEntidade::CHAVE." = hi.".HistoriaEntidade::CHAVE .
            " inner join ".SessaoEntidade::TABELA." ss" .
            " on ss.".SessaoEntidade::CHAVE." = hi.".SessaoEntidade::CHAVE .
            " inner join ".ModuloEntidade::TABELA." md" .
            " on md.".ModuloEntidade::CHAVE." = ss.".ModuloEntidade::CHAVE;

        $campos = "hh.*";
        $pesquisa = new Pesquisa();
        $where = 'where 1 = 1';
        if(!empty($Condicoes[CO_MODULO])){
            $where = $where . " and md.".CO_MODULO." = ".$Condicoes[CO_MODULO] ;
        }
        if(!empty($Condicoes[CO_SESSAO])){
            $where = $where . " and ss.".CO_SESSAO." = ".$Condicoes[CO_SESSAO]  ;
        }
        $where = $where . ' ORDER BY hh.'.DT_CADASTRO. ' ASC';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

}
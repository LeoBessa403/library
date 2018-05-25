<?php

/**
 * VisitaModel.class [ MODEL ]
 * @copyright (c) 2017, Leo Bessa
 */
class  VisitaModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(VisitaEntidade::ENTIDADE);
    }

    public function visitasDispositivo()
    {
        $tabela = VisitaEntidade::TABELA . " vs" .
            " inner join " . TrafegoEntidade::TABELA . " tr" .
            " on vs." . TrafegoEntidade::CHAVE . " = tr." . TrafegoEntidade::CHAVE;

        $campos = " ds_dispositivo, COUNT(ds_dispositivo) AS qt_dispositivo";
        $pesquisa = new Pesquisa();
        $where = " GROUP BY ds_dispositivo";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function visitasSO()
    {
        $tabela = VisitaEntidade::TABELA . " vs" .
            " inner join " . TrafegoEntidade::TABELA . " tr" .
            " on vs." . TrafegoEntidade::CHAVE . " = tr." . TrafegoEntidade::CHAVE;

        $campos = " ds_sistema_operacional, SUM(nu_visitas) AS qt_visitas";
        $pesquisa = new Pesquisa();
        $where = " GROUP BY ds_sistema_operacional";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function visitasNavegador()
    {
        $tabela = VisitaEntidade::TABELA . " vs" .
            " inner join " . TrafegoEntidade::TABELA . " tr" .
            " on vs." . TrafegoEntidade::CHAVE . " = tr." . TrafegoEntidade::CHAVE;

        $campos = " ds_navegador, SUM(nu_visitas) AS qt_visitas";
        $pesquisa = new Pesquisa();
        $where = " GROUP BY ds_navegador";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function visitasCidade()
    {
        $tabela = VisitaEntidade::TABELA . " vs" .
            " inner join " . TrafegoEntidade::TABELA . " tr" .
            " on vs." . TrafegoEntidade::CHAVE . " = tr." . TrafegoEntidade::CHAVE;

        $campos = " ds_cidade, SUM(nu_visitas) AS qt_visitas";
        $pesquisa = new Pesquisa();
        $where = " GROUP BY ds_cidade";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

}
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
        $where = "WHERE " . DS_CODE_PAIS . " = 'BR' GROUP BY ds_dispositivo";
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
        $where = "WHERE " . DS_CODE_PAIS . " = 'BR' GROUP BY ds_sistema_operacional";
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
        $where = "WHERE " . DS_CODE_PAIS . " = 'BR' GROUP BY ds_navegador";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function visitasEstado()
    {
        $tabela = VisitaEntidade::TABELA . " vs" .
            " inner join " . TrafegoEntidade::TABELA . " tr" .
            " on vs." . TrafegoEntidade::CHAVE . " = tr." . TrafegoEntidade::CHAVE;

        $campos = " ds_estado, SUM(nu_visitas) AS qt_visitas";
        $pesquisa = new Pesquisa();
        $where = "WHERE " . DS_CODE_PAIS . " = 'BR' GROUP BY ds_estado";
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
        $where = "WHERE " . DS_CODE_PAIS . " = 'BR' GROUP BY ds_cidade";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function visitasPagina()
    {
        $campos = DS_TITULO_URL_AMIGAVEL . ", " . NU_VISUALIZACAO . ", " . NU_USUARIO;
        $pesquisa = new Pesquisa();
        $where = "WHERE " . DS_TITULO_URL_AMIGAVEL . "  NOT LIKE '%img%' AND " .
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%images%' AND " .
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%.%' ORDER BY " . NU_VISUALIZACAO . " DESC";
        $pesquisa->Pesquisar(PaginaEntidade::TABELA, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function totalVisitas()
    {
        $campos = "count(co_visita) as usuarios, sum(nu_visitas) as qt_visitas";
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar(VisitaEntidade::TABELA, null, null, $campos);
        return $pesquisa->getResult()[0];
    }

    public function totalVisitasMesAtual()
    {
        $proximoMes  = date("Y-m",strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . " +1 month"));
        $campos = "count(co_visita) as usuarios, sum(nu_visitas) as qt_visitas";
        $pesquisa = new Pesquisa();
        $where = 'WHERE dt_atualizado BETWEEN "' . date('Y-m') .
            '-01 00:00:00" AND "' . $proximoMes . '-01 00:00:00"';
        $pesquisa->Pesquisar(VisitaEntidade::TABELA, $where, null, $campos);
        return $pesquisa->getResult()[0];
    }

}
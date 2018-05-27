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
        $where = "WHERE ".DS_CODE_PAIS." = 'BR' GROUP BY ds_dispositivo";
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
        $where = "WHERE ".DS_CODE_PAIS." = 'BR' GROUP BY ds_sistema_operacional";
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
        $where = "WHERE ".DS_CODE_PAIS." = 'BR' GROUP BY ds_navegador";
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
        $where = "WHERE ".DS_CODE_PAIS." = 'BR' GROUP BY ds_estado";
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
        $where = "WHERE ".DS_CODE_PAIS." = 'BR' GROUP BY ds_cidade";
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        return $pesquisa->getResult();
    }

    public function visitasPagina()
    {
        $campos = DS_TITULO_URL_AMIGAVEL .", ". NU_VISUALIZACAO .", ". NU_USUARIO;
        $pesquisa = new Pesquisa();
        $where = "WHERE ".DS_TITULO_URL_AMIGAVEL."  NOT LIKE '%img%' AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%images%' AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%.php%' AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%.html%' AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%NaoEncontrado%' AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%.js%'  AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%.json%'  AND ".
            DS_TITULO_URL_AMIGAVEL . " NOT LIKE '%.ico%' ORDER BY ". NU_VISUALIZACAO ." DESC";
        $pesquisa->Pesquisar(PaginaEntidade::TABELA, $where, null, $campos);
        return $pesquisa->getResult();
    }

}
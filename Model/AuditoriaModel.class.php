<?php

/**
 * AuditoriaModel.class [ MODEL ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AuditoriaModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(AuditoriaEntidade::ENTIDADE);
    }


    public function PesquisaAvancada($Condicoes)
    {
        $tabela = AuditoriaEntidade::TABELA." aud" .
            " inner join ".AuditoriaTabelaEntidade::TABELA." audTab" .
            " on audTab.".AuditoriaEntidade::CHAVE." = aud.".AuditoriaEntidade::CHAVE .
            " left join ".UsuarioEntidade::TABELA." usu" .
            " on aud.".UsuarioEntidade::CHAVE." = usu.".UsuarioEntidade::CHAVE;

        $campos = "DISTINCT aud.*";
        $pesquisa = new Pesquisa();
        $where = 'where 1 = 1';
        if(!empty($Condicoes[CO_USUARIO][0])){
            $where = $where . " and usu.".CO_USUARIO." = ".$Condicoes[CO_USUARIO][0] ;
        }
        if(!empty($Condicoes[NO_TABELA])){
            $where = $where . " and audTab.".NO_TABELA." in ('".implode("', '",$Condicoes[NO_TABELA])."')" ;
        }
        if(!empty($Condicoes[CO_REGISTRO])){
            $where = $where . " and audTab.".CO_REGISTRO." = ".$Condicoes[CO_REGISTRO];
        }
        if(!empty($Condicoes['dt1'])){
            $where = $where . " and aud.".DT_REALIZADO." >= '".
                Valida::DataDBDate($Condicoes['dt1'])." 00:00:00'" ;
        }
        if(!empty($Condicoes['dt2'])){
            $where = $where . " and aud.".DT_REALIZADO." <= '".
                Valida::DataDBDate($Condicoes['dt2'])." 23:59:59'" ;
        }
        $where = $where . ' ORDER BY '.AuditoriaEntidade::CHAVE. ' DESC';
        $pesquisa->Pesquisar($tabela, $where, null, $campos);
        $auditorias = [];
        /** @var AuditoriaEntidade $auditoria */
        foreach ($pesquisa->getResult() as $auditoria){
            $aud[0] = $auditoria;
            $auditorias[] = $this->getUmObjeto(AuditoriaEntidade::ENTIDADE, $aud);
        }
        return $auditorias;
    }

}
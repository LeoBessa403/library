<?php

/**
 * PerfilFuncionalidadeModel.class [ MODEL ]
 * @copyright (c) 2017, Leo Bessa
 */
class  PerfilFuncionalidadeModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(PerfilFuncionalidadeEntidade::ENTIDADE);
    }

    public function PesquisaPerfis($perfis)
    {
        $campos = FuncionalidadeEntidade::CHAVE;
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($perfis);
        $pesquisa->Pesquisar( PerfilFuncionalidadeEntidade::TABELA, $where, null, $campos);
        return $pesquisa->getResult();
    }


}
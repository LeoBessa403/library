<?php

class AbstractModel
{
    private $Tabela;
    private $Entidade;

    public function __construct($Tabela, $Entidade)
    {
        $this->Tabela = $Tabela;
        $this->Entidade = $Entidade;
    }

    public function PesquisaTodos()
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($this->Tabela);
        $obj = new $this->Entidade($pesquisa->getResult());
        return $obj;
    }

    public function PesquisaUmRegistro($id)
    {
//        $pesquisa = new Pesquisa();
//        $pesquisa->Pesquisar($tabela, "where " . Constantes::AUDITORIA_CHAVE_PRIMARIA . " = :id " . $order, "id={$id}");
//        return $pesquisa->getResult();
    }

}
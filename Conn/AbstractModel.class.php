<?php

class AbstractModel
{
    private $Tabela;
    private $Entidade;
    private $Campos;

    public function __construct($Tabela, $Entidade)
    {
        $this->Tabela = $Tabela;
        $this->Entidade = $Entidade;
        $this->Campos = $Entidade::getCampos();
    }

    public function PesquisaTodos()
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($this->Tabela);
        foreach ($pesquisa->getResult() as $entidade) {
            $obj = new $this->Entidade();
            foreach ($this->Campos as $campo) {
                $metodo = str_replace('_', ' ', $campo);
                $metodo = 'set' . ucwords($metodo);
                $metodo = str_replace(' ', '', $metodo);
                $obj->$metodo($entidade[$campo]);
            }
            $dados[] = $obj;
        }
        return $dados;
    }

    public function PesquisaUmRegistro($id)
    {
//        $pesquisa = new Pesquisa();
//        $pesquisa->Pesquisar($tabela, "where " . Constantes::AUDITORIA_CHAVE_PRIMARIA . " = :id " . $order, "id={$id}");
//        return $pesquisa->getResult();
    }

}
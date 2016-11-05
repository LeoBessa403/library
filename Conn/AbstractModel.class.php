<?php

class AbstractModel
{
    private $Tabela;
    private $Entidade;
    private $Campos;
    private $Chave;
    private $Relacionamentos;

    public function __construct($Tabela, $Entidade, $Chave)
    {
        $this->Tabela = $Tabela;
        $this->Entidade = $Entidade;
        $this->Chave = $Chave;
        $this->Campos = $Entidade::getCampos();
        $this->Relacionamentos = $Entidade::getRelacionamentos();
    }

    public function PesquisaTodos()
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($this->Tabela);
        $dados = array();
        foreach ($pesquisa->getResult() as $entidade) {
            $obj = new $this->Entidade();
            foreach ($this->Campos as $campo) {
                $metodo = str_replace('_', ' ', $campo);
                $metodo = 'set' . ucwords($metodo);
                $metodo = str_replace(' ', '', $metodo);
                $obj->$metodo($entidade[$campo]);
            }
            $obj = $this->PesquisaTodosNv2($obj);
            $dados[] = $obj;
        }
        debug($dados);
        return $dados;
    }

    private function PesquisaTodosNv2($obj)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($this->Tabela);
        foreach ($this->Relacionamentos as $campo) {
            if ($campo['Tipo'] == 1) {
                $metodoGet = str_replace('_', ' ', $campo['Chave']);
                $metodoGet = 'get' . ucwords($metodoGet);
                $metodoGet = str_replace(' ', '', $metodoGet);
                $dados2 = $this->PesquisaUmRegistro(
                    $obj->$metodoGet(), $campo['Tabela'], $campo['Campos'], $campo['Entidade']
                );
                $metodoSet = str_replace('_', ' ', $campo['Chave']);
                $metodoSet = 'set' . ucwords($metodoSet);
                $metodoSet = str_replace(' ', '', $metodoSet);
                $obj->$metodoSet($dados2);
            } else {

            }
        }
        return $obj;
    }

    private function PesquisaTodosNv3($obj)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($this->Tabela);
        foreach ($this->Relacionamentos as $campo) {
            if ($campo['Tipo'] == 1) {
                $metodoGet = str_replace('_', ' ', $campo['Chave']);
                $metodoGet = 'get' . ucwords($metodoGet);
                $metodoGet = str_replace(' ', '', $metodoGet);
                $dados2 = $this->PesquisaUmRegistro(
                    $obj->$metodoGet(), $campo['Tabela'], $campo['Campos'], $campo['Entidade']
                );
                $metodoSet = str_replace('_', ' ', $campo['Chave']);
                $metodoSet = 'set' . ucwords($metodoSet);
                $metodoSet = str_replace(' ', '', $metodoSet);
                $obj->$metodoSet($dados2);
            } else {

            }
        }
        return $obj;
    }

    public function PesquisaUmRegistro($Chave, $Tabela = null, $Campos = null, $Entidade = null)
    {
        $Tabela = ($Tabela) ? $Tabela : $this->Tabela;
        $Chave = ($Chave) ? $Chave : $this->Chave;
        $Campos = ($Campos) ? $Campos : $this->Campos;
        $Entidade = ($Entidade) ? $Entidade : $this->Entidade;

        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Tabela, "where " . $Chave . " = :id ", "id={$Chave}");
        $registro = $pesquisa->getResult()[0];
        $obj = new $Entidade();
        foreach ($Campos as $campo) {
            $metodo = str_replace('_', ' ', $campo);
            $metodo = 'set' . ucwords($metodo);
            $metodo = str_replace(' ', '', $metodo);
            $obj->$metodo($registro[$campo]);
        }
        return $obj;
    }

}
<?php

class AbstractModel
{
    private $Entidade;

    public function __construct($Entidade)
    {
        $this->Entidade = $Entidade;
    }

    public function PesquisaTodos()
    {
        $Entidade = $this->Entidade;
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA);
        $dados = array();
        foreach ($pesquisa->getResult() as $entidade) {
            $obj = new $Entidade();
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($entidade[$campo]);
            }
            $obj = $this->PesquisaTodosNv2($obj);
            $dados[] = $obj;
        }
        return $dados;
    }

    private function PesquisaTodosNv2($obj)
    {
        $Entidade = $this->Entidade;
        foreach ($Entidade::getRelacionamentos() as $campo) {
            if ($campo['Tipo'] == 1) {
                $obj2 = new $campo['Entidade']();
                $metodoGet = $this->getMetodo($obj2::CHAVE);
                $dados2 = $this->PesquisaUmRegistroNv2($obj->$metodoGet(), $campo['Entidade']);
                $metodoSet = $this->getMetodo($obj2::CHAVE, false);
                $obj->$metodoSet($dados2);
                $this->PesquisaTodosNv3($obj, $obj2);
            } else {
                debug("Passou aqui");
            }
        }
        return $obj;
    }

    private function PesquisaTodosNv3($obj, $obj2)
    {
        $campos = $obj2::getRelacionamentos();
        foreach ($campos as $campo) {
            $obj3 = new $campo['Entidade']();
            if ($campo['Tipo'] == 1) {
                $metodoGet = $this->getMetodo($obj2::CHAVE);
                $metodoGet2 = $this->getMetodo($obj3::CHAVE);
                $dados3 = $this->PesquisaUmRegistroNv3(
                    $obj->$metodoGet()->$metodoGet2(), $obj3::ENTIDADE
                );
                $metodoSet2 = $this->getMetodo($obj3::CHAVE, false);
                $obj->$metodoGet()->$metodoSet2($dados3);
            } else {
                debug("Passou aqui");
            }
        }
        return $obj;
    }

    public function PesquisaUmRegistro($Codigo)
    {
        $Entidade = $this->Entidade;
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $registro = $pesquisa->getResult()[0];
        $obj = new $Entidade();
        foreach ($Entidade::getCampos() as $campo) {
            $metodo = $this->getMetodo($campo, false);
            $obj->$metodo($registro[$campo]);
        }
        return $obj;
    }

    private function PesquisaUmRegistroNv2($Codigo, $Entidade)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $registro = $pesquisa->getResult()[0];
        $obj = new $Entidade();
        foreach ($Entidade::getCampos() as $campo) {
            $metodo = $this->getMetodo($campo, false);
            $obj->$metodo($registro[$campo]);
        }
        return $obj;
    }

    private function PesquisaUmRegistroNv3($Codigo, $Entidade)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $registro = $pesquisa->getResult()[0];
        $obj = new $Entidade();
        foreach ($Entidade::getCampos() as $campo) {
            $metodo = $this->getMetodo($campo, false);
            $obj->$metodo($registro[$campo]);
        }
        return $obj;
    }

    private function getMetodo($campo, $get = true)
    {
        $metodo = str_replace('_', ' ', $campo);
        $metodo = ucwords($metodo);
        $metodo = str_replace(' ', '', $metodo);
        $tipo = ($get) ? 'get' : 'set';
        $metodo = $tipo . $metodo;
        return $metodo;
    }

}
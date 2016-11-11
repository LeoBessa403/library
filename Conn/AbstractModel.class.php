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

    private function PesquisaTodosNv1($Entidade, $ChaveExtrangeira, $codigo)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, 'where ' . $ChaveExtrangeira . ' = ' . $codigo);
        $dados = array();
        foreach ($pesquisa->getResult() as $entidade) {
            $obj = new $Entidade();
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($entidade[$campo]);
            }
            $dados[] = $obj;
        }
        return $dados;
    }

    private function PesquisaTodosNv2($obj)
    {
        $Entidade = $this->Entidade;
        foreach ($Entidade::getRelacionamentos() as $campo) {
            $obj2 = new $campo['Entidade']();
            $metodoGet = $this->getMetodo($obj2::CHAVE);
            $metodoSet = $this->getMetodo($obj2::CHAVE, false);
            if ($campo['Tipo'] == 1) {
                $dados2 = $this->PesquisaUmRegistroNv2($obj->$metodoGet(), $campo['Entidade']);
                $obj->$metodoSet($dados2);
                $this->PesquisaTodosNv3($obj, $obj2);
            } else {
                $novoMetodo = $this->getMetodo($obj::CHAVE);
                $todos = $this->PesquisaTodosNv1($campo['Entidade'], $obj::CHAVE, $obj->$novoMetodo());
                $obj->$metodoSet($todos);
                $this->PesquisaTodosNv3($obj, $obj2);
            }
        }
        return $obj;
    }

    private function PesquisaTodosNv3($obj, $obj2)
    {
        $campos = $obj2::getRelacionamentos();
        foreach ($campos as $campo) {
            $obj3 = new $campo['Entidade']();
            $entidades = array($obj::ENTIDADE, $obj2::ENTIDADE);
            $metodoGet = $this->getMetodo($obj2::CHAVE);
            $metodoGet2 = $this->getMetodo($obj3::CHAVE);
            if (!in_array($obj3::ENTIDADE, $entidades)) {
                if ($campo['Tipo'] == 1) {
                    if(is_array($obj->$metodoGet())){
                        $indece = 0;
                        foreach ($obj->$metodoGet() as $novoRegistro) {
                            $dados4 = $this->PesquisaUmRegistroNv3(
                                $novoRegistro->$metodoGet2(), $obj3::ENTIDADE
                            );
                            $metodoSet2 = $this->getMetodo($obj3::CHAVE, false);
                            $obj->$metodoGet()[$indece]->$metodoSet2($dados4);
                            $indece++;
                        }
                    }else{
                        $dados3 = $this->PesquisaUmRegistroNv3(
                            $obj->$metodoGet()->$metodoGet2(), $obj3::ENTIDADE
                        );
                        $metodoSet2 = $this->getMetodo($obj3::CHAVE, false);
                        $obj->$metodoGet()->$metodoSet2($dados3);
                    }
                } else {
                    if($obj->$metodoGet()){
                        $dados3 = $this->PesquisaUmRegistroNv3(
                            $obj->$metodoGet()->$metodoGet2(), $obj3::ENTIDADE
                        );
                        $metodoSet2 = $this->getMetodo($obj3::CHAVE, false);
                        $obj->$metodoGet()->$metodoSet2($dados3);
                    }
                }

            }
        }
        return $obj;
    }

    public function PesquisaUmRegistro($Codigo)
    {
        $Entidade = $this->Entidade;
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $obj = new $Entidade();
        if($pesquisa->getResult()){
            $registro = $pesquisa->getResult()[0];
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($registro[$campo]);
            }
            $obj = $this->PesquisaTodosNv2($obj);
        }
        return $obj;
    }

    private function PesquisaUmRegistroNv2($Codigo, $Entidade)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $obj = new $Entidade();
        if($pesquisa->getResult()) {
            $registro = $pesquisa->getResult()[0];
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($registro[$campo]);
            }
        }
        return $obj;
    }

    private function PesquisaUmRegistroNv3($Codigo, $Entidade)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $obj = new $Entidade();
        if($pesquisa->getResult()) {
            $registro = $pesquisa->getResult()[0];
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($registro[$campo]);
            }
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
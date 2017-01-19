<?php

class AbstractModel
{
    private $Entidade;

    public function __construct($Entidade)
    {
        $this->Entidade = $Entidade;
    }

    public function Salva(array $dados, $codigo = null)
    {
        $Entidade = $this->Entidade;
        if (!$codigo) {
            $cadastro = new Cadastra();
            $cadastro->Cadastrar($Entidade::TABELA, $dados);
            return $cadastro->getUltimoIdInserido();
        } else {
            $atualiza = new Atualiza();
            $atualiza->Atualizar($Entidade::TABELA, $dados, "where " . $Entidade::CHAVE . " = :codigo", "codigo={$codigo}");
            return $atualiza->getResult();
        }
    }

    public function Deleta($codigo)
    {
        $Entidade = $this->Entidade;
        $deleta = new Deleta();
        $deleta->Deletar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :codigo", "codigo={$codigo}");
        return $deleta->getResult();
    }

    public function DeletaQuando(array $Condicoes)
    {
        $Entidade = $this->Entidade;
        $deleta = new Deleta();
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($Condicoes);
        $deleta->Deletar($Entidade::TABELA, $where);
        return $deleta->getResult();
    }

    public function PesquisaUmRegistro($Codigo)
    {
        $Entidade = $this->Entidade;
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        return $this->getUmObjeto($Entidade, $pesquisa->getResult());
    }

    public function PesquisaUmQuando(array $Condicoes)
    {
        if (count($Condicoes)) {
            $Entidade = $this->Entidade;
            $pesquisa = new Pesquisa();
            $where = $pesquisa->getClausula($Condicoes);
            $pesquisa->Pesquisar($Entidade::TABELA, $where);
            return $this->getUmObjeto($Entidade, $pesquisa->getResult());
        } else {
            return array();
        }
    }

    public function getUmObjeto($Entidade, $dados)
    {
        $obj = new $Entidade();
        if ($dados) {
            $registro = $dados[0];
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($registro[$campo]);
            }
            $obj = $this->PesquisaInclusaoRelacionamento($Entidade, $obj);
            $obj = $this->PesquisaTodosNv2($obj);
            return $obj;
        } else {
            return array();
        }
    }

    public function PesquisaTodos($Condicoes = array())
    {
        $Entidade = $this->Entidade;
        $pesquisa = new Pesquisa();
        $where = $pesquisa->getClausula($Condicoes);
        $pesquisa->Pesquisar($Entidade::TABELA, $where);
        $dados = array();
        foreach ($pesquisa->getResult() as $entidade) {
            $obj = new $Entidade();
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($entidade[$campo]);
            }
            $obj = $this->PesquisaInclusaoRelacionamento($Entidade, $obj);
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
            $obj = $this->PesquisaInclusaoRelacionamento($Entidade, $obj);
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
                if ($obj->$metodoGet()) {
                    $dados2 = $this->PesquisaUmRegistroNv2($obj->$metodoGet(), $campo['Entidade']);
                    $obj->$metodoSet($dados2);
                }
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
            $metodoGet = $this->getMetodo($obj2::CHAVE);
            $metodoGet2 = $this->getMetodo($obj3::CHAVE);
            if ($campo['Tipo'] == 1) {
                if (is_array($obj->$metodoGet())) {
                    $indece = 0;
                    foreach ($obj->$metodoGet() as $novoRegistro) {
                        if ($novoRegistro->$metodoGet2()) {
                            $dados4 = $this->PesquisaUmRegistroNv3(
                                $novoRegistro->$metodoGet2(), $obj3::ENTIDADE
                            );
                            $metodoSet2 = $this->getMetodo($obj3::CHAVE, false);
                            $obj->$metodoGet()[$indece]->$metodoSet2($dados4);
                            $indece++;
                        }
                    }
                } else {
                    if ($obj->$metodoGet()) {
                        if ($obj->$metodoGet()->$metodoGet2()) {
                            $dados3 = $this->PesquisaUmRegistroNv3(
                                $obj->$metodoGet()->$metodoGet2(), $obj3::ENTIDADE
                            );
                            $metodoSet2 = $this->getMetodo($obj3::CHAVE, false);
                            $obj->$metodoGet()->$metodoSet2($dados3);
                        }
                    }
                }
            } else {
                if ($obj->$metodoGet()) {
                    if ($obj->$metodoGet()->$metodoGet2()) {
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

    private function PesquisaUmRegistroNv2($Codigo, $Entidade)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $obj = new $Entidade();
        if ($pesquisa->getResult()) {
            $registro = $pesquisa->getResult()[0];
            if ($registro) {
                foreach ($Entidade::getCampos() as $campo) {
                    $metodo = $this->getMetodo($campo, false);
                    $obj->$metodo($registro[$campo]);
                }
                $obj = $this->PesquisaInclusaoRelacionamento($Entidade, $obj);
            }
        }
        return $obj;
    }

    private function PesquisaUmRegistroNv3($Codigo, $Entidade)
    {
        $pesquisa = new Pesquisa();
        $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$Codigo}");
        $obj = new $Entidade();
        if ($pesquisa->getResult()) {
            $registro = $pesquisa->getResult()[0];
            foreach ($Entidade::getCampos() as $campo) {
                $metodo = $this->getMetodo($campo, false);
                $obj->$metodo($registro[$campo]);
            }
            $obj = $this->PesquisaInclusaoRelacionamento($Entidade, $obj);
        }
        return $obj;
    }

    private function PesquisaInclusaoRelacionamento($Entidade, $obj)
    {
        $metodoGetChave = $this->getMetodo($Entidade::CHAVE);
        $CoRegistro = $obj->$metodoGetChave();
        foreach ($Entidade::getRelacionamentos() as $indice => $result) {
            if (!in_array($indice, $Entidade::getCampos())) {
                $metodo = $this->getMetodo($indice, false);
                $metodoGet = $this->getMetodo($indice);
                $pesquisando[$Entidade::CHAVE] = $CoRegistro;
                $NovaEntidade = $result['Entidade'];
                $pesquisa = new Pesquisa();
                $where = $pesquisa->getClausula($pesquisando);
                $pesquisa->Pesquisar($NovaEntidade::TABELA, $where);
                $obj2 = new $NovaEntidade();
                if ($pesquisa->getResult()) {
                    $registro = $pesquisa->getResult()[0];
                    if ($registro) {
                        foreach ($NovaEntidade::getCampos() as $campo) {
                            $metodo2 = $this->getMetodo($campo, false);
                            $obj2->$metodo2($registro[$campo]);
                        }
                    }
                }
                $obj->$metodo($obj2->$metodoGet());
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
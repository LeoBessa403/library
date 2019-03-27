<?php

/**
 * <b>Read.class:</b>
 * Classe responsável por leituras genéticas no banco de dados!
 *
 * @copyright (c) 2104, Leo Bessa
 */
class Pesquisa extends Conn
{

    private $Select;
    private $Places;
    private $Result;
    private $Tabela;

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;

    /**
     * <b>Pesquisa:</b> Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e uma analize em cadeia (Dados) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
     * @param STRING $Valores = variavel={$valor}&variavel2={$valor2}
     * @param STRING $Campos = variavel={$valor}&variavel2={$valor2}
     */
    public function Pesquisar($Tabela, $Termos = null, $Valores = null, $Campos = null)
    {
        $this->Tabela = $Tabela;
        if (!empty($Valores)):
            parse_str($Valores, $this->Places);
        endif;

        if (!$Campos):
            $Campos = '*';
        endif;

        $this->Select = "SELECT {$Campos} FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna um array com todos os resultados obtidos.
     * Para obter um resultado chame o índice getResult()[0]!
     * @return ARRAY $this = Array ResultSet
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRegistrosEncontrados()
    {
        return $this->Read->rowCount();
    }

    /**
     * <b>Get Claúsula: </b> Retorna a claúsula where para pesquisas!
     * @param ARRAY $dados = (Indice = Coluna da tabela e valor = valor a ser pesquisado)
     * EX: array('no_membro' => $_POST['no_membro'] , 'st_status' => $_POST['st_status'])
     * @return STRING a cla[usula montada
     */
    public function getClausula(array $dados)
    {
        $where = '';
        $pesquisa = array();
        foreach ($dados as $key => $value) {
            if (!empty($dados[$key])):
                if ($value):
                    $operador = explode("#", $key);
                    if (count($operador) > 1):
                        $tipo = explode(".", $operador[1]);
                        if (!empty($tipo[1])):
                            $tipo = strtolower(substr($tipo[1], 0, 2));
                        endif;
                    else:
                        $tipo = explode(".", $operador[0]);
                        $newTipo = (count($tipo) > 1) ? $tipo[1] : $tipo[0];
                        $tipo = strtolower(substr($newTipo, 0, 2));
                    endif;
                    if (!empty($operador[1])) {
                        switch ($operador[0]) {
                            case 'in':
                                if ($tipo == 'st' || $tipo == 'tp') {
                                    $pesquisa[] = $operador[1] . " in ('" . $value . "')";
                                } elseif ($tipo == 'co' || $tipo == 'sg') {
                                    $pesquisa[] = $operador[1] . " in (" . $value . ")";
                                }
                                break;
                            case '=':
                                $pesquisa[] = $operador[1] . " = '" . $value . "'";
                                break;
                            case '<>':
                                $pesquisa[] = $operador[1] . " <> '" . $value . "'";
                                break;
                            case 'like':
                                $pesquisa[] = $operador[1] . " like '%" . $value . "%'";
                                break;
                            case '>=':
                                $pesquisa[] = $operador[1] . " >= '" . $value . "'";
                                break;
                            case '<=':
                                $pesquisa[] = $operador[1] . " <= '" . $value . "'";
                                break;
                            case '>':
                                $pesquisa[] = $operador[1] . " > '" . $value . "'";
                                break;
                            case '<':
                                $pesquisa[] = $operador[1] . " < '" . $value . "'";
                                break;
                            case 'is null':
                                $pesquisa[] = $operador[1] . " is null";
                                break;
                            case 'is not null':
                                $pesquisa[] = $operador[1] . " is not null";
                                break;
                            default:
                                break;
                        }
                    } else {
                        switch ($tipo) {
                            case 'st':
                                $pesquisa[] = $key . " in ('" . $value . "')";
                                break;
                            case 'tp':
                                $pesquisa[] = $key . " in ('" . $value . "')";
                                break;
                            case 'dt':
                                $pesquisa[] = $key . " = '" . $value . "'";
                                break;
                            case 'co':
                                $pesquisa[] = $key . " in (" . $value . ")";
                                break;
                            case 'sg':
                                $pesquisa[] = $key . " in (" . $value . ")";
                                break;
                            case 'no':
                                $pesquisa[] = $key . " like '%" . $value . "%'";
                                break;
                            case 'ds':
                                $pesquisa[] = $key . " like '%" . $value . "%'";
                                break;
                            case 'nu':
                                $pesquisa[] = $key . " like '%" . $value . "%'";
                                break;
                            default:
                                break;
                        }
                    }
                endif;
            endif;
        }
        $i = 0;
        foreach ($pesquisa as $value) {
            if ($i > 0):
                $where .= " and " . $value;
            else:
                $where = "where " . $value;
            endif;
            $i++;
        }
        return $where;
    }

    /**
     * <b>Seta os dados:</b> Dados a serem substituidos na query de pesquisa.
     * @param STRING $Valores = variavel={$valor}&variavel2={$valor2}
     */
    public function setDados($Valores)
    {
        parse_str($Valores, $this->Places);
        $this->Execute();
    }

    /**
     * <b>getSql:</b> Retorna o SQL que esta sendo Executado.
     */
    public function getSql()
    {
        return $this->Select;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect()
    {
        $this->Conn = parent::getConn();
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax()
    {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if ($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int)$Valor;
                endif;
                $this->Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = null;
            Notificacoes::mesagens(
                "Erro ao Ler: {$e->getMessage()}</br>{$this->getSql()}",
                TiposMensagemEnum::ERRO);
        }
    }

}

<?php

/**
 * GerarEntidades.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 *
 * @copyright (c) 2015, Leonardo Bessa
 */
class GerarEntidades
{
    var $tabelas;
    var $constantes;
    var $relacionamentos;

    public function __construct($tabelas = array())
    {
        $this->tabelas = $tabelas;
        $this->constantes = ($tabelas) ? true : false;
        $this->inicializarConexao();
        $this->gerar();
    }


    protected function inicializarConexao()
    {
        $conn = mysql_connect(HOST, USER, PASS);
        mysql_select_db(DBSA, $conn);
        if (!mysql_set_charset('utf8', $conn)) {
            mysql_query('SET NAMES "utf8"');
        }
    }

    /**
     * @return bool
     */
    public function gerar()
    {
        try {
            $constantes = array();
            if (!$this->tabelas) {
                $result = mysql_query('SHOW TABLES');
                $this->tabelas = [];
                if ($result) {
                    while ($row = mysql_fetch_row($result)) {
                        $this->tabelas[] = $row[0];
                    }
                }
            }
            /**
             * Iterate tables
             */
            foreach ($this->tabelas as $table) {
                $row2 = mysql_query('SHOW COLUMNS FROM ' . $table);
                $referencias = array();
                $referencia = mysql_query("SELECT i.TABLE_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME 
                    FROM information_schema.TABLE_CONSTRAINTS i 
                    LEFT JOIN information_schema.KEY_COLUMN_USAGE k 
                    ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME 
                    WHERE i.CONSTRAINT_TYPE = 'FOREIGN KEY' 
                    AND i.TABLE_SCHEMA = '" . DBSA . "'");
                while ($res = mysql_fetch_row($referencia)) {
                    $referencias[$res[1]][] = $res[0];
                }
                $colunas = array();
                $chave_primaria = '';
                $relacionamentosTabela = array();
                if (mysql_num_rows($row2) > 0) {
                    while ($row = mysql_fetch_assoc($row2)) {
                        $colunas[] = $row['Field'];
                        $constantes[strtoupper($row['Field'])] = $row['Field'];
                        if ($row['Extra'] != '')
                            $chave_primaria = $row['Field'];
                        if ($row['Extra'] == '' && $row['Key'] != '')
                            $relacionamentosTabela[] = $row['Field'];

                    }
                }
                $Entidade = $this->getEntidade($table);
                $this->geraEntidade($Entidade, $table, $chave_primaria, $colunas, $referencias, $relacionamentosTabela);
                $this->geraClassRelacionamento($this->relacionamentos);

                $ArquivoModel = "<?php\n
/**
 * {$Entidade}Model.class [ MODEL ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class  {$Entidade}Model extends AbstractModel
{\n
    public function __construct()
    {
        parent::__construct({$Entidade}Entidade::ENTIDADE);
    }\n\n
}";
                $this->saveModel($ArquivoModel, $Entidade);
                
                if (!$this->constantes) {

                    $ArquivoConstante = "<?php\n
/**
 * Constantes.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class  Constantes
{\n";
                    foreach ($constantes as $indice => $res) {
                        $ArquivoConstante .= "\tconst " . $indice . " = '" . $res . "';\n";
                    }
                    $ArquivoConstante .= "\n}";
                    $this->saveConstantes($ArquivoConstante, 'w+');
                } else {
                    $ArquivoConstante = '\n\n';
                    foreach ($constantes as $indice => $res) {
                        $ArquivoConstante .= "\tconst " . $indice . " = '" . $res . "';\n";
                    }
                    $this->saveConstantes($ArquivoConstante, 'a+');
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }

    private function getEntidade($Entidade)
    {
        $Entidade = str_replace(array('tb_', 'co_'), '', $Entidade);
        $Entidade = str_replace('_', ' ', $Entidade);
        $Entidade = ucwords($Entidade);
        $Entidade = str_replace(' ', '', $Entidade);
        return $Entidade;
    }

    private function geraEntidade($Entidade, $table, $chave_primaria, $colunas, $referencias, $relacionamentosTabela)
    {
        $ArquivoEntidade = "<?php\n
/**
 * {$Entidade}.Entidade [ ENTIDADE ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class {$Entidade}Entidade extends AbstractEntidade
{
\tconst TABELA = '{$table}';
\tconst ENTIDADE = '{$Entidade}Entidade';
\tconst CHAVE = Constantes::" . strtoupper($chave_primaria) . ";\n\n";

        foreach ($colunas as $coluna) {
            $ArquivoEntidade .= "\tprivate $" . $coluna . ";\n";
        }
        if (!empty($referencias[$table])) {
            foreach ($referencias[$table] as $novaColuna) {
                $ArquivoEntidade .= "\tprivate $" . str_replace('tb_', 'co_', $novaColuna) . ";\n";
            }
        }
        $ArquivoEntidade .= "\n\n";
        $ArquivoEntidade .= "\t/**
     * @return array
     */\n";
        $ArquivoEntidade .= "\tpublic static function getCampos() {
    \treturn [\n";
        foreach ($colunas as $coluna) {
            $ArquivoEntidade .= "\t\t\tConstantes::" . strtoupper($coluna) . ",\n";
        }
        $ArquivoEntidade .= "\t\t];
    }\n\n";
        $ArquivoEntidade .= "\t/**
     * @return \$relacionamentos
     */\n";
        $ArquivoEntidade .= "\tpublic static function getRelacionamentos() {
    \t\$relacionamentos = Relacionamentos::getRelacionamentos();\n\t\treturn \$relacionamentos[static::TABELA];\n\t}\n";
        foreach ($relacionamentosTabela as $rel) {
            $this->relacionamentos[$table][$rel] = [
                $rel,
                $this->getEntidade($rel)
            ];
            $this->relacionamentos[str_replace('co_', 'tb_', $rel)][str_replace('tb_', 'co_', $table)] = [
                $rel,
                $this->getEntidade($table)
            ];
        }
        if (!empty($referencias[$table])) {
            foreach ($referencias[$table] as $rel) {
                $this->relacionamentos[$table][$rel] = [
                    $rel,
                    $this->getEntidade($rel)
                ];
                $this->relacionamentos[str_replace('co_', 'tb_', $rel)][str_replace('tb_', 'co_', $table)] = [
                    $rel,
                    $this->getEntidade($table)
                ];
            }
        }
        $ArquivoEntidade .= "\n\n";
        foreach ($colunas as $coluna) {
            $metodoGet = $this->getMetodo($coluna);
            $ArquivoEntidade .= "\t/**
     * @return \$$coluna
     */\n";
            $ArquivoEntidade .= "\tpublic function {$metodoGet}()
    {
        return \$this->$coluna;
    }\n\n";
            $metodoSet = $this->getMetodo($coluna, false);
            $ArquivoEntidade .= "\t/**
     * @param \$$coluna
     * @return mixed
     */\n";
            $ArquivoEntidade .= "\tpublic function {$metodoSet}(\$$coluna)
    {
        return \$this->$coluna = \$$coluna;
    }\n\n";
        }

        if (!empty($referencias[$table])) {
            foreach ($referencias[$table] as $metodos) {
                $metodos = str_replace('tb_', 'co_', $metodos);
                $metodoGet = $this->getMetodo($metodos);
                $ArquivoEntidade .= "\t/**
     * @return \$$metodos
     */\n";
                $ArquivoEntidade .= "\tpublic function {$metodoGet}()
    {
        return \$this->$metodos;
    }\n\n";
                $metodoSet = $this->getMetodo($metodos, false);
                $ArquivoEntidade .= "\t/**
     * @param mixed \$$metodos
     */\n";
                $ArquivoEntidade .= "\tpublic function {$metodoSet}(\$$metodos)
    {
        return \$this->$metodos = \$$metodos;
    }\n\n";
            }
        }

        $ArquivoEntidade .= "}";
        $this->saveEntidade($ArquivoEntidade, $Entidade);
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

    protected function saveEntidade($ArquivoEntidade, $Entidade)
    {
        if (!$ArquivoEntidade) return false;
        try {
            $handle = fopen(PASTA_ENTIDADES . '/' . $Entidade . 'Entidade.class.php', 'w+');
            fwrite($handle, $ArquivoEntidade);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return true;
    }

    private function geraClassRelacionamento($relacionamentos)
    {
        $ArquivoRelacionamento = "<?php\n
/**
 * Relacionamentos.class [ RELACIONAMENTOS DO BANCO ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class Relacionamentos
{\n\n";
        $ArquivoRelacionamento .= "\tpublic static function getRelacionamentos(){
    \t\treturn array(\n";
        foreach ($relacionamentos as $tabela => $valor) {
            $ArquivoRelacionamento .= "\t\t\t(" . $this->getEntidade($tabela) . "Entidade::TABELA) => Array(\n";
            $i = 0;
            foreach ($valor as $campo => $entidade) {
                $ArquivoRelacionamento .= "\t\t\t\t(Constantes::" . strtoupper($campo) . ") => Array(\n";
                $ArquivoRelacionamento .= "\t\t\t\t\t('Campo') => Constantes::" . strtoupper($entidade[$i]) . ",\n";
                $ArquivoRelacionamento .= "\t\t\t\t\t('Entidade') => '" . $entidade[$i + 1] . "',\n";
                $ArquivoRelacionamento .= "\t\t\t\t\t('Tipo') => '1',\n";
                $ArquivoRelacionamento .= "\t\t\t\t),\n";
            }
            $ArquivoRelacionamento .= "\t\t\t),\n";
        }
        $ArquivoRelacionamento .= "\t\t);\n}\n}";

        $this->saveRelacionamentos($ArquivoRelacionamento);
    }

    protected function saveRelacionamentos($ArquivoRelacionamento)
    {
        if (!$ArquivoRelacionamento) return false;
        try {
            $handle = fopen(PASTA_CLASS . '/Relacionamentos.class.php', 'w+');
            fwrite($handle, $ArquivoRelacionamento);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }

    protected function saveModel($ArquivoModel, $Entidade)
    {
        if (!$ArquivoModel) return false;
        try {
            $handle = fopen(PASTA_MODEL . '/' . $Entidade . 'Model.class.php', 'w+');
            fwrite($handle, $ArquivoModel);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return true;
    }

    protected function saveConstantes($ArquivoConstante, $operacao)
    {
        if (!$ArquivoConstante) return false;
        try {
            $handle = fopen(PASTA_CLASS . 'Constantes.class.php', $operacao);
            fwrite($handle, $ArquivoConstante);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return true;
    }
}

?>

<?php

/**
 * GerarEntidades.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 *
 * @copyright (c) 2015, Leonardo Bessa
 */
class GerarEntidades
{


    public function __construct()
    {
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
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function gerar()
    {
        try {

            $tables = array();
            $constantes = array();
            $result = mysql_query('SHOW TABLES');
            while ($row = mysql_fetch_row($result)) {
                $tables[] = $row[0];
            }

            /**
             * Iterate tables
             */
            foreach ($tables as $table) {
                $ArquivoEntidade = "";
                $row2 = mysql_query('SHOW COLUMNS FROM ' . $table);
                $colunas = array();
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
                $Entidade = str_replace('tb_', '', $table);
                $Entidade = str_replace('_', ' ', $Entidade);
                $Entidade = ucwords($Entidade);
                $Entidade = str_replace(' ', '', $Entidade);
                $ArquivoEntidade = "<?php\n
/**
 * {$Entidade}.Entidade [ ENTIDADE ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class {$Entidade}Entidade
{
\tconst TABELA = '{$table}';
\tconst ENTIDADE = '{$Entidade}Entidade';
\tconst CHAVE = Constantes::" . strtoupper($chave_primaria) . ";\n\n";

                foreach ($colunas as $coluna) {
                    $ArquivoEntidade .= "\tprivate $" . $coluna . ";\n";
                }
                $ArquivoEntidade .= "\n\n";
                $ArquivoEntidade .= "\t/**
     * @return \$campos
     */\n";
                $ArquivoEntidade .= "\tpublic static function getCampos() {
    \t\$campos = [\n";
                foreach ($colunas as $coluna) {
                    $ArquivoEntidade .= "\t\t\tConstantes::" . strtoupper($coluna) . ",\n";
                }
                $ArquivoEntidade .= "\t\t];
    \treturn \$campos;
    }\n\n";
                $ArquivoEntidade .= "\t/**
     * @return \$relacionamentos
     */\n";
                $ArquivoEntidade .= "\tpublic static function getRelacionamentos() {
    \t\$relacionamentos = [\n";
                foreach ($relacionamentosTabela as $rel) {
                    $ArquivoEntidade .= "\t\t\tConstantes::" . strtoupper($rel) . " => array(
                'Entidade' => " . str_replace(' ', '', ucwords(str_replace('_', ' ', str_replace('co_', '', $rel)))) . "Entidade::ENTIDADE,
                'Tipo' => 1,
            ),\n";
                }
                $ArquivoEntidade .= "\t\t];
    \treturn \$relacionamentos;
    }\n";
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
     * @param mixed \$$coluna
     */\n";
                    $ArquivoEntidade .= "\tpublic function {$metodoSet}(\$$coluna)
    {
        return \$this->$coluna = \$$coluna;
    }\n\n";
                }

                $ArquivoEntidade .= "}";
                $this->saveEntidade($ArquivoEntidade, $Entidade);

                $ArquivoModel = "<?php\n
/**
 * {$Entidade}Model.class [ MODEL ]
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */\n
class  {$Entidade}Model extends AbstractModel
{\n
    \tpublic function __construct()
    {
        parent::__construct({$Entidade}Entidade::ENTIDADE);
    }\n\n
}";
                $this->saveModel($ArquivoModel, $Entidade);

            }

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
            $this->saveConstantes($ArquivoConstante);

        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
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

    protected function saveConstantes($ArquivoConstante)
    {
        if (!$ArquivoConstante) return false;
        try {
            $handle = fopen(PASTA_CLASS . 'Constantes.class.php', 'w+');
            fwrite($handle, $ArquivoConstante);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return true;
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

?>
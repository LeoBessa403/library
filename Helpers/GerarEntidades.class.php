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
                if (mysql_num_rows($row2) > 0) {
                    while ($row = mysql_fetch_assoc($row2)){
                        $colunas[] = $row['Field'];
                        if($row['Extra'] != '')
                        $chave_primaria = $row['Field'];
//                        debug($row,1);
                    }
                }
                $Entidade = str_replace('tb_', '', $table);
                $Entidade = str_replace('_', ' ', $Entidade);
                $Entidade = ucwords($Entidade);
                $Entidade = str_replace(' ', '', $Entidade);
                $ArquivoEntidade = "<?php\n
/**
 * {$Entidade}.Entidade [ ENTIDADE ]
 *
 * @copyright (c) ".date('Y').", Leo Bessa
 */\n
class {$Entidade}Entidade
{
\tconst TABELA = '{$table}';
\tconst ENTIDADE = '{$Entidade}Entidade';
\tconst CHAVE = Constantes::".strtoupper($chave_primaria).";\n\n";

foreach ($colunas as $coluna)  {
    $ArquivoEntidade .= "\tprivate $".$coluna.";\n";
}
                $ArquivoEntidade .= "\n\n";
foreach ($colunas as $coluna)  {
    $metodoGet = $this->getMetodo($coluna);
    $ArquivoEntidade .= "\t/**
     * @return \$$coluna
     */\n";
    $ArquivoEntidade .= "\tpublic function {$metodoGet}()
    {
        return \$this->$coluna;
    }\n\n";
    $metodoSet = $this->getMetodo($coluna,false);
    $ArquivoEntidade .= "\t/**
     * @param mixed \$$coluna
     */\n";
    $ArquivoEntidade .= "\tpublic function {$metodoSet}(\$$coluna)
    {
        return \$this->$coluna = \$$coluna;
    }\n\n";
}

                $ArquivoEntidade .= "}";
                $this->saveFile($ArquivoEntidade, $Entidade);
            }

        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }


    protected function saveFile($ArquivoEntidade, $Entidade)
    {
        if (!$ArquivoEntidade) return false;
        try {
            $handle = fopen(PASTA_ENTIDADES .'/'. $Entidade . 'Entidade.class.php', 'w+');
            fwrite($handle, $ArquivoEntidade);
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
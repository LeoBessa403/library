<?php

/**
 * Backup.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 *
 * @copyright (c) 2015, Leonardo Bessa
 */
class Backup
{
    var $charset = '';
    var $conn;

    /**
     * Constructor initializes database
     */
    function Backup()
    {
        $backup = fopen('BancoDados/Backup.txt', "a+");
        $backupDate = fgets($backup);
        $dias = Valida::CalculaDiferencaDiasData(date("d/m/Y"), Valida::DataShow($backupDate));

        if ($dias < 1 && PROD):
            $novaData = Valida::CalculaData(date("d/m/Y"), BACKUP, "+");
            $backupCheck = fopen('BancoDados/Backup.txt', "w");
            fwrite($backupCheck, Valida::DataDBDate($novaData));
            fclose($backupCheck);
            $this->charset = 'utf8';
            $conn = new ObjetoPDO();
            $this->conn = $conn->inicializarConexao();
            $this->RealizarBackup();
        endif;
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     * @return bool
     */
    public function RealizarBackup($tables = '*')
    {
        try {
            /**
             * Tables to export
             */
            if ($tables == '*') {
                $tables = array();
                $result = mysqli_query($this->conn, 'SHOW TABLES');
                while ($row = mysqli_fetch_row($result)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', $tables);
            }

            $sql = '-- AMBIENTE: ' . HOME . ' / BANCO: ' . DBSA . ";\n\n";
            $sql = 'CREATE DATABASE IF NOT EXISTS ' . DBSA . ";\n\n";
            $sql .= 'USE ' . DBSA . ";\n\n";

            /**
             * Iterate tables
             */
            foreach ($tables as $table) {

                $result = mysqli_query($this->conn, 'SELECT * FROM ' . $table);
                $numFields = mysqli_num_fields($result);

                $sql .= 'DROP TABLE IF EXISTS ' . $table . ';';
                $row2 = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE ' . $table));
                $sql .= "\n\n\n" . $row2[1] . ";\n\n\n";

                for ($i = 0; $i < $numFields; $i++) {
                    while ($row = mysqli_fetch_row($result)) {
                        $sql .= 'INSERT INTO ' . $table . ' VALUES(';
                        for ($j = 0; $j < $numFields; $j++) {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n", "\\n", $row[$j]);
                            if (isset($row[$j])) {
                                $sql .= '"' . $row[$j] . '"';
                            } else {
                                $sql .= '""';
                            }

                            if ($j < ($numFields - 1)) {
                                $sql .= ',';
                            }
                        }

                        $sql .= ");\n\n";
                    }
                }

                $sql .= "\n\n\n";

            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return $this->saveFile($sql);
    }

    /**
     * Save SQL to file
     * @param string $sql
     * @return bool
     */
    protected function saveFile(&$sql)
    {
        if (!$sql) return false;
        try {
            $handle = fopen(PASTABACKUP . 'Backup ' . Valida::ValNome(DESC) . ' ' . date("Y-m-d H-i-s", time()) . '.sql', 'w+');
            fwrite($handle, $sql);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }
}
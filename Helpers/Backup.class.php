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
     * Backup constructor.
     * @param $validar
     */
    function __construct($validar = true)
    {
        if($validar){
            $backup = fopen('BancoDados/Backup.txt', "a+");
            $backupDate = fgets($backup);
            $dias = Valida::CalculaDiferencaDiasData(date("d/m/Y"), Valida::DataShow($backupDate));

            if ($dias < 1):
                $this->gerarBackup();
            endif;
        }else{
            $this->gerarBackup();
        }
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

            $sql = "-- Atualizado em: " . Valida::DataAtual() . "\n-- AMBIENTE: " . HOME . "\n-- BANCO: " . DBSA ."\n\n";
            $sql .= 'CREATE DATABASE IF NOT EXISTS ' . DBSA . ";\n\n";
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
            $handle = fopen(PASTABACKUP . 'Backup-' . Valida::ValNome(DESC) . '.sql', 'w+');
            fwrite($handle,  $sql);
            fclose($handle);
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error ao gerar o arquivo de backup. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }
        return true;
    }

    /**
     * Realiza o controle da versão
     */
    public function controleVersao()
    {
        $linhas = fopen('versao.txt', "a+");
        $versoes = fgets($linhas);
        $versao = explode('//', $versoes);
        $versaoNova = explode('.', $versao[2]);
        $nova = $versaoNova[0] . '.' . $versaoNova[1] . '.' . ($versaoNova[2] + 1);
        $versao[2] = $nova;
        $versaoAtualizada = implode('//',$versao);
        $backupVersao = fopen('versao.txt', "w");
        fwrite($backupVersao, $versaoAtualizada);
        fclose($backupVersao);
    }

    /**
     * Realiza o controle da versão
     */
    private function limpaArquivoAtualizacaoBanco()
    {
        $AtualizaArqBanco = fopen('BancoDados/Atualizacao.sql', "w");
        fwrite($AtualizaArqBanco,  "");
        fclose($AtualizaArqBanco);
    }

    /**
     * Realiza o controle da versão
     */
    private function limpaArquivoBackup()
    {
        $novaData = Valida::CalculaData(date("d/m/Y"), BACKUP, "+");
        $backupCheck = fopen('BancoDados/Backup.txt', "w");
        fwrite($backupCheck, Valida::DataDBDate($novaData));
        fclose($backupCheck);
    }

    /**
     * Realiza o BackUp
     */
    private function gerarBackup()
    {
        $this->limpaArquivoBackup();
        $this->limpaArquivoAtualizacaoBanco();
        $this->charset = 'utf8';
        $this->controleVersao();
        $conn = new ObjetoPDO();
        $this->conn = $conn->inicializarConexao();
        $this->RealizarBackup();
    }
}
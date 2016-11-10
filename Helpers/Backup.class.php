<?php
/**
 * Backup.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 * 
 * @copyright (c) 2015, Leonardo Bessa
 */
class Backup {

    var $charset = '';
    
    
 
    /**
     * Constructor initializes database
     */
    function Backup()
    {
        $xml = simplexml_load_file("Banco de Dados/Controle.Backup.xml");
        $data       = $xml->data;
        $dias = Valida::CalculaDiferencaDiasData(date("d/m/Y"), $data);
        $novaData = Valida::CalculaData($data, BACKUP , "+");
        
        if($dias < 1):
            $this->charset  = 'utf8';
            $this->initializeDatabase();
            $this->RealizarBackup();
            
            // ATUALIZA O XML DE CONTROLE DE BACKUP
            $novo = '<?xml version="1.0" encoding="UTF-8"?>
            <root>
                <data>'.$novaData.'</data>
            </root>';
            file_put_contents('Banco de Dados/Controle.Backup.xml', $novo);
        endif;
        
    }
 
    protected function initializeDatabase()
    {
        $conn = mysql_connect(HOST, USER, PASS);
        mysql_select_db(DBSA, $conn);
        if (! mysql_set_charset ($this->charset, $conn))
        {
            mysql_query('SET NAMES '.$this->charset);
        }
    }
 
    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function RealizarBackup($tables = '*')
    {
        try
        {
            /**
            * Tables to export
            */
            if($tables == '*')
            {
                $tables = array();
                $result = mysql_query('SHOW TABLES');
                while($row = mysql_fetch_row($result))
                {
                    $tables[] = $row[0];
                }
            }
            else
            {
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }
 
            $sql = 'CREATE DATABASE IF NOT EXISTS '.DBSA.";\n\n";
            $sql .= 'USE '.DBSA.";\n\n";
 
            /**
            * Iterate tables
            */
            foreach($tables as $table)
            {

                $result = mysql_query('SELECT * FROM '.$table);
                $numFields = mysql_num_fields($result);
 
                $sql .= 'DROP TABLE IF EXISTS '.$table.';';
                $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
                $sql.= "\n\n".$row2[1].";\n\n";
 
                for ($i = 0; $i < $numFields; $i++)
                {
                    while($row = mysql_fetch_row($result))
                    {
                        $sql .= 'INSERT INTO '.$table.' VALUES(';
                        for($j=0; $j<$numFields; $j++)
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                            if (isset($row[$j]))
                            {
                                $sql .= '"'.$row[$j].'"' ;
                            }
                            else
                            {
                                $sql.= '""';
                            }
 
                            if ($j < ($numFields-1))
                            {
                                $sql .= ',';
                            }
                        }
 
                        $sql.= ");\n";
                    }
                }
 
                $sql.="\n\n\n";
 
            }
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }
 
        return $this->saveFile($sql);
    }
 
    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql)
    {
        if (!$sql) return false;
 
        try
        {
            if($handle = fopen(PASTABACKUP.'Backup '.DESC.' '.date("d-m-Y H-i-s", time()).'.sql','w+')){
                debug('ok');
            }else{
                debug('deu ruim');
            }
            fwrite($handle, $sql);
            fclose($handle);
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }
 
        return true;
    }
}

?>
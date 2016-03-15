<?php

/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genéticos no banco de dados!
 * 
 * @copyright (c) 2104, Leo Bessa
 */
class Cadastra extends Conn {

    private $tabela;
    private $dados;
    private $Result;

    /** @var PDOStatement */
    private $Create;

    /** @var PDO */
    private $Conn;

    /**
     * <b>Inseri:</b> Executa um cadastro simplificado no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array atribuitivo com nome da coluna e valor!
     * 
     * @param STRING $Tabela = Informe o nome da tabela no banco!
     * @param ARRAY $Dados = Informe um array atribuitivo. <br>( Nome Da Coluna => Valor ).<br>
     * Ex.: ("nome" => "leo", "sobrenome" => "bessa").
     */
    public function Cadastrar($tabela, array $dados) {
        $this->tabela = (string) $tabela;
        $this->dados = $dados;

        $this->getSyntax();
        $this->Execute();
        
        // Auditoria
        if(TABELA_AUDITORIA):
            $id_item = $this->Result;
            $auditoria = new Auditoria();
            $auditoria->Auditar($this->tabela, $this->dados, 'I', $id_item);
        endif;
    }

    /**
     * <b>Obtem o resultado:</b> Retorna o ID do registro inserido ou FALSE caso nem um registro seja inserido! 
     * @return INT $Variavel = lastInsertId OR FALSE
     */
    public function getUltimoIdInserido() {
        return $this->Result;
    }
    
    /**
     * <b>getSql:</b> Retorna o SQL que esta sendo Executado.  
     */
    public function getSql() {
       return $this->Create;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($this->Create);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        $Fileds = implode(', ', array_keys($this->dados));
        $Places = ':' . implode(', :', array_keys($this->dados));
        $this->Create = "INSERT INTO {$this->tabela} ({$Fileds}) VALUES ({$Places})";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        $this->Conn->beginTransaction();
        try {
            $this->Create->execute($this->dados);
            $this->Result = $this->Conn->lastInsertId();
            $this->Conn->commit();
        } catch (PDOException $e) {
            $this->Conn->rollBack();
            $this->Result = null;
            Valida::Mensagem("Erro ao Cadastrar: {$e->getMessage()}", 4);
        }
    }

}

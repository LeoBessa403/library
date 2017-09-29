<?php

/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genéticos no banco de dados!
 *
 * @copyright (c) 2104, Leo Bessa
 */
class Cadastra extends Conn
{

    private $tabela;
    private $dados;
    private $Result;
    private $Commit;

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
     * @param Bool $Commit Realizar o Commit
     */
    public function Cadastrar($tabela, array $dados, $Commit)
    {
        $this->tabela = (string)$tabela;
        $this->dados = $dados;
        $this->Commit = $Commit;

        $this->getSyntax();
        $this->Execute();

        // Auditoria
        if (TABELA_AUDITORIA):
            $id_item = $this->Result;
            $auditoria = new Auditar();
            $auditoria->Audita($this->tabela, $this->dados, 'I', $id_item);
        endif;
    }

    private function getSyntax()
    {
        $Fileds = implode(', ', array_keys($this->dados));
        $Places = ':' . implode(', :', array_keys($this->dados));
        $this->Create = "INSERT INTO {$this->tabela} ({$Fileds}) VALUES ({$Places})";
    }

    private function Execute()
    {
        $this->Connect();
        if($this->Commit)
        $this->Conn->beginTransaction();
        try {
            $this->Create->execute($this->dados);
            $this->Result = $this->Conn->lastInsertId();
            if($this->Commit)
            $this->Conn->commit();
        } catch (PDOException $e) {
            if($this->Commit)
            $this->Conn->rollBack();
            $this->Result = null;
            Valida::Mensagem("Erro ao Cadastrar: na TABEA {$this->tabela} {$e->getMessage()}", 4);
        }
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
        $this->Create = $this->Conn->prepare($this->Create);
    }

    //Cria a sintaxe da query para Prepared Statements

    /**
     * <b>Obtem o resultado:</b> Retorna o ID do registro inserido ou FALSE caso nem um registro seja inserido!
     * @return INT $Variavel = lastInsertId OR FALSE
     */
    public function getUltimoIdInserido()
    {
        return $this->Result;
    }

    //Obtém a Conexão e a Syntax, executa a query!

    /**
     * <b>getSql:</b> Retorna o SQL que esta sendo Executado.
     */
    public function getSql()
    {
        return $this->Create;
    }

}

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
    public function Cadastrar($tabela, array $dados)
    {
        $this->tabela = (string)$tabela;
        $this->dados = $dados;

        $this->getSyntax();
        $this->Execute();

        // Auditoria
        if (TABELA_AUDITORIA && $tabela != AcessoEntidade::TABELA):
            $id_item = $this->Result;
            $auditoria = new Auditar();
            $auditoria->Audita($this->tabela, $this->dados, AuditoriaEnum::INSERT, $id_item);
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
        try {
            $this->Create->execute($this->dados);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = null;
            if (DESENVOLVEDOR){
                Valida::Mensagem("Erro ao Cadastrar: na TABELA {$this->tabela} {$e->getMessage()}", 4);
                debug(10);
            }
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
        $this->Conn = ObjetoPDO::$ObjetoPDO;
        if (!$this->Conn) {
            $this->Conn = parent::getConn();
            Auditar::$coAuditoria = null;
        }
        $this->Create = $this->Conn->prepare($this->Create);
    }

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

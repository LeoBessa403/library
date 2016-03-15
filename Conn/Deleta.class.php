<?php

/**
 * <b>Delete.class:</b>
 * Classe responsável por deletar genéricamente no banco de dados!
 * 
 * @copyright (c) 2104, Leo Bessa
 */
class Deleta extends Conn {

    private $Tabela;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Delete;

    /** @var PDO */
    private $Conn;
    
    /**
     * <b>Deleta:</b> Deleta dados do Banco
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE | ORDER
     * @param STRING $Valores = link={$link}&link2={$link2}
     */
    public function Deletar($Tabela, $Termos, $Valores) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;
        
         // Auditoria
        if(TABELA_AUDITORIA):
            $auditoria = new Auditoria();
            $auditoria->Auditar($this->Tabela, null, 'D', null, $Termos, $Valores);
        endif;
        
        parse_str($Valores, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna o resultado da execução da query de exclusão
     * @return BOOL $this = TRUE para deletado e FALSE para erro.
     */
    public function getResult() {
        return $this->Result;
    }
    
     /**
     * <b>Contar Registros: </b> Retorna o número de registros deletados pela QUERY!
     * @return INT $Var = Quantidade de registros que foram deletados.
     */
    public function getRegistrosExcluidos() {
        return $this->Delete->rowCount();
    }

    /**
     * <b>Seta os dados:</b> Dados a serem substituidos na query para deletar.  
     * @param STRING $Valores = variavel={$valor}&variavel2={$valor2}
     */
    public function setDados($Valores) {
        parse_str($Valores, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }
    
    /**
     * <b>getSql:</b> Retorna o SQL que esta sendo Executado.  
     */
    public function getSql() {
       return $this->Delete;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        $this->Conn->beginTransaction();
        try {
            $this->Delete->execute($this->Places);
            $this->Result = true;
            $this->Conn->commit();
        } catch (PDOException $e) {
            $this->Conn->rollBack();
            $this->Result = null;
            Valida::Mensagem("Erro ao Deletar: {$e->getMessage()}", 4);
        }
    }

}

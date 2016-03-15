<?php

/**
 * <b>Update.class:</b>
 * Classe responsável por atualizações genéticas no banco de dados!
 * 
 * @copyright (c) 2104, Leo Bessa
 */
class Atualiza extends Conn {

    private $Tabela;
    private $Dados;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Update;
    private $Ex;

    /** @var PDO */
    private $Conn;

    /**
     * <b>Atualiza:</b> Executa uma atualização simplificada com Prepared Statments. Basta informar o 
     * nome da tabela, os dados a serem atualizados em um Attay Atribuitivo, as condições e uma 
     * analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param ARRAY $Dados = [ NomeDaColuna ] => Valor ( Atribuição )
     * @param STRING $Termos = WHERE coluna = :link AND.. OR..
     * @param STRING $Valores = link={$link}&link2={$link2}
     */
    public function Atualizar($Tabela, array $Dados, $Termos, $Valores) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        $this->Termos = (string) $Termos;
       
        // Auditoria
        if(TABELA_AUDITORIA):
            $auditoria = new Auditoria();
            $auditoria->Auditar($this->Tabela, $this->Dados, 'U', null, $Termos, $Valores);
        endif;
        
        parse_str($Valores, $this->Places);
        $this->getSyntax();
        $this->Execute();

    }

    /**
     * <b>Obter resultado:</b> Retorna TRUE se não ocorrer erros, ou FALSE. Mesmo não alterando os dados se uma query
     * for executada com sucesso o retorno será TRUE. Para verificar alterações execute o getRegistrosAlterados();
     * @return BOOL $Var = True ou False
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros alteradas no banco!
     * @return INT $Var = Quantidade de linhas alteradas
     */
    public function getRegistrosAlterados() {
        return $this->Update->rowCount();
    }

    /**
     * <b>Seta os dados:</b> Dados a serem substituidos na query de pesquisa.  
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
       return $this->Update;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Update = $this->Conn->prepare($this->Update);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        foreach ($this->Dados as $Key => $Value):
            $Places[] = $Key . ' = :' . $Key;
        endforeach;

        $Places = implode(', ', $Places);
        $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        $this->Conn->beginTransaction();
        try {
            $this->Update->execute(array_merge($this->Dados, $this->Places));
            $this->Result = true;
            $this->Conn->commit();
        } catch (PDOException $e) {
            $this->Conn->rollBack();
            $this->Result = null;
            Valida::Mensagem("Erro ao Atualizar: {$e->getMessage()}", 4);
        }
    }

}

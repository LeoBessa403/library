<?php

/**
 * <b>Delete.class:</b>
 * Classe responsável por deletar genéricamente no banco de dados!
 *
 * @copyright (c) 2104, Leo Bessa
 */
class Deleta extends Conn
{

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
     * @param STRING $co_registro = Código do Registro
     */
    public function Deletar($Tabela, $Termos, $Valores = null, $co_registro = null)
    {
        $this->Tabela = (string)$Tabela;
        $this->Termos = (string)$Termos;
        parse_str($Valores, $this->Places);
        $this->getSyntax();

        if ($this->liberaAuditoria($this->Tabela)):
            $auditoria = new Auditar();
            $auditoria->Audita($this->Tabela, null, AuditoriaEnum::DELETE, $co_registro, $Termos, $Valores);
            $this->gravaAtualizacaoBanco($this->Delete, $this->Places);
        endif;

        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna o resultado da execução da query de exclusão
     * @return BOOL $this = TRUE para deletado e FALSE para erro.
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros deletados pela QUERY!
     * @return INT $Var = Quantidade de registros que foram deletados.
     */
    public function getRegistrosExcluidos()
    {
        return $this->Delete->rowCount();
    }

    /**
     * <b>Seta os dados:</b> Dados a serem substituidos na query para deletar.
     * @param STRING $Valores = variavel={$valor}&variavel2={$valor2}
     */
    public function setDados($Valores)
    {
        parse_str($Valores, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * <b>getSql:</b> Retorna o SQL que esta sendo Executado.
     */
    public function getSql()
    {
        return $this->Delete;
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
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax()
    {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        $this->Connect();
        try {
            $this->Delete->execute($this->Places);
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            if (DEBUG){
                echo "Erro ao Deletar na TABELA {$this->Tabela}: {$e->getMessage()}</br>{$this->getSql()}";
                debug(10);
            }
        }
    }

}

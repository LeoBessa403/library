<?php

/**
 * <b>Update.class:</b>
 * Classe responsável por atualizações genéticas no banco de dados!
 *
 * @copyright (c) 2104, Leo Bessa
 */
class Atualiza extends Conn
{

    private $Tabela;
    private $Dados;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Update;

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
     * @param STRING $co_registro = Código do Registro
     */
    public function Atualizar($Tabela, array $Dados, $Termos, $Valores, $co_registro)
    {
        $this->Tabela = (string)$Tabela;
        if(!empty($Dados[DT_CADASTRO])){
            unset($Dados[DT_CADASTRO]);
        }
        $this->Dados = $Dados;
        $this->Termos = (string)$Termos;
        parse_str($Valores, $this->Places);
        $this->getSyntax();

        if ($this->liberaAuditoria($this->Tabela)):
            $auditoria = new Auditar();
            $auditoria->Audita($this->Tabela, $this->Dados, AuditoriaEnum::UPDATE, $co_registro, $Termos, $Valores);
            $this->gravaAtualizacaoBanco($this->Update, $this->Dados, $co_registro);
        endif;

        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna TRUE se não ocorrer erros, ou FALSE. Mesmo não alterando os dados se uma query
     * for executada com sucesso o retorno será TRUE. Para verificar alterações execute o getRegistrosAlterados();
     * @return BOOL $Var = True ou False
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros alteradas no banco!
     * @return INT $Var = Quantidade de linhas alteradas
     */
    public function getRegistrosAlterados()
    {
        return $this->Update->rowCount();
    }

    /**
     * <b>Seta os dados:</b> Dados a serem substituidos na query de pesquisa.
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
        return $this->Update;
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
        $this->Update = $this->Conn->prepare($this->Update);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax()
    {
        foreach ($this->Dados as $Key => $Value):
            $Places[] = $Key . ' = :' . $Key;
        endforeach;

        $Places = implode(', ', $Places);
        $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        $this->Connect();
        try {
            $this->Update->execute(array_merge($this->Dados, $this->Places));
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            if (DEBUG){
                Notificacoes::mesagens(
                    "Erro ao Atualizar na TABELA {$this->Tabela}: {$e->getMessage()}</br>{$this->getSql()}",
                    TiposMensagemEnum::ERRO);
                debug(10);
            }
        }
    }

}

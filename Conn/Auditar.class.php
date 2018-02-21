<?php

/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genéticos no banco de dados!
 *
 * @copyright (c) 2104, Leo Bessa
 */
class Auditar extends Conn
{

    private $tabela;
    private $dados;
    private $Result;
    public static $coAuditoria;

    /** @var PDOStatement */
    private $Create;

    /** @var PDO */
    private $Conn;

    /**
     * @param $tabela
     * @param array|null $dados
     * @param $operacao
     * @param null $id_item
     * @param null $termos
     * @param null $valores
     */
    public function Audita($tabela, array $dados = null, $operacao, $id_item = null, $termos = null, $valores = null)
    {

        if (isset($_SESSION[SESSION_USER])):
            $us = $_SESSION[SESSION_USER];
            $user = $us->getUser();
        else:
            $user = array();
        endif;

        if (!static::$coAuditoria) {
            $this->tabela = TABELA_AUDITORIA;
            if (!empty($user)):
                $dadosAuditoria[DS_PERFIL_USUARIO] = $user[md5('no_perfis')];
                $dadosAuditoria[CO_USUARIO] = $user[md5(CAMPO_ID)];
            endif;
            $dadosAuditoria[DT_REALIZADO] = Valida::DataDB(Valida::DataAtual('d/m/Y H:i:s'));
            $this->dados = $dadosAuditoria;
            $this->getSyntax();
            $this->Execute();
            static::$coAuditoria = $this->Result;
        }

        $dadosAuditoriaTabela[NO_TABELA]       = $tabela;
        $dadosAuditoriaTabela[TP_OPERACAO]     = $operacao;
        $dadosAuditoriaTabela[CO_REGISTRO]     = $id_item;
        $dadosAuditoriaTabela[CO_AUDITORIA]    = static::$coAuditoria;
        $this->tabela = AuditoriaTabelaEntidade::TABELA;
        $this->dados = $dadosAuditoriaTabela;
        $this->getSyntax();
        $this->Execute();

        $dadosAuditoriaItens[CO_AUDITORIA_TABELA] = $this->Result;
        $this->tabela = AuditoriaItensEntidade::TABELA;

        switch($operacao){
           //INSERI DADOS
           case AuditoriaEnum::INSERT:
               foreach ($dados as $key => $value) {
                   $dadosAuditoriaItens[DS_ITEM_ATUAL] = $value;
                   $dadosAuditoriaItens[DS_CAMPO] = $key;
                   $this->dados = $dadosAuditoriaItens;
                   $this->getSyntax();
                   $this->Execute();
               }
           break;
           // ATUALIZA DADOS
           case AuditoriaEnum::UPDATE:
                $Entidade = $this->getEntidade($tabela);
                $pesquisa = new Pesquisa();
                $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ", "id={$id_item}");
                $result = $pesquisa->getResult()[0];
                foreach ($result as $key => $value) {
                    $dadosAuditoriaItens[DS_ITEM_ANTERIOR] = $value;
                    $dadosAuditoriaItens[DS_ITEM_ATUAL] = (!empty($dados[$key])) ? $dados[$key] : null;
                    $dadosAuditoriaItens[DS_CAMPO] = $key;
                    $this->dados = $dadosAuditoriaItens;
                    $this->getSyntax();
                    $this->Execute();
                }
           break;
           // DELETA DADOS
           case AuditoriaEnum::DELETE:
//                $tab   = "information_schema.table_constraints istc
//                            INNER JOIN information_schema.key_column_usage isku ON isku.table_schema = istc.table_schema
//                            AND isku.table_name = istc.table_name
//                            AND isku.constraint_name = istc.constraint_name";
//                $where = "WHERE istc.constraint_type = 'PRIMARY KEY' AND istc.table_schema = '".DBSA."' AND istc.table_name = '".$tabela."'";
//
//                $pesquisa = new Pesquisa();
//                $pesquisa->Pesquisar($tab, $where, null, 'isku.column_name');
//                $result = $pesquisa->getResult();
//                $id = "";
//                $chaves = array();
//                foreach ($result as $res) {
//                    $id .=  $res['column_name'].",";
//                    $chaves[] = $res['column_name'];
//                }
//                $tamanho     = strlen($id);
//                $id  = substr($id,0,$tamanho-1);
//
//                $pesquisa->Pesquisar($tabela, $termos, $valores);
//                $result2 = $pesquisa->getResult();
//                if($result2):
//                    $id_item = "";
//                    foreach ($result2[0] as $key => $value) {
//                        if(in_array($key, $chaves))
//                        $id_item .= $value.",";
//                    }
//                    $tamanho  = strlen($id_item);
//                    $id_item  = substr($id_item,0,$tamanho-1);
//
//                    foreach ($result2[0] as $key => $value) {
//                        $item_anterior .= $key."==".$value.";/";
//                    }
//                    $tamanho        = strlen($item_anterior);
//                    $item_anterior  = substr($item_anterior,0,$tamanho-2);
//                endif;

           break;
           default : echo "Operação Inválida";
           break;
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
        $this->Create = $this->Conn->prepare($this->Create);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax()
    {
        $Fileds = implode(', ', array_keys($this->dados));
        $Places = ':' . implode(', :', array_keys($this->dados));
        $this->Create = "INSERT INTO {$this->tabela} ({$Fileds}) VALUES ({$Places})";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        $this->Connect();
        try {
            $this->Create->execute($this->dados);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = null;
            $this->Result = null;
            if (DESENVOLVEDOR){
                Valida::Mensagem("Erro ao Cadastrar a {$this->tabela}: {$e->getMessage()}", 4);
                debug(10);
            }
        }
    }

    private function getEntidade($Entidade)
    {
        $Entidade = str_replace(array('TB_'), '', $Entidade);
        $Entidade = str_replace('_', ' ', $Entidade);
        $Entidade = ucwords(strtolower($Entidade));
        $Entidade = str_replace(' ', '', $Entidade);
        return $Entidade."Entidade";
    }

}

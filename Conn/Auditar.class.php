<?php

/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genéticos no banco de dados!
 * 
 * @copyright (c) 2104, Leo Bessa
 */
class Auditar extends Conn {

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
    public function Audita($tabela, array $dados = null, $operacao, $id_item = null, $termos = null, $valores = null) {
        $this->tabela = TABELA_AUDITORIA;
        
        if(isset($_SESSION[SESSION_USER])):
            $us = $_SESSION[SESSION_USER];                                                                    
            $user = $us->getUser();
        else:
            $user = array();
        endif;
        $item_atual     = "";
        $item_anterior  = "";
        switch($operacao){
           //INSERI DADOS 
           case 'I':
               foreach ($dados as $key => $value) {
                   $item_atual .= $key."==".$value.";/";
               }
               $tamanho     = strlen($item_atual);        
               $item_atual  = substr($item_atual,0,$tamanho-2);               
           break;
           // ATUALIZA DADOS
           case 'U':
                $tab   = "information_schema.table_constraints istc
                            INNER JOIN information_schema.key_column_usage isku ON isku.table_schema = istc.table_schema
                            AND isku.table_name = istc.table_name
                            AND isku.constraint_name = istc.constraint_name";
                $where = "WHERE istc.constraint_type = 'PRIMARY KEY' AND istc.table_schema = '".DBSA."' AND istc.table_name = '".$tabela."'";

                $pesquisa = new Pesquisa();
                $pesquisa->Pesquisar($tab, $where, null, 'isku.column_name');
                $result = $pesquisa->getResult();
                $id = "";
                $chaves = array();
                foreach ($result as $res) {
                    $id .=  $res['column_name'].",";
                    $chaves[] = $res['column_name'];
                }
                $tamanho     = strlen($id);        
                $id  = substr($id,0,$tamanho-1); 
                
                $pesquisa->Pesquisar($tabela, $termos, $valores);
                $result2 = $pesquisa->getResult();
                $id_item = "";
                foreach ($result2[0] as $key => $value) {
                    if(in_array($key, $chaves))
                    $id_item .= $value.",";
                }
                $tamanho  = strlen($id_item);        
                $id_item  = substr($id_item,0,$tamanho-1);

                foreach ($result2[0] as $key => $value) {
                    $item_anterior .= $key."==".$value.";/";
                }
                $tamanho        = strlen($item_anterior);        
                $item_anterior  = substr($item_anterior,0,$tamanho-2);  
                
                foreach ($dados as $key => $value) {
                   $item_atual .= $key."==".$value.";/";
                }
                $tamanho     = strlen($item_atual);        
                $item_atual  = substr($item_atual,0,$tamanho-2); 
                
           break;
           // DELETA DADOS
           case 'D':
                $tab   = "information_schema.table_constraints istc
                            INNER JOIN information_schema.key_column_usage isku ON isku.table_schema = istc.table_schema
                            AND isku.table_name = istc.table_name
                            AND isku.constraint_name = istc.constraint_name";
                $where = "WHERE istc.constraint_type = 'PRIMARY KEY' AND istc.table_schema = '".DBSA."' AND istc.table_name = '".$tabela."'";

                $pesquisa = new Pesquisa();
                $pesquisa->Pesquisar($tab, $where, null, 'isku.column_name');
                $result = $pesquisa->getResult();
                $id = "";
                $chaves = array();
                foreach ($result as $res) {
                    $id .=  $res['column_name'].",";
                    $chaves[] = $res['column_name'];
                }
                $tamanho     = strlen($id);        
                $id  = substr($id,0,$tamanho-1); 
                
                $pesquisa->Pesquisar($tabela, $termos, $valores);
                $result2 = $pesquisa->getResult();
                if($result2):
                    $id_item = "";
                    foreach ($result2[0] as $key => $value) {
                        if(in_array($key, $chaves))
                        $id_item .= $value.",";
                    }
                    $tamanho  = strlen($id_item);        
                    $id_item  = substr($id_item,0,$tamanho-1);

                    foreach ($result2[0] as $key => $value) {
                        $item_anterior .= $key."==".$value.";/";
                    }
                    $tamanho        = strlen($item_anterior);        
                    $item_anterior  = substr($item_anterior,0,$tamanho-2);                  
                endif;
              
           break;
           default : echo "Operação Inválida";
           break;
        }
        $dados = array();
        $dados['ds_item_atual']             = $item_atual;
        $dados['ds_item_anterior']          = $item_anterior;
        $dados['no_tabela']                 = $tabela;
        $dados['no_operacao']               = $operacao;
        $dados['co_registro']               = $id_item;
        if(!empty($user)):
            $dados['co_usuario']            = $user[md5(CAMPO_ID)];
        endif;
        if(!empty($user)):
            $dados['ds_perfil_usuario']     = $user[md5('no_perfis')];
        endif;
        $dados['dt_realizado']              = Valida::DataDB(Valida::DataAtual('d/m/Y H:i:s'));       
      
        $this->dados = $dados;

        $this->getSyntax();
        $this->Execute();
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
        try {
            $this->Create->execute($this->dados);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = null;
            Valida::Mensagem("Erro ao Cadastrar a Auditoria: {$e->getMessage()}", 4);
        }
    }

}

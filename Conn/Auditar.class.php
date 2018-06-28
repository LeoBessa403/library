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
    private $Audita;

    /** @var PDO */
    private $Conn;

    /**
     * @param $tabela
     * @param array|null $dados
     * @param $operacao
     * @param null $co_registro
     * @param null $termos
     * @param null $valores
     */
    public function Audita($tabela, array $dados = null, $operacao, $co_registro = null, $termos = null, $valores = null)
    {
        if (isset($_SESSION[SESSION_USER]) && (UrlAmigavel::$modulo == ADMIN || $operacao == AuditoriaEnum::DELETE)):
            /** @var Session $us */
            $us = $_SESSION[SESSION_USER];
            $user = $us->getUser();
        else:
            $user = array();
        endif;

        if (!static::$coAuditoria) {
            $this->tabela = TABELA_AUDITORIA;
            if (count($user)):
                $dadosAuditoria[DS_PERFIL_USUARIO] = $user[md5('no_perfis')];
                $dadosAuditoria[CO_USUARIO] = $user[md5(CAMPO_ID)];
            else:
                $dadosAuditoria[DS_PERFIL_USUARIO] = 'Via Site';
            endif;
            $dadosAuditoria[DT_REALIZADO] = Valida::DataHoraAtualBanco();
            $this->dados = $dadosAuditoria;
            $this->getSyntax();
            $this->Execute();
            static::$coAuditoria = $this->Result;
        }

        $dadosAuditoriaTabela[NO_TABELA] = $tabela;
        $dadosAuditoriaTabela[TP_OPERACAO] = $operacao;
        $dadosAuditoriaTabela[CO_REGISTRO] = $co_registro;
        $dadosAuditoriaTabela[CO_AUDITORIA] = static::$coAuditoria;
        $this->tabela = AuditoriaTabelaEntidade::TABELA;
        $this->dados = $dadosAuditoriaTabela;
        $this->getSyntax();
        $this->Execute();

        $dadosAuditoriaItens[CO_AUDITORIA_TABELA] = $this->Result;
        $this->tabela = AuditoriaItensEntidade::TABELA;

        switch ($operacao) {
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
                $result = $this->getResult($tabela, $co_registro, $termos, $valores);
                foreach ($result as $item) {
                    foreach ($item as $key => $value) {
                        $dadosAuditoriaItens[DS_ITEM_ANTERIOR] = $value;
                        $dadosAuditoriaItens[DS_ITEM_ATUAL] = (!empty($dados[$key])) ? $dados[$key] : null;
                        $dadosAuditoriaItens[DS_CAMPO] = $key;
                        $this->dados = $dadosAuditoriaItens;
                        $this->getSyntax();
                        $this->Execute();
                    }
                }
                break;
            // DELETA DADOS
            case AuditoriaEnum::DELETE:
                $result = $this->getResult($tabela, $co_registro, $termos, $valores);
                foreach ($result as $item) {
                    foreach ($item as $key => $value) {
                        $dadosAuditoriaItens[DS_ITEM_ANTERIOR] = $value;
                        $dadosAuditoriaItens[DS_CAMPO] = $key;
                        $this->dados = $dadosAuditoriaItens;
                        $this->getSyntax();
                        $this->Execute();
                    }
                }
                break;
            default :
                echo "Operação Inválida";
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
        if (!$this->Conn) {
            $this->Conn = parent::getConn();
        }
        $this->Audita = $this->Conn->prepare($this->Audita);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax()
    {
        $Fileds = implode(', ', array_keys($this->dados));
        $Places = ':' . implode(', :', array_keys($this->dados));
        $this->Audita = "INSERT INTO {$this->tabela} ({$Fileds}) VALUES ({$Places})";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute()
    {
        $this->Connect();
        try {
            $this->Audita->execute($this->dados);
            $this->Result = $this->Conn->lastInsertId();
        } catch (PDOException $e) {
            $this->Result = null;
            $this->Result = null;
            if (DEBUG) {
                Valida::Mensagem("Erro ao Cadastrar a {$this->tabela}: {$e->getMessage()}", 4);
                debug(10);
            }
        }
    }

    private function getEntidade($Entidade)
    {
        $Entidade = str_replace(array('tb_', 'TB_'), '', $Entidade);
        $Entidade = str_replace('_', ' ', $Entidade);
        $Entidade = ucwords(strtolower($Entidade));
        $Entidade = str_replace(' ', '', $Entidade);
        return $Entidade . "Entidade";
    }

    private function getResult($tabela, $co_registro, $termos, $valores)
    {
        $Entidade = $this->getEntidade($tabela);
        $pesquisa = new Pesquisa();
        if (!$co_registro) {
            $pesquisa->Pesquisar($Entidade::TABELA, $termos, $valores);
            return $pesquisa->getResult();
        } else {
            $pesquisa->Pesquisar($Entidade::TABELA, "where " . $Entidade::CHAVE . " = :id ",
                "id={$co_registro}");
            return $pesquisa->getResult();
        }
    }

}

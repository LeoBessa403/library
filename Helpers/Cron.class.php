<?php

/**
 * Cron.class [ HELPER ]
 * Reponsável por realizar o backup do Banco de Dados!
 *
 * @copyright (c) 2015, Leonardo Bessa
 */
class Cron
{
    var $charset = '';
    var $conn;

    /**
     * Constructor initializes database
     * Backup constructor.
     */
    function __construct()
    {
        $cron = fopen('cron.txt', "a+");
        $cronDate = fgets($cron);
        $dias = Valida::CalculaDiferencaDiasData(date("d/m/Y"), Valida::DataShow($cronDate));

        if ($dias < 1):
            $control = new IndexController();
            if (method_exists($control, 'CronExecute')){
                $control->CronExecute();
            }
            $this->executeCrons();
        endif;
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     */
    public function ExecutarCrons()
    {
        try {
            /** @var CronsService $cronsService */
            $cronsService = new CronsService();
            $crons = $cronsService->PesquisaTodos();

            if (!empty($crons)) {
                /** @var CronsEntidade $cron */
                foreach ($crons as $cron) {
                    $result = mysqli_query($this->conn, $cron->getDsSql());
                    if (!$result) {
                        Notificacoes::geraMensagem(
                            "Error na Cron " . $cron->getNoCron(),
                            TiposMensagemEnum::ERRO
                        );
                    }
                }
            }
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                "Error: " . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
        }
    }

    /**
     * Realiza o controle da versão
     */
    private function limpaArquivoCron()
    {
        $novaData = Valida::CalculaData(date("d/m/Y"), 1, "+");
        $cronCheck = fopen('cron.txt', "w");
        fwrite($cronCheck, Valida::DataDBDate($novaData));
        fclose($cronCheck);
    }

    /**
     * Realiza o BackUp
     */
    private function executeCrons()
    {
        $this->charset = 'utf8';
        $conn = new ObjetoPDO();
        $this->conn = $conn->inicializarConexao();
        $this->ExecutarCrons();
        $this->limpaArquivoCron();
    }
}
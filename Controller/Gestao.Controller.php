<?php

class Gestao extends AbstractController
{
    public $result;
    public $form;
    public $projeto;
    public $dados;
    public $progresso;
    public $noProjeto;

    function GerarEntidadesGestao()
    {
        if (!empty($_POST)) {
            new GerarEntidades($_POST[NO_TABELA]);
            Notificacoes::geraMensagem('Arquivos Gerados com Sucesso.', TiposMensagemEnum::SUCESSO);
            Redireciona(ADMIN . "/" . CONTROLLER_INICIAL_ADMIN . "/" . ACTION_INICIAL_ADMIN);
        }
        $this->form = GestaoForm::Gerar();
    }

    function GerarBackupGestao()
    {
        if (!empty($_POST)) {
            $back = (!empty($_POST[ST_STATUS])) ? SimNaoEnum::SIM : SimNaoEnum::NAO;
            if ($back == SimNaoEnum::SIM) {
                new Backup(false);
                Notificacoes::geraMensagem('BackUp do banco do ' .
                    DESC . ' gerado com Sucesso.', TiposMensagemEnum::SUCESSO);
                Redireciona(ADMIN . "/" . CONTROLLER_INICIAL_ADMIN . "/" . ACTION_INICIAL_ADMIN);
            } else {
                Notificacoes::geraMensagem('É preciso sinalizar com SIM para realizar o BackUp do banco do ' .
                    DESC_SIS . '.', TiposMensagemEnum::ALERTA);
            }
        }
        $this->form = GestaoForm::GerarBackup();
    }

    function ConfigGestao()
    {
        if (!empty($_POST)) {
            unset($_POST['GerarBackup']);
            $dados = $_POST;
            $dados['TEM_SITE'] = (!empty($dados['TEM_SITE'])) ? TRUE : FALSE;
            $dados['MODULO_ASSINANTE'] = (!empty($dados['MODULO_ASSINANTE'])) ? TRUE : FALSE;
            $dados['LOGAR_EMAIL'] = (!empty($dados['LOGAR_EMAIL'])) ? TRUE : FALSE;
            $dados['TABELA_AUDITORIA'] = (!empty($dados['TABELA_AUDITORIA'])) ? TRUE : FALSE;
            $dados['WHATSAPP'] = '55' . Valida::RetiraMascara($dados['WHATSAPP']);
            $retorno = $this->geraConstantes($dados);
            if ($retorno) {
                /** @var Session $session */
                $session = new Session();
                $session->setSession(MENSAGEM, ATUALIZADO);
                Redireciona(ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action);
            } else {
                Notificacoes::geraMensagem(
                    'Error ao salvar o arquivo de configuração padrão.', TiposMensagemEnum::ERRO);
            }
        }
        $res['TEM_SITE'] = (TEM_SITE) ? 'checked' : null;
        $res['MODULO_ASSINANTE'] = (MODULO_ASSINANTE) ? 'checked' : null;
        $res['LOGAR_EMAIL'] = (LOGAR_EMAIL) ? 'checked' : null;
        $res['TABELA_AUDITORIA'] = (TABELA_AUDITORIA) ? 'checked' : null;
        $res['DESC'] = DESC;
        $res['DESC_SIS'] = DESC_SIS;
        $res['DESC_SITE'] = DESC_SITE;
        $res['TITULO_SITE'] = TITULO_SITE;
        $res['CONTROLLER_INICIAL_ADMIN'] = CONTROLLER_INICIAL_ADMIN;
        $res['ACTION_INICIAL_ADMIN'] = ACTION_INICIAL_ADMIN;
        $res['CONTROLLER_INICIAL_SITE'] = CONTROLLER_INICIAL_SITE;
        $res['ACTION_INICIAL_SITE'] = ACTION_INICIAL_SITE;
        $res['TABLE_USER'] = TABLE_USER;
        $res['CAMPO_PASS'] = CAMPO_PASS;
        $res['CAMPO_ID'] = CAMPO_ID;
        $res['CAMPO_PERFIL'] = CAMPO_PERFIL;
        $res['SESSION_USER'] = SESSION_USER;
        $res['INATIVO'] = INATIVO;
        $res['BACKUP'] = BACKUP;
        $res['TAMANHO'] = TAMANHO;
        $res['WHATSAPP'] = str_replace('55', '', WHATSAPP);
        $res['NUM_BG_IMAGENS'] = NUM_BG_IMAGENS;
        $res['CONTROLLER_SEO'] = CONTROLLER_SEO;
        $res['USER_EMAIL'] = USER_EMAIL;
        $res['PASS_EMAIL'] = PASS_EMAIL;
        $res['HOST_EMAIL'] = HOST_EMAIL;
        $res['PORTA_EMAIL'] = PORTA_EMAIL;
        $res['ID_ANALITCS'] = ID_ANALITCS;

        $this->form = GestaoForm::Config($res);
    }

    private function geraConstantes($constantes)
    {
        $ArquivoConstante = "<?php \n
/**
 * Config.Padrao [ HELPER ]
 * Constantes padrão gerados do sistema
 *
 * @copyright (c) " . date('Y') . ", Leo Bessa
 */ \n";
        foreach ($constantes as $indice => $res) {
            $ArquivoConstante .= "define('" . $indice . "', '" . $res . "');\n";
        }
        $ArquivoConstante .= "\n";
        try {
            $handle = fopen(PASTA_RAIZ . 'library/Config.Padrao.php', 'w+');
            fwrite($handle, $ArquivoConstante);
            fclose($handle);
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error ao gerar as constantes do arquivo de configuração padrão. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
            return false;
        }
        return true;
    }

    public function ResetConfigGestao()
    {
        try {
            $handle = fopen(PASTA_RAIZ . 'library/Config.Padrao.php', 'w+');
            fwrite($handle, '');
            fclose($handle);
            /** @var Session $session */
            $session = new Session();
            $session->setSession(MENSAGEM, ATUALIZADO);
            Redireciona(ADMIN . "/" . UrlAmigavel::$controller . "/ConfigGestao");
        } catch (Exception $e) {
            Notificacoes::geraMensagem(
                'Error ao resetar o arquivo de configuração padrão. ' . $e->getMessage(),
                TiposMensagemEnum::ERRO
            );
        }
    }

    public function PreProjetoGestao()
    {
        /** @var HistoriaService $historiaService */
        $historiaService = $this->getService(HISTORIA_SERVICE);
        /** @var HistoricoHistoriaService $historicoHistoriaService */
        $historicoHistoriaService = $this->getService(HISTORICO_HISTORIA_SERVICE);

        $histHistorias = $historicoHistoriaService->PesquisaAvancada([]);

        $historiaService->motaGraficoEvolucao($histHistorias,true);

        $this->dados = $historiaService::$dados;
    }

    public function AcompanharProjetoGestao()
    {
        Redireciona(ADMIN . "/Modulo/ListarModulo");
    }


    public function LimparBancoGestao()
    {
        $retorno = false;
        if (!empty($_POST)) {
            unset($_POST['LimparBanco']);
            if (empty($_POST['tp_dados'])) {
                Notificacoes::geraMensagem(
                    'O Campo Tabelas do Banco é obrigatório.', TiposMensagemEnum::ALERTA);
            } else {
                if (in_array(1, $_POST['tp_dados'])) {
                    /** @var AcessoService $acessoService */
                    $acessoService = $this->getService(ACESSO_SERVICE);
                    $retorno = $acessoService->limpaDadosAcessos($_POST['dt_fim']);
                }
                if (in_array(2, $_POST['tp_dados'])) {
                    /** @var AuditoriaService $auditoriaService */
                    $auditoriaService = $this->getService(AUDITORIA_SERVICE);
                    $retorno = $auditoriaService->limpaDadosAuditoria($_POST['dt_fim']);
                }
                if ($retorno) {
                    Notificacoes::geraMensagem(
                        'Dados Apagados com SUCESSO!.', TiposMensagemEnum::SUCESSO);
                    Redireciona(ADMIN . "/" . CONTROLLER_INICIAL_ADMIN . "/" . ACTION_INICIAL_ADMIN);
                } else {
                    Notificacoes::geraMensagem(
                        'Error ao Apagados dados do Banco.', TiposMensagemEnum::ALERTA);
                }
            }
        }
        $this->form = GestaoForm::LimparBanco();
    }

}

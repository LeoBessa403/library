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
            $dados['WHATSAPP_MSG'] = '55' . Valida::RetiraMascara($dados['WHATSAPP_MSG']);
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
        $res['WHATSAPP_MSG'] = str_replace('55', '', WHATSAPP_MSG);
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
            $handle = fopen(PASTA_RAIZ . ADMIN . '/Config.Padrao.php', 'w+');
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
            $handle = fopen(PASTA_RAIZ . ADMIN . '/Config.Padrao.php', 'w+');
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
        /** @var ProjetoService $projetoService */
        $projetoService = $this->getService(PROJETO_SERVICE);
        $meuProjeto = $projetoService->PesquisaTodos();
        if (!$meuProjeto) {
            $projeto[NO_PROJETO] = DESC_SIS;
            $projetoService->salvaProjeto($projeto);
        }

        /** @var HistoriaService $historiaService */
        $historiaService = $this->getService(HISTORIA_SERVICE);
        /** @var HistoricoHistoriaService $historicoHistoriaService */
        $historicoHistoriaService = $this->getService(HISTORICO_HISTORIA_SERVICE);

        $histHistorias = $historicoHistoriaService->PesquisaAvancada([]);

        $historiaService->motaGraficoEvolucao($histHistorias, true);

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

    public function CronsGestao()
    {
        /** @var CronsService $cronsService */
        $cronsService = $this->getService(CRONS_SERVICE);
        /** @var CronsService $cronsService */
        $this->result = $cronsService->PesquisaTodos();
    }

    public function CadastroCronsGestao()
    {
        /** @var CronsService $cronsService */
        $cronsService = $this->getService(CRONS_SERVICE);
        if (!empty($_POST['CadastroCrons'])) {
            $retorno = $cronsService->salvaCron($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/Gestao/CronsGestao/');
            }
        }

        $coCron = UrlAmigavel::PegaParametro(CO_CRON);
        $res = [];
        if ($coCron) {
            /** @var CronsEntidade $cron */
            $cron = $cronsService->PesquisaUmRegistro($coCron);

            $res[NO_CRON] = $cron->getNoCron();
            $res[DS_SQL] = $cron->getDsSql();
            $res[CO_CRON] = $cron->getCoCron();
        }
        $this->form = GestaoForm::CadastroCrons($res);
    }

    /**
     * Faz a Minificação dos Arquivos CSS e JS
     */
    public function MinificacaoGestao()
    {
        if (!empty($_POST['Minificacao'])) {
            $retorno = false;
            if (empty($_POST['tp_arquivos'])) {
                Notificacoes::geraMensagem(
                    'O Campo Tipo de Arquivo é obrigatório.', TiposMensagemEnum::ALERTA);
            } else {
                $path = INCLUDES_LIBRARY . '/plugins/';
                require $path . 'minify/Minify.php';
                require $path . 'minify/CSS.php';
                require $path . 'minify/JS.php';
                require $path . 'minify/Exception.php';
                require $path . 'minify/Exceptions/BasicException.php';
                require $path . 'minify/Exceptions/FileImportException.php';
                require $path . 'minify/Exceptions/IOException.php';
                require $path . 'PathConverter/ConverterInterface.php';
                require $path . 'PathConverter/Converter.php';

                if (in_array('css', $_POST['tp_arquivos'])) {
                    $minifierCSS = new MatthiasMullie\Minify\CSS();

                    // ARQUIVOS CSS
                    $css[] = INCLUDES_LIBRARY . "plugins/bootstrap/css/bootstrap.min.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/font-awesome/css/font-awesome.min.css";
                    $css[] = INCLUDES_LIBRARY . "fonts/style.css";
                    $css[] = INCLUDES_LIBRARY . "css/main-responsive.css";
                    $css[] = INCLUDES_LIBRARY . "css/main.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/iCheck/skins/all.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/perfect-scrollbar/src/perfect-scrollbar.css";
                    $css[] = INCLUDES_LIBRARY . "css/theme_navy.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/css3-animation/animations.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/bootstrap-modal/css/bootstrap-modal.css";
                    $css[] = INCLUDES_LIBRARY . "Helpers/includes/Jcalendar.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/select2/select2.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/bootstrap-fileupload/bootstrap-fileupload.min.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/jQRangeSlider/css/classic-min.css";

                    $css[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/css/core.main.min.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/css/daygrid.main.min.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/css/list.main.min.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/css/timegrid.main.min.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/css/bootstrap.main.min.css";

                    $css[] = INCLUDES_LIBRARY . "plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/DataTables/media/css/DT_bootstrap.css";
                    $css[] = INCLUDES_LIBRARY . "plugins/gritter/css/jquery.gritter.css";

                    foreach ($css as $itemCss) {
                        $minifierCSS->add($itemCss);
                    }

                    // CRIA ARQUIVO MINIFICADO CSS
                    $miniCss = INCLUDES_LIBRARY . 'css/css_padrao.min.css';
                    $minifierCSS->minify($miniCss);

                    $retorno = true;
                }
                if (in_array('js_geral', $_POST['tp_arquivos'])) {
                    $minifierJS1 = new MatthiasMullie\Minify\JS();

                    // ARQUIVOS JS
                    $js1[] = INCLUDES_LIBRARY . "plugins/respond.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/excanvas.min.js";
                    $js1[] = INCLUDES_LIBRARY . "Helpers/includes/jquery-1.10.2.js";
                    $js1[] = INCLUDES_LIBRARY . "Helpers/includes/jquery-2.0.3.js";
                    $js1[] = INCLUDES_LIBRARY . "Helpers/includes/jquery-ui.js";
                    $js1[] = INCLUDES_LIBRARY . "Helpers/includes/jquery.mask.js";
                    $js1[] = INCLUDES_LIBRARY . "Helpers/includes/jquery.maskMoney.js";
                    $js1[] = INCLUDES_LIBRARY . "Helpers/includes/validacoes.js";

                    $js1[] = INCLUDES_LIBRARY . "plugins/bootstrap/js/bootstrap.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/blockUI/jquery.blockUI.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/iCheck/jquery.icheck.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/perfect-scrollbar/src/jquery.mousewheel.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/perfect-scrollbar/src/perfect-scrollbar.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/perfect-scrollbar/src/jquery.mousewheel.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/jquery-cookie/jquery.cookie.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js";
                    $js1[] = INCLUDES_LIBRARY . "js/main.js";
                    $js1[] = INCLUDES_LIBRARY . "js/ui-animation.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/flot/jquery.flot.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/flot/jquery.flot.pie.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/flot/jquery.flot.resize.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/jquery.sparkline/jquery.sparkline.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/bootstrap-modal/js/bootstrap-modal.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/bootstrap-modal/js/bootstrap-modalmanager.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/select2/select2.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/bootstrap-fileupload/bootstrap-fileupload.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/bootstrap-switch/static/js/bootstrap-switch.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/DataTables/media/js/jquery.dataTables.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/DataTables/media/js/DT_bootstrap.js";
                    $js1[] = INCLUDES_LIBRARY . "js/table-data.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/ckeditor/ckeditor.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/ckeditor/adapters/jquery.js";
                    $js1[] = INCLUDES_LIBRARY . "js/Funcoes.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js";
                    $js1[] = INCLUDES_LIBRARY . "js/form-wizard.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/jQRangeSlider/jQAllRangeSliders-min.js";
                    $js1[] = INCLUDES_LIBRARY . "js/ui-sliders.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/js/core.main.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/js/daygrid.main.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/js/interaction.main.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/js/list.main.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/js/timegrid.main.min.js";
                    $js1[] = INCLUDES_LIBRARY . "plugins/FullCalendar4/js/bootstrap.main.min.js";

                    foreach ($js1 as $itemJS1) {
                        $minifierJS1->add($itemJS1);
                    }

                    $miniJS1 = INCLUDES_LIBRARY . 'js/js_padrao.min.js';
                    $minifierJS1->minify($miniJS1);

                    $retorno = true;
                }
                if (in_array('js_renovacao', $_POST['tp_arquivos'])) {
                    $minifierJS2 = new MatthiasMullie\Minify\JS();
                    // CRIA ARQUIVO MINIFICADO JS Renovação pagamento
                    $js2[] = PASTA_RAIZ . "library/js/Assinante/RenovaPlanoAssinante_back.js";
                    foreach ($js2 as $itemJS2) {
                        $minifierJS2->add($itemJS2);
                    }
                    // CRIA ARQUIVO MINIFICADO JS Renovação pagamento
                    $miniJS2 = PASTA_RAIZ . "library/js/Assinante/RenovaPlanoAssinante.js";
                    $minifierJS2->minify($miniJS2);

                    $retorno = true;
                }
                if (in_array('js_agenda', $_POST['tp_arquivos'])) {
                    $minifierJS3 = new MatthiasMullie\Minify\JS();
                    // CRIA ARQUIVO MINIFICADO JS Agendamento
                    $js3[] = PASTA_RAIZ . ADMIN . "/js/Agenda/Agendamento_back.js";
                    foreach ($js3 as $itemJS3) {
                        $minifierJS3->add($itemJS3);
                    }
                    // CRIA ARQUIVO MINIFICADO JS Agendamento
                    $miniJS3 = PASTA_RAIZ . ADMIN . "/js/Agenda/Agendamento.js";
                    $minifierJS3->minify($miniJS3);

                    $retorno = true;
                }
                if ($retorno) {
                    Notificacoes::geraMensagem(
                        'Minificação dos Arquivos com SUCESSO!.', TiposMensagemEnum::SUCESSO);
                    Redireciona(ADMIN . "/" . CONTROLLER_INICIAL_ADMIN . "/" . ACTION_INICIAL_ADMIN);
                } else {
                    Notificacoes::geraMensagem(
                        'Error ao Minificar os Arquivos.', TiposMensagemEnum::ALERTA);
                }
            }

        }
        $this->form = GestaoForm::Minificacao();
    }

}

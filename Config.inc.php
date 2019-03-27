<?php
//Inicia a Sessão
// Pasta do arquivos do site
define('SITE', 'web');
// Pasta dos arquivos da Admiistração
define('ADMIN', 'admin');
session_start();
if (file_exists(ADMIN . "/configuracoes.php")):
    include ADMIN . "/configuracoes.php";
elseif (file_exists("../" . ADMIN . "/configuracoes.php")):
    include "../" . ADMIN . "/configuracoes.php";
else:
    include "../../" . ADMIN . "/configuracoes.php";
endif;
servidor_inicial();

if (file_exists( "library/Config.Padrao.php")):
    include  "library/Config.Padrao.php";
elseif (file_exists("../library/Config.Padrao.php")):
    include "../library/Config.Padrao.php";
else:
    include "../../library/Config.Padrao.php";
endif;

if (file_exists(ADMIN . "/Class/Constantes.class.php")):
    include ADMIN . "/Class/Constantes.class.php";
elseif (file_exists("../" . ADMIN . "/Class/Constantes.class.php")):
    include "../" . ADMIN . "/Class/Constantes.class.php";
else:
    include "../../" . ADMIN . "/Class/Constantes.class.php";
endif;

if (file_exists('library/Constantes.class.php')):
    include_once "library/Constantes.class.php";
else:
    include_once "../../library/Constantes.class.php";
endif;

if (defined('TEM_SITE') == false) {
    // PROJETO POSSUI SITE
    define('TEM_SITE', FALSE);
    // PROJETO POSSUI MODULO ASSINANTE
    define('MODULO_ASSINANTE', FALSE);
    // LOGAR COM EMAIL OU CPF
    define('LOGAR_EMAIL', TRUE);
    // TABELA PARA ARMAZENAR OS DADOS PARA AUDITORIA
    define('TABELA_AUDITORIA', TRUE);
    // Título do Site
    define('DESC', 'Descrição do Sistema');
    // Título do Sistema
    define('DESC_SIS', 'SisNovo');
    // CONTROLLER INICIAL DO SITE
    define('CONTROLLER_INICIAL_SITE', 'IndexWeb');
    // AÇÃO INICIAL DO SITE
    define('ACTION_INICIAL_SITE', 'Index');
    // CONTROLLER INICIAL DO ADMIN
    define('CONTROLLER_INICIAL_ADMIN', 'Index');
    // AÇÃO INICIAL DO ADMIN
    define('ACTION_INICIAL_ADMIN', 'Index');
    // Tabela de pesquisa de usuário para validação
    define('TABLE_USER', 'tb_usuario');
    // Campo da senha na Tabela de pesquisa de usuário para validação
    define('CAMPO_PASS', 'ds_code');
    // Campo do ID (Chave Primaria) na Tabela de pesquisa de usuário para validação
    define('CAMPO_ID', 'co_usuario');
    // Campo do Perfil na Tabela de pesquisa de usuário para validação dos perfis
    // (Ex.: cadastrante, administrador, pesquisador) Sepmre separados por (, )
    define('CAMPO_PERFIL', 'ds_perfil');
    // Atribui o nome da Sessão do usuario Logado no sitema
    define('SESSION_USER', 'user_sistema_novinho');
    // Tempo de Inativadade Máximo em Minutos, aceito para deslogar do Sistema.
    define('INATIVO', 30);
    // A frequencia em dias para realizar o BACKUP NO BANCO DE DADOS
    define('BACKUP', 5);
    // TAMANHO PADRÃO DO WIDTH DAS IAMGENS A SEREM CARREGADAS
    define('TAMANHO', 800);
    // NÚMERO PADRÃO DE ENVIO DO WHATSAPP
    define('WHATSAPP', '');
    // DESCRIÇÃO PADRÃO DO SITE
    define('DESC_SITE', 'Sistema de gestão novo');
    // TÍTULO PADRÃO DO SITE
    define('TITULO_SITE', 'Sistema de gestão novo');
    // CONTROLLERS PARA GERAR O SEO DIFERENCIADO
    define('CONTROLLER_SEO', '');
    // NÚMERO DE IMAGENS DE BACKGROUND DA TELA INICIAL DO SISTEMA
    define('NUM_BG_IMAGENS', 1);

    //////////////////////////////////////////////
    // ******* CONFIGURAÇÕES DE EMAIL ********** //
    //////////////////////////////////////////////

    define('HOST_EMAIL', '');
    define('PORTA_EMAIL', '');
    define('USER_EMAIL', '');
    define('PASS_EMAIL', '');

    //////////////////////////////////////////////
    // *********** GOOGLE ANALITCS  *********** //
    //////////////////////////////////////////////
    define('ID_ANALITCS', FALSE);
}

//*************************************//
//* CONFIGURAÇÕES DE LOGIN DO SISTEMA *//
//*************************************//
// Define o Controler/Action para area de login
define('LOGIN', '/' . CONTROLLER_INICIAL_ADMIN . '/Acessar/');
// Define o Controler/Action para validar o login
define('VALIDA_LOGAR', '/acesso/valida');
// Define o Controler/Action para Redireciona apos o login ser validado
define('LOGADO', '/' . CONTROLLER_INICIAL_ADMIN . '/' . ACTION_INICIAL_ADMIN);
// Nome da View da Página de Erro Controller ou Action não encontrado. (Erro 404).
define('ERRO_404', '404');
// CONTROLLERS PARA NÃO SEGUIR PARA A AUDITORIA
define('SEM_AUDITORIA', AcessoEntidade::TABELA . ', ' . TrafegoEntidade::TABELA . ', ' .
    PaginaVisitaEntidade::TABELA . ', ' . PaginaEntidade::TABELA . ', ' . VisitaEntidade::TABELA. ', ' .
    FuncionalidadeEntidade::TABELA. ', ' . AuditoriaEntidade::TABELA . ', ' . AuditoriaTabelaEntidade::TABELA . ', ' .
    AuditoriaItensEntidade::TABELA);
// Action do primeiro acesso
define('PRIMEIRO_ACESSO', '/' . CONTROLLER_INICIAL_ADMIN . '/' . ACTION_INICIAL_ADMIN);


// CONFIGURAÇÕES DO SERVIDOR
date_default_timezone_set('America/Sao_Paulo');

//*************************************//
//***** CONFIGURAÇÕES DA BIBLIOTECA ***//
//*************************************//

// Define a pasta Raiz das Imagens da Biblioteca
define('PASTA_RAIZ', str_replace('\\', '/', str_replace('library', '', __DIR__)));
define('INCLUDES', HOME . 'library/Helpers/includes/');
define('INCLUDES_PLUGINS', HOME . 'library/plugins/');
define('PASTAIMG', INCLUDES . 'imagens/');
define('PASTASITE', HOME . SITE . '/');
define('PASTAADMIN', HOME . ADMIN . '/');
define('PASTABACKUP', PASTA_RAIZ . '/BancoDados/');
define('PASTA_LIBRARY', HOME . 'library/');
define('PASTA_ENTIDADES', PASTA_RAIZ . ADMIN . '/Entidade/');
define('PASTA_MODEL', PASTA_RAIZ . ADMIN . '/Model/');
define('PASTA_CLASS', PASTA_RAIZ . ADMIN . '/Class/');
define('PASTA_SEVICE', PASTA_RAIZ . ADMIN . '/Service/');
define('PARTIAL_SITE', PASTA_RAIZ . SITE . '/partial/');
define('PARTIAL_ADMIN', PASTA_RAIZ . ADMIN . '/partial/');
define('PARTIAL_LIBRARY', PASTA_RAIZ . 'library/Partial/');
define('PASTA_UPLOADS', PASTA_RAIZ . 'uploads/');
define('PASTAUPLOADS', HOME . 'uploads/');

// ARQUIVOS PRE DEFINIDOS
define('TIMTHUMB', PASTA_LIBRARY . 'Helpers/Timthumb.class.php');
define('SEM_FOTO', PASTAUPLOADS . 'sem-foto.jpg');


// DEFINE PARA VALIDAÇÃO DO CADASTRO
define('CADASTRADO', "cadastrado");
define('ATUALIZADO', "atualizado");
define('DELETADO', "deletado");
define('MENSAGEM', "mensagem");
define('TIPO', "tipo");
define('PESQUISA_AVANCADA', "pesquisa_avancada");


// AUTO LOAD DE CLASSES ####################
function __autoload($Class)
{
    $pastas = array('Conn', 'Entidade', 'Service', 'Controller', 'Helpers', 'Model', 'Class', 'Form', 'Enum', 'Validador');
    $rotas = array(
        './library/',
        '../../library/',
        '../',
        '',
        './' . ADMIN . '/',
        '../../' . ADMIN . '/',
        './' . SITE . '/',
        '../../' . SITE . '/'
    );
    $control = false;

    foreach ($pastas as $pasta):
        foreach ($rotas as $rota):
            $arquivos = array(
                $rota . $pasta . '/' . $Class . '.' . $pasta . '.php',
                $rota . $pasta . '/' . $Class . '.class.php',
                $rota . $pasta . '/' . $Class . '.php',
            );
            foreach ($arquivos as $arquivo):
                if (file_exists($arquivo) && !is_dir($arquivo)):
                    include_once($arquivo);
                    $control = true;
                    break;
                endif;
            endforeach;
            if ($control) break;
        endforeach;
        if ($control) break;
    endforeach;

    if (!$control):
        debug("Não foi possível incluir {$Class}");
    endif;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine)
{
    $label = ($ErrNo == E_USER_NOTICE ? "INFORMATIVO" : ($ErrNo == E_USER_WARNING ? "ALERTA" : ($ErrNo == E_USER_ERROR ? "ERRO" : "ERRO")));
    echo '<div class="alert alert-danger alert-dismissable" style="padding-left: 40px;">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <big><b>' . $label . ': </b></big> ' . $ErrFile . ' - <b><i>Linha: ' . $ErrLine . ' </i></b></big>
        </div>';
    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

/**
 * <b>Redirecionamento:</b> Redireciona para o caminho solicitado.
 * @param STRING $local = Modulo/Controller/Action e caso necessario /parametros/valores
 */
function Redireciona($local)
{
    echo "<script>location.href='" . HOME . $local . "';</script>";
    exit();
}

/**
 * <b>Usado para fazer Debug</b>
 * @param $array = Array a ser apresentado
 * @param $Exit = Array a ser apresentado
 * @return STRING = Print_r($array).
 */
function debug($array, $Exit = false)
{
    echo "<fieldset style='margin-left: 35px;'>"
        . "<legend style=' background-color: #fcfcfc; padding: 5px;'>Debug</legend>"
        . "<pre>";
    print_r($array);
    echo "<br /><br />";

    $aTrace = debug_backtrace();
    echo $aTrace[0]['file'] . " - " . $aTrace[0]['line'];

    echo "</pre>"
        . "</fieldset><br />";
    echo '<script src="' . INCLUDES . 'jquery-2.0.3.js"></script>
                <script type="text/javascript">
                        $(function() {
                            $(".navbar-content").hide();
                        });
                </script>';
    if (!$Exit):
        exit;
    endif;
}

/**
 * Carrega os JS das View respectivas
 * @param $urlAmigavel UrlAmigavel
 */
function carregaJs($urlAmigavel)
{
    $arquivo = '/js/' . $urlAmigavel::$controller . '/' . $urlAmigavel::$action . '.js';
    if (file_exists(ADMIN . $arquivo)) {
        echo '<script src="' . HOME . ADMIN . $arquivo . '"></script>';
    }
}
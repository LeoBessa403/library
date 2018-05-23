<?php
//Inicia a Sessão
// Pasta do arquivos do site
define('SITE', 'web');
// Pasta dos arquivos da Admiistração
define('ADMIN', 'admin');
session_start();
if (file_exists(ADMIN."/configuracoes.php")):
    include ADMIN."/configuracoes.php";
elseif (file_exists("../".ADMIN."/configuracoes.php")):
    include "../".ADMIN."/configuracoes.php";
else:
    include "../../".ADMIN."/configuracoes.php";
endif;
servidor_inicial();

//*************************************//
//* CONFIGURAÇÕES DE LOGIN DO SISTEMA *//
//*************************************//
// Define o Controler/Action para area de login
define('LOGIN', '/Index/Acessar/');
// Define o Controler/Action para validar o login
define('VALIDA_LOGAR', '/acesso/valida');
// Define o Controler/Action para Redireciona apos o login ser validado
define('LOGADO', '/Index/Index');
// Nome da View da Página de Erro Controller ou Action não encontrado. (Erro 404).
define('ERRO_404', '404');
// CONTROLLERS PARA NÃO SEGUIR PARA A AUDITORIA
define('SEM_AUDITORIA', AcessoEntidade::TABELA . ', ' . TrafegoEntidade::TABELA . ', ' .
    PaginaVisitaEntidade::TABELA. ', ' . PaginaEntidade::TABELA . ', ' . VisitaEntidade::TABELA);


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
define('PASTABACKUP', PASTA_RAIZ . '/BancoDados/backup/');
define('PASTA_ENTIDADES', PASTA_RAIZ . ADMIN . '/Entidade/');
define('PASTA_MODEL', PASTA_RAIZ . ADMIN . '/Model/');
define('PASTA_CLASS', PASTA_RAIZ . ADMIN . '/Class/');
define('PASTA_SEVICE', PASTA_RAIZ . ADMIN . '/Service/');
define('PARTIAL_SITE', PASTA_RAIZ . SITE . '/Partial/');
define('PARTIAL_ADMIN', PASTA_RAIZ . ADMIN . '/Partial/');


// DEFINE PARA VALIDAÇÃO DO CADASTRO
define('CADASTRADO', "cadastrado");
define('ATUALIZADO', "atualizado");
define('MENSAGEM', "mensagem");
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
    echo "<script>location.href='".HOME . $local."';</script>";
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
    $arquivo = '/js/includes/' . $urlAmigavel::$controller . '/' . $urlAmigavel::$action . '.js';
    if (file_exists(ADMIN . $arquivo)) {
        echo '<script src="' . HOME . ADMIN . $arquivo . '"></script>';
    }
}
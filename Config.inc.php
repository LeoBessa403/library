<?php
//Inicia a Sessão
// Pasta do arquivos do site
define('SITE', 'web');
// Pasta dos arquivos da Admiistração
define('ADMIN', 'admin');
session_start();
if (file_exists("admin/configuracoes.php")):
    include "admin/configuracoes.php";
elseif (file_exists("../admin/configuracoes.php")):
    include "../admin/configuracoes.php";
else:
    include "../../admin/configuracoes.php";
endif;
servidor_inicial();


//*************************************//
//* CONFIGURAÇÕES DE LOGIN DO SISTEMA *//
//*************************************//
// Define o Controler/Action para area de login
define('LOGIN', '/login.php');
// Define o Controler/Action para validar o login
define('VALIDA_LOGAR', '/acesso/valida');
// Define o Controler/Action para Redireciona apos o login ser validado
define('LOGADO', '/Index/Index');
// Nome da View da Página de Erro Controller ou Action não encontrado. (Erro 404).
define('ERRO_404', '404');


// CONFIGURAÇÕES DO SERVIDOR
date_default_timezone_set('America/Sao_Paulo');

//*************************************//
//***** CONFIGURAÇÕES DA BIBLIOTECA ***//
//*************************************//

// Define a pasta Raiz das Imagens da Biblioteca
define('PASTA_RAIZ', str_replace('\\','/', str_replace('library','',__DIR__)));
define('INCLUDES', HOME . 'library/Helpers/includes/');
define('INCLUDES_PLUGINS', HOME . 'library/plugins/');
define('PASTAIMG', INCLUDES . 'imagens/');
define('PASTASITE', HOME . SITE . '/');
define('PASTAADMIN', HOME . ADMIN . '/');
define('PASTABACKUP', PASTA_RAIZ. '/BancoDados/backup/');
define('PASTA_ENTIDADES', PASTA_RAIZ. ADMIN . '/Entidade/');
define('PASTA_MODEL', PASTA_RAIZ. ADMIN . '/Model/');
define('PASTA_CLASS', PASTA_RAIZ. ADMIN . '/Class/');


// DEFINE PARA VALIDAÇÃO DO CADASTRO
define('CADASTRADO', "cadastrado");
define('ATUALIZADO', "atualizado");


// AUTO LOAD DE CLASSES ####################
function __autoload($Class)
{

    $cDir = array('Conn', 'Helpers', 'Controller', 'Model', 'Class', 'Entidade');
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists("./library/{$dirName}/{$Class}.class.php") && !is_dir("./library/{$dirName}/{$Class}.class.php")):
            include_once("./library/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../library/{$dirName}/{$Class}.class.php") && !is_dir("../library/{$dirName}/{$Class}.class.php")):
            include_once("../library/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../../library/{$dirName}/{$Class}.class.php") && !is_dir("../../library/{$dirName}/{$Class}.class.php")):
            include_once("../../library/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../{$dirName}/{$Class}.class.php") && !is_dir("../{$dirName}/{$Class}.class.php")):
            include_once("../{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("{$Class}.class.php") && !is_dir("{$Class}.class.php")):
            include_once("{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("./" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php") && !is_dir("./" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php")):
            include_once("./" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php");
            $iDir = true;
        elseif (!$iDir && file_exists("./" . ADMIN . "/{$dirName}/{$Class}.class.php") && !is_dir("./" . ADMIN . "/{$dirName}/{$Class}.class.php")):
            include_once("./" . ADMIN . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("./" . SITE . "/{$dirName}/{$Class}.class.php") && !is_dir("./" . ADMIN . "/{$dirName}/{$Class}.class.php")):
            include_once("./" . SITE . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../../" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php") && !is_dir("../../" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php")):
            include_once("../../" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../../" . ADMIN . "/{$dirName}/{$Class}.class.php") && !is_dir("../../" . ADMIN . "/{$dirName}/{$Class}.class.php")):
            include_once("../../" . ADMIN . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../../" . SITE . "/{$dirName}/{$Class}.class.php") && !is_dir("../../" . ADMIN . "/{$dirName}/{$Class}.class.php")):
            include_once("../../" . SITE . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php") && !is_dir("../" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php")):
            include_once("../" . ADMIN . "/{$dirName}/{$Class}.{$dirName}.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../" . ADMIN . "/{$dirName}/{$Class}.class.php") && !is_dir("../" . ADMIN . "/{$dirName}/{$Class}.class.php")):
            include_once("../" . ADMIN . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("../" . SITE . "/{$dirName}/{$Class}.class.php") && !is_dir("../" . ADMIN . "/{$dirName}/{$Class}.class.php")):
            include_once("../" . SITE . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        elseif (!$iDir && file_exists("./" . SITE . "/{$dirName}/{$Class}.{$dirName}.php") && !is_dir("./" . SITE . "/{$dirName}/{$Class}.{$dirName}.php")):
            include_once("./" . SITE . "{$dirName}/{$Class}.{$dirName}.php");
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php OU {$Class}.Controller.php");
        die;
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
    header("Location: " . HOME . $local);
}

/**
 * <b>Usado para fazer Debug</b>
 * @param QUALQUER TIPO $array = Array a ser apresentado
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
    if (!$Exit):
        echo '<script src="' . INCLUDES . 'jquery-2.0.3.js"></script>
                <script type="text/javascript">
                        $(function() {
                            $(".navbar-content").hide();
                        });
                </script>';
        exit;
    endif;
}

/**
 * <b>Usada para Gerar o Menu da Aplicação</b>
 * @return STRING = Menu.
 */
function GeraMenu(array $menu)
{
    $url = new UrlAmigavel();
    $ativo = UrlAmigavel::$controller;

    echo '<ul class="main-navigation-menu">';
    if ($ativo == "Index"):
        echo '<li class="active">';
    else:
        echo '<li>';
    endif;
    echo '<a href="' . PASTAADMIN . 'Index/Index"><i class="clip-home-3"></i>
                                   <span class="title"> PÁGINA INICIAL  </span><span class="selected"></span>
                           </a>
                   </li>
                   <li>
                           <a href="' . HOME . '" target="_blank"><i class="clip-cog-2"></i>
                                   <span class="title"> SITE </span><span class="selected"></span>
                           </a>
                   </li>';

    foreach ($menu as $key => $value) {
        $montando[$key] = $value;
        $tem = false;
        $controle = 0;
        foreach ($montando[$key] as $value) :
            if ($controle > 0):
                if (Valida::ValPerfil($value)):
                    $tem = true;
                endif;
            endif;
            $controle++;
        endforeach;
        if ($tem):
            $titulo = array_keys($montando, $montando[$key]);
            if ($ativo == $titulo[0]):
                echo '<li class="active">';
            else:
                echo '<li>';
            endif;
            echo '<a href="javascript:void(0)"><i class="' . $montando[$key][0] . '"></i>
                                       <span class="title"> ' . $titulo[0] . ' </span><i class="icon-arrow"></i>
                                       <span class="selected"></span>
                               </a>
                               <ul class="sub-menu" style="display: none;">';
            $cout = 0;
            foreach ($montando[$key] as $value) {
                if ($cout > 0):
                    $titulo_menu = str_replace($titulo[0], "", $value);
                    if (Valida::ValPerfil($value)):
                        echo '<li>
                                                        <a href="' . PASTAADMIN . $titulo[0] . '/' . $value . '">
                                                                <span class="title"> ' . $titulo_menu . ' </span>
                                                        </a>
                                                     </li>';
                    endif;
                endif;
                $cout++;
            }
            echo '</ul>
                       </li>';
        endif;
    }
    echo '</ul>';

}

//set_error_handler('PHPErro');

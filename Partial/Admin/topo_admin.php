<?php
ob_start();
$url = new UrlAmigavel();
if (in_array(UrlAmigavel::$action, UrlAmigavel::$ACESSO_PERMITIDO)):
    $url->pegaControllerAction();
    exit;
endif;
$valida = new ValidaUsuario();
$valida->validacao();
$compara = strstr(UrlAmigavel::$action, 'Exporta');
if ($compara != null):
    $url->pegaControllerAction();
    exit;
endif;
/** @var Session $session */
$session = new Session();
/** @var Session $us */
$us = $_SESSION[SESSION_USER];
$user = $us->getUser();
?><!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.3 Author: ClipTheme -->
<!--[if IE 8]>
<html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]>
<html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- start: HEAD -->
<head>
    <title>SISTEMA | <?= DESC_SIS; ?></title>
    <!-- start: META -->
    <meta charset="utf-8"/>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1"/><![endif]-->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- end: META -->
    <link rel="stylesheet" href="<?= PASTA_LIBRARY; ?>css/css_padrao.min.css">

    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="<?= HOME; ?>favicon.ico"/>
    <!-- SCRIPT GERAR GRAFICOS -->
    <script type="text/javascript" src="<?= INCLUDES; ?>gera-grafico.min.js"></script>
</head>
<!-- end: HEAD -->
<!-- start: BODY -->
<body>
<!-- start: HEADER -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <!-- start: TOP NAVIGATION CONTAINER -->
    <div class="container">
        <div class="navbar-header">
            <!-- start: RESPONSIVE MENU TOGGLER -->
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="clip-list-2"></span>
            </button>
            <!-- end: RESPONSIVE MENU TOGGLER -->
            <!-- start: LOGO -->
            <a style="color: white; text-shadow: 1px 1px 2px #fefefe; font-size: 30px;" class="navbar-brand"
               href="<?= PASTAADMIN; ?>Index/IndexAdmin">
                <?= Valida::getImgSistema(35) . DESC_SIS; ?>
            </a>
            <!-- end: LOGO -->
        </div>
        <div class="navbar-tools">
            <!-- start: TOP NAVIGATION MENU -->
            <ul class="nav navbar-right">
                <!-- USER DROPDOWN -->
                <?php include_once 'user_dropdown.php'; ?>
                <!-- Inclusão do Partial de Notificações  -->
                <?php include_once 'notificacoes.php'; ?>
                <!-- Inclusão do Partial de Perfis  -->
                <?php include_once 'perfis.php'; ?>
                <li class="dropdown">
                    <a href="<?= PASTAADMIN; ?>login/deslogar/desloga/10" title="Sair do Sistema" tabindex="1">
                        <i class="clip-exit" title="Sair do Sistema"></i>
                    </a>
                </li>
            </ul>
            <!-- end: TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->
<!-- start: MAIN CONTAINER -->
<div class="main-container">
    <div class="navbar-content">
        <!-- start: SIDEBAR -->
        <div class="main-navigation navbar-collapse collapse">
            <!-- start: MAIN MENU TOGGLER BUTTON -->
            <div class="navigation-toggler">
                <i class="clip-chevron-left"></i>
                <i class="clip-chevron-right"></i>
            </div>
            <!-- end: MAIN MENU TOGGLER BUTTON -->


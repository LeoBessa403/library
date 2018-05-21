<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.4 Author: ClipTheme -->
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
    <!-- start: MAIN CSS -->
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>fonts/style.css">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>css/main-responsive.css">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>css/main.css">
    <link rel="stylesheet"
          href="<?php echo PASTAADMIN; ?>plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/perfect-scrollbar/src/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>css/theme_navy.css" type="text/css" id="skin_color">
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/css3-animation/animations.css">

    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo PASTAADMIN;?>plugins/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="stylesheet" href="<?= PASTAADMIN; ?>plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?= PASTAADMIN; ?>plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet"
          type="text/css"/>

    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR FULLCALENDARIO -->
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/fullcalendar/fullcalendar/fullcalendar.css">
    <!-- start: CSS REQUIRED FOR DATAPICKER -->
    <link rel="stylesheet" href="<?php echo INCLUDES; ?>Jcalendar.css">
    <!-- start: CSS REQUIRED FOR SELECT -->
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/select2/select2.css">
    <!-- start: CSS REQUIRED FOR UPLOAD -->
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
    <!-- start: CSS REQUIRED FOR CHECK -->
    <link rel="stylesheet"
          href="<?php echo PASTAADMIN; ?>plugins/bootstrap-switch/static/stylesheets/bootstrap-switch.css">
    <!-- start: CSS REQUIRED FOR CHECK -->
    <link rel="stylesheet" href="<?php echo PASTAADMIN; ?>plugins/DataTables/media/css/DT_bootstrap.css">
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="<?= PASTASITE; ?>img/favicon.ico"/>
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
</head>
<!-- end: HEAD -->
<!-- start: BODY -->
<body class="login example1" style="margin-top: 0; padding: 0;">
<div class="main-login col-md-4 col-md-offset-4" style="margin-top: 0; padding: 10px 0;">
    <div class="logo">
        <a style="color: whitesmoke;" href="<?php echo PASTASITE; ?>">
            <?= DESC_SIS; ?>
        </a>
    </div>
    <!-- start: LOGIN BOX -->
    <div class="box-login">
        <h3 class="logo" style="margin: 20px 0 10px; padding: 0;">Cadastrar Usuario do Sistema</h3>
        <?php
        echo $form;
        ?>
        <!-- end: COPYRIGHT -->
    </div>
    <div class="copyright" style="color: #ccc;">
        <?php echo date("Y"); ?> &copy; LEO BESSA
    </div>
    <?php Modal::aviso("alerta"); ?>
    <!-- start: MAIN JAVASCRIPTS -->
    <!--[if lt IE 9]>
    <script src="<?php echo PASTAADMIN;?>plugins/respond.min.js"></script>
    <script src="<?php echo PASTAADMIN;?>plugins/excanvas.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDES;?>jquery-1.10.2.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <script src="<?php echo INCLUDES; ?>jquery-2.0.3.js"></script>
    <!--<![endif]-->
    <!--<script src="<?php echo PASTAADMIN; ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>-->
    <script src="<?php echo INCLUDES; ?>jquery-ui.js"></script>
    <script src="<?php echo PASTAADMIN; ?>plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDES; ?>jquery.mask.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDES; ?>jquery.maskMoney.js"></script>
    <?php echo '<script type="text/javascript">
                        function constantes(){    
                                var dados = {
                                    "HOME" : "' . HOME . '",
                                    "INATIVO" : "' . INATIVO . '",
                                    "PASTAUPLOADS" : "' . PASTAUPLOADS . '"                                        
                                    };
                                return dados;
                        }
                </script>'; ?>
    <script type="text/javascript" src="<?php echo INCLUDES; ?>validacoes.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->

    <script src="<?php echo PASTAADMIN; ?>plugins/select2/select2.min.js"></script>
    <script src="<?php echo PASTAADMIN; ?>plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script src="<?php echo PASTAADMIN; ?>js/Funcoes.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script>
        jQuery(document).ready(function () {
            Funcoes.init();
            <?php
            $session = new Session();
            if($session->CheckSession(CADASTRADO)):
            $session->FinalizaSession(CADASTRADO);
            ?>
            Funcoes.Sucesso("<?= Mensagens::USUARIO_CADASTRADO_SUCESSO;?>");
            <?php
            endif;
            if($session->CheckSession(MENSAGEM)):
            ?>
            Funcoes.Alerta("<?php echo $session->getSession(MENSAGEM);?>");
            <?php
            $session->FinalizaSession(MENSAGEM);
            endif;
            ?>
        });
    </script>
</body>
<!-- end: BODY -->
</html>
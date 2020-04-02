<?php
//$pages = array(
//    'IndexWeb/Index' => 'Home',
//    'Categorias/ListarCategorias' => 'Categorias',
//    'Fabricantes/ListarFabricantes' => 'Fabricantes',
//    'Institucional/SobreNos' => 'Sobre nós',
//    'Institucional/Contatos' => 'Contatos',
//    'Institucional/Duvidas' => 'Dúvidas',
//    'Produtos/DetalharFavoritos' => 'Favoritos',
//    'Produtos/ComparaProdutos' => 'Comparação de produtos',
//);
///** @var UrlAmigavel $url */
//$url = new UrlAmigavel();
///** @var Seo $seo */
//$seo = new Seo($url);
///** @var Sitemap $siteMap */
//$siteMap = new Sitemap();
///** @var VisitaService $visitaService */
//$visitaService = new VisitaService();
//$visitaService->gestaoVisita();
?>
<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="pt-br" itemscope itemtype="https://schema.org/WebSite"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="pt-br" itemscope itemtype="https://schema.org/WebSite"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="pt-br" itemscope itemtype="https://schema.org/WebSite"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="pt-br" itemscope itemtype="https://schema.org/WebSite"> <!--<![endif]-->
<head>
    <!-- Inclução das tags do Seo -->
    <!--        --><?php //require_once 'library/includes/SeoTags.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Site Sistema da Beleza</title>
    <meta name="description" content="Uma descrição do site">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700%7CNiconne"
          rel="stylesheet">

    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="<?= HOME; ?>favicon.ico"/>

    <!-- Bootstrap.css -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/bootstrap.min.css">
    <!-- Date pixker -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/bootstrap-datepicker.min.css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/font-awesome.min.css">
    <!-- XS Icon -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/xs-icon.css">
    <!-- Owl slider -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/owl.carousel.min.css">
    <!-- Isotope -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/isotope.css">
    <!-- magnific-popup -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/magnific-popup.css">
    <!--For Plugins external css-->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/plugins.css"/>

    <!--Theme custom css -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/style.css">

    <!--Theme Responsive css-->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/responsive.css"/>
</head>
<body>
<h1 style="display: none;">
    <!--        --><? //= //$seo->getTitulo(); ?>
</h1>
<!-- GOOGLE ANALITCS -->
<?php if (ID_ANALITCS): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= ID_ANALITCS; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '<?= ID_ANALITCS; ?>');
    </script>
<?php endif; ?>
<!-- FIM / GOOGLE ANALITCS -->

<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
        href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Main menu -->
<header class="beautypress-header-section beautypress-version-1 beautypress-extra-css menu-skew header-height-calc-minus navbar-fixed">
    <div class="container">
        <div class="beautypress-logo-wraper">
            <a href="index.html" class="beautypress-logo beautypress-version-2  beautypress-version-4">
                <img src="<?= PASTASITE; ?>img/logo-v1-1.png" alt="">
            </a>
        </div><!-- .beautypress-logo-wraper END -->
    </div>
    <div class="beautypress-header-top bg-navy-blue">
        <div class="container">
            <ul class="beautypress-simple-iocn-list beautypress-version-1">
                <li class="no-link"><i class="xsicon icon-call"></i>Nos chame no<a title="Nos chame no WhatSapp"
                                                                    href="<?= Valida::geraLinkWhatSapp('Ola') ?>"
                                                                    target="_blank">
                        <i class="fa fa-whatsapp i-zap"></i>WhatSapp</li>
                <li class="no-link"><i class="xsicon icon-envelope i-zap"></i>
                    <a href="mailto:<?= USER_EMAIL; ?>"><?= USER_EMAIL; ?></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="beautypress-main-header bg-color-purple color-white">
        <div class="container">
            <nav class="xs_nav beautypress-nav beautypress-mega-menu">
                <div class="nav-header">
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <li><a href="#">Home</a>
                            <ul class="nav-dropdown">
                                <li><a href="#">home</a></li>
                                <?php foreach ($pages as $key => $packagePage) : ?>
                                    <li><a href="<?php echo PASTASITE . $key; ?>">
                                            <?php echo $packagePage; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li><a href="<?= PASTAADMIN; ?>Index/PrimeiroAcesso" target="_blank">SisBela</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div><!-- .beautypress-main-header END -->
</header><!-- .beautypress-header-section END -->
<!-- Main menu closed -->


<!-- welcome section -->
<section class="beautypress-welcome-section beautypress-welcome-section-v1 welcome-height-calc-minus">
    <div class="beautypress-welcome-slider-wraper">
        <div class="beautypress-welcome-slider owl-carousel">
            <div class="beautypress-welcome-slider-item content-left beautypress-bg"
                 style="background-image: url(<?= PASTASITE; ?>img/slider-bg-1.png);">
                <div class="container">
                    <div class="beautypress-welcome-content-group">
                        <div class="beautypress-welcome-container">
                            <div class="beautypress-welcome-wraper">
                                <h2 class="color-pink">37th Years Of </h2>
                                <h3 class="color-purple">BeautyPress</h3>
                                <p class="color-black">Allow our team of beauty specialists to help you prepare for
                                    your wedding and enhance your special.</p>
                                <div class="beautypress-btn-wraper">
                                    <a href="#" class="xs-btn bg-color-pink round-btn box-shadow-btn">learn more
                                        <span></span></a>
                                    <a href="#" class="xs-btn bg-color-purple round-btn box-shadow-btn">phurchase
                                        <span></span></a>
                                </div>
                            </div>
                        </div><!-- .beautypress-welcome-container END -->
                    </div><!-- .beautypress-welcome-content-group END -->
                </div>
            </div><!-- .beautypress-welcome-slider-item END -->
            <div class="beautypress-welcome-slider-item content-left beautypress-bg"
                 style="background-image: url(<?= PASTASITE; ?>img/slider-bg-2.png);">
                <div class="container">
                    <div class="beautypress-welcome-content-group">
                        <div class="beautypress-welcome-container">
                            <div class="beautypress-welcome-wraper">
                                <h2 class="color-pink">Beautiful Face</h2>
                                <h3 class="color-purple">Healthy You</h3>
                                <p class="color-black">Allow our team of beauty specialists to help you prepare for
                                    your wedding and enhance your special.</p>
                                <div class="beautypress-btn-wraper">
                                    <a href="#" class="xs-btn bg-color-pink round-btn box-shadow-btn">learn more
                                        <span></span></a>
                                    <a href="#" class="xs-btn bg-color-purple round-btn box-shadow-btn">phurchase
                                        <span></span></a>
                                </div>
                            </div>
                        </div><!-- .beautypress-welcome-container END -->
                    </div><!-- .beautypress-welcome-content-group END -->
                </div>
            </div><!-- .beautypress-welcome-slider-item END -->
            <div class="beautypress-welcome-slider-item content-right beautypress-bg"
                 style="background-image: url(<?= PASTASITE; ?>img/slider-bg-3.png);">
                <div class="container">
                    <div class="beautypress-welcome-content-group">
                        <div class="beautypress-welcome-container">
                            <div class="beautypress-welcome-wraper">
                                <h2 class="color-pink">Beauty means</h2>
                                <h3 class="color-purple">Happiness</h3>
                                <p class="color-black">Allow our team of beauty specialists to help you prepare for
                                    your wedding and enhance your special.</p>
                                <div class="beautypress-btn-wraper">
                                    <a href="#" class="xs-btn bg-color-pink round-btn box-shadow-btn">learn more
                                        <span></span></a>
                                    <a href="#" class="xs-btn bg-color-purple round-btn box-shadow-btn">phurchase
                                        <span></span></a>
                                </div>
                            </div>
                        </div><!-- .beautypress-welcome-container END -->
                    </div><!-- .beautypress-welcome-content-group END -->
                </div>
            </div><!-- .beautypress-welcome-slider-item END -->
        </div><!-- .beautypress-welcome-slider END -->
    </div>
</section><!-- .beautypress-welcome-section END -->
<!-- welcome section -->
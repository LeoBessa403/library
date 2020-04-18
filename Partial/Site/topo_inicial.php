<?php
$pages = array(
    'home_inicio' => 'Início',
    'experimentar_gratis' => 'Experimentar Grátis',
    'planos_sistema' => 'Planos',
    'saiba_mais' => 'Saiba Mais',
);
$redesSocial = array(
    'instagram' => [
        'link' => 'https://www.instagram.com/sistemadabeleza/',
        'class' => 'beautypress-instagram',
        'title' => 'Nos siga no Instagram',
        'iClass' => 'fa fa-instagram',
    ],
    'facebook' => [
        'link' => 'https://www.facebook.com/sistemadabeleza/',
        'class' => 'beautypress-facebook',
        'title' => 'Nos siga no Facebook',
        'iClass' => 'fa fa-facebook',
    ],
    'youtube' => [
        'link' => 'https://www.youtube.com/channel/UCurAWOHi0yrq7SnmelWdOJA',
        'class' => 'beautypress-pinterest',
        'title' => 'Veja nosso canal no YouTube',
        'iClass' => 'fa fa-youtube-play',
    ],
    'twitter' => [
        'link' => 'https://twitter.com/sistemadabeleza/',
        'class' => 'beautypress-twitter',
        'title' => 'Nos siga no Twitter',
        'iClass' => 'fa fa-twitter',
    ],
    'whatsapp' => [
        'link' => 'https://api.whatsapp.com/send?phone=' . WHATSAPP .
            '&amp;l=pt_BR&amp;text=Olhando no site e gostaria de saber mais!',
        'class' => 'beautypress-whatsapp',
        'title' => 'Nos chame no WhatsApp',
        'iClass' => 'fa fa-whatsapp',
    ],
    'email' => [
        'link' => 'mailto:' . USER_EMAIL,
        'class' => 'beautypress-envelope',
        'title' => 'Nos envie um E-mail',
        'iClass' => 'fa fa-envelope',
    ],
);
$url = new UrlAmigavel();
$seo = new Seo($url);
$siteMap = new Sitemap();
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
    <?php require_once 'library/Partial/Site/SeoTags.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
<p class="browserupgrade">Voçê está usando um programa <strong>DESATUALIZADO</strong> navegador. por favor <a
        href="http://browsehappy.com/">atualize seu navegador</a> para que possa navegar no site e sistema de forma
    melhor.</p>
<![endif]-->

<!-- Main menu -->
<header class="beautypress-header-section beautypress-version-1 beautypress-extra-css menu-skew header-height-calc-minus navbar-fixed">
    <div class="container">
        <div class="beautypress-logo-wraper">
            <a class="beautypress-logo beautypress-version-2 beautypress-version-4 home_inicio">
                <img src="<?= PASTASITE; ?>img/logo-v1-1.png" alt="">
            </a>
        </div><!-- .beautypress-logo-wraper END -->
    </div>
    <div class="beautypress-header-top bg-navy-blue">
        <div class="container">
            <h4 style="display: none;">Redes Sociais</h4>
            <ul class="beautypress-simple-iocn-list beautypress-social-list beautypress-version-1">
                <?php foreach ($redesSocial as $key => $dados) : ?>
                    <li><a href="<?= $dados['link']; ?>" class="<?= $dados['class']; ?>"
                           target="_blank" title="<?= $dados['title']; ?>"><i class="<?= $dados['iClass']; ?>">
                            </i></a></li>
                <?php endforeach; ?>
                <a href="#" class="btn-exp xs-btn round-btn box-shadow-btn bg-color-green experimentar_gratis">
                    Experimentar Grátis<span></span></a>
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
                        <?php foreach ($pages as $key => $packagePage) : ?>
                            <li class="<?= $key; ?>"><a href="#">
                                    <?php echo $packagePage; ?></a></li>
                        <?php endforeach; ?>
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

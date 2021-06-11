<?php
$pages = array(
    'home_inicio' => 'Início',
    'planos_sistema' => 'Planos',
    'duvidas' => 'Dúvidas',
    'saiba_mais' => 'Saiba Mais',
    'bonus' => 'Bônus',
    'compra' => 'Comprar',
);

$url = new UrlAmigavel();
$seo = new Seo($url);
$siteMap = new Sitemap();
/** @var VisitaService $visitaService */
$visitaService = new VisitaService();
$visitaService->gestaoVisita();
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

    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="<?= HOME; ?>favicon.ico"/>
    <!-- Bootstrap.css -->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/app.css">

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

<!-- Icons/Glyphs -->
    <link rel="stylesheet" href="<?= PASTA_LIBRARY; ?>css/font-awesome.min.css">


    <!--Theme Responsive css-->
    <link rel="stylesheet" href="<?= PASTASITE; ?>css/responsive.css"/>
</head>
<body>
<h1 style="display: none;"><?= $seo->getTitulo(); ?></h1>
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

    <div class="beautypress-main-header bg-color-purple color-white">
        <div class="container">
            <nav class="xs_nav beautypress-nav beautypress-mega-menu">
                <div class="nav-header">
                    <div class="nav-toggle"></div>
                </div>
                <div class="nav-menus-wrapper">
                    <ul class="nav-menu">
                        <?php foreach ($pages as $key => $packagePage) : ?>
                            <li data-class="<?= $key; ?>" class="menu_click"><a href="#">
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


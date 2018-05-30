<title><?= $seo->getTitulo(); ?></title>
    <meta name="description" content="<?= $seo->getDescricao(); ?>"/>
    <meta name="robots" content="index, follow"/>

    <link rel="base" href="<?= HOME; ?>"/>
    <link rel="canonical" href="<?= $seo->getUrl(); ?>"/>

    <meta itemprop="name" content="<?= $seo->getTitulo(); ?>"/>
    <meta itemprop="description" content="<?= $seo->getDescricao(); ?>"/>
    <meta itemprop="image" content="<?= $seo->getImagem() ?>"/>
    <meta itemprop="url" content="<?= $seo->getUrl(); ?>"/>

    <meta property="og:type" content="WebSite"/>
    <meta property="og:title" content="<?= $seo->getTitulo(); ?>"/>
    <meta property="og:description" content="<?= $seo->getDescricao(); ?>"/>
    <meta property="og:image" content="<?= $seo->getImagem(); ?>"/>
    <meta property="og:url" content="<?= $seo->getUrl(); ?>"/>
    <meta property="og:site_name" content="<?= DESC; ?>"/>
    <meta property="og:locale" content="pt_BR"/>
    <meta property="article:author" content="https://www.facebook.com/leodjx" />
    <meta property="article:publisher" content="https://www.facebook.com/leodjx" />

    <meta property="twitter:card" content="summary_large_image"/>
    <meta property="twitter:site" content="@gejdombosco" />
    <meta property="twitter:domain" content="<?= HOME; ?>"/>
    <meta property="twitter:title" content="<?= $seo->getTitulo(); ?>"/>
    <meta property="twitter:description" content="<?= $seo->getDescricao(); ?>"/>
    <meta property="twitter:image" content="<?= $seo->getImagem(); ?>"/>
    <meta property="twitter:url" content="<?= $seo->getUrl(); ?>"/>

    <link rel="alternate" type="application/rss+xml" href="<?= HOME; ?>rss.php"/>
    <link rel="sitemap" type="application/xml" href="<?= HOME; ?>sitemap.xml" />


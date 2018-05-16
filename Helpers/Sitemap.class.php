<?php

/**
 * Sitemap.class [ HELPER ]
 * Classe responável por gerar Sitemaps e RSS feeds para o site e o sistema!
 * @copyright (c) 2014, Robson V. Leite UPINSIDE TECNOLOGIA
 */
class Sitemap
{
    //SITEMAP
    private $Sitemap;
    private $SitemapXml;
    private $SitemapGz;
    private $SitemapPing;

    /**
     * Sitemap constructor.
     * @param bool $Ping
     */
    function __construct($Ping = true)
    {
        //Gera SITEMAP (1X / dia)
        $SiteMapCheck = fopen('sitemap.txt', "a+");
        $SiteMapCheckDate = fgets($SiteMapCheck);
        if ($SiteMapCheckDate != date('Y-m-d')):
            $this->exeSitemap($Ping);
            $SiteMapCheck = fopen('sitemap.txt', "w");
            fwrite($SiteMapCheck, date('Y-m-d'));
            fclose($SiteMapCheck);
        endif;
    }


    private function exeSitemap($Ping)
    {
        $this->SitemapUpdate();
        if ($Ping != false):
            $this->SitemapPing();
        endif;
    }

    private function SitemapUpdate()
    {
        $this->Sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
        $this->Sitemap .= '<?xml-stylesheet type="text/xsl" href="sitemap.xsl"?>' . "\r\n";
        $this->Sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\r\n";

        //HOME
        $this->Sitemap .= '<url>' . "\r\n";
        $this->Sitemap .= '<loc>' . HOME . '</loc>' . "\r\n";
        $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
        $this->Sitemap .= '<changefreq>daily</changefreq>' . "\r\n";
        $this->Sitemap .= '<priority>1.0</priority >' . "\r\n";
        $this->Sitemap .= '</url>' . "\r\n";


        if(file_exists('sitemap.php')){
            require_once 'sitemap.php';
        }

        //CLOSE
        $this->Sitemap .= '</urlset>';

        //CRIA O XML
        $this->SitemapXml = fopen(PASTA_RAIZ . "sitemap.xml", "w+");
        fwrite($this->SitemapXml, $this->Sitemap);
        fclose($this->SitemapXml);

        //CRIA O GZ
        $this->SitemapGz = gzopen(PASTA_RAIZ . "sitemap.xml.gz", 'w9');
        gzwrite($this->SitemapGz, $this->Sitemap);
        gzclose($this->SitemapGz);
    }

    private function SitemapPing()
    {
        $this->SitemapPing = array();
        $this->SitemapPing['g'] = 'https://www.google.com/webmasters/tools/ping?sitemap=' . urlencode(HOME . 'sitemap.xml');
        $this->SitemapPing['b'] = 'https://www.bing.com/webmaster/ping.aspx?siteMap=' . urlencode(HOME . 'sitemap.xml');

        foreach ($this->SitemapPing as $url):
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            curl_getinfo($ch);
            curl_close($ch);
        endforeach;
    }

}

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

    public function exeSitemap($Ping = true)
    {
        $this->SitemapUpdate();
        if ($Ping != false):
            $this->SitemapPing();
        endif;
    }

    private function SitemapUpdate()
    {
        /** @var ProdutoService $produtoService */
        $produtoService = new ProdutoService();
        $produtos = $produtoService->PesquisaTodos();
        /** @var CategoriaService $categoriaService */
        $categoriaService = new CategoriaService();
        $categorias = $categoriaService->PesquisaTodos();
        /** @var FabricanteService $fabricanteService */
        $fabricanteService = new FabricanteService();
        $fabricantes = $fabricanteService->PesquisaTodos();
        /** @var SegmentoService $segmentoService */
        $segmentoService = new SegmentoService();
        $segmentos = $segmentoService->PesquisaTodos();

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

        if ($produtos):
            // Produtos
            /** @var ProdutoEntidade $produto */
            foreach ($produtos as $produto):
                $this->Sitemap .= '<url>' . "\r\n";
                $this->Sitemap .= '<loc>' . HOME . SITE . '/Produtos/DetalharProduto/' . $produto->getNoProdutoUrlAmigavel() . '</loc>' . "\r\n";
                $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($produto->getDtCadastro())) . '</lastmod>' . "\r\n";
                $this->Sitemap .= '<changefreq>daily</changefreq>' . "\r\n";
                $this->Sitemap .= '<priority>0.9</priority >' . "\r\n";
                $this->Sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;

        if ($categorias):
            // Categorias
            /** @var CategoriaEntidade $categoria */
            foreach ($categorias as $categoria):
                $this->Sitemap .= '<url>' . "\r\n";
                $this->Sitemap .= '<loc>' .  PASTASITE. 'Categorias/ListarCategorias/'. Valida::GeraParametro(CO_FABRICANTE . "/" .
                        $categoria->getCoCategoria()) . '</loc>' . "\r\n";
                $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
                $this->Sitemap .= '<changefreq>weekly</changefreq>' . "\r\n";
                $this->Sitemap .= '<priority>0.8</priority >' . "\r\n";
                $this->Sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;
        if ($fabricantes):
            //Fabricantes
            /** @var FabricanteEntidade $fabricante */
            foreach ($fabricantes as $fabricante):
                $this->Sitemap .= '<url>' . "\r\n";
                $this->Sitemap .= '<loc>' .  PASTASITE. 'Fabricantes/ListarFabricantes/'. Valida::GeraParametro(CO_FABRICANTE . "/" .
                        $fabricante->getCoFabricante()) . '</loc>' . "\r\n";
                $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($fabricante->getDtCadastro())) . '</lastmod>' . "\r\n";
                $this->Sitemap .= '<changefreq>weekly</changefreq>' . "\r\n";
                $this->Sitemap .= '<priority>0.8</priority >' . "\r\n";
                $this->Sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;
        if ($segmentos):
            //Segmentos
            /** @var SegmentoEntidade $segmento */
            foreach ($segmentos as $segmento):
                $this->Sitemap .= '<url>' . "\r\n";
                $this->Sitemap .= '<loc>' .  PASTASITE. 'Segmentos/ListarSegmentos/'. Valida::GeraParametro(CO_SEGMENTO . "/" .
                        $segmento->getCoSegmento()) . '</loc>' . "\r\n";
                $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
                $this->Sitemap .= '<changefreq>weekly</changefreq>' . "\r\n";
                $this->Sitemap .= '<priority>0.7</priority >' . "\r\n";
                $this->Sitemap .= '</url>' . "\r\n";
            endforeach;
        endif;


        //Contatos
        $this->Sitemap .= '<url>' . "\r\n";
        $this->Sitemap .= '<loc>' . HOME . 'web/Institucional/Contatos</loc>' . "\r\n";
        $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
        $this->Sitemap .= '<changefreq>monthly</changefreq>' . "\r\n";
        $this->Sitemap .= '<priority>0.8</priority >' . "\r\n";
        $this->Sitemap .= '</url>' . "\r\n";

        //Sobre Nós
        $this->Sitemap .= '<url>' . "\r\n";
        $this->Sitemap .= '<loc>' . HOME . 'web/Institucional/SobreNos</loc>' . "\r\n";
        $this->Sitemap .= '<lastmod>' . date('Y-m-d\TH:i:sP') . '</lastmod>' . "\r\n";
        $this->Sitemap .= '<changefreq>monthly</changefreq>' . "\r\n";
        $this->Sitemap .= '<priority>0.8</priority >' . "\r\n";
        $this->Sitemap .= '</url>' . "\r\n";

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

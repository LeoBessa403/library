<?php

/**
 * Seo.class [ HELPER ]
 * Classe Responsóvel por montar toda a estrutura de SEO
 *
 * @copyright (c) 2018, Leonardo Bessa
 */
class Seo
{
    private $Url;
    private $Titulo;
    private $Descricao;
    private $Imagem;

    /**
     * Seo constructor.
     * @param UrlAmigavel $url
     */
    function __construct(UrlAmigavel $url)
    {
        $this->geraUrl($url);
        if (!in_array($url::$controller, explode(', ', CONTROLLER_SEO))) {
            $this->geraTitulo($url);
            $this->geraDescricao($url);
            $this->geraImagem();
        } else {
            $this->geraDadosSeo($url);
        }
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->Titulo;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->Descricao;
    }

    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->Imagem;
    }

    /**
     * @param UrlAmigavel $url
     */
    private function geraUrl(UrlAmigavel $url)
    {
        $this->Url = HOME . $url::$modulo . '/' . $url::$controller . '/' . $url::$action;
    }

    /**
     * @param UrlAmigavel $url
     */
    private function geraTitulo(UrlAmigavel $url)
    {
        $this->Titulo = ($url::$controller == 'IndexWeb')
            ? DESC . ' | ' . TITULO_SITE : $url::$controller . ' | ' . DESC;
    }

    /**
     * @param UrlAmigavel $url
     */
    private function geraDescricao(UrlAmigavel $url)
    {
        $this->Descricao = ($url::$controller == 'IndexWeb')
            ? DESC . ' | ' . DESC_SITE : $url::$controller . ' ' . $url::$action . ' | ' . DESC;
    }

    private function geraImagem()
    {
        $imagem = HOME . 'library/Imagens/padrao.jpg';
        if (!file_exists($imagem) && !is_dir($imagem)) {
            $this->Imagem = $imagem;
        } else {
            $this->Imagem = '';
        }
    }

    /**
     * @param UrlAmigavel $url
     */
    private function geraDadosSeo(UrlAmigavel $url)
    {
        $control = $url::$controller;
        $metodo = 'getSeo' . $control;
        $controller = new $control();
        $dadosSeo = $controller->$metodo();
        $this->Imagem = $dadosSeo['imagem'];
        $this->Descricao = Valida::Resumi($dadosSeo['descricao'], 150);
        $this->Titulo = $dadosSeo['titulo'] . ' | ' . DESC;
    }

}
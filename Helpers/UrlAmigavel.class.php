<?php

/**
 * UrlAmigavel.class [ HELPER ]
 * Realização a gestão da dos controladores e metodos a serem executados
 * e pega os Parámetos via GET!
 * @copyright (c) 2014, Leo Bessa
 */
class UrlAmigavel
{
    private static $url;
    private static $explode;
    private static $params;

    /** @var Retorna o valor do Modulo solicitado * */
    public static $modulo;

    /** @var Retorna o valor do Controller solicitado * */
    public static $controller;

    /** @var Retorna o valor do Metodo solicitado * */
    public static $action;

    /** @var array Action Permitidas pra acesso sem validação de usuário */
    public static $ACESSO_PERMITIDO = ['Acessar', 'Registrar'];


    /**
     * RealizaÃ§Ã£o a gestã£o da dos controladores e metodos a serem executados
     * e pega os ParÃ¢metos via GET!
     */
    public function __construct()
    {
        self::setUrl();
        self::setExplode();
        self::setModulo();
        self::setController();
        self::setAction();
        self::setParams();
    }

    /**
     * <b>PegaParametro:</b> Pega todos os parÃªmetros passados pela URL
     * @param STRING $name = Passando o nome do parametro a ser retornado.
     * @return ARRAY Retorna um array de parÃ¢metros ou caso mensione o parÃ¢metro a ser pesquisado
     * retorno com o valor de uma variavel solicitada
     */
    public static function PegaParametro($name = null)
    {
        if ($name != null):
            if (array_key_exists(md5($name), self::$params)):
                return self::$params[md5($name)];
            endif;
        else:
            return self::$params;
        endif;
    }

    /**
     * <b>pegaControllerAction:</b> Gerencia e inicia o controlador e metodo a ser executado
     * @return INCLUDE Retorna a inclusÃ£o do arquivo solicitado.
     * @return Valor padÃ£o para Controller (INDEX) e metodo (INDEX)
     * @return Realiza a InclusÃ£o da View com o mesmo nome da action dentro da Pasta View.
     * Ex.: <br>Nome do Arquivo <b>cadastro.View.php</b>
     */
    public function pegaControllerAction()
    {
        $erro_404 = false;
        if (self::$modulo != SITE && self::$action != "Index" && self::$controller != "Index"):
            if (!Valida::ValPerfil(self::$action)):
                self::$action = "Index";
                self::$controller = "Index";
                $erro_404 = true;
            endif;
        endif;


        if (self::$modulo != SITE && self::$modulo != ADMIN):
            self::$modulo = "web";
            self::$controller = "IndexWeb";
            self::$action = "Index";
            $erro_404 = true;
        endif;

        if (self::$controller == ""):
            self::$controller = "IndexWeb";
            self::$action = "Index";
        elseif (self::$action == ""):
            self::$action = "Index";
        endif;

        $controller_path = self::$modulo . "/Controller/" . self::$controller . '.Controller.php';
        if ((!file_exists($controller_path)) && (!file_exists("Controller/" . self::$controller . '.Controller.php'))):
            self::$controller = "IndexWeb";
            self::$action = "Index";
            $erro_404 = true;
        endif;

        $controller_path = self::$modulo . "/Controller/" . self::$controller . '.Controller.php';

        if (!file_exists($controller_path)):
            $controller_path = "Controller/" . self::$controller . '.Controller.php';
        endif;

        require_once($controller_path);
        $app = new self::$controller();


        if (!method_exists($app, self::$action)):
            self::$action = "Index";
            $erro_404 = true;
        endif;

        if (self::$modulo == ADMIN):
            // VALIDAÇÃO POR PERFIL REFAZER PRA NOVA ENTIDADE
            if (!Valida::ValPerfil(self::$action) && !in_array(self::$action, self::$ACESSO_PERMITIDO)) :
                self::$action = "Index";
                $erro_404 = true;
            endif;
        endif;

        $action = self::$action;
        $app->$action();

        extract((array)$app);

        if ($erro_404):
            $module = (self::$modulo == SITE) ? 'Web' : '';
            $arquivo_include = 'View/Index'. $module .'/' . ERRO_404 . '.View.php';
            $action = ERRO_404;
        else:
            $arquivo_include = 'View/' . self::$controller . "/" . self::$action . '.View.php';
            $action = self::$action;
        endif;
        if (file_exists($arquivo_include) && !is_dir($arquivo_include)):
            include $arquivo_include;
        elseif (file_exists(self::$modulo . "/" . $arquivo_include) && !is_dir(self::$modulo . "/" . $arquivo_include)):
            include self::$modulo . "/" . $arquivo_include;
        else:
            Valida::Mensagem("A View <b>" . self::$modulo . "/" . self::$controller . "/" .
                $action . ".View.php</b> não foi encontrada!", 3);
        endif;
    }


    /**
     * <b>Usada para Gerar o Menu da Aplicação</b>
     * @return STRING = Menu.
     */
    public function GeraMenu(array $menu)
    {
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
            foreach ($montando[$key] as $res) :
                if ($controle > 0):
                    if (Valida::ValPerfil($res)) :
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
                foreach ($montando[$key] as $result) {
                    if ($cout > 0):
                        $titulo_menu = str_replace($titulo[0], "", $result);
                        if (Valida::ValPerfil($result)):
                            echo '<li>
                                                        <a href="' . PASTAADMIN . $titulo[0] . '/' . $result . '">
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

    /*************************/
    /**** METODOS PRIVADOS ***/
    /*************************/

    private static function setUrl()
    {
        $url = (isset($_GET['url']) && $_GET['url'] != "" ? $_GET['url'] : "web/IndexWeb/Index");
        $url = $url;
        self::$url = $url . '/';
    }

    private static function setExplode()
    {
        self::$explode = explode('/', self::$url);
    }

    private static function setModulo()
    {
        self::$modulo = self::$explode[0];
    }

    private static function setController()
    {
        self::$controller = self::$explode[1];
    }

    private static function setAction()
    {
        $ac = (!isset(self::$explode[2]) || self::$explode[2] == null || self::$explode[2] == 'Index' ? 'Index' : self::$explode[2]);
        self::$action = $ac;
    }

    private static function setParams()
    {
        unset(self::$explode[0], self::$explode[1], self::$explode[2]);
        array_pop(self::$explode);

        if (end(self::$explode) == null)
            array_pop(self::$explode);

        if (!empty(self::$explode[3])):
            self::$explode = base64_decode(self::$explode[3]);
            self::$explode = explode("/", self::$explode);
            self::$explode[1] = base64_decode(self::$explode[1]);
        endif;


        $i = 0;
        $ind = array();
        $value = array();
        if (!empty (self::$explode)) {
            foreach (self::$explode as $val) {
                if ($i % 2 == 0) {
                    $ind[] = $val;
                } else {
                    $value[] = $val;
                }
                $i++;
            }
        } else {
            $ind = array();
            $value = array();
        }
        if (count($ind) == count($value) && !empty($ind) && !empty($value))
            self::$params = array_combine($ind, $value);
        else
            self::$params = array();

    }
}
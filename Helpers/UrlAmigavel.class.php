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

    /** @var String Retorna o valor do Modulo solicitado * */
    public static $modulo;

    /** @var String Retorna o valor do Controller solicitado * */
    public static $controller;

    /** @var String Retorna o valor do Metodo solicitado * */
    public static $action;

    /** @var array Action Permitidas pra acesso sem validação de usuário */
    public static $ACESSO_PERMITIDO = ['Acessar', 'Registrar', 'RecuperarSenha', 'AtivacaoUsuario'];

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
     * @return ArrayAccess Retorna um array de parÃ¢metros ou caso mensione o parÃ¢metro a ser pesquisado
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
        return null;
    }

    /**
     * @return mixed
     */
    public static function PegaParametroUrlAmigavel()
    {
        if (!empty(self::$explode[3])) {
            return self::$explode[3];
        } else {
            return false;
        }
    }

    /**
     * <b>pegaControllerAction:</b> Gerencia e inicia o controlador e metodo a ser executado
     * INCLUDE Retorna a inclusÃ£o do arquivo solicitado.
     * Valor padÃ£o para Controller (INDEX) e metodo (INDEX)
     * Realiza a InclusÃ£o da View com o mesmo nome da action dentro da Pasta View.
     * Ex.: <br>Nome do Arquivo <b>cadastro.View.php</b>
     */
    public function pegaControllerAction()
    {
        $erro_404 = false;
        if (self::$modulo != SITE && self::$action != ACTION_INICIAL_ADMIN &&
            self::$controller != CONTROLLER_INICIAL_ADMIN):
            if (!Valida::ValPerfil(self::$action)):
                self::$action = ACTION_INICIAL_ADMIN;
                self::$controller = CONTROLLER_INICIAL_ADMIN;
                $erro_404 = true;
            endif;
        endif;


        if (self::$modulo != SITE && self::$modulo != ADMIN):
            self::$modulo = SITE;
            self::$controller = CONTROLLER_INICIAL_SITE;
            self::$action = ACTION_INICIAL_SITE;
            $erro_404 = true;
        endif;

        if (self::$controller == ""):
            self::$controller = CONTROLLER_INICIAL_SITE;
            self::$action = ACTION_INICIAL_SITE;
        elseif (self::$action == ""):
            self::$action = ACTION_INICIAL_SITE;
        endif;

        $controller_path = self::$modulo . "/Controller/" . self::$controller . '.Controller.php';
        if ((!file_exists($controller_path)) &&
            (!file_exists("Controller/" . self::$controller . '.Controller.php')) &&
            (!file_exists("library/Controller/" . self::$controller . '.Controller.php'))):
            self::$controller = (self::$modulo == ADMIN) ? CONTROLLER_INICIAL_ADMIN : CONTROLLER_INICIAL_SITE;
            self::$action = (self::$modulo == ADMIN) ? ACTION_INICIAL_ADMIN : ACTION_INICIAL_SITE;
            $erro_404 = true;
        endif;

        $controller_path = self::$modulo . "/Controller/" . self::$controller . '.Controller.php';

        if (!file_exists($controller_path)):
            $controller_path = "library/Controller/" . self::$controller . '.Controller.php';
        endif;

        require_once($controller_path);
        $app = new self::$controller();

        if (!method_exists($app, self::$action)):
            self::$action = (self::$modulo == ADMIN) ? ACTION_INICIAL_ADMIN : ACTION_INICIAL_SITE;
            $erro_404 = true;
        endif;

        if (self::$modulo == ADMIN && !$erro_404):
            // VALIDAÇÃO POR PERFIL REFAZER PRA NOVA ENTIDADE
            if (!Valida::ValPerfil(self::$action) && !in_array(self::$action, self::$ACESSO_PERMITIDO)) :
                self::$action = ACTION_INICIAL_ADMIN;
                $erro_404 = true;
            endif;
        endif;

        if (method_exists($app, self::$action)):
            $action = self::$action;
            $app->$action();
        endif;

        extract((array)$app);
        $actAux = self::$action;

        if ($erro_404):
            $module = (self::$modulo == SITE) ? CONTROLLER_INICIAL_SITE : CONTROLLER_INICIAL_ADMIN;
            $arquivo_include = 'View/' . $module . '/' . ERRO_404 . '.View.php';
        else:
            $arquivo_include = 'View/' . self::$controller . "/" . self::$action . '.View.php';
        endif;
        if (file_exists($arquivo_include) && !is_dir($arquivo_include)):
            include $arquivo_include;
        elseif (file_exists(self::$modulo . "/" . $arquivo_include) && !is_dir(self::$modulo . "/" . $arquivo_include)):
            include self::$modulo . "/" . $arquivo_include;
        elseif (file_exists("library/" . $arquivo_include) && !is_dir("library/" . $arquivo_include)):
            include "library/" . $arquivo_include;
        else:
            Notificacoes::mesagens("A View <b>" . self::$modulo . "/" . self::$controller . "/" .
                $actAux . ".View.php</b> não foi encontrada!",
                TiposMensagemEnum::ERRO);
        endif;
    }

    /**
     * <b>Usada para Gerar o Menu da Aplicação</b>
     */
    public function GeraMenu()
    {
        /** @var ControllerService $controllerService */
        $controllerService = new ControllerService();
        $controllers = $controllerService->PesquisaTodos();

        $ativo = UrlAmigavel::$controller;

        echo '<ul class="main-navigation-menu">';
        if ($ativo == ACTION_INICIAL_ADMIN):
            echo '<li class="active">';
        else:
            echo '<li>';
        endif;
        echo '<a href="' . PASTAADMIN . 'Index/Index"><i class="clip-home-3"></i>
                                   <span class="title"> PÁGINA INICIAL  </span><span class="selected"></span>
                           </a>
                   </li>';
        if (TEM_SITE) {
            echo '<li>
                           <a href="' . HOME . '" target="_blank"><i class="clip-cog-2"></i>
                                   <span class="title"> SITE </span><span class="selected"></span>
                           </a>
                   </li>';
        }
        /** @var ControllerEntidade $controller */
        foreach ($controllers as $controller) {
            $titulo = $controller->getNoController();
            $tem = false;
            if (!empty($controller->getCoFuncionalidade())) {
                /** @var FuncionalidadeEntidade $func */
                foreach ($controller->getCoFuncionalidade() as $func) :
                    if ($func->getStMenu() == SimNaoEnum::SIM):
                        if (Valida::ValPerfil($func->getDsAction())) :
                            $tem = true;
                            break;
                        endif;
                    endif;
                endforeach;
            }
            if(($titulo == 'Assinante' || $titulo == 'Plano') && (!MODULO_ASSINANTE)){
                $tem = false;
            }
            if($titulo == 'Visita' && !TEM_SITE){
                $tem = false;
            }
            if ($tem):
                if ($ativo == $titulo):
                    echo '<li class="active">';
                else:
                    echo '<li>';
                endif;
                echo '<a href="javascript:void(0)"><i class="' . $controller->getDsClassIcon() . '"></i>
                                       <span class="title"> ' . $titulo . ' </span><i class="icon-arrow"></i>
                                       <span class="selected"></span>
                               </a>
                               <ul class="sub-menu" style="display: none;">';
                /** @var FuncionalidadeEntidade $func */
                foreach ($controller->getCoFuncionalidade() as $func) {
                    $titulo_menu = str_replace($titulo, "", $func->getNoFuncionalidade());
                    if (Valida::ValPerfil($func->getDsAction()) && $func->getStMenu() == SimNaoEnum::SIM):
                        echo '<li>
                                    <a href="' . PASTAADMIN . $titulo . '/' . $func->getDsAction() . '">
                                            <span class="title"> ' . $titulo_menu . ' </span>
                                    </a>
                                 </li>';
                    endif;
                }
                echo '</ul>
                       </li>';
            endif;
        }
        echo '</ul>';

    }

    public static function getLink()
    {
        $link = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        return str_replace(str_replace(array('http://', 'https://'), '', HOME), '', $link);
    }

    /*************************/
    /**** METODOS PRIVADOS ***/
    /*************************/
    private static function setUrl()
    {
        $link = static::getLink();
        $url = (isset($link) && $link != "" ? $link :
            Redireciona(SITE . "/" . CONTROLLER_INICIAL_SITE . "/" . ACTION_INICIAL_SITE));
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
        $act = (self::$modulo == ADMIN) ? ACTION_INICIAL_ADMIN : ACTION_INICIAL_SITE;
        $ac = (!isset(self::$explode[2]) || self::$explode[2] == null || self::$explode[2] == $act
            ? $act : self::$explode[2]);
        self::$action = $ac;
    }

    private static function setParams()
    {
        unset(self::$explode[0], self::$explode[1], self::$explode[2]);
        array_pop(self::$explode);

        if (end(self::$explode) == null) {
            array_pop(self::$explode);
        }

        $controller_url_amigavel = explode(', ', CONTROLLER_SEO);
        if (!empty(self::$explode[3])):
            if (!in_array(self::$controller, $controller_url_amigavel)) {
                self::$explode = base64_decode(self::$explode[3]);
                self::$explode = explode("/", self::$explode);
                if (!empty(self::$explode[1])) {
                    self::$explode[1] = base64_decode(self::$explode[1]);
                } else {
                    self::$explode[1] = null;
                }
                if (!empty(self::$explode[3])) {
                    self::$explode[3] = base64_decode(self::$explode[3]);
                }
                if (!empty(self::$explode[5])) {
                    self::$explode[5] = base64_decode(self::$explode[5]);
                }
                if (!empty(self::$explode[7])) {
                    self::$explode[7] = base64_decode(self::$explode[7]);
                }
            }
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
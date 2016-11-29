<?php
/**
 * UrlAmigavel.class [ HELPER ]
 * Realização a gestão da dos controladores e metodos a serem executados
 * e pega os Parámetos via GET!
 * @copyright (c) 2014, Leo Bessa
 */
  class UrlAmigavel{
        private static $url;
        private static $explode;
        private static $params;
        
        /** @var Retorna o valor do Modulo solicitado **/
        public static $modulo;
        
        /** @var Retorna o valor do Controller solicitado **/
        public static $controller;
        
        /** @var Retorna o valor do Metodo solicitado **/
        public static $action;
      
        
       /**
        * RealizaÃ§Ã£o a gestã£o da dos controladores e metodos a serem executados
        * e pega os ParÃ¢metos via GET!       
        */
        public function  __construct(){
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
        public static function PegaParametro( $name = null ){
            if ( $name != null ):
                if(array_key_exists(md5($name), self::$params)):
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
        public function pegaControllerAction(){
            $erro_404 = false;
            if(self::$modulo != SITE && self::$action != "Index" && self::$controller != "Index"):
                if(!Valida::ValPerfil( self::$action )):
                    self::$action     = "Index";
                    self::$controller = "Index";
                    $erro_404 = true;
                endif;
            endif;


            if(self::$modulo != SITE && self::$modulo != ADMIN):
                self::$modulo = "web";
                self::$controller = "Index";
                self::$action = "Index";
                $erro_404 = true;
            endif;

            if(self::$controller == ""):
                self::$controller = "Index";
                self::$action = "Index";
            elseif(self::$action == ""):
                self::$action = "Index";
            endif;

            $controller_path = self::$modulo."/Controller/" . self::$controller . '.Controller.php';
            if((!file_exists($controller_path)) && (!file_exists("Controller/" . self::$controller . '.Controller.php'))):
                self::$controller = "Index";
                self::$action = "Index";
                $erro_404 = true;
            endif;

            $controller_path = self::$modulo."/Controller/" . self::$controller . '.Controller.php';

            if(!file_exists($controller_path)):
                $controller_path = "Controller/" . self::$controller . '.Controller.php';
            endif;

            require_once($controller_path);
            $app = new self::$controller();


            if( !method_exists($app, self::$action) ):
                self::$action = "Index";
                $erro_404 = true;
            endif;

            if(self::$modulo == ADMIN):
                // VALIDAÇÃO POR PERFIL REFAZER PRA NOVA ENTIDADE
                if(!Valida::ValPerfil(self::$action) && self::$action != 'Acessar'):
                    self::$action = "Index";
                    $erro_404 = true;
                endif;
            endif;

            $action = self::$action;
            $app->$action();

            extract((array) $app);

            if($erro_404):
                $arquivo_include = 'View/Index/'.ERRO_404.'.View.php';
                $action = ERRO_404;
            else:
                $arquivo_include = 'View/'. self::$controller ."/".self::$action.'.View.php';
                $action = self::$action;
           endif;
           if (file_exists($arquivo_include) && !is_dir($arquivo_include)):
               include $arquivo_include;
           elseif (file_exists(self::$modulo."/".$arquivo_include) && !is_dir(self::$modulo."/".$arquivo_include)):
               include self::$modulo."/".$arquivo_include;
           else:
               Valida::Mensagem("A View <b>".$action.".View.php</b> no Módulo <b>".self::$modulo."</b> não foi encontrada!", 3);
           endif;            
        }
        
        /*************************/
        /**** METODOS PRIVADOS ***/
        /*************************/
        
         private static function setUrl(){
            $url = (isset($_GET['url']) && $_GET['url'] != "" ? $_GET['url'] : "web/Index/Index");
            $url = $url;
            self::$url = $url.'/';
        }

        private static function setExplode(){
            self::$explode = explode( '/' , self::$url );
        }
        
        private static function setModulo(){
            self::$modulo = self::$explode[0];
        }
        
        private static function setController(){
            self::$controller = self::$explode[1];
        }    
        
        private static function setAction(){
            $ac = (!isset(self::$explode[2]) || self::$explode[2] == null || self::$explode[2] == 'Index' ? 'Index' : self::$explode[2]);
            self::$action = $ac;
        }

        private static function setParams(){  
            unset( self::$explode[0], self::$explode[1], self::$explode[2] );
                array_pop( self::$explode );

            if ( end( self::$explode ) == null )
                array_pop( self::$explode );
            
            if(!empty(self::$explode[3])):
                self::$explode = base64_decode(self::$explode[3]);
                self::$explode = explode("/", self::$explode);
                self::$explode[1] = base64_decode(self::$explode[1]);
            endif;
           
            
            $i = 0;
            $ind = array(); 
            $value = array();
            if( !empty (self::$explode) ){
                foreach ( self::$explode as $val ){
                    if ( $i % 2 == 0 ){
                        $ind[] = $val;
                    }else{
                        $value[] = $val;
                    }
                    $i++;
                }
            }else{
                $ind = array();
                $value = array();
            }
            if( count($ind) == count($value) && !empty($ind) && !empty($value) )
                self::$params = array_combine($ind, $value);
            else
                self::$params = array();      
            
        }
    }
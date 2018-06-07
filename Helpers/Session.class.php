<?php

/**
 * Session.class [ HELPER ]
 * Classe Responsóvel pelas sessões e cookies do sistema!
 *
 * @copyright (c) 2014, Leonardo Bessa
 */
class Session
{

    private $acesso;


    /**
     * <b>Atribui a uma Session:</b> Cria uma session e atribui um valor
     * @param STRING $name : atribui o nome da Session
     * @param VALOR ou ARRAY $valor: atribui o valor para a Session ou Cria uma session que armazena vários dados para array
     * Ex.: $_SESSION[$name][$key] = $value
     */
    public function setSession($name, $valor)
    {
        if (is_array($valor)):
            if (!$this->CheckSession($name)):
                $_SESSION[$name] = "";
            endif;
            foreach ($valor as $key => $value) {
                $_SESSION[$name][$key] = $value;
            }
        else:
            $_SESSION[$name] = $valor;
        endif;
    }

    public function setUser($user)
    {
        $usuario = "";
        foreach ($user as $key => $value) {
            $usuario .= md5($key) . ";=/" . base64_encode($value) . ";==/";
        }
        $this->acesso = $usuario;
        $this->setSession(SESSION_USER, $this);
    }

    public function setUserUltimoAcesso($acesso)
    {
        $user = $this->getUser();
        $user[md5(DT_FIM_ACESSO)] = $acesso;
        $usuario = "";
        foreach ($user as $key => $value) {
            $usuario .= $key . ";=/" . base64_encode($value) . ";==/";
        }
        $this->acesso = $usuario;
        $this->setSession(SESSION_USER, $this);
    }

    public function getUser()
    {
        $tamanho = strlen($this->acesso);
        $usuario = substr($this->acesso, 0, $tamanho - 4);

        $user = explode(";==/", $usuario);
        $us = array();
        foreach ($user as $value) {
            $user2 = explode(";=/", $value);
            $us[$user2[0]] = base64_decode($user2[1]);
        }
        return $us;
    }

    /**
     * <b>Pega uma Session:</b> Retorna o valor de uma Session
     * @param STRING $name : O nome da Session a ser verificada
     * @return STRING O valor da Session pesquisada ou FALSE caso não existe ou tenha o valor em branco da Session
     */
    public static function getSession($name, $segundo_indice = null)
    {
        if (self::CheckSession($name)):
            if (is_array($_SESSION[$name]) && $segundo_indice != null):
                if (!empty($_SESSION[$name][$segundo_indice])):
                    return $_SESSION[$name][$segundo_indice];
                else:
                    return false;
                endif;
            else:
                return $_SESSION[$name];
            endif;
        else:
            return false;
        endif;
    }


    /**
     * <b>Verifica a Session:</b> Verifica se uma Sessão existe e se tem valor
     * @param STRING $name : O nome da Session a ser verificada
     * @return BOOL TRUE para existe e tem valor e FALSE para não existe ou não tem um valor
     */
    public static function CheckSession($name)
    {
        if (!empty($_SESSION[$name])):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * <b>Finaliza a Session:</b> Responsável por finalizar uma Session
     * @param STRING $name : O nome da Session a ser finalizada
     */
    public function FinalizaSession($name)
    {
        if ($this->CheckSession($name)):
            unset($_SESSION[$name]);
        else:
            Valida::Mensagem("A Sessão informada não existe!", 3);
        endif;

    }

    /**
     * <b>Atribui um Cookie:</b> Cria um Cookie e atribui um valor
     * @param STRING $name : atribui o nome do Cookie
     * @param STRING $valor : atribui o valor para o Cookie
     * @param INT $time : Valor inteiro em minutos de duração para o Cookie, <i>Valor padrão 20</i>;
     */
    public static function setCookie($name, $valor, $time = 20)
    {
        setcookie($name, $valor, (time() + ($time * 60)));
    }

    /**
     * <b>Pega um Cookie:</b> Retorna o valor de um Cookie
     * @param STRING $name : O nome do Cookie a ser verificada
     * @return STRING O valor do Cookie pesquisado ou FALSE caso não existe ou tenha o valor em branco do Cookie
     */
    public static function getCookie($name = null)
    {
        if (self::CheckCookie($name)):
            return $_COOKIE[$name];
        else:
            return $_COOKIE;
        endif;
    }

    /**
     * <b>Verifica o Cookie:</b> Verifica se um Cookie existe e se tem valor
     * @param STRING $name : O nome do Cookie a ser verificado
     * @return BOOL TRUE para existe e tem valor e FALSE para não existe ou não tem um valor
     */
    public static function CheckCookie($name)
    {
        if (!empty($_COOKIE[$name])):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * <b>Finaliza o Cookie:</b> Responsável por finalizar um Cookie
     * @param STRING $name : O nome do Cookie a ser finalizado
     */
    public static function FinalizaCookie($name)
    {
        if (self::CheckCookie($name)):
            setcookie($name);
        else:
            Valida::Mensagem("O Cookie informado não existe!", 3);
        endif;
    }

}
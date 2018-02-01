<?php


class ObjetoPDO extends Conn {

    public static $ObjetoPDO;

    function __construct()
    {
        $this->getConexao();
    }

    /** Retorna um objeto PDO Singleton Pattern. */
    protected function getConexao() {
        self::$ObjetoPDO = self::getConn();
    }

}

<?php

/**
 * Funcionalidade.Entidade [ ENTIDADE ]
 * @copyright (c) 2017, Leo Bessa
 */

class FuncionalidadeEntidade extends AbstractEntidade
{
    const TABELA = 'TB_FUNCIONALIDADE';
    const ENTIDADE = 'FuncionalidadeEntidade';
    const CHAVE = CO_FUNCIONALIDADE;

    private $co_funcionalidade;
    private $no_funcionalidade;
    private $st_status;
    private $st_menu;
    private $ds_action;
    private $co_perfil_funcionalidade;
    private $co_controller;

    /**
     * @return array
     */
    public static function getCampos()
    {
        return [
            CO_FUNCIONALIDADE,
            NO_FUNCIONALIDADE,
            ST_STATUS,
            ST_MENU,
            DS_ACTION,
            CO_CONTROLLER,
        ];

    }

    /**
     * @return array $relacionamentos
     */
    public static function getRelacionamentos()
    {
        $relacionamentos = Relacionamentos::getRelacionamentos();
        return $relacionamentos[static::TABELA];
    }


    /**
     * @return int $co_funcionalidade
     */
    public function getCoFuncionalidade()
    {
        return $this->co_funcionalidade;
    }

    /**
     * @param $co_funcionalidade
     * @return mixed
     */
    public function setCoFuncionalidade($co_funcionalidade)
    {
        return $this->co_funcionalidade = $co_funcionalidade;
    }

    /**
     * @return mixed $no_funcionalidade
     */
    public function getNoFuncionalidade()
    {
        return $this->no_funcionalidade;
    }

    /**
     * @param $no_funcionalidade
     * @return mixed
     */
    public function setNoFuncionalidade($no_funcionalidade)
    {
        return $this->no_funcionalidade = $no_funcionalidade;
    }

    /**
     * @return mixed
     */
    public function getDsAction()
    {
        return $this->ds_action;
    }

    /**
     * @param mixed $ds_action
     */
    public function setDsAction($ds_action)
    {
        $this->ds_action = $ds_action;
    }

    /**
     * @return mixed $st_status
     */
    public function getStStatus()
    {
        return $this->st_status;
    }

    /**
     * @param $st_status
     * @return mixed
     */
    public function setStStatus($st_status)
    {
        return $this->st_status = $st_status;
    }

    /**
     * @return mixed $st_menu
     */
    public function getStMenu()
    {
        return $this->st_menu;
    }

    /**
     * @param $st_menu
     * @return mixed
     */
    public function setStMenu($st_menu)
    {
        $this->st_menu = $st_menu;
    }

    /**
     * @return PerfilFuncionalidadeEntidade $co_perfil_funcionalidade
     */
    public function getCoPerfilFuncionalidade()
    {
        return $this->co_perfil_funcionalidade;
    }

    /**
     * @param $co_perfil_funcionalidade
     * @return mixed
     */
    public function setCoPerfilFuncionalidade($co_perfil_funcionalidade)
    {
        return $this->co_perfil_funcionalidade = $co_perfil_funcionalidade;
    }

    /**
     * @return ControllerEntidade $co_controller
     */
    public function getCoController()
    {
        return $this->co_controller;
    }

    /**
     * @param $co_controller
     * @return mixed
     */
    public function setCoController($co_controller)
    {
        $this->co_controller = $co_controller;
    }

}
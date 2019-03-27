<?php

/**
 * Controller.Entidade [ ENTIDADE ]
 * @copyright (c) 2019, Leo Bessa
 */

class ControllerEntidade extends AbstractEntidade
{
	const TABELA = 'TB_CONTROLLER';
	const ENTIDADE = 'ControllerEntidade';
	const CHAVE = CO_CONTROLLER;

	private $co_controller;
    private $no_controller;
    private $ds_class_icon;
    private $co_funcionalidade;


    /**
    * @return array
    */
	public static function getCampos() 
    {
    	return [
			CO_CONTROLLER,
			NO_CONTROLLER,
			DS_CLASS_ICON,
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
	* @return int $co_controller
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
        return $this->co_controller = $co_controller;
    }

	/**
	* @return mixed $no_controller
    */
	public function getNoController()
    {
        return $this->no_controller;
    }

	/**
	* @param $no_controller
    * @return mixed
    */
	public function setNoController($no_controller)
    {
        return $this->no_controller = $no_controller;
    }

	/**
	* @return mixed $ds_class_icon
    */
	public function getDsClassIcon()
    {
        return $this->ds_class_icon;
    }

	/**
	* @param $ds_class_icon
    * @return mixed
    */
	public function setDsClassIcon($ds_class_icon)
    {
        return $this->ds_class_icon = $ds_class_icon;
    }


    /**
     * @return FuncionalidadeEntidade $co_funcionalidade
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
        $this->co_funcionalidade = $co_funcionalidade;
    }



}
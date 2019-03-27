<?php

/**
 * PerfilModel.class [ MODEL ]
 * @copyright (c) 2017, Leo Bessa
 */
class  PerfilModel extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(PerfilEntidade::ENTIDADE);
    }

    public function Deleta($coPerfil)
    {
        return parent::Deleta($coPerfil);
    }
}
<?php

/**
 * PerfilService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PerfilService extends AbstractService
{
    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(PerfilEntidade::ENTIDADE);
        $this->ObjetoModel = New PerfilModel();
    }

    public static function montaComboTodosPerfis()
    {
        /** @var PerfilService $perfilService */
        $perfilService = new PerfilService();
        $Perfis = $perfilService->PesquisaTodos();
        $todosPerfis = array();
        /** @var PerfilEntidade $perfil */
        foreach ($Perfis as $perfil) :
            if ($perfil->getCoPerfil() > 1)
                $todosPerfis[$perfil->getCoPerfil()] = $perfil->getNoPerfil();
        endforeach;
        return $todosPerfis;
    }

    public static function montaComboPerfil(UsuarioEntidade $usuario)
    {
        $meusPerfis = array();
        if ($usuario->getCoUsuarioPerfil()) {
            /** @var UsuarioPerfilEntidade $perfil */
            foreach ($usuario->getCoUsuarioPerfil() as $perfil) :
                $meusPerfis[$perfil->getCoPerfil()->getCoPerfil()] = $perfil->getCoPerfil()->getNoPerfil();
            endforeach;
        }
        return $meusPerfis;
    }

    public static function montaArrayPerfil(UsuarioEntidade $usuario)
    {
        $meusPerfis = array();
        if ($usuario->getCoUsuarioPerfil()) {
            /** @var UsuarioPerfilEntidade $perfil */
            foreach ($usuario->getCoUsuarioPerfil() as $perfil) :
                $meusPerfis[] = $perfil->getCoPerfil()->getCoPerfil();
            endforeach;
        }
        return $meusPerfis;
    }

    public function salvaPerfil($dados)
    {
        /** @var PerfilFuncionalidadeService $perfilFuncionalidadeService */
        $perfilFuncionalidadeService = $this->getService(PERFIL_FUNCIONALIDADE_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $session = new Session();

        $perfil[NO_PERFIL] = trim($dados[NO_PERFIL]);

        $PDO->beginTransaction();
        if (!empty($_POST[CO_PERFIL])):
            $coPerfil = $dados[CO_PERFIL];
            $atualiza = $this->Salva($perfil, $coPerfil);
            if ($atualiza):
                $perfilFuncional[CO_PERFIL] = $coPerfil;
                $perfilFuncionalidadeService->DeletaQuando($perfilFuncional);
                $session->setSession(MENSAGEM, ATUALIZADO);
            endif;
        else:
            $coPerfil = $this->Salva($perfil);
            if ($coPerfil):
                $session->setSession(MENSAGEM, CADASTRADO);
            endif;
        endif;
        if ($coPerfil) {
            $perfilFunc[CO_PERFIL] = $coPerfil;
            foreach ($dados[CO_FUNCIONALIDADE] as $coFuncionalidade) {
                $perfilFunc[CO_FUNCIONALIDADE] = $coFuncionalidade;
                $perfilFuncionalidadeService->Salva($perfilFunc);
            }
            $retorno[SUCESSO] = true;
        }
        if ($retorno[SUCESSO]) {
            $PDO->commit();
        } else {
            $session->setSession(MENSAGEM, 'Não foi possível Salvar o Perfil');
            $PDO->rollBack();
        }
        return $retorno;
    }

}
<?php

/**
 * FuncionalidadeService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  FuncionalidadeService extends AbstractService
{
    private $ObjetoModel;

    public function __construct()
    {
        parent::__construct(FuncionalidadeEntidade::ENTIDADE);
        $this->ObjetoModel = New FuncionalidadeModel();
    }

    public static function montaComboTodosFuncionalidades()
    {
        /** @var FuncionalidadeService $funcionalidadeService */
        $funcionalidadeService = new FuncionalidadeService();

        $funcionalidades = $funcionalidadeService->PesquisaTodos();
        $todasFunc = array();
        $bloqueioFunc = array();
        $coAssinante = AssinanteService::getCoAssinanteLogado();
        if($coAssinante){
            $bloqueioFunc = array(0,1,2,3,4,7,8,9);
        }
        /** @var FuncionalidadeEntidade $func */
        foreach ($funcionalidades as $func) :
            $coController = ($func->getCoController()) ? $func->getCoController()->getCoController() : 0;
            if(!in_array($coController,$bloqueioFunc)){
                $todasFunc[$func->getCoFuncionalidade()] = $func->getNoFuncionalidade();
            }
        endforeach;
        return $todasFunc;
    }

    public function salvaFuncionalidade($dados)
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

        $funcionalidade[NO_FUNCIONALIDADE] = trim($dados[NO_FUNCIONALIDADE]);
        $funcionalidade[DS_ACTION] = trim($dados[DS_ACTION]);
        $funcionalidade[ST_MENU] = (!empty($dados[ST_MENU])) ? SimNaoEnum::SIM : SimNaoEnum::NAO;

        $PDO->beginTransaction();
        if (!empty($dados['nova_controller'])):
            /** @var ControllerService $controllerService */
            $controllerService = $this->getService(CONTROLLER_SERVICE);
            $controller[NO_CONTROLLER] = trim($dados[NO_CONTROLLER]);
            $controller[DS_CLASS_ICON] = trim($dados[DS_CLASS_ICON]);
            $funcionalidade[CO_CONTROLLER] = $controllerService->Salva($controller);
        else:
            $funcionalidade[CO_CONTROLLER] = $dados[CO_CONTROLLER][0];
        endif;
        if (!empty($_POST[CO_FUNCIONALIDADE])):
            $coFuncionalidade = $dados[CO_FUNCIONALIDADE];
            $atualiza = $this->Salva($funcionalidade, $coFuncionalidade);
            if ($atualiza):
                $perfilFuncional[CO_FUNCIONALIDADE] = $coFuncionalidade;
                $perfilFuncionalidadeService->DeletaQuando($perfilFuncional);
                $session->setSession(MENSAGEM, ATUALIZADO);
            endif;
        else:
            $funcionalidade[ST_STATUS] = StatusAcessoEnum::ATIVO;
            $coFuncionalidade = $this->Salva($funcionalidade);
            if ($coFuncionalidade):
                $session->setSession(MENSAGEM, CADASTRADO);
            endif;
        endif;
        if ($coFuncionalidade) {
            if(!empty($dados[CO_PERFIL])){
                $perfilFunc[CO_FUNCIONALIDADE] = $coFuncionalidade;
                foreach ($dados[CO_PERFIL] as $coPerfil) {
                    $perfilFunc[CO_PERFIL] = $coPerfil;
                    $perfilFuncionalidadeService->Salva($perfilFunc);
                }
            }
            $retorno[SUCESSO] = true;
        }
        if ($retorno[SUCESSO]) {
            $PDO->commit();
        } else {
            $session->setSession(MENSAGEM, 'Não foi possível Salvar a Funcionalidade');
            $PDO->rollBack();
        }
        return $retorno;
    }

}
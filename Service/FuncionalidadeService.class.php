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
        /** @var FuncionalidadeEntidade $func */
        foreach ($funcionalidades as $func) :
            $todasFunc[$func->getCoFuncionalidade()] = $func->getNoFuncionalidade();
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

        $PDO->beginTransaction();
        if (!empty($_POST[CO_FUNCIONALIDADE])):
            $coFuncionalidade = $dados[CO_FUNCIONALIDADE];
            $atualiza = $this->Salva($funcionalidade, $coFuncionalidade);
            if ($atualiza):
                $perfilFuncional[CO_FUNCIONALIDADE] = $coFuncionalidade;
                $perfilFuncionalidadeService->DeletaQuando($perfilFuncional);
                $retorno[MSG] = Mensagens::OK_ATUALIZADO;
                $session->setSession(ATUALIZADO, "OK");
            endif;
        else:
            $coFuncionalidade = $this->Salva($funcionalidade);
            if ($coFuncionalidade):
                $retorno[MSG] = Mensagens::OK_SALVO;
                $session->setSession(CADASTRADO, "OK");
            endif;
        endif;
        if ($coFuncionalidade) {
            $perfilFunc[CO_FUNCIONALIDADE] = $coFuncionalidade;
            foreach ($dados[CO_PERFIL] as $coPerfil) {
                $perfilFunc[CO_PERFIL] = $coPerfil;
                $perfilFuncionalidadeService->Salva($perfilFunc);
            }
            $retorno[SUCESSO] = true;
        }
        if ($retorno[SUCESSO]) {
            $PDO->commit();
        } else {
            $retorno[MSG] = 'Não foi possível Salvar a Funcionalidade';
            $PDO->rollBack();
        }
        return $retorno;
    }

}
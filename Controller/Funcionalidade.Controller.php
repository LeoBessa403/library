<?php

class Funcionalidade extends AbstractController
{
    public $result;

    function ListarFuncionalidade()
    {
        /** @var FuncionalidadeService $funcionalidadeService */
        $funcionalidadeService = $this->getService(FUNCIONALIDADE_SERVICE);
        $this->result = $funcionalidadeService->PesquisaTodos();
    }


    function CadastroFuncionalidade()
    {
        /** @var FuncionalidadeService $funcionalidadeService */
        $funcionalidadeService = $this->getService(FUNCIONALIDADE_SERVICE);

        $id = "cadastroFuncionalidade";

        if (!empty($_POST[$id])):
            $retorno = $funcionalidadeService->salvaFuncionalidade($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/ListarFuncionalidade/');
            }
        endif;

        $coFuncionalidade = UrlAmigavel::PegaParametro("fun");
        $res[ST_MENU] = 'checked';
        $res['nova_controller'] = '';
        if ($coFuncionalidade):
            /** @var FuncionalidadeEntidade $funcionalidade */
            $funcionalidade = $funcionalidadeService->PesquisaUmRegistro($coFuncionalidade);
            $res[NO_FUNCIONALIDADE] = $funcionalidade->getNoFuncionalidade();
            $res[CO_FUNCIONALIDADE] = $funcionalidade->getCoFuncionalidade();
            $res[DS_ACTION] = $funcionalidade->getDsAction();
            $res[ST_MENU] = ($funcionalidade->getStMenu() == 'S')
                ? 'checked' : '';
            $res[CO_CONTROLLER] = (!empty($funcionalidade->getCoController()))
                ? $funcionalidade->getCoController()->getCoController() : NULL;
            $perfisFunc = [];
            if (!empty($funcionalidade->getCoPerfilFuncionalidade())) {
                /** @var PerfilFuncionalidadeEntidade $perfilFunc */
                foreach ($funcionalidade->getCoPerfilFuncionalidade() as $perfilFunc) {
                    $perfisFunc[] = $perfilFunc->getCoPerfil()->getCoPerfil();
                }
            }
            $res[CO_PERFIL] = $perfisFunc;
        endif;

        $this->form = FuncionalidadeForm::Cadastrar($res);

    }

}

?>
   
<?php

class Perfil extends AbstractController
{
    public $result;

    function ListarPerfil()
    {
        $coAssinante = AssinanteService::getCoAssinanteLogado();
        if($coAssinante){
            /** @var PerfilAssinanteService $perfilAssinanteService */
            $perfilAssinanteService = $this->getService(PERFIL_ASSINANTE_SERVICE);
            $this->result = $perfilAssinanteService->PesquisaTodos([
                CO_ASSINANTE => $coAssinante
            ]);
        }else{
            /** @var PerfilService $perfilService */
            $perfilService = $this->getService(PERFIL_SERVICE);
            $this->result = $perfilService->PesquisaTodos();
        }
    }

    function CadastroPerfil()
    {
        /** @var PerfilService $perfilService */
        $perfilService = $this->getService(PERFIL_SERVICE);
        /** @var PerfilAssinanteService $perfilAssinanteService */
        $perfilAssinanteService = $this->getService(PERFIL_ASSINANTE_SERVICE);


        $id = "cadastroPerfil";

        if (!empty($_POST[$id])):
            if(AssinanteService::getCoAssinanteLogado()){
                $retorno = $perfilAssinanteService->salvaPerfilAssinante($_POST);
            }else{
                $retorno = $perfilService->salvaPerfil($_POST);
            }
            if($retorno[SUCESSO]){
                Redireciona(UrlAmigavel::$modulo.'/'.UrlAmigavel::$controller.'/ListarPerfil/');
            }
        endif;

        $coPerfil = UrlAmigavel::PegaParametro(CO_PERFIL);
        $res = array();
        $res[CO_PERFIL] = null;
        $coAssinante = AssinanteService::getCoAssinanteLogado();
        if($coAssinante){
            /** @var PerfilAssinanteEntidade $perfil */
            $perfil = $perfilAssinanteService->PesquisaUmRegistro($coPerfil);
            $res[CO_PERFIL] = $perfil->getCoPerfilAssinante();
        }elseif($coPerfil) {
            /** @var PerfilEntidade $perfil */
            $perfil = $perfilService->PesquisaUmRegistro($coPerfil);
            $res[CO_PERFIL] = $perfil->getCoPerfil();
            $res[NO_PERFIL] = $perfil->getNoPerfil();
            $perfisFunc = [];
            if (!empty($perfil->getCoPerfilFuncionalidade())) {
                /** @var PerfilFuncionalidadeEntidade $perfilFunc */
                foreach ($perfil->getCoPerfilFuncionalidade() as $perfilFunc) {
                    $perfisFunc[] = $perfilFunc->getCoFuncionalidade()->getCoFuncionalidade();
                }
            }
            $res[CO_FUNCIONALIDADE] = $perfisFunc;
        }

        $this->form = PerfilForm::Cadastrar($res);

    }

}
   
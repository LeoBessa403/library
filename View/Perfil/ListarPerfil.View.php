<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Perfis
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Perfis
                        <small>Listar Perfis</small>
                        <?php Valida::geraBtnNovo(); ?>
                    </h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        Perfis dos Usuários
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::deletaRegistro("Perfil");
                        Modal::confirmacao("confirma_Perfil");
                        $arrColunas = array('Perfil', 'Funcionalidades', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        if(AssinanteService::getCoAssinanteLogado()){
                            /** @var PerfilAssinanteEntidade $res */
                            foreach ($result as $res):
                                $acao = '<a href="' . PASTAADMIN . 'Perfil/CadastroPerfil/' .
                                    Valida::GeraParametro(CO_PERFIL . "/" . $res->getCoPerfilAssinante()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a>
                                 <a data-toggle="modal" role="button" class="btn btn-bricky 
                                        tooltips deleta" id="' . $res->getCoPerfilAssinante() . '"
                                           href="#Perfil" data-original-title="Excluir Registro" data-placement="top">
                                            <i class="fa fa-trash-o"></i>
                                        </a>';
                                $funcs = [];
                                if (count($res->getCoPerfilFuncionalidade())) {
                                    /** @var PerfilFuncionalidadeEntidade $funcPerfil */
                                    foreach ($res->getCoPerfilFuncionalidade() as $funcPerfil) {
                                        $funcs[] = $funcPerfil->getCoFuncionalidade()->getNoFuncionalidade();
                                    }
                                }
                                $grid->setColunas($res->getNoPerfil());
                                $grid->setColunas(implode(', ', $funcs));
                                $grid->setColunas($acao, 2);
                                $grid->criaLinha($res->getCoPerfilAssinante());

                            endforeach;
                        }else{
                            /** @var PerfilEntidade $res */
                            foreach ($result as $res):
                                if($res->getCoPerfil() != 1){
                                    $acao = '<a href="' . PASTAADMIN . 'Perfil/CadastroPerfil/' .
                                        Valida::GeraParametro(CO_PERFIL . "/" . $res->getCoPerfil()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a>
                                 <a data-toggle="modal" role="button" class="btn btn-bricky 
                                        tooltips deleta" id="' . $res->getCoPerfil() . '"
                                           href="#Perfil" data-original-title="Excluir Registro" data-placement="top">
                                            <i class="fa fa-trash-o"></i>
                                        </a>';
                                    $funcs = [];
                                    if (count($res->getCoPerfilFuncionalidade())) {
                                        /** @var PerfilFuncionalidadeEntidade $funcPerfil */
                                        foreach ($res->getCoPerfilFuncionalidade() as $funcPerfil) {
                                            $funcs[] = $funcPerfil->getCoFuncionalidade()->getNoFuncionalidade();
                                        }
                                    }
                                    $grid->setColunas($res->getNoPerfil());
                                    $grid->setColunas(implode(', ', $funcs));
                                    $grid->setColunas($acao, 2);
                                    $grid->criaLinha($res->getCoPerfil());
                                }
                            endforeach;
                        }
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
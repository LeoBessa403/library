<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Funcionalidades
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Funcionalidades
                        <small>Listar Funcionalidades</small>
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
                        Funcionalidades do Sistema
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::deletaRegistro("Funcionalidade");
                        Modal::confirmacao("confirma_Funcionalidade");
                        $arrColunas = array('Nome', 'Action', 'Controller', 'Perfis', 'Apresentar Menu', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var FuncionalidadeEntidade $res */
                        foreach ($result as $res) {
                            $perfis = [];
                            if(count($res->getCoPerfilFuncionalidade())){
                                /** @var PerfilFuncionalidadeEntidade $funcPerfil */
                                foreach ($res->getCoPerfilFuncionalidade() as $funcPerfil) {
                                    if($funcPerfil->getCoPerfil()){
                                        if($funcPerfil->getCoPerfil()->getCoPerfil() > 1)
                                            $perfis[] = $funcPerfil->getCoPerfil()->getNoPerfil();
                                    }
                                    if($funcPerfil->getCoPerfilAssinante()){
                                        if($funcPerfil->getCoPerfilAssinante()->getCoPerfilAssinante() > 1)
                                            $perfis[] = $funcPerfil->getCoPerfilAssinante()->getNoPerfil();
                                    }
                                }
                            }
                            if ($res->getCoFuncionalidade() > 1):
                                $acao = '<a href="' . PASTAADMIN . 'Funcionalidade/CadastroFuncionalidade/' .
                                    Valida::GeraParametro("fun/" . $res->getCoFuncionalidade()) . '" class="btn btn-primary tooltips" 
                                   data-original-title="Editar Registro" data-placement="top">
                                    <i class="fa fa-clipboard"></i>
                                </a>
                                <a data-toggle="modal" role="button" class="btn btn-bricky tooltips deleta" id="' .
                                    $res->getCoFuncionalidade() . '" 
                                   href="#Funcionalidade" data-original-title="Excluir Registro" data-placement="top">
                                    <i class="fa fa-trash-o"></i>
                                </a>';
                                $grid->setColunas($res->getNoFuncionalidade());
                                $grid->setColunas($res->getDsAction());
                                $grid->setColunas($controller = $res->getCoController()->getNoController());
                                $grid->setColunas(implode(', ', $perfis));
                                $grid->setColunas(Valida::SituacaoSimNao($res->getStMenu()));
                                $grid->setColunas($acao, 2);
                                $grid->criaLinha($res->getCoFuncionalidade());
                            endif;
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
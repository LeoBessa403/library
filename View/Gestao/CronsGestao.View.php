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
                    <h1>Gestão
                        <small>Crons</small>
                        <?php Valida::geraBtn('Cadastrar Cron', 'CadastroCronsGestao', 'btn-info', 'cron'); ?>
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
                        Gestão de Crons
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        $arrColunas = array('Nome', 'Cadastrado', 'Sql', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var CronsEntidade $res */
                        foreach ($result as $res) {
                            $acao = '<a href="' . PASTAADMIN . 'Gestao/CadastroCronsGestao/' .
                                Valida::GeraParametro(CO_CRON . "/" . $res->getCoCron()) . '" class="btn btn-primary tooltips" 
                                   data-original-title="Editar Registro" data-placement="top">
                                    <i class="fa fa-clipboard"></i>
                                </a>
                                <a data-toggle="modal" role="button" class="btn btn-bricky tooltips deleta" id="' .
                                $res->getCoCron() . '" 
                                   href="#Cron" data-original-title="Excluir Registro" data-placement="top">
                                    <i class="fa fa-trash-o"></i>
                                </a>';
                            $grid->setColunas($res->getNoCron(), 4);
                            $grid->setColunas(Valida::DataShow($res->getDtCadastro(),'d/m/Y'), 2);
                            $grid->setColunas($res->getDsSql());
                            $grid->setColunas($acao, 2);
                            $grid->criaLinha($res->getCoCron());
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
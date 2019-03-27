<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Anotacao
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Anotacao
                        <small>Listar Anotacao</small>
                        <?php Valida::geraBtnNovo(null,
                            'Cadastro' . UrlAmigavel::$controller . '/' .
                            Valida::GeraParametro(CO_HISTORIA . '/' . $coHistoria)); ?>
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
                        Anotacaos do modulo
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::deletaRegistro("Anotacao");
                        Modal::confirmacao("confirma_Anotacao");
                        $arrColunas = array('Nome da Anotacao', 'História', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var AnotacaoEntidade $res */
                        foreach ($result as $res):
                            $acao = '<a href="' . PASTAADMIN . 'Anotacao/CadastroAnotacao/' .
                                Valida::GeraParametro(CO_ANOTACAO . "/" . $res->getCoAnotacao()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a>';
                            $grid->setColunas($res->getDsTitulo());
                            $grid->setColunas($res->getCoHistoria()->getDsTitulo());
                            $grid->setColunas($acao, 1);
                            $grid->criaLinha($res->getCoAnotacao());
                        endforeach;
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <div class="pull-right">
                    <!-- end: DYNAMIC TABLE PANEL -->
                    <?php Valida::geraBtnVoltar('Historia/ListarHistoria/' . Valida::GeraParametro(
                            CO_SESSAO . "/" . $coSessao)); ?>
                </div>
                <br><br><br>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Botões
                        </a>
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Gestão
                        <small>Botões</small>
                        <?php Valida::geraBtn('Cadastrar Botão', 'CadastroBotao', 'btn-success', 'botao'); ?>
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
                        Gestão de Botões
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        $arrColunas = array('Código Botão', 'Texto', 'Descrição', 'Total de Cliques', 'Último Clique', 'Ativo', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var BotaoEntidade $res */
                        foreach ($result as $res) {
                            $acao = '<a href="' . PASTAADMIN . 'Gestao/CadastroBotao/' .
                                Valida::GeraParametro(CO_BOTAO . "/" . $res->getCoBotao()) . '" class="btn btn-primary tooltips" 
                                   data-original-title="Editar Registro" data-placement="top">
                                    <i class="fa fa-clipboard"></i>
                                </a>
                                <a data-toggle="modal" role="button" class="btn btn-bricky tooltips deleta" id="' .
                                $res->getCoBotao() . '" 
                                   href="#Cron" data-original-title="Excluir Registro" data-placement="top">
                                    <i class="fa fa-trash-o"></i>
                                </a>';

                            $ultimoClique = 'Sem Cliques';
                            if(!empty($res->getCoClique())){
                                $ultimoClique = Valida::DataShow($res->getUltimoCoClique()->getDtCadastro(),'d/m/Y H:i');
                            }
                            $grid->setColunas($res->getCoBotao(), 2);
                            $grid->setColunas($res->getNoBotao(), 4);
                            $grid->setColunas($res->getDsBotao());
                            $grid->setColunas($res->getNuTotalCliques(),2);
                            $grid->setColunas($ultimoClique, 3);
                            $grid->setColunas(Valida::StatusLabel($res->getStStatus()),2);
                            $grid->setColunas($acao, 2);
                            $grid->criaLinha($res->getCoBotao());
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
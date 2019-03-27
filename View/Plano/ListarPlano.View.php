<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Plano
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Plano
                        <small>Listar Plano</small>
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
                        Planos
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::confirmacao("confirma_Plano");
                        $arrColunas = array('Plano', 'Meses Ativo', 'Valor R$', 'Módulos', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var PlanoEntidade $res */
                        foreach ($result as $res):
                            if ($res->getCoPlano() != 1) {
                                $acao = '<a href="' . PASTAADMIN . 'Plano/CadastroPlano/' .
                                    Valida::GeraParametro(CO_PLANO . "/" . $res->getCoPlano()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a>';
                                $acao .= ' <a href="' . PASTAADMIN . 'Plano/HistoricoPlano/' .
                                    Valida::GeraParametro(CO_PLANO . "/" . $res->getCoPlano()) . '" 
                                class="btn btn-med-grey tooltips" 
                                    data-original-title="Histórico do Plano" data-placement="top">
                                     <i class="clip-folder-open"></i>
                                 </a>';
                                $modulos = [];
                                /** @var PlanoPacoteEntidade $planoPacote */
                                foreach ($res->getCoPlanoPacote() as $planoPacote) {
                                    $modulos[] = $planoPacote->getCoPacote()->getNoPacote();
                                }

                                $grid->setColunas($res->getNoPlano());
                                $grid->setColunas($res->getNuMesAtivo(), 2);
                                $grid->setColunas(Valida::FormataMoeda($res->getCoUltimoPlanoAssinante()->getNuValor()), 2);
                                $grid->setColunas(implode(', ', $modulos));
                                $grid->setColunas($acao, 2);
                                $grid->criaLinha($res->getCoPlano());
                            }
                        endforeach;
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
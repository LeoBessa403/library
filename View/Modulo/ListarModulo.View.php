<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Modulo
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Modulo
                        <small>Listar Modulo</small>
                        <?php Valida::geraBtnNovo(null,
                            'Cadastro' . UrlAmigavel::$controller . '/' .
                            Valida::GeraParametro(CO_PROJETO . '/' . $coProjeto)); ?>
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
                        Modulos do projeto
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::deletaRegistro("Modulo");
                        Modal::confirmacao("confirma_Modulo");
                        $arrColunas = array('Nome da Modulo', 'Projeto', 'Progresso', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var HistoriaService $historiaService */
                        $historiaService = new HistoriaService();

                        /** @var ModuloEntidade $res */
                        foreach ($result as $res):
                            $acao = '<a href="' . PASTAADMIN . 'Modulo/CadastroModulo/' .
                                Valida::GeraParametro(CO_MODULO . "/" . $res->getCoModulo()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a> 
                                 <a href="' . PASTAADMIN . 'Sessao/ListarSessao/' .
                                Valida::GeraParametro(CO_MODULO . "/" . $res->getCoModulo()) . '" 
                                class="btn btn-dark-grey tooltips" 
                                    data-original-title="Sessões do Modulo" data-placement="top">
                                     <i class="clip-stack-empty"></i>
                                 </a>
                                  <a href="' . PASTAADMIN . 'Modulo/EstatisticaModulo/' .
                                Valida::GeraParametro(CO_MODULO . "/" . $res->getCoModulo()) . '" 
                                class="btn btn-green tooltips" 
                                    data-original-title="Estatistica do Modulo" data-placement="top">
                                     <i class="clip-bars"></i>
                                 </a>';

                            // Monta Barra de Progresso
                            $dados['esforco'] = 0;
                            $dados['esforcoRestante'] = 0;
                            if ($res->getCoSessao()) {
                                /** @var SessaoEntidade $sessao */
                                foreach ($res->getCoSessao() as $sessao) {
                                    /** @var HistoriaEntidade $historia */
                                    foreach ($sessao->getCoHistoria() as $historia) {
                                        /** @var HistoriaEntidade $historia */
                                        $historia = $historiaService->PesquisaUmRegistro($historia->getCoHistoria());
                                        $dados['esforco'] = $dados['esforco'] +
                                            $historia->getCoUltimoHistoricoHistoria()->getNuEsforco();
                                        $dados['esforcoRestante'] = $dados['esforcoRestante'] +
                                            $historia->getCoUltimoHistoricoHistoria()->getNuEsforcoRestante();
                                    }
                                }
                            }
                            $barra = Valida::getBarraProgresso($dados);
                            $barra = $barra['barra'];

                            $grid->setColunas($res->getNoModulo());
                            $grid->setColunas($res->getCoProjeto()->getNoProjeto());
                            $grid->setColunas($barra);
                            $grid->setColunas($acao, 3);
                            $grid->criaLinha($res->getCoModulo());
                        endforeach;
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <div class="pull-right">
                    <!-- end: DYNAMIC TABLE PANEL -->
                    <?php Valida::geraBtnVoltar('Gestao/PreProjetoGestao'); ?>
                </div>
                <br><br><br>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
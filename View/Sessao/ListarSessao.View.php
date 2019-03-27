<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Sessao
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Sessao
                        <small>Listar Sessao</small>
                        <?php Valida::geraBtnNovo(null,
                            'Cadastro' . UrlAmigavel::$controller . '/' .
                            Valida::GeraParametro(CO_MODULO . '/' . $coModulo)); ?>
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
                        Sessaos do modulo
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::deletaRegistro("Sessao");
                        Modal::confirmacao("confirma_Sessao");
                        $arrColunas = array('Nome da Sessao', 'Modulo', 'Progresso', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var SessaoEntidade $res */
                        foreach ($result as $res):
                            $acao = '<a href="' . PASTAADMIN . 'Sessao/CadastroSessao/' .
                                Valida::GeraParametro(CO_SESSAO . "/" . $res->getCoSessao()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a> 
                                 <a href="' . PASTAADMIN . 'Historia/ListarHistoria/' .
                                Valida::GeraParametro(CO_SESSAO . "/" . $res->getCoSessao()) . '" 
                                class="btn btn-dark-grey tooltips" 
                                    data-original-title="Histórias da Sessões" data-placement="top">
                                     <i class="clip-stack-empty"></i>
                                 </a>
                                  <a href="' . PASTAADMIN . 'Sessao/EstatisticaSessao/' .
                                Valida::GeraParametro(CO_SESSAO . "/" . $res->getCoSessao()) . '" 
                                class="btn btn-green tooltips" 
                                    data-original-title="Estatistica da Sessao" data-placement="top">
                                     <i class="clip-bars"></i>
                                 </a>';

                            // Monta Barra de Progresso
                            $dados['esforco'] = 0;
                            $dados['esforcoRestante'] = 0;
                            if($res->getCoHistoria()){
                                /** @var HistoriaEntidade $historia */
                                foreach ($res->getCoHistoria() as $historia) {
                                    $dados['esforco'] = $dados['esforco'] +
                                        $historia->getCoUltimoHistoricoHistoria()->getNuEsforco();
                                    $dados['esforcoRestante'] = $dados['esforcoRestante'] +
                                        $historia->getCoUltimoHistoricoHistoria()->getNuEsforcoRestante();
                                }
                            }
                            $barra = Valida::getBarraProgresso($dados);
                            $barra = $barra['barra'];

                            $grid->setColunas($res->getNoSessao());
                            $grid->setColunas($res->getCoModulo()->getNoModulo());
                            $grid->setColunas($barra);
                            $grid->setColunas($acao, 3);
                            $grid->criaLinha($res->getCoSessao());
                        endforeach;
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <div class="pull-right">
                    <!-- end: DYNAMIC TABLE PANEL -->
                    <?php Valida::geraBtnVoltar('Modulo/ListarModulo/' . Valida::GeraParametro(
                            CO_PROJETO . "/" . $coProjeto)); ?>
                </div>
                <br><br><br>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
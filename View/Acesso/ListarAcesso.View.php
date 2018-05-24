<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Acessos
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Acessos
                        <small>Listar Acessos</small>
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
                        Acessos
                    </div>
                    <div class="panel-body">
                        <?php
                        $grid = new Grid();
                        echo $grid->PesquisaAvancada('Pesquisar Acessos');
                        ?>
                        <h2>
                            <small>Acessos Cadastradas</small>
                        </h2>
                        <?php
                        Modal::load();
                        $arrColunas = array('Usuário', 'CPF', 'Status', 'Início', 'Fim', 'Navegador', 'S.O.',
                            'Dispositivo', 'Estado', 'Cidade');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();

                        /** @var AcessoEntidade $res */
                        foreach ($result as $res):
                            $grid->setColunas(Valida::Resumi(strtoupper($res->getCoUsuario()->getCoPessoa()->getNoPessoa()),25));
                            $grid->setColunas(Valida::MascaraCpf($res->getCoUsuario()->getCoPessoa()->getNuCpf()));
                            $grid->setColunas(FuncoesSistema::StatusAcesso($res->getTpSituacao()));
                            $grid->setColunas(Valida::DataShow($res->getDtInicioAcesso(), 'd/m/Y H:i:s'));
                            $grid->setColunas(Valida::DataShow($res->getDtFimAcesso(), 'd/m/Y H:i:s'));
                            $grid->setColunas($res->getCoTrafego()->getDsNavegador());
                            $grid->setColunas($res->getCoTrafego()->getDsSistemaOperacional());
                            $grid->setColunas($res->getCoTrafego()->getDsDispositivo());
                            $grid->setColunas($res->getCoTrafego()->getDsUf());
                            $grid->setColunas($res->getCoTrafego()->getDsCidade());
                            $grid->criaLinha($res->getCoAcesso());
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
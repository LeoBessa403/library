<div class="main-content">
    <!-- end: SPANEL CONFIGURATION MODAL FORM -->
    <div class="container">
        <!-- start: PAGE HEADER -->
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-home-3"></i>
                        <a href="#">
                            Início
                        </a>
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Visitas ao Site</h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        Total de Visitas
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-3">
                            <div class="alert alert-block alert-success fade in">
                                <h4 class="alert-heading"><i class="fa fa-group"></i> Usuários/Total</h4>
                                <h2><?= $totalVisitasPagina['total']['usuarios']; ?></h2>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="alert alert-block alert-info fade in">
                                <h4 class="alert-heading"><i class="fa fa-eye"></i> Visualizações/Total</h4>
                                <h2><?= $totalVisitasPagina['total']['qt_visitas']; ?></h2>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="alert alert-block alert-warning fade in">
                                <h4 class="alert-heading"><i class="fa fa-user"></i> Usuários/Mês</h4>
                                <h2><?= $totalVisitasPagina['totalMesAtual']['usuarios']; ?></h2>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="alert alert-block alert-danger fade in">
                                <h4 class="alert-heading"><i class="fa fa-eye-slash"></i> Visualizações/Mês</h4>
                                <h2><?= $totalVisitasPagina['totalMesAtual']['qt_visitas']; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE HEADER -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-calendar"></i>
                        Resumo das Visitas
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="alert alert-warning fade in">
                                <div id="div_so"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-danger fade in">
                                <div id="div_dispositivo"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-success fade in">
                                <div id="div_nav"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-warning fade in">
                                <div id="div_cidade"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <div id="div_mapa"></div>
                            </div>
                        </div>
                        <!-- end: FULL CALENDAR PANEL -->
                    </div>
                    <!-- end: PAGE CONTENT-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        Páginas mais visitadas
                    </div>
                    <div class="panel-body">
                        <?php
                        $grid = new Grid();
                        ?>
                        <h2>
                            <small>Páginas visitadas</small>
                        </h2>
                        <?php
                        Modal::load();

                        $arrColunas = array('Página', 'Nº de Visitas', 'Nº de Usuários');
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        $i = 0;
                        foreach ($visitasPagina as $visitaPagina):
                            $link = '<a class="tooltips" 
                                   href="' . HOME . $visitaPagina[DS_TITULO_URL_AMIGAVEL] . '" 
                                   data-original-title="Página Visitada"  target="_black"
                                   data-placement="top">' . $visitaPagina[DS_TITULO_URL_AMIGAVEL] . '</a>';

                            $grid->setColunas($link);
                            $grid->setColunas($visitaPagina[NU_VISUALIZACAO]);
                            $grid->setColunas($visitaPagina[NU_USUARIO]);
                            $grid->criaLinha($i);
                            $i++;
                        endforeach;
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
    </div>
</div>

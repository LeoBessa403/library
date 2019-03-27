<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Projeto
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Projeto <?= DESC_SIS; ?>
                        <?php Valida::geraBtn(
                            'Acompanhar Projeto', 'AcompanharProjetoGestao',
                            'btn-success', 'configProjeto'
                        ); ?>
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
                        Estatísticas do Projeto
                    </div>
                    <div class="panel-body">
                        <?php include_once PARTIAL_LIBRARY . 'Admin/template_estatistica.php'; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
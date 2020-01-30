<div class="main-content">
    <div class="container">
        <!-- start: PAGE HEADER -->
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Gestão
                        </a>
                    </li>
                    <li class="active">
                        Gerar Backup
                    </li>

                </ol>
                <div class="page-header">
                    <h1>Gestão
                        <small>Gerar Backup</small>
                    </h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <?php
        Modal::load();
        ?>
        <div class="row">
            <div class="col-sm-12">
                <h3>Último Backup em: <b><?= Valida::DataShow(Backup::getDataUltimoBackup()); ?></b></h3>
            </div>
            <?php
            echo $form;
            ?>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
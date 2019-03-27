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
                        Arquivo de Configuração Padrão
                    </li>

                </ol>
                <div class="page-header">
                    <h1>Gestão
                        <small>Arquivo de Configuração Padrão</small>
                        <?php Valida::geraBtn('Reset Config', 'ResetConfigGestao' , 'btn-info', 'config'); ?>
                    </h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <?php
        Modal::load();
        Modal::modelConfirmacao("Config",'Deseja realmete Resetar o CONFIG?', null,'');
        ?>
        <div class="row">
            <?php
            echo $form;
            ?>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
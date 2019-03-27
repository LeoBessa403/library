<?php
/** @var AssinanteEntidade $assinanteEdit */
$assinanteEdit = $assinante;
?>
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
                            Assinante
                        </a>
                    </li>
                    <li class="active">
                        Dados Complementares
                    </li>

                </ol>
                <div class="page-header">
                    <h1>Assinante
                        <small> Dados Complementares</small>
                    </h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <?php
        Modal::load();
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
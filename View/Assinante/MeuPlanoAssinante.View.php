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
                            Pagamentos do Assinante
                        </a>
                    </li>
                    <li class="active">
                        Cadastro / Edição
                    </li>

                </ol>
                <div class="page-header">
                    <h1>Pagamentos do Assinante
                        <small>Cadastro / Edição</small>
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
            /** @var PagSeguro $pag */
            $pag = new PagSeguro();
            ?>
            <a id="pagarAgora" class="btn btn-dark-grey" style="margin-top: 10px;">
                <span class="ladda-label"> Pagar Agora </span>
                <i class="fa fa-money"></i>
            </a>
            <form id="comprar" action="<?= $pag->url_pagamento; ?>" method="post"
                  onsubmit="PagSeguroLightbox(this); return false;">
                <input type="hidden" name="code" id="code" value=""/>
            </form>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->

<!-- SCRIPT PAGSEGURO -->
<script type="text/javascript"
        src="<?= PASTA_LIBRARY; ?>js/pagseguro.lightbox.js"></script>
<style>
    th, td {
        padding: 7px;
    }
</style>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Auditoria
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>

                </ol>
                <div class="page-header">
                    <h1>Auditoria
                        <small>Listar Registros</small>
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
                        Auditoria
                    </div>
                    <div class="panel-body">
                        <?php
                        $grid = new Grid();
                        echo $grid->PesquisaAvancada('Pesquisar Auditoria');
                        ?>
                        <h2>
                            <small>Auditorias Encontradas</small>
                        </h2>
                        <hr>
                        <div class="panel-group accordion-custom accordion-teal" id="accordion">
                            <?php
                            /** @var AuditoriaEntidade $auditoria */
                            foreach ($result as $auditoria) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse"
                                               data-parent="#accordion"
                                               href="#collapse<?php echo $auditoria->getCoAuditoria(); ?>">
                                                <i class="icon-arrow"></i>
                                                <?php echo $auditoria->getDtRealizado() . '  //  ';
                                                echo ($auditoria->getDsPerfilUsuario() != 'Via Site')
                                                    ? $auditoria->getCoUsuario()->getCoPessoa()->getNoPessoa()
                                                    : $auditoria->getDsPerfilUsuario(); ?>
                                            </a></h4>
                                    </div>
                                    <div id="collapse<?php echo $auditoria->getCoAuditoria(); ?>"
                                         class="panel-collapse collapse" style="height: 0px;">
                                        <div class="panel-body">
                                            <div class="tabbable">
                                                <ul id="myTab<?php echo $auditoria->getCoAuditoria(); ?>"
                                                    class="nav nav-tabs tab-padding tab-space-3 tab-pane">
                                                    <?php
                                                    /** @var AuditoriaTabelaEntidade $auditoriaTabela */
                                                    foreach ($auditoria->getCoAuditoriaTabela() as $auditoriaTabela) { ?>
                                                        <li class="">
                                                            <a href="#panel_tab<?php echo $auditoriaTabela->getCoAuditoriaTabela(); ?>"
                                                               data-toggle="tab">
                                                            <span class="badge badge-<?= Valida::getBadgeLabel($auditoriaTabela->getTpOperacao()); ?>">
                                                            <?php echo str_replace(array('TB_', 'tb_'), '',
                                                                $auditoriaTabela->getNoTabela()); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <div class="tab-content">
                                                    <?php
                                                    /** @var AuditoriaTabelaEntidade $auditoriaTabela */
                                                    foreach ($auditoria->getCoAuditoriaTabela() as $auditoriaTabela) { ?>
                                                        <div class="tab-pane"
                                                             id="panel_tab<?php echo $auditoriaTabela->getCoAuditoriaTabela(); ?>">
                                                            Tabela:
                                                            <b><?php echo str_replace("_", " ",
                                                                    str_replace(array('TB_', 'tb_'), '',
                                                                        $auditoriaTabela->getNoTabela())); ?></b><br>
                                                            Ação Realizada: <b><?php
                                                                echo AuditoriaEnum::getDescricaoValor(
                                                                    $auditoriaTabela->getTpOperacao()
                                                                );
                                                                ?></b>

                                                            <?php
                                                            $grid = new Grid();
                                                            ?>
                                                            <h2>
                                                                <small>Itens da Auditoria</small>
                                                            </h2>
                                                            <?php
                                                            $arrColunas = array('Dado', 'Item Atual', 'Item Anterior');
                                                            $grid = new Grid();
                                                            $grid->setColunasIndeces($arrColunas);
                                                            $grid->criaGrid(
                                                                $auditoriaTabela->getCoAuditoriaTabela(), false
                                                            );
                                                            if($auditoriaTabela->getCoAuditoriaItens()){
                                                                /** @var AuditoriaItensEntidade $item */
                                                                foreach ($auditoriaTabela->getCoAuditoriaItens() as $item):
                                                                    $grid->setColunas(
                                                                        Valida::getDsCampoLabel($item->getDsCampo())
                                                                    );
                                                                    $grid->setColunas($item->getDsItemAtual());
                                                                    $grid->setColunas($item->getDsItemAnterior());
                                                                    $grid->criaLinha($item->getCoAuditoriaItens());
                                                                endforeach;
                                                            }
                                                            $grid->finalizaGrid();
                                                            ?>

                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- end: DYNAMIC TABLE PANEL -->
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
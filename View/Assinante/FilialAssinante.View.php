<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-grid-6"></i>
                        <a href="#">
                            Filiais Assinante
                        </a>
                    </li>
                    <li class="active">
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Filiais Assinante
                        <small>Listar Filiais Assinante</small>
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
                        Filiais Assinante
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::confirmacao("confirma_Assinante");
                        $arrColunas = array('Assinante / Filial', 'Responsável', 'E-mail', 'Expiração', 'Status', 'Ações');
                        $grid = new Grid();
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        /** @var AssinanteEntidade $res */
                        foreach ($result as $res):
                            $acao = '<a href="' . PASTAADMIN . 'Assinante/CadastroAssinante/' .
                                Valida::GeraParametro(CO_ASSINANTE . "/" . $res->getCoAssinante()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a>';
                            $empresa = ($res->getCoEmpresa()) ? $res->getCoEmpresa()->getNoFantasia() : '';
                            $grid->setColunas($empresa);
                            $grid->setColunas($res->getCoPessoa()->getNoPessoa());
                            $grid->setColunas($res->getCoPessoa()->getCoContato()->getDsEmail());
                            $grid->setColunas(Valida::DataShow($res->getDtExpiracao()), 2);
                            $grid->setColunas(Valida::StatusLabel($res->getStStatus()), 2);
                            $grid->setColunas($acao, 1);
                            $grid->criaLinha($res->getCoAssinante());
                        endforeach;
                        $grid->finalizaGrid();
                        ?>
                    </div>
                </div>
                <!-- end: DYNAMIC TABLE PANEL -->
                <?php Valida::geraBtnVoltar(); ?>
            </div>
        </div>
        <!-- end: PAGE CONTENT-->
    </div>
</div>
<!-- end: PAGE -->
<div class="main-content">
    <div class="container">
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
                        Listar
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Assinante
                        <small>Listar Assinante</small>
                        <?php Valida::geraBtnNovo(); ?>
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
                        Assinantes

                    </div>
                    <div class="panel-body">
                        <?php
                        $grid = new Grid();
                        echo $grid->PesquisaAvancada('Pesquisar Assinantes');
                        ?>
                        <h2>
                            <small>Assinantes Cadastrados</small>
                        </h2>
                        <?php
                        Modal::load();
                        Modal::confirmacao("confirma_Assinante");
                        $arrColunas = array('Assinante', 'Endereço', 'Responsável', 'E-mail', 'Status Assinante', 'Expiração', 'Status Plano', 'Sit. Pagamento', 'Ações');
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        //                        debug($result,1);
                        /** @var AssinanteEntidade $res */
                        foreach ($result as $res):
                            $acao = '<a href="' . PASTAADMIN . 'Assinante/CadastroAssinante/' .
                                Valida::GeraParametro(CO_ASSINANTE . "/" . $res->getCoAssinante()) . '" class="btn btn-primary tooltips" 
                                    data-original-title="Editar Registro" data-placement="top">
                                     <i class="fa fa-clipboard"></i>
                                 </a>';
//                            if (!empty($res->getCoPlanoAssinanteAssinatura())) {
//                                $acao .= ' <a href="' . PASTAADMIN . 'Assinante/HistoricoAssinante/' .
//                                    Valida::GeraParametro(CO_ASSINANTE . "/" . $res->getCoAssinante()) . '"
//                                class="btn btn-med-grey tooltips"
//                                    data-original-title="Histórico do Assinante" data-placement="top">
//                                     <i class="clip-folder-open"></i>
//                                 </a>';
//                            }
                            $acao .= ' <a href="' . PASTAADMIN . 'Assinante/MeuPlanoAssinante/' .
                                Valida::GeraParametro(CO_ASSINANTE . "/" . $res->getCoAssinante()) . '" 
                        class="btn btn-warning tooltips" data-original-title="Pagamentos do Assinante" data-placement="top">
                                     <i class="fa fa-money"></i>
                                 </a>';

                            $acao .= ' <a href="' . PASTAADMIN . 'Assinante/DadosComplementaresAssinante/' .
                                Valida::GeraParametro(CO_ASSINANTE . "/" . $res->getCoAssinante()) . '" 
                                class="btn btn-green tooltips" 
                                    data-original-title="Dados Complementares do Assinante" data-placement="top">
                                     <i class="fa fa-copy"></i>
                                 </a>';
                            $endereco = '';
                            if (!empty($enderecos[$res->getCoEmpresa()->getCoEndereco()])) {
                                $endereco = $enderecos[$res->getCoEmpresa()->getCoEndereco()];
                            }

                            $spanLabel = '<span class="circle-img label_span label-' .
                                StatusPagamentoEnum::$cores[$res->getUltimoCoPlanoAssinante()->getStPagamento()] . '">
                                            &nbsp;&nbsp;&nbsp;&nbsp;</span> ';

                            $statusSis = AssinanteService::getStatusAssinante(Valida::DataShow($res->getDtExpiracao()));
                            $empresa = ($res->getCoEmpresa()) ? $res->getCoEmpresa()->getNoFantasia() : '';
                            $grid->setColunas($empresa);
                            $grid->setColunas($endereco);
                            $grid->setColunas($res->getCoPessoa()->getNoPessoa());
                            $grid->setColunas($res->getCoPessoa()->getCoContato()->getDsEmail());
                            $grid->setColunas(Valida::StatusLabel($res->getStStatus()), 2);
                            $grid->setColunas(Valida::DataShow($res->getDtExpiracao()), 2);
                            $grid->setColunas(Valida::getLabelStatusPlano($statusSis), 2);
                            $grid->setColunas($spanLabel .
                                StatusPagamentoEnum::getDescricaoValor($res->getUltimoCoPlanoAssinante()->getStPagamento()), 3);
                            $grid->setColunas($acao, 3);
                            $grid->criaLinha($res->getCoAssinante());
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
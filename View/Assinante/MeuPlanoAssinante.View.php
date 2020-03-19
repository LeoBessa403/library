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
                        Assinaturas
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Assinante
                        <small>Listar Assinaturas</small>
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
                        Assinaturas de Planos
                    </div>
                    <div class="panel-body">
                        <?php
                        Modal::load();
                        Modal::confirmacao("confirma_Assinante");
                        $grid = new Grid();
                        $arrColunas = array('Status', 'Plano', 'Data Pagamento', 'Valor R$', 'Nº Profissionais',
                            'Sit. Pagamento', 'Expiração', 'Ações');
                        $grid->setColunasIndeces($arrColunas);
                        $grid->criaGrid();
                        $statusSis = '';
                        /** @var PlanoAssinanteAssinaturaEntidade $res */
                        foreach ($result as $res):
                            $acao = '';

                            if ($res->getStPagamento() < 3) {
                                $acao .= ' <a href="' . PASTAADMIN . 'Assinante/RenovaPlanoAssinante/' .
                                    Valida::GeraParametro(CO_PLANO_ASSINANTE_ASSINATURA . "/" .
                                        $res->getCoPlanoAssinanteAssinatura()) . '"
                                class="btn btn-green tooltips"
                                    data-original-title="Pagar a Renovação da Assinatura" data-placement="top">
                                     <i class="fa fa-money"></i>
                                 </a>';
                            }
                            $dtPagamento = ($res->getDtConfirmaPagamento())
                                ? Valida::DataShow($res->getDtConfirmaPagamento())
                                : null;
                            if ($statusSis != 'A') {
                                $statusSis = ($res->getStPagamento() == 3) ? 'A' : 'I';
                            } else {
                                $statusSis = 'I';
                            }
                            $grid->setColunas(Valida::StatusLabel($statusSis), 2);
                            $grid->setColunas($res->getCoPlanoAssinante()->getCoPlano()->getNoPlano());
                            $grid->setColunas($dtPagamento, 2);
                            $grid->setColunas($res->getNuValorAssinatura(), 2);
                            $grid->setColunas($res->getNuProfissionais(), 2);
                            $grid->setColunas(StatusPagamentoEnum::getDescricaoValor($res->getStPagamento()), 2);
                            $grid->setColunas(Valida::DataShow($res->getDtExpiracao()), 2);
                            $grid->setColunas($acao, 3);
                            $grid->criaLinha($res->getCoPlanoAssinanteAssinatura());
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
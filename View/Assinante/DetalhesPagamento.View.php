<!--  MODAL FORM DE CADASTRO E EDIÇÃO -->
<div class="modal fade in modal-overflow j_listar" id="VisualizarPagamento" tabindex="-1"
     role="dialog" aria-hidden="true">
    <div class="modal-header btn-light-grey">
        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
            X
        </button>
        <h4 class="modal-title">Visualisar Assinatura</h4>
    </div>
    <div class="modal-body">
        <div class="row col-sm-12" id="Visualizar-Pagamento">
            <div id="form-group-st_status" class="form-group col-sm-12">
                <label for="st_status" class="col-sm-3 align-right">
                    Status Assinatura:
                </label>
                <div class="col-sm-9">
                    <span class="st_status"><b></b></span>
                </div>
            </div>
            <div id="form-group-Code" class="form-group col-sm-12">
                <label for="Code" class="col-sm-3  align-right">
                    Código da Transação:
                </label>
                <div class="col-sm-9">
                    <span class="Code"><b></b></span>
                </div>
            </div>
            <div id="form-group-plano" class="form-group col-sm-12">
                <label for="plano" class="col-sm-3  align-right">
                    Plano:
                </label>
                <div class="col-sm-9">
                    <span class="plano"><b></b></span>
                </div>
            </div>
            <div id="form-group-Data_Pagamento" class="form-group col-sm-12">
                <label for="Data_Pagamento" class="col-sm-3  align-right">
                    Data Pagamento:
                </label>
                <div class="col-sm-9">
                    <span class="Data_Pagamento"><b></b></span>
                </div>
            </div>
            <div id="form-group-Situacao_Pagamento" class="form-group col-sm-12">
                <label for="Situacao_Pagamento" class="col-sm-3  align-right">
                    Situação do Pagamento:
                </label>
                <div class="col-sm-9">
                    <span class="Situacao_Pagamento"><b></b></span>
                </div>
            </div>
            <div id="form-group-Meio_Pagamento" class="form-group col-sm-12">
                <label for="Meio_Pagamento" class="col-sm-3  align-right">
                    Meio de Pagamento:
                </label>
                <div class="col-sm-9">
                    <span class="Meio_Pagamento"><b></b></span>
                </div>
            </div>
            <div id="form-group-Valor_Ass" class="form-group col-sm-12">
                <label for="Valor_Ass" class="col-sm-3  align-right">
                    Valor Assinatura:
                </label>
                <div class="col-sm-9">
                    <span class="Valor_Ass"><b></b></span>
                </div>
            </div>
            <div id="form-group-Valor_Desconto" class="form-group col-sm-12">
                <label for="Valor_Desconto" class="col-sm-3  align-right">
                    Valor desconto:
                </label>
                <div class="col-sm-9">
                    <span class="Valor_Desconto"><b></b></span>
                </div>
            </div>
            <div id="form-group-Valor_Liquido" class="form-group col-sm-12">
                <label for="Valor_Liquido" class="col-sm-3  align-right">
                    Valor Líquido:
                </label>
                <div class="col-sm-9">
                    <span class="Valor_Liquido"><b></b></span>
                </div>
            </div>
            <div id="form-group-Profissionais" class="form-group col-sm-12">
                <label for="Profissionais" class="col-sm-3  align-right">
                    Nº Profissionais:
                </label>
                <div class="col-sm-9">
                    <span class="Profissionais"><b></b></span>
                </div>
            </div>
            <div id="form-group-transacoes" class="form-group col-sm-12">
                <label for="transacoes" class="col-sm-3  align-right">
                    <h4><b>Transações:</b></h4>
                </label>
                <div class="col-sm-12">
                    <span class="transacoes"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer pull-left" style="width: 100%;">
        <button data-dismiss="modal" class="btn btn-primary cancelar">Fechar</button>
    </div>
</div>
<a data-toggle="modal" role="button" href="#VisualizarPagamento" id="j_listar"></a>
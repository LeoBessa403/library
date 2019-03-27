<?php
/** @var TaxaCartaoEntidade $historico */
$historico = $historico;
?>
<div class="content">
    Taxa: <b><?=
        Valida::FormataMoeda($historico->getNuTaxaCartao()); ?></b></br>
    Cadastrado em: <b><?=
        Valida::DataShow(
            $historico->getDtCadastro(), 'd/m/Y H:i'
        )
        ?></b></br>
</div>
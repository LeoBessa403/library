<?php
/** @var TaxaCartaoEntidade $historico */
$historico = $historico;
?>
<div class="content">
    Taxa: <b><?=
        Valida::FormataMoeda($historico->getNuTaxaCartao()); ?></b></br>
    Taxa de Antecipação: <b><?=
        Valida::FormataMoeda($historico->getNuTaxaAntecipacao()); ?></b></br>
    Cadastrado em: <b><?=
        Valida::DataShow(
            $historico->getDtCadastro(), 'd/m/Y H:i'
        )
        ?></b></br>
</div>
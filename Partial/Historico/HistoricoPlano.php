<?php
/** @var PlanoAssinanteEntidade $historico */
$historico = $historico;
?>
<div class="content">
    Valor R$: <b><?=
        Valida::FormataMoeda($historico->getNuValor()); ?></b></br>
    Observação: <b><?= $historico->getDsObservacao(); ?></b></br>
    Cadastrado em: <b><?=
        Valida::DataShow(
            $historico->getDtCadastro(), 'd/m/Y H:i'
        )
        ?></b></br>
</div>
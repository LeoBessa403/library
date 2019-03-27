<?php
/** @var HistoricoHistoriaEntidade $historico */
$historico = $historico;
?>
<div class="content">
    Data: <b><?=
        Valida::DataShow(
            $historico->getDtCadastro(), 'd/m/Y H:i'
        ); ?></b></br>
    Esforço: <b><?= $historico->getNuEsforco(); ?></b></br>
    Esforço Restante: <b><?= ($historico->getNuEsforcoRestante())
        ? $historico->getNuEsforcoRestante() : 0;?></b></br>
</div>
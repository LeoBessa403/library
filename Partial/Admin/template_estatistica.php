<?php
$estatisticas = Valida::getDadosEstatistica($dados);
?>
<div class="col-sm-12">
    <?= $estatisticas['barra']; ?>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-success fade in">
        <h4 class="alert-heading"><i class="fa fa-calendar"></i> Percentual alcançado</h4>
        <h2><?= $estatisticas['percentual']; ?>%</h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-warning fade in">
        <h4 class="alert-heading"><i class="fa fa-calendar"></i> Data de Termino</h4>
        <h2><?= $estatisticas['dataPrevista']; ?></h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-info fade in">
        <h4 class="alert-heading"><i class="clip-star-6"></i> Esforço Total</h4>
        <h2><?= $dados['esforco']; ?></h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-danger fade in">
        <h4 class="alert-heading"><i class="clip-star-5"></i> Esforço Restante</h4>
        <h2><?= $dados['esforcoRestante']; ?></h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-info fade in">
        <h4 class="alert-heading"><i class="clip-brightness-medium"></i> Média Projeto Pontos / Dia</h4>
        <h2><?= $estatisticas['pontosDia']; ?></h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-danger fade in">
        <h4 class="alert-heading"><i class="clip-clock"></i> Horas</h4>
        <h2><?= $estatisticas['horas']; ?></h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-success fade in">
        <h4 class="alert-heading"><i class="clip-calendar"></i> Dias</h4>
        <h2><?= $estatisticas['dias']; ?></h2>
    </div>
</div>
<div class="col-sm-3">
    <div class="alert alert-block alert-warning fade in">
        <h4 class="alert-heading"><i class="fa fa-moon-o"></i> Semanas</h4>
        <h2><?= $estatisticas['semanas']; ?></h2>
    </div>
</div>
<div class="col-md-12">
    <h3>Esforço / Esforço Restante</h3>
    <div class="alert alert-success fade in">
        <div id="div_esforco"></div>
    </div>
</div>
<div class="col-md-12">
    <h3>Percentual de evolução</h3>
    <div class="alert alert-info fade in">
        <div id="div_percentual_evolucao"></div>
    </div>
</div>
<h2><?= $nome; ?></h2>
<div id="timeline" class="demo1">
    <div class="timeline">
        <div class="spine"></div>
        <?php
        $cores = Valida::getCoresHistorico();
        $mes_extenso = Valida::getMesesHistorico();
        $historicos = array_reverse($historicos);

        $meses = '';
        $fechamento = '';
        $corI = 0;
        $controle = true;
        foreach ($historicos

        as $historico) {
        $data = strtotime($historico->getDtCadastro());
        if ($meses != Valida::DataShow($historico->getDtCadastro(), 'Y/m')) {
        if (!$controle)
            $fechamento = '</ul>';
        $controle = false;
        $meses = Valida::DataShow($historico->getDtCadastro(), 'Y/m')
        ?>
        <div class="date_separator">
                <span><?php
                    $mes = date('M', $data);
                    $dia = date('d', $data);
                    $ano = date('Y', $data);
                    echo $mes_extenso["$mes"] . " de {$ano}";
                    ?></span>
        </div>
        <ul class="columns">
            <?php } else {
                $fechamento = '';
            }
            if ($corI == 5)
                $corI = 0;
            ?>
            <li>
                <div class="timeline_element <?= $cores[$corI]; ?>">
                    <div class="timeline_title">
                        <span class="timeline_date"></span>
                    </div>
                    <?php
                    $arquivoHistorico = PARTIAL_LIBRARY . 'Historico/' . UrlAmigavel::$action . '.php';
                    if (file_exists($arquivoHistorico))
                        require $arquivoHistorico;
                    ?>
                </div>
            </li>
            <?= $fechamento;
            $corI++;
            ?>
            <?php } ?>
    </div>
</div>
<span class="pull-right" style="margin-right: 10px; margin-bottom: 10px; display: block;">
    <?php
    $act = (isset($voltar)) ? $voltar : '/Listar' . UrlAmigavel::$controller;
    echo '<a href="' . PASTAADMIN . UrlAmigavel::$controller . $act . '"
           class="btn btn-primary tooltips" data-original-title="Voltar" data-placement="top">
            Voltar <i class="clip-arrow-right-2"></i>
        </a>';
    ?>
</span>
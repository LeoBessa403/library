</div>
<!-- end: SIDEBAR -->
</div>
<!-- start: PAGE -->
<?php
$url->pegaControllerAction();
?>
<!-- end: PAGE -->
</div>
<!-- end: MAIN NAVIGATION MENU --><!-- end: MAIN CONTAINER -->
<!-- start: FOOTER -->
<div class="footer clearfix">
    <div class="footer-inner" style="float:none;  text-align: center;">
        <?php include_once 'controle_versao.php'; ?>
    </div>
    <div class="footer-items">
        <span class="go-top"><i class="clip-chevron-up"></i></span>
    </div>
</div>
<!-- end: FOOTER -->
<!-- start: MAIN JAVASCRIPTS -->
<script type="text/javascript" src="<?= PASTA_LIBRARY; ?>js/js_padrao.min.js"></script>
<?php include_once PARTIAL_LIBRARY . 'constantes_javascript.php'; ?>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
    jQuery(document).ready(function () {
        Funcoes.init();
        Main.init();
        TableData.init();
        FormWizard.init();
    });
</script>
<?php carregaJs($url); ?>
<!-- Carrega DIVs dos Alertas e Notificações   -->
<?php include_once 'alertas.php'; ?>
</body>
<!-- end: BODY -->
</html>
<?php
ob_end_flush();
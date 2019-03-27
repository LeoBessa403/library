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
    <div class="footer-inner">
        <?php include_once 'controle_versao.php'; ?>
    </div>
    <div class="footer-items">
        <span class="go-top"><i class="clip-chevron-up"></i></span>
    </div>
</div>
<!-- end: FOOTER -->
<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?= PASTA_LIBRARY; ?>plugins/respond.min.js"></script>
<script type="text/javascript" src="<?= PASTA_LIBRARY; ?>plugins/excanvas.min.js"></script>
<script type="text/javascript" src="<?= INCLUDES;?>jquery-1.10.2.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="<?= INCLUDES; ?>jquery-2.0.3.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="<?= INCLUDES; ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?= INCLUDES; ?>jquery.mask.js"></script>
<script type="text/javascript" src="<?= INCLUDES; ?>jquery.maskMoney.js"></script>
<?= '<script type="text/javascript">
                        function constantes(){    
                                var dados = {
                                    "HOME" : "' . HOME . '",
                                    "INATIVO" : "' . INATIVO . '",
                                    "PASTAUPLOADS" : "' . PASTAUPLOADS . '" ,                                       
                                    "AMBIENTE" : "ADMIN"                                      
                                    };
                                return dados;
                        }
                </script>'; ?>
<script type="text/javascript" src="<?= INCLUDES; ?>validacoes.js"></script>

<script src="<?= PASTA_LIBRARY; ?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/blockUI/jquery.blockUI.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/iCheck/jquery.icheck.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/jquery-cookie/jquery.cookie.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/main.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/ui-animation.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="<?= PASTA_LIBRARY; ?>plugins/flot/jquery.flot.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/flot/jquery.flot.pie.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/flot/jquery.flot.resize.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/jquery.sparkline/jquery.sparkline.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/fullcalendar/fullcalendar/fullcalendar.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/index.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/select2/select2.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/bootstrap-switch/static/js/bootstrap-switch.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/DataTables/media/js/DT_bootstrap.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/table-data.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/ckeditor/ckeditor.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/ckeditor/adapters/jquery.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/Funcoes.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/FullCalendar.js"></script>
<script src="<?= PASTA_LIBRARY; ?>plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
<script src="<?= PASTA_LIBRARY; ?>js/form-wizard.js"></script>
<?php carregaJs($url); ?>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
    jQuery(document).ready(function () {
        Funcoes.init();
        Main.init();
        TableData.init();
        Calendar.init();
        FormWizard.init();
        Index.init();
    });
</script>
<!-- Carrega DIVs dos Alertas e Notificações   -->
<?php include_once 'alertas.php'; ?>
</body>
<!-- end: BODY -->
</html>
<?php
ob_end_flush();
<?php
if (TEM_SITE) {
    ?>
    <div class="al-center logo" style="width: 100%">
        <a style="color: #000000;" class="btn btn-beige" href="<?= PASTASITE; ?>">
            Voltar ao Site
        </a>
    </div>
<?php } ?>
</div>
<!-- start: MAIN JAVASCRIPTS -->
<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script src="<?= PASTAADMIN; ?>plugins/respond.min.js"></script>
<script src="<?= PASTAADMIN; ?>plugins/excanvas.min.js"></script>
<script type="text/javascript" src="<?= INCLUDES;?>jquery-1.10.2.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script src="<?= INCLUDES; ?>jquery-2.0.3.js"></script>
<!--<![endif]-->
<?= '<script type="text/javascript">
                        function constantes(){    
                                var dados = {
                                    "HOME" : "' . HOME . '",
                                    "INATIVO" : "' . INATIVO . '",
                                    "PASTAUPLOADS" : "' . PASTAUPLOADS . '"                                        
                                    };
                                return dados;
                        }
                </script>'; ?>
<!--<script src="<?= PASTAADMIN; ?>plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>-->
<script src="<?= INCLUDES; ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?= INCLUDES; ?>jquery.mask.js"></script>
<script type="text/javascript" src="<?= INCLUDES; ?>jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?= INCLUDES; ?>validacoes.js"></script>
<script src="<?= PASTAADMIN; ?>plugins/select2/select2.min.js"></script>
<script src="<?= PASTAADMIN; ?>js/Funcoes.js"></script>
<script>
    jQuery(document).ready(function () {
        Funcoes.init();
    });
</script>
<?php
/** @var Session $session */
$session = new Session();
if ($session->CheckSession(MENSAGEM)) {
    switch ($session::getSession(MENSAGEM)) {
        case CADASTRADO:
            Notificacoes::cadastrado();
            break;
        case ATUALIZADO:
            Notificacoes::atualizado();
            break;
        case DELETADO:
            Notificacoes::deletado();
            break;
        default:
            Notificacoes::mesagens($session::getSession(MENSAGEM), $class);
            break;
    }
    $session->FinalizaSession(MENSAGEM);
}
Notificacoes::alerta();

?>
</body>
</html>
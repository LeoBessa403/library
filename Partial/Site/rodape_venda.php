<!-- Footer section -->
<footer class="beautypress-footer-section beautypress-version-5">
    <div class="container">
        <div class="beautypress-footer-wraper">
            <div class="beautypress-footer-content">
                <div class="beautypress-footer-logo">
                    <a href="#" class="home_inicio bg-color-white" style="padding: 20px; border-radius: 10%">
                        <img src="<?= PASTASITE; ?>img/footer_logo-v4.png" alt="">
                    </a>
                </div><!-- .beautypress-footer-logo END -->
                <p>O sistema de gestão <?= DESC; ?> é ideal para SEU NEGÓCIO, Salão de Beleza, Barbearia, Clínica de
                    Estética, Ateliê de Maquiagem, Esmalteria, Spa e Outros. Acesse de qualquer lugar todas as
                    ferramentas, são muito fáceis de usar e podem ser acessadas pelo computador, Tablet ou celular.
                    Ganhe mais tempo com suas tarefas e deixe nosso sistema organizar sua agenda pra você.</p>
            </div><!-- .beautypress-footer-content END -->
            <nav class="beautypress-footer-menu">
                <ul>
                    <?php foreach ($pages as $key => $packagePage) : ?>
                        <li data-class="<?= $key; ?>" class="menu_click"><a href="#">
                                <?php echo $packagePage; ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="<?= PASTAADMIN; ?>Index/PrimeiroAcesso" target="_blank">SisBela</a></li>
                </ul>
            </nav><!-- .beautypress-footer-menu END -->
        </div><!-- .beautypress-footer-wraper END -->
    </div>
    <div class="beautypress-copyright-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                    <div class="beautypress-copyright-text">
                        <p><?php include_once 'controle_versao.php'; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><!-- .beautypress-footer-section END -->
<!-- Footer section end -->
<div class="icon-whats">
    <a class="pulse" title="Nos chame no WhatsApp"
       href="<?= Valida::geraLinkWhatSapp(Mensagens::ZAP01) ?>"
       target="_blank">
        <i class="fa fa-whatsapp"></i>
    </a>
</div>

<script src="<?= PASTASITE; ?>js/jquery-3.2.1.min.js"></script>
<script src="<?= PASTASITE; ?>js/plugins.js"></script>
<script src="<?= PASTASITE; ?>js/bootstrap.min.js"></script>
<script src="<?= PASTASITE; ?>js/bootstrap-datepicker.min.js"></script>
<script src="<?= PASTASITE; ?>js/isotope.pkgd.min.js"></script>
<script src="<?= PASTASITE; ?>js/jquery.ajaxchimp.min.js"></script>
<script src="<?= PASTASITE; ?>js/owl.carousel.min.js"></script>
<script src="<?= PASTASITE; ?>js/jquery.magnific-popup.min.js"></script>
<script src="<?= PASTASITE; ?>js/appear.js"></script>
<script src="<?= PASTASITE; ?>js/spectragram.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCy7becgYuLwns3uumNm6WdBYkBpLfy44k"></script>
<script src="<?= PASTASITE; ?>js/main.js"></script>
<script src="<?= HOME ?>library/Helpers/includes/jquery-ui.js"></script>
<script src="<?= HOME ?>library/Helpers/includes/jquery.mask.js"></script>
<script src="<?= HOME ?>library/Helpers/includes/jquery.maskMoney.js"></script>
<script src="<?= HOME ?>library/Helpers/includes/validacoes.js"></script>
<script src="<?= HOME ?>library/js/Funcoes.js"></script>
<script src="<?= HOME ?>library/plugins/select2/select2.min.js"></script>

<?php include_once PARTIAL_LIBRARY . 'constantes_javascript.php'; ?>
<?php carregaJs($url); ?>
</body>
</html>
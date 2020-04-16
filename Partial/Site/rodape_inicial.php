
<div class="beautypress-our-service-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-3 col-xl-3">
                <div class="beautypress-single-our-sevice beautypress-version-2 bg-color-white">
                    <div class="beautypress-service-header color-green">
                        <i class="fa fa-whatsapp"></i>
                    </div><!-- .beautypress-service-header END -->
                    <div class="beautypress-service-footer">
                        <a href="#" class="beautypress-service-title underline-title">Massage Parlour</a>
                        <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
                        <a href="#" class="xs-btn bg-color-purple purple-2 round-btn box-shadow-btn">
                            learn more
                            <span></span>
                        </a>
                    </div><!-- .beautypress-service-footer END -->
                </div><!-- .beautypress-single-our-sevice END -->
            </div>
            <div class="col-md-12 col-sm-12 col-lg-3 col-xl-3">
                <div class="beautypress-single-our-sevice beautypress-version-2 bg-color-white">
                    <div class="beautypress-service-header">
                        <i class="fa fa-whatsapp"></i>
                    </div><!-- .beautypress-service-header END -->
                    <div class="beautypress-service-footer">
                        <a href="#" class="beautypress-service-title underline-title">Massage Parlour</a>
                        <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>

                        <a href="#" class="xs-btn bg-color-purple purple-2 round-btn box-shadow-btn">
                            learn more
                            <span></span>
                        </a>
                    </div><!-- .beautypress-service-footer END -->
                </div><!-- .beautypress-single-our-sevice END -->
            </div>
            <div class="col-md-12 col-sm-12 col-lg-3 col-xl-3">
                <div class="beautypress-single-our-sevice beautypress-version-2 bg-color-white">
                    <div class="beautypress-service-header">
                        <i class="fa fa-whatsapp"></i>
                    </div><!-- .beautypress-service-header END -->
                    <div class="beautypress-service-footer">
                        <a href="#" class="beautypress-service-title">Therapy Parlour</a>
                        <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>

                        <a href="#" class="xs-btn bg-color-purple purple-2 round-btn box-shadow-btn">
                            learn more
                            <span></span>
                        </a>
                    </div><!-- .beautypress-service-footer END -->
                </div><!-- .beautypress-single-our-sevice END -->
            </div>
            <div class="col-md-12 col-sm-12 col-lg-3 col-xl-3">
                <div class="beautypress-single-our-sevice beautypress-version-2 bg-color-white">
                    <div class="beautypress-service-header">
                        <i class="fa fa-whatsapp"></i>
                    </div><!-- .beautypress-service-header END -->
                    <div class="beautypress-service-footer">
                        <a href="#" class="beautypress-service-title">Classical Massage</a>
                        <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>

                        <a href="#" class="xs-btn bg-color-purple purple-2 round-btn box-shadow-btn">
                            learn more
                            <span></span>
                        </a>
                    </div><!-- .beautypress-service-footer END -->
                </div><!-- .beautypress-single-our-sevice END -->
            </div>
        </div>
    </div>
</div><!-- .beautypress-our-service-section END -->
<!-- Our service -->

<!-- Footer section -->
<footer class="beautypress-footer-section beautypress-version-5">
    <div class="container">
        <div class="beautypress-footer-wraper">
            <div class="beautypress-footer-content">
                <div class="beautypress-footer-logo">
                    <a href="<?= HOME; ?>">
                        <img src="<?= PASTASITE; ?>img/footer_logo-v4.png" alt="">
                    </a>
                </div><!-- .beautypress-footer-logo END -->
                <p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. </p>
                <div class="beautypress-footer-social text-center">
                    <ul class="beautypress-social-list">
                        <?php foreach ($redesSocial as $key => $dados) : ?>
                            <li><a href="<?= $dados['link']; ?>" class="<?= $dados['class']; ?>"
                                   target="_blank" title="<?= $dados['title']; ?>"><i class="<?= $dados['iClass']; ?>">
                                    </i></a></li>
                        <?php endforeach; ?>
                    </ul><!-- .beautypress-social-list END -->
                </div>
            </div><!-- .beautypress-footer-content END -->
            <nav class="beautypress-footer-menu">
                <ul>
                    <?php foreach ($pages as $key => $packagePage) : ?>
                        <li class="<?= $key; ?>"><a href="#">
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
<script src="<?= HOME ?>library/Helpers/includes/jquery.mask.js"></script>

<?php include_once PARTIAL_LIBRARY . 'constantes_javascript.php'; ?>
    <?php carregaJs($url); ?>
</body>
</html>
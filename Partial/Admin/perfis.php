<li class="dropdown">
    <?php
    $no_perfis = $user[md5('no_perfis')];
    $perfis = explode(', ', $no_perfis);
    ?>
    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown"
       href="#">
        <i class="clip-users"></i>
        <span class="badge"> <?= count($perfis) ?></span>
    </a>
    <ul class="dropdown-menu posts">
        <li>
            <span class="dropdown-menu-title pullUp"> <?= count($perfis) ?> Perfis Ativos</span>
        </li>
        <li>
            <div class="drop-down-wrapper ps-container">
                <ul>
                    <?php
                    foreach ($perfis as $perfil) {
                        ?>
                        <li>
                            <a href="javascript:">
                                <div class="clearfix">
                                    <div class="thread-content">
                                        <span class="author"><?= $perfil; ?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="ps-scrollbar-x-rail"
                     style="left: 0px; bottom: 3px; width: 270px; display: none;">
                    <div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps-scrollbar-y-rail"
                     style="top: 0px; right: 3px; height: 250px; display: inherit;">
                    <div class="ps-scrollbar-y" style="top: 0px; height: 125px;"></div>
                </div>
            </div>
        </li>
        <!--                            <li class="view-all">-->
        <!--                                <a href="pages_messages.html">-->
        <!--                                    See all messages <i class="fa fa-arrow-circle-o-right"></i>-->
        <!--                                </a>-->
        <!--                            </li>-->
    </ul>
</li>
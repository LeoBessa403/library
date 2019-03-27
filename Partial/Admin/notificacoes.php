<li class="dropdown" xmlns="http://www.w3.org/1999/html">
    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#" id="notif">
        <i class="fa-envelope fa"></i>
        <span class="badge"><span class="nu_notificacoes">0</span></span>
    </a>
    <ul class="dropdown-menu posts">
        <li>
            <span class="dropdown-menu-title pullUp"> Você tem <span class="nu_notificacoes"></span> Notificações</span>
        </li>
        <li>
            <div class="drop-down-wrapper ps-container notifica">
                <ul>
                    <?php
                    if ($user[md5(DT_EXPIRACAO)]) {
                        if ($user[md5('status_sistema')] == StatusSistemaEnum::EXPIRANDO) {
                            $difDatas = Valida::CalculaDiferencaDiasData(date('d/m/Y'), $user[md5(DT_EXPIRACAO)]);
                            ?>
                            <li>
                                <a href="javascript:">
                                    <div class="clearfix">
                                        <div class="thread-image">
                                            <?= Valida::getImgSistema(); ?>
                                        </div>
                                        <div class="thread-content">
                                            <span class="author">Renovação da Assinatura</span>
                                            <span class="preview"><b>Sua assinatura irá expirar em <?= $difDatas; ?>
                                                    Dias</b>, click no link para
                                        renovar sua assinatura.</span>
                                            <span class="time"> Expira Em <?= $user[md5(DT_EXPIRACAO)]; ?></span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php }
                    } ?>
                    <?php
                    if ($user[md5(ST_DADOS_COMPLEMENTARES)] == SimNaoEnum::NAO) {
                        ?>
                        <li>
                            <a href="javascript:">
                                <div class="clearfix">
                                    <div class="thread-image">
                                        <?= Valida::getImgSistema(); ?>
                                    </div>
                                    <div class="thread-content">
                                        <span class="author">Dados Complementares</span>
                                        <span class="preview"><b>Preencha os seus dados complementares para
                                                completar as informações para sua página! Acesse no Menu.</br>
                                        <big>Assinante >> DadosComplementares</big></b></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    } ?>
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
    </ul>
</li>
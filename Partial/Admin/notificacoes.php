<style>
    .click_aqui {
        color: white;
        font-weight: bolder;
    }

    .click_aqui:hover {
        color: darkgrey;
    }
</style>
<li class="dropdown" xmlns="http://www.w3.org/1999/html">
    <a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#"
       id="notif">
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
                    $retorno = AssinanteService::verificaStatusSistema();
                    if ($retorno['status_sistema'] == StatusSistemaEnum::EXPIRANDO) {
                        ?>
                        <li>
                            <a href="<?= HOME . ADMIN; ?>/Assinante/MeuPlanoAssinante">
                                <div class="clearfix">
                                    <div class="thread-image">
                                        <?= Valida::getImgSistema(); ?>
                                    </div>
                                    <div class="thread-content">
                                        <span class="author">Renovação da Assinatura</span>
                                        <span class="preview"><b>Sua assinatura irá expirar em <?= $retorno['dias']; ?>
                                                    Dias</b>, click no link para
                                        renovar sua assinatura.</span>
                                        <span class="time"> Expira Em <?= $retorno['dtExpiracao']; ?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    } ?>
                    <?php
                    $retorno = AssinanteService::verificaStatusSistema();
                    if ($retorno['status_sistema'] == StatusSistemaEnum::PENDENTE) {
                        ?>
                        <li>
                            <a href="<?= HOME . ADMIN; ?>/Assinante/MeuPlanoAssinante">
                                <div class="clearfix">
                                    <div class="thread-image">
                                        <?= Valida::getImgSistema(); ?>
                                    </div>
                                    <div class="thread-content">
                                        <span class="author">Sistema Expirado!</span>
                                        <span class="preview"><b>Sua assinatura está expirada e pagamento pendente em
                                                <?= $retorno['dias'] * -1; ?> Dias</b>, click no link para
                                        renovar sua assinatura.</span>
                                        <span class="time"> Expira Em <?= $retorno['dtExpiracao']; ?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    } ?>
                    <?php
                    if (SuporteService::PesquisaCountMensagens()) {
                        ?>
                        <li>
                            <a href="<?= HOME . ADMIN; ?>/Suporte/ListarSuporte">
                                <div class="clearfix">
                                    <div class="thread-image">
                                        <?= Valida::getImgSistema(); ?>
                                    </div>
                                    <div class="thread-content">
                                        <span class="author">Você tem
                                            <b><?= SuporteService::PesquisaCountMensagens(); ?></b>
                                        Mensagem(ns) não Lida.</span>
                                        <span class="preview"><b>Caso queira ver as mensagens, click aqui para
                                                ver sau caixa de mensagens.</b></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php
                    } ?>
                    <?php
                    if (isset($user[md5(ST_DADOS_COMPLEMENTARES)]) &&
                        $user[md5(ST_DADOS_COMPLEMENTARES)] == SimNaoEnum::NAO) {
                        ?>
                        <li>
                            <a href="<?= HOME . ADMIN; ?>/Assinante/DadosComplementaresAssinante">
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
            </div>
        </li>
    </ul>
</li>
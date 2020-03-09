<?php
// VERIFICA STATUS DO SISTEMA DO ASSINANTE
$retorno = AssinanteService::verificaStatusSistema();

// ALERTA PARA O ASSINANTE CASO O SISTEMA ESTEJA EXPIRANDO
if ($retorno['status_sistema'] == StatusSistemaEnum::EXPIRANDO && UrlAmigavel::$action == ACTION_INICIAL_ADMIN &&
    UrlAmigavel::$controller == CONTROLLER_INICIAL_ADMIN) {
    Notificacoes::geraMensagem(
        '<h6><b>Renovação da Assinatura</b></h6>
                                Sua assinatura irá expirar em <b>' . $retorno['dias'] . ' Dias</b>, 
                                <a class="click_aqui" href="' . HOME . ADMIN .
        '/Assinante/MeuPlanoAssinante">CLICK AQUI</a>
                                 para renovar sua assinatura. <span class="time"> Expira Em ' .
        $retorno['dtExpiracao'] . '</span>',
        TiposMensagemEnum::ALERTA
    );
}
// ALERTA PARA O ASSINANTE CASO O SISTEMA ESTEJA PENDENTE
if ($retorno['status_sistema'] == StatusSistemaEnum::PENDENTE  && UrlAmigavel::$action == ACTION_INICIAL_ADMIN &&
    UrlAmigavel::$controller == CONTROLLER_INICIAL_ADMIN) {
    $dados['titulo'] = 'Sistema Expirado!';
    $dados['mensagem'] = '<p>Sua assinatura está expirada e pagamento pendente em <b>' . $retorno['dias'] * -1 .
        ' Dia(s)</b>, <a class="click_aqui" href="' . HOME . ADMIN .
        '/Assinante/MeuPlanoAssinante">CLICK AQUI</a> para renovar sua assinatura. Expirado Em ' .
        $retorno['dtExpiracao'] . '</p>';
    $dados['tipo'] = TiposMensagemEnum::ERRO;
    Notificacoes::notificacao($dados);
}
// ALERTA DE TROCA DE SENHA
if ($user[md5(ST_TROCA_SENHA)] == SimNaoEnum::NAO && empty($session->CheckSession(ST_TROCA_SENHA)) &&
    UrlAmigavel::$action == 'Index' && UrlAmigavel::$controller == 'Index') {

    $dados['titulo'] = 'Cadastro Ativado com Sucesso!';
    $dados['mensagem'] = '<p>Para trocar sua senha acesseo link <a href="' . PASTAADMIN . 'Usuario/TrocaSenhaUsuario"
                                                               style="color:#ccc">TROCAR SENHA</a>, 
                                                               para sua maior segurança</p>';
    $dados['tipo'] = TiposMensagemEnum::SUCESSO;
    Notificacoes::notificacao($dados);

}
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
            Notificacoes::mesagens($session::getSession(MENSAGEM), $session::getSession(TIPO));
            break;
    }
    $session->FinalizaSession(MENSAGEM);
}
Notificacoes::alerta();
Modal::ModalConfirmaAtivacao();

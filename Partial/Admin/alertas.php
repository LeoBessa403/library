<?php
if ($user[md5(ST_TROCA_SENHA)] == SimNaoEnum::NAO && empty($session->CheckSession(ST_TROCA_SENHA)) &&
    UrlAmigavel::$action == 'Index' && UrlAmigavel::$controller == 'Index') {

    $dados['titulo'] = 'Cadastro Ativado com Sucesso!';
    $dados['mensagem'] = '<p>Para trocar sua senha acesseo link <a href="' . PASTAADMIN . 'Usuario/TrocaSenhaUsuario"
                                                               style="color:#ccc">TROCAR SENHA</a>, para sua maior segurança</p>';
    $dados['tipo'] = TiposMensagemEnum::SUCESSO;
    Notificacoes::notificacao($dados);

}
if (!empty($user[md5('status_sistema')])) {
    if ($user[md5('status_sistema')] == StatusSistemaEnum::PENDENTE) {
        $difDatas = Valida::CalculaDiferencaDiasData(date('d/m/Y'), $user[md5(DT_EXPIRACAO)]);

        $dados['titulo'] = 'Sistema Expirado!';
        $dados['mensagem'] = '<p>Sua assinatura está expirada em <b>' . $difDatas * -1 . ' Dia(s)</b>, click no link para
    renovar sua assinatura. Expirado Em ' . $user[md5(DT_EXPIRACAO)] . '</p>';
        $dados['tipo'] = TiposMensagemEnum::ERRO;
        Notificacoes::notificacao($dados);
    }
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

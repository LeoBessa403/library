<?php

/**
 * WhatsAppService.class [ SEVICE ]
 * @copyright (c) 2020, Leo Bessa
 */
class  WhatsAppService extends AbstractService
{

    private $urlApiWhats;
    private $tokenApiWhats;


    public function __construct()
    {
        $this->urlApiWhats = "https://api.chat-api.com/instance" . WHATSAPP_INSTANCE . "/";
        $this->tokenApiWhats = API_WHATS_TOKEN;
        if (!$this->verificaStatus()) {

            if (PerfilService::perfilMaster()) {
                Notificacoes::geraMensagem(
                    'O Status do Servidor de Envio do WhatsApp esta Inativo.<br>' .
                    'Verifique as configurações no site:
            <a href="https://app.chat-api.com/login" target="_blank">Chat Api</a>',
                    TiposMensagemEnum::ERRO
                );
            } else {
                Notificacoes::geraMensagem(
                    'O Status do Servidor de Envio do WhatsApp esta Inativo.<br>' .
                    'Favor entrar em Contato com o Administrador do Sistema: <br>
                    <div class="icon-whats">
             <a class="pulse" title="Nos chame no WhatsApp"
                           href="' . Valida::geraLinkWhatSapp('Status do WhatsApp do Sistema esta Inativo.') . '"
                           target="_blank">
                            <i class="fa fa-whatsapp"></i>
                        </a></div>',
                    TiposMensagemEnum::ALERTA
                );
            }

            Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller .
                '/' . UrlAmigavel::$action);
        }
    }

    public function verificaStatus()
    {
        if (API_WHATS_SERVER) {
            $url = $this->urlApiWhats . 'status?token=' . $this->tokenApiWhats;
            $result = file_get_contents($url); // Send a request
            $data = json_decode($result, 1); // Parse JSON
            if ($data["accountStatus"] == 'authenticated') {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function enviarMensagem($telDestinatario, $msg, $nacional = true)
    {
        $msgZap = urldecode($msg);
        $telDestinatario = filter_var(Valida::RetiraMascara($telDestinatario), FILTER_SANITIZE_NUMBER_INT);
        $url = $this->urlApiWhats . 'sendMessage?token=' . $this->tokenApiWhats;
        $telSendMsg = (PROD) ? ($nacional) ? '55' . $telDestinatario : $telDestinatario : WHATSAPP_MSG;
        $data = [
            'phone' => $telSendMsg, // Número do Telefone
            'body' => $msgZap, // Menssagem
        ];
        $json = json_encode($data); // Encode data to JSON
        // Make a POST request
        $options = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => $json
        ]
        ]);
        // Send a request
        return file_get_contents($url, false, $options);
    }

    public function enviarMensagemArquivo($telDestinatario, $msg, $arquivo, $nacional = true)
    {
        $msgZap = urldecode($msg);
        $telDestinatario = filter_var(Valida::RetiraMascara($telDestinatario), FILTER_SANITIZE_NUMBER_INT);
        $url = $this->urlApiWhats . 'sendFile?token=' . $this->tokenApiWhats;
        $telSendMsg = (PROD) ? ($nacional) ? '55' . $telDestinatario : $telDestinatario : WHATSAPP_MSG;
        $data = [
            'phone' => $telSendMsg, // Número do Telefone
            'body' => $arquivo['caminho'], // Arquivo
            'filename' => $arquivo['nome'], // Nome do Arquivo
            'caption' => $msgZap, // Menssagem com o Arquivo
        ];
        $json = json_encode($data); // Encode data to JSON
        // Make a POST request
        $options = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => $json
        ]
        ]);
        // Send a request
        return file_get_contents($url, false, $options);
    }

    public function enviaMsgRetornoPagamento($coAssinante, $Xml)
    {
        /** @var AssinanteService $AssinanteService */
        $AssinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var AssinanteEntidade $assinante */
        $assinante = $AssinanteService->PesquisaUmRegistro($coAssinante);

        $data = explode('T', (string)$Xml->lastEventDate);
        $hora = explode('.', $data[1]);

        $msg = '  Olá, ' . strtoupper($assinante->getCoPessoa()->getNoPessoa()) . ', Eu Sou O *SisBela*, 
seu _Sistema da Beleza_, e gostaria de te informar que o _Pagamento_ do Assinante *' .
            $assinante->getCoEmpresa()->getNoFantasia() . '* Mudou o Status do pagamento para _*' .
            StatusPagamentoEnum::getDescricaoValor((string)$Xml->status) . '*_ em ' .
            Valida::DataShow($data[0] . ' ' . $hora[0], 'd/m/Y H:i') .
            ' conforme retornado da operadora do pagamento. 
            
   Acesse nosso sistema para maiores Informações.';
        return $this->enviarMensagem($assinante->getCoPessoa()->getCoContato()->getNuTel1(), $msg);
    }

    public function enviaMsgUsuarioInicial($dadosEmail, $coUsuario)
    {
        $Mensagem = "  Olá " . strtoupper($dadosEmail[NO_PESSOA]) . ", Seu cadastro no *" . DESC .
            "* foi realizado com sucesso.
                 
   Sua senha é: _*" . $dadosEmail[DS_SENHA] . "*_";
        $Mensagem .= ". 
        _Ao acesso o Sistema pela primeira vez, deve trocar a senha._
              
   Acesse o Nosso _Sistema da Beleza_ agora mesmo e começe a usar-lo para uma melhor organização de sua agenda. Esperamos por você
   
   Acesso o link para a <a href='" . HOME . "admin/Index/AtivacaoUsuario/" .
            Valida::GeraParametro(CO_USUARIO . "/" . $coUsuario) . "'>ATIVAÇÃO DO CADASTRO</a>";
        return $this->enviarMensagem($dadosEmail[NU_TEL1], $Mensagem);
    }


}
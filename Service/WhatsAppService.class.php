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
        $this->urlApiWhats = API_WHATS_URL;
        $this->tokenApiWhats = API_WHATS_TOKEN;
    }

    public function verificaStatus()
    {
        $url = $this->urlApiWhats . 'status?token=' . $this->tokenApiWhats;
        $result = file_get_contents($url); // Send a request
        $data = json_decode($result, 1); // Parse JSON
        if($data["accountStatus"] == 'authenticated'){
            return true;
        }else{
            return false;
        }
    }

    public function enviarMensagem($telDestinatario, $msg)
    {
        if($this->verificaStatus()){
            $msgZap = urldecode($msg);
            $telDestinatario = filter_var(Valida::RetiraMascara($telDestinatario), FILTER_SANITIZE_NUMBER_INT);
            $url = $this->urlApiWhats . 'sendMessage?token=' . $this->tokenApiWhats;
            $telSendMsg = (PROD) ? '55' . $telDestinatario : WHATSAPP_MSG;
            $data = [
                'phone' => $telSendMsg, // Receivers phone
                'body' => $msgZap, // Message
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
        }else{
            return false;
        }

    }


}
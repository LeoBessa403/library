<?php

/**
 * Email.class [ HELPER ]
 * Reponsável por envio de E-mails do Sistema!
 * 
 * @copyright (c) 2015, Leonardo Bessa
 */
class Email {

    /** @var PHPMailer */
    public $Mail;

    /** CONSTROLE */
    private $Error;
    private $Result;

    private $Email_Destinatario;
    private $Email_Remetente;
    private $Senha_Email_Remetente;
    private $Titulo;
    private $Mensagem;

    /**
     * Email constructor.
     * @param null $Email_Remetente
     * @param null $Senha_Email_Remetente
     */
    function __construct($Email_Remetente = null, $Senha_Email_Remetente = null){
        $this->Email_Remetente = ($Email_Remetente)? $Email_Remetente : USER_EMAIL; 
        $this->Senha_Email_Remetente = ($Senha_Email_Remetente)? $Senha_Email_Remetente : PASS_EMAIL;
        $this->Mail = new PHPMailer(true);
    }

    /**
     * Verifica e cria o diretório padrão de uploads no sistema!<br>
     * <b>../uploads/</b>
     */
    function Enviar() {
        
        $compara = strstr(HOME,'localhost');
        if($compara == null):
                /** @var PHPMailer $mail*/
                $mail = $this->Mail;
                $this->Mail->CharSet = 'utf-8';
                $this->Mail->setLanguage('pt');
                $mail->IsSMTP();
                $mail->SMTPAuth   = true;
                $mail->IsHTML(true); 

                $mail->Host       = HOST_EMAIL;
                $mail->Port       = PORTA_EMAIL;
                $mail->Username   = $this->Email_Remetente;
                $mail->Password   = $this->Senha_Email_Remetente;
                $mail->SMTPDebug  = 1;       
                $mail->From = utf8_decode($this->Email_Remetente);
                $mail->FromName = utf8_decode(DESC);
                $mail->Subject = utf8_decode($this->Titulo);
                $mail->Body = utf8_decode($this->Mensagem);
                $mail->AltBody = 'Mensagem de Erro automática, favor não responder!'; // optional - MsgHTML will create an alternate automatically
                foreach ($this->Email_Destinatario as $nome => $email) {
                    if($email){
                        $mail->AddAddress(utf8_decode($email), utf8_decode($nome));
                        if($mail->Send()){
                            $this->Error = null;
                            $this->Result = true;
                        }else{
                            $this->Error = '<b>ERRO AO ENVIAR E-MAIL:</b> ' . $mail->ErrorInfo;
                            $this->Result = false;
                        }
                        /* Limpa tudo */
                        $mail->ClearAllRecipients();
                    }
                }
            $mail->ClearAttachments();
            $mail->clearAddresses();
        endif;
       
    }

    /**
     * @param array $Email_Destinatario
     * @return $this
     */
    public function setEmailDestinatario(Array $Email_Destinatario) {
        $this->Email_Destinatario = $Email_Destinatario;
        return $this;
    }
    
    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     */
    public function getEmailDestinatario() {
        return $this->Email_Destinatario;
    }

    /**
     * @param $Titulo
     * @return $this
     */
    public function setTitulo($Titulo) {
        $this->Titulo = $Titulo;
        return $this;
    }

    /**
     * @param $Mensagem
     * @return $this
     */
    public function setMensagem($Mensagem) {
        $this->Mensagem = $Mensagem;
        return $this;
    }
    
    /**
     * @param $File
     * @throws phpmailerException
     *  <b>Enviar Anexo:</b> Efetue o Upload da imagem com a classe de upload. Com o getResult() deste envio, basta anexar ao e-mail!
     */
    public function addFile($File) {
        $this->File = $this->Mail->AddAttachment($File);
    }

    /**
     * <b>Verificar Envio:</b> Executando um getResult é possível verificar se foi ou não efetuado
     * o envio do e-mail. Para mensagens execute o getError();
     * @return BOOL $Result = TRUE or FALSE
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com o erro e o tipo de erro.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError() {
        return $this->Error;
    }

    

}


  

   
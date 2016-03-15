<?php

/**
 * Upload.class [ HELPER ]
 * Reponsável por envio de E-mails do Sistema!
 * 
 * @copyright (c) 2015, Leonardo Bessa
 */
class Email {

    private $Email_Destinatario;
    private $Email_Remetente;
    private $Senha_Email_Remetente;
    private $Titulo;
    private $Mensagem;
  
    /**
     * <b>setClasses:</b> ionicia o formulário e suas configurações
     * @param STRING $idform: atribui o ID para o Formulário
     */
    function __construct($Email_Remetente = null, $Senha_Email_Remetente = null){
        $this->Email_Remetente = ($Email_Remetente)? $Email_Remetente : USER_EMAIL; 
        $this->Senha_Email_Remetente = ($Senha_Email_Remetente)? $Senha_Email_Remetente : PASS_EMAIL;
    }

    /**
     * Verifica e cria o diretório padrão de uploads no sistema!<br>
     * <b>../uploads/</b>
     */
    function Enviar() {
        
        $compara = strstr(HOME,'localhost');
        if($compara == null):
                $control = TRUE;
                $mail = new PHPMailer(true);
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
        //            $mail->AddAttachment('images/phpmailer.gif');      // attachment
        //            $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                foreach ($this->Email_Destinatario as $nome => $email) {
                    if($email){
                        $mail->AddAddress(utf8_decode($email), utf8_decode($nome));
                        if($mail->Send())
                            $valida = TRUE;
                        else
                            $valida = FALSE;
                        /* Limpa tudo */
                        $mail->ClearAllRecipients();
                        $mail->ClearAttachments();
                        if($valida == FALSE){
                            $control = FALSE;
                        }
                    }
                }


                if($control == true)
                    return TRUE;
                else
                    return $mail->ErrorInfo;
        endif;
       
    }

    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function setEmailDestinatario(Array $Email_Destinatario) {
        $this->Email_Destinatario = $Email_Destinatario;
        return $this;
    }
    
    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function getEmailDestinatario() {
        return $this->Email_Destinatario;
    }
    
    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function setTitulo($Titulo) {
        $this->Titulo = $Titulo;
        return $this;
    }
    
    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function getTitulo() {
        return $this->Titulo;
    }
    
    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function setMensagem($Mensagem) {
        $this->Mensagem = $Mensagem;
        return $this;
    }
    
    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function getMensagem() {
        return $this->Mensagem;
    }
    

}


  

   
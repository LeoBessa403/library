<?php

/**
 * Upload.class [ HELPER ]
 * Reponsável por executar upload de imagens, arquivos e mídias no sistema!
 *
 * @copyright (c) 2014, Leonardo Bessa
 */
class Upload
{

    private $File;
    private $Name;

    /** IMAGE UPLOAD */
    private $Width;
    private $Image;

    /** RESULTSET */
    private $Result;
    private $Error;

    /** DIRETÓTIOS */
    private $Folder;
    public static $BaseDir;

    /**
     * Verifica e cria o diretório padrão de uploads no sistema!<br>
     * <b>../uploads/</b>
     */
    function __construct()
    {
        self::$BaseDir = PASTA_UPLOADS;
        if (!file_exists(self::$BaseDir) && !is_dir(self::$BaseDir)):
            mkdir(self::$BaseDir, 0777);
        endif;
    }


    /**
     * <b>Enviar Imagens Multiplas:</b> Basta envelopar um $_FILES['fotos'] de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param FILES $Image = Enviar envelope de $_FILES (JPG ou PNG)
     * @param STRING $Name = Nome da imagems ( ou do artigo )
     * @param STRING $Folder = Pasta personalizada
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    public function UploadImagens($Files, $Nome, $Folder = null, $Width = null)
    {
        $Nome_Arquivo = [];
        for ($i = 0; $i < count($Files["name"]); $i++):
            if (count($Files["name"]) < 2):
                if(is_array($Files["name"])){
                    $Arquivo['name'] = $Files['name'][0];
                    $Arquivo['type'] = $Files['type'][0];
                    $Arquivo['tmp_name'] = $Files['tmp_name'][0];
                    $Arquivo['error'] = $Files['error'][0];
                    $Arquivo['size'] = $Files['size'][0];
                }else{
                    $Arquivo['name'] = $Files['name'];
                    $Arquivo['type'] = $Files['type'];
                    $Arquivo['tmp_name'] = $Files['tmp_name'];
                    $Arquivo['error'] = $Files['error'];
                    $Arquivo['size'] = $Files['size'];
                }
            else:
                $Arquivo['name'] = $Files['name'][$i];
                $Arquivo['type'] = $Files['type'][$i];
                $Arquivo['tmp_name'] = $Files['tmp_name'][$i];
                $Arquivo['error'] = $Files['error'][$i];
                $Arquivo['size'] = $Files['size'][$i];
            endif;
            $this->UploadImagem($Arquivo, $Nome, $Folder, $Width);
            $Nome_Arquivo[$i] = $this->getResult();
        endfor;
        return $Nome_Arquivo;
    }

    /**
     * <b>Enviar Arquivo:</b> Basta envelopar um $_FILES de um arquivo e caso queira um nome e um tamanho personalizado.
     * Caso não informe o tamanho será 2mb!
     * @param FILES $File = Enviar envelope de $_FILES (PDF ou DOCX)
     * @param STRING $Name = Nome do arquivo ( ou do artigo )
     * @param STRING $Folder = Pasta personalizada
     * @param STRING $MaxFileSize = Tamanho máximo do arquivo (2mb)
     */
    public function UploadArquivo(array $File, $Name = null, $Folder = null, $MaxFileSize = null)
    {
        $this->File = $File;
        $this->Name = ((string)$Name ? $Name : substr($File['name'], 0, strrpos($File['name'], '.')));
        $this->Folder = ((string)$Folder ? $Folder : 'files');
        $MaxFileSize = ((int)$MaxFileSize ? $MaxFileSize : 2);

        $FileAccept = array(
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/pdf'
        );

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo não suportado. Envie .PDF ou .DOCX!';
        else:
            $this->CreateFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    /**
     * <b>Enviar Mídia:</b> Basta envelopar um $_FILES de uma mídia e caso queira um nome e um tamanho personalizado.
     * Caso não informe o tamanho será 40mb!
     * @param FILES $Media = Enviar envelope de $_FILES (MP3 ou MP4)
     * @param STRING $Name = Nome do arquivo ( ou do artigo )
     * @param STRING $Folder = Pasta personalizada
     * @param STRING $MaxFileSize = Tamanho máximo do arquivo (40mb)
     */
    public function UploadMidia(array $midia, $Name = null, $Folder = null, $MaxFileSize = null)
    {
        $this->File = $midia;
        $this->Name = ((string)$Name ? $Name : substr($midia['name'], 0, strrpos($midia['name'], '.')));
        $this->Folder = ((string)$Folder ? $Folder : 'medias');
        $MaxFileSize = ((int)$MaxFileSize ? $MaxFileSize : 40);

        $FileAccept = array(
            'audio/mp3',
            'video/mp4'
        );

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo não suportado. Envie audio MP3 ou vídeo MP4!';
        else:
            $this->CreateFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    /**
     * <b>Verificar Upload:</b> Executando um getResult é possível verificar se o Upload foi executado ou não. Retorna
     * uma string com o caminho e nome do arquivo ou FALSE.
     * @return STRING  = Caminho e Nome do arquivo ou False
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com um code, um title, um erro e um tipo.
     * @return ARRAY $Error = Array associatico com o erro
     */
    public function getError()
    {
        return $this->Error;
    }

    /**
     * <b>Obter Nome da Imagem:</b>
     * @return STRING nome da imagem
     */
    public function getNameImage()
    {
        return $this->Name;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    /**
     * <b>Enviar Imagem:</b> Basta envelopar um $_FILES de uma imagem e caso queira um nome e uma largura personalizada.
     * Caso não informe a largura será 1024!
     * @param FILES $Image = Enviar envelope de $_FILES (JPG ou PNG)
     * @param STRING $Name = Nome da imagems ( ou do artigo )
     * @param STRING $Folder = Pasta personalizada
     * @param INT $Width = Largura da imagem ( 800 padrão )
     */
    private function UploadImagem(array $Image, $Name = null, $Folder = null, $Width = null)
    {
        $this->File = $Image;
        $this->Name = ((string)$Name ? $Name : substr($Image['name'], 0, strrpos($Image['name'], '.')));
        $this->Width = ((int)$Width ? $Width : TAMANHO);
        $this->Folder = ($Folder ? $Folder : "");

        $this->CreateFolder($this->Folder);
        $this->setFileName();
        $this->UploadImage();
    }

    //Verifica e cria o diretório base!
    private function CreateFolder($Folder)
    {
        $Folder = explode("/", $Folder);
        $pasta = "";
        foreach ($Folder as $value) {
            if($value){
                $pasta .= $value . "/";
                if (!file_exists(self::$BaseDir . $pasta) && !is_dir(self::$BaseDir . $pasta)):
                    mkdir(self::$BaseDir . $pasta, 0777);
                endif;
            }
        }
        $this->Folder = $pasta;
    }

    //Verifica e monta o nome dos arquivos tratando a string!
    private function setFileName()
    {
        $FileName = Valida::ValNome($this->Name) . '-' . uniqid() . strrchr($this->File['name'], '.');
        $this->Name = $FileName;
    }

    //Realiza o upload de imagens redimensionando a mesma!
    private function UploadImage()
    {
        switch ($this->File['type']):
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->Image = imagecreatefromjpeg($this->File['tmp_name']);
                break;
            case 'image/png':
            case 'image/x-png':
                $this->Image = imagecreatefrompng($this->File['tmp_name']);
                break;
        endswitch;

        if (!$this->Image):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG!';
        else:
            $x = imagesx($this->Image);
            $y = imagesy($this->Image);
            $ImageX = ($this->Width < $x ? $this->Width : $x);
            $ImageH = ($ImageX * $y) / $x;

            $NewImage = imagecreatetruecolor($ImageX, $ImageH);
            imagealphablending($NewImage, false);
            imagesavealpha($NewImage, true);
            imagecopyresampled($NewImage, $this->Image, 0, 0, 0, 0, $ImageX, $ImageH, $x, $y);

            switch ($this->File['type']):
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewImage, self::$BaseDir . $this->Folder . $this->Name, 100);
                    break;
                case 'image/png':
                case 'image/x-png':
                    imagepng($NewImage, self::$BaseDir . $this->Folder . $this->Name);
                    break;
            endswitch;

            if (!$NewImage):
                $this->Result = false;
                $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG!';
            else:
                $this->Result = $this->Folder . $this->Name;
                $this->Error = null;
            endif;

            imagedestroy($this->Image);
            imagedestroy($NewImage);
        endif;
    }

    //Envia arquivos e mídias
    private function MoveFile()
    {
        if (move_uploaded_file($this->File['tmp_name'], self::$BaseDir . $this->Folder . $this->Name)):
            $this->Result = $this->Name;
            $this->Error = null;
        else:
            $this->Result = false;
            $this->Error = 'Erro ao mover o arquivo. Favor tente mais tarde!';
        endif;
    }

}


  

   
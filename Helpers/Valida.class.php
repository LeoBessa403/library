<?php

/**
 * Check.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * @copyright (c) 2014, Leo Bessa
 */
class Valida
{

    private static $Data;
    private static $Format;

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true,
     * ou retorna false.
     * @param STRING $email = Uma conta de e-mail
     * @return BOOL = 1 para True em um email válido, ou 2 para false
     */
    public static function ValEmail($email)
    {
        self::$Data = (string)$email;
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$Format, self::$Data)):
            return 1;
        else:
            return 2;
        endif;
    }

    /**
     * <b>Verifica CPF:</b> Executa validação CPF
     * @param STRING $cpf = Número de CPF.
     * @return BOOL = 1 para CPF válido, ou 2 para false.
     */
    public static function ValCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (empty($cpf) || strlen($cpf) != 11) {
            return 2;
        }
        $digitoA = 0;
        $digitoB = 0;
        for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
            $digitoA += $cpf[$i] * $x;
        }
        for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
            if (str_repeat($i, 11) == $cpf) {
                return 2;
            }
            $digitoB += $cpf[$i] * $x;
        }
        $somaA = (($digitoA % 11) < 2) ? 0 : 11 - ($digitoA % 11);
        $somaB = (($digitoB % 11) < 2) ? 0 : 11 - ($digitoB % 11);
        if ($somaA != $cpf[9] || $somaB != $cpf[10]) {
            return 2;
        } else {
            return 1;
        }
    }

    /**
     * <b>Verifica CNPJ:</b> Executa validação do CNPJ
     * @param STRING $cnpj = Número de CNPJ.
     * @return BOOL = 1 para True para CNPJ válido, ou 2 para false.
     */
    public static function ValCNPJ($cnpj)
    {
        $soma = 0;
        $multiplicador = 0;
        $multiplo = 0;
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (empty($cnpj) || strlen($cnpj) != 14) {
            return 2;
        }
        for ($i = 0; $i <= 9; $i++) {
            $repetidos = str_pad('', 14, $i);
            if ($cnpj === $repetidos) {
                return 2;
            }
        }
        $parte1 = substr($cnpj, 0, 12);
        $parte1_invertida = strrev($parte1);
        for ($i = 0; $i <= 11; $i++) {
            $multiplicador = ($i == 0) || ($i == 8) ? 2 : $multiplicador;
            $multiplo = ($parte1_invertida[$i] * $multiplicador);
            $soma += $multiplo;
            $multiplicador++;
        }
        $rest = $soma % 11;
        $dv1 = ($rest == 0 || $rest == 1) ? 0 : 11 - $rest;
        $parte1 .= $dv1;
        $parte1_invertida = strrev($parte1);
        $soma = 0;
        for ($i = 0; $i <= 12; $i++) {
            $multiplicador = ($i == 0) || ($i == 8) ? 2 : $multiplicador;
            $multiplo = ($parte1_invertida[$i] * $multiplicador);
            $soma += $multiplo;
            $multiplicador++;
        }
        $rest = $soma % 11;
        $dv2 = ($rest == 0 || $rest == 1) ? 0 : 11 - $rest;
        if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]):
            return 1;
        else:
            return 2;
        endif;

    }

    /**
     * <b>Mensagem:</b> função para gerar mensagens do sistema
     * @param STRING $msg : Mensagem a ser apresentada
     * @param INT $typo : atribui a classe para ser estilizada <br>(1 - Sucesso, ok / 2 - Informativo /
     * <br>3 - Alerta / 4 - Erro).
     */
    public static function Mensagem($msg, $typo, $termina = null)
    {
        $class = ($typo == 1 ? "success" : ($typo == 2 ? "info" : ($typo == 3 ? "warning" : "danger")));
        $label = ($typo == 1 ? "SUCESSO" : ($typo == 2 ? "INFORMATIVO" : ($typo == 3 ? "ALERTA" : "ERRO")));
        $icon = ($typo == 1 ? "check-circle" : ($typo == 2 ? "info-circle" :
            ($typo == 3 ? "exclamation-triangle" : "times-circle"))
        );

        echo '<div id="sumir" class="alert alert-' . $class . '" style="padding-left: 30px;">
                <p data-dismiss="alert" class="close" style="margin-top: 0;">
                        &times;
                </p>
                <i class="fa fa-' . $icon . '"></i>                
                <b>' . $label . ': </b>' . $msg . '
            </div>';

        if ($termina):
            die;
        endif;
    }

    /**
     * <b>Tranforma Data pro formato do Banco:</b> Transforma uma data no formato DD/MM/YY em
     * uma data no formato TIMESTAMP!
     * @param STRING $data = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public static function DataDB($data)
    {
        self::$Format = explode(' ', $data);
        self::$Data = explode('/', self::$Format[0]);

        if (empty(self::$Format[1])):
            self::$Format[1] = date('H:i:s');
        endif;

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
        return self::$Data;
    }

    /**
     * <b>Tranforma Data pro formato do Banco DATE:</b> Transforma uma data no formato DD/MM/YY
     * em uma data no formato TIMESTAMP!
     * @param STRING $data = Data em (d/m/Y)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public static function DataDBDate($data)
    {
        self::$Data = explode('/', $data);

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0];
        return self::$Data;
    }

    /**
     * @param $link
     * @return string
     */
    public static function GeraParametro($link)
    {
        self::$Data = explode('/', $link);
        $link = md5(self::$Data[0]) . "/" . base64_encode(self::$Data[1]);
        if (!empty(self::$Data[2])) {
            $link .= "/" . md5(self::$Data[2]) . "/" . base64_encode(self::$Data[3]);
        }
        if (!empty(self::$Data[4])) {
            $link .= "/" . md5(self::$Data[4]) . "/" . base64_encode(self::$Data[5]);
        }
        if (!empty(self::$Data[6])) {
            $link .= "/" . md5(self::$Data[6]) . "/" . base64_encode(self::$Data[7]);
        }
        return base64_encode($link);
    }

    /**
     * Verifica se uma data é valida
     *
     * @param DateTime $value d/m/Y
     * @return boolean
     */
    public static function DataValida($value)
    {
        list($dia, $mes, $ano) = explode('/', $value);
        return checkdate($mes, $dia, $ano);
    }

    /**
     * <b>Tranforma Data pro formato de apresentação em Tela:</b> Transforma
     * uma data no formato TIMESTAMP em uma data no formato d/m/Y!
     * @param STRING $data = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @param STRING $formato = formato da data para apresentação =
     * ex.: (d/m/Y H:i:s) ou (d/m/Y H:i) ou (d/m/Y), valor padrão (d/m/Y H:i)
     * @return STRING = $Data = Data no formato escolhido!
     */
    public static function DataShow($data, $formato = NULL)
    {
        self::$Format = explode(' ', $data);
        self::$Data = explode('-', self::$Format[0]);

        if (empty(self::$Format[1])):
            self::$Format[1] = date('H:i:s');
        endif;
        if (!$formato):
            $formato = "d/m/Y";
        endif;

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
        self::$Data = date($formato, strtotime(self::$Data));
        return self::$Data;
    }

    /**
     * <b>DATA ATUAL</b>
     * @param $formato
     * @return DateTime = $Data = Data Atual no Formato ('d/m/Y H:i:s')!
     */
    public static function DataAtual($formato = 'd/m/Y H:i:s')
    {
        return date($formato);
    }

    /**
     * <b>DATA ATUAL BANCO</b>
     * @param $formato
     * @return STRING = $Data = Data Atual no Formato Para o Banco ('Y-m-d H:i:s')!
     */
    public static function DataAtualBanco($formato = 'Y-m-d')
    {
        return date($formato);
    }

    /**
     * <b>DATA HORA ATUAL BANCO</b>
     * @param $formato
     * @return STRING = $Data = Data Atual no Formato Para o Banco ('Y-m-d H:i:s')!
     */
    public static function DataHoraAtualBanco($formato = 'Y-m-d H:i:s')
    {
        return date($formato);
    }

    /**
     * <b>Somatório ou Subtração de Datas:</b>
     * @param STRING $data = Data em (d/m/Y)
     * @param INT $diferenca = Diferença de dias entre as Datas
     * @param STRING $operacao = Operação de Soma (+) ou Subtração (-)
     * @return Date
     */
    public static function CalculaData($data, $diferenca, $operacao)
    {
        self::$Data = explode('/', $data);
        if ($operacao == "+"):
            return date("d/m/Y", mktime(0, 0, 0, self::$Data[1], self::$Data[0] + $diferenca, self::$Data[2]));
        else:
            return date("d/m/Y", mktime(0, 0, 0, self::$Data[1], self::$Data[0] - $diferenca, self::$Data[2]));
        endif;
    }

    /**
     * <b>Calcula a Diferença de Dias entre 2 Datas:</b>
     * @param STRING $data1 = Data em (d/m/Y)
     * @param STRING $data2 = Data em (d/m/Y)
     * @return INT = Número de Dias de Diferença entre as Datas.
     */
    public static function CalculaDiferencaDiasData($data1, $data2)
    {
        $Data1 = explode('/', $data1);
        $Data2 = explode('/', $data2);
        $Data1 = mktime(0, 0, 0, $Data1[1], $Data1[0], $Data1[2]);
        $Data2 = mktime(0, 0, 0, $Data2[1], $Data2[0], $Data2[2]);
        $Diferenca = $Data2 - $Data1; //CALCULA-SE A DIFERENÇA EM SEGUNDOS
        return ($Diferenca / (60 * 60 * 24)); //CALCULA-SE A DIFERENÇA EM DIAS
    }

    /**
     * <b>Limpa conteúdo da Variável:</b>
     */
    public static function LimpaVariavel($var)
    {
        $var = strip_tags(trim($var));
        return $var;
    }

    /**
     * <b>Resumi:</b> Limita a quantidade de caracteres a serem exibidas em uma string!
     * @param STRING $palavra = Uma string qualquer
     * @param INT $Limite = Quantidade de caracteres que limita uma string
     * @return STRING $String = Uma string limitado com o limite concatenada com (...)
     */
    public static function Resumi($palavra, $Limite)
    {
        self::$Data = strip_tags(trim($palavra));
        self::$Format = (int)$Limite;

        $count = strlen($palavra);
        if ($count <= self::$Format):
            return $palavra;
        else:
            $strpos = strrpos(substr($palavra, 0, self::$Format), ' ');
            return substr($palavra, 0, $strpos) . ' ...';
        endif;
    }

    /**
     * <b>Pega Miniatura da Imagem:</b> Ao executar este HELPER, ele automaticamente verifica
     * a existencia da imagem na pasta
     * uploads. Se existir retorna a imagem redimensionada!
     * @return HTML = imagem redimencionada!
     */
    public static function GetMiniatura($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null, $Classe = null)
    {

        $classAdd = 'center-block';
        if(UrlAmigavel::$modulo == ADMIN)
            $classAdd = '';

        self::$Data = 'uploads/' . $ImageUrl;

        if (file_exists(self::$Data) && !is_dir(self::$Data)):
            $patch = HOME;
            $imagem = self::$Data;
            return "<img itemprop=\"image\" src=\"{$patch}library/Helpers/Timthumb.class.php?src={$patch}{$imagem}&w={$ImageW}&h={$ImageH}&zc=3\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" class=\"{$classAdd} {$Classe}\" />";
        else:
            return false;
        endif;
    }

    /**
     * <b>FORMATA MOEDA PARA VISUALIZAÇÃO:</b> Ao executar este HELPER, ele automaticamente
     * Formata para o valor moeda de apresentação.
     * @param FLOAT $valor = Valor a ser convertido.
     * @param STRING $simbolo = Simbolo a ser usado antes do valor ex.: (R$, U$).
     * @return Miniimagem
     */
    public static function FormataMoeda($valor, $simbolo = null)
    {
        if ($simbolo):
            $simbolo = $simbolo . " ";
        endif;
        return $simbolo . number_format($valor, 2, ',', '.');
    }

    /**
     * <b>FORMATA MOEDA PARA PERSISTÊNCIA NO BANCO:</b> Ao executar este HELPER, ele automaticamente
     * Formata para o valor moeda do banco (FLOAT).
     */
    public static function FormataMoedaBanco($valor)
    {
        $valor = str_replace(array(".", "R$"), "", $valor);
        $valor = str_replace(",", ".", $valor);
        return number_format(trim($valor), 2, '.', '');
    }

    /**
     * <b>Valida se o o usuário está logado no sistema:</b> Verifica se existe a Session do usuário apos o login.
     * Caso não exista a Session ele será Redirecionada para a tela de login "Definida nas configurações
     * do sistema de Login!".
     * Retornando com o Parâmetro erro = restrito;
     */
    public static function ValLogin()
    {
        if (Session::CheckSession(SESSION_USER)):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * @param $act
     * @param $action
     * @return bool
     */
    public static function ValPerfil($act, $action = null)
    {
        if (Session::CheckSession(SESSION_USER)):
            if (Session::getSession(SESSION_USER, CAMPO_PERFIL)):
                if ($action == "Index" || $action == "Logar"):
                    return true;
                endif;
                $compara = strstr(UrlAmigavel::$action, 'Exporta');
                if ($compara != null):
                    return true;
                endif;
                /** @var Session $us */
                $us = $_SESSION[SESSION_USER];
                $user = $us->getUser();
                $meusPerfis = $user[md5(CAMPO_PERFIL)];
                $perfis = explode(",", $meusPerfis);
                if (in_array(1, $perfis)):
                    return true;
                endif;
                $perfilFuncionalidade = new PerfilFuncionalidadeModel();
                $dados[CO_PERFIL] = $meusPerfis;
                $meusPerfis = $perfilFuncionalidade->PesquisaTodos($dados);

                $funcionalidades = array();
                /** @var FuncionalidadeEntidade $func */
                foreach ($meusPerfis as $func) {
                    $funcionalidades[] = $func->getCoFuncionalidade()->getCoFuncionalidade();
                }

                $funcionalidadeModel = new FuncionalidadeModel();
                $data[CO_FUNCIONALIDADE] = $act;
                /** @var FuncionalidadeEntidade $funcionalidade */
                $funcionalidade = $funcionalidadeModel->PesquisaUmQuando($data);

                if (!empty($funcionalidades) && !empty($funcionalidade)):
                    if (in_array($funcionalidade->getCoFuncionalidade(), $funcionalidades)):
                        return true;
                    endif;
                endif;
            endif;
        endif;
        return false;
    }

    /**
     * @param $tmp
     * @param $name
     * @param $nome_foto
     * @param $width
     * @return string
     */
    public static function Redimenciona($tmp, $name, $nome_foto, $width)
    {
        $ext = strtolower(substr($name, -3));
        $nome_foto = Valida::ValNome($nome_foto) . "_" . uniqid();
        $arquivo = PASTAUPLOADS . $nome_foto . "." . $ext;

        switch ($ext) {
            case 'jpg':
                $img = imagecreatefromjpeg($tmp);
                break;
            case 'jpeg':
                $img = imagecreatefromjpeg($tmp);
                break;
            case 'png':
                $img = imagecreatefrompng($tmp);
                break;
        }
        $x = imagesx($img);
        $y = imagesy($img);
        $height = ($width * $y) / $x;
        $nova = imagecreatetruecolor($width, $height);

        imagealphablending($nova, false);
        imagesavealpha($nova, true);
        imagecopyresampled($nova, $img, 0, 0, 0, 0, $width, $height, $x, $y);

        if (file_exists($arquivo)):
            unlink($arquivo);
        endif;


        switch ($ext) {
            case 'jpg':
                imagejpeg($nova, PASTAUPLOADS . $nome_foto . "." . $ext, 100);
                break;
            case 'jpeg':
                imagejpeg($nova, PASTAUPLOADS . $nome_foto . "." . $ext, 100);
                break;
            case 'png':
                imagepng($nova, PASTAUPLOADS . $nome_foto . "." . $ext);
                break;
        }
        imagedestroy($img);
        imagedestroy($nova);
        return $nome_foto . "." . $ext;
    }

    /**
     * <b>Tranforma URL e Nome:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
     * @param STRING $Name = Uma string qualquer
     * @return STRING = $Data = Uma URL amigável válida
     */
    public static function ValNome($Name)
    {
        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
        self::$Data = strip_tags(trim(self::$Data));
        self::$Data = str_replace(' ', '-', self::$Data);
        self::$Data = str_replace(array('-----', '----', '---', '--'), '-', self::$Data);

        return strtolower(utf8_encode(self::$Data));
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function MascaraCpf($string)
    {
        $cpf = self::MascaraString('###.###.###-##', $string);
        return $cpf;
    }

    /**
     * @param $mascara
     * @param $string
     * @return mixed
     */
    public static function MascaraString($mascara, $string)
    {
        $string = self::RetiraMascara($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $mascara[strpos($mascara, "#")] = $string[$i];
        }
        return $mascara;
    }

    /**
     * @param $valor
     * @return mixed
     */
    public static function RetiraMascara($valor)
    {
        $valor = str_replace(array(".", ",", "/", "-", " ", "(", ")", 'R$', '_'), "", $valor);
        return $valor;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function MascaraCnpj($string)
    {
        $cnpj = self::MascaraString('##.###.###/####-##', $string);
        return $cnpj;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function MascaraCep($string)
    {
        $cep = self::MascaraString('##.###-###', $string);
        return $cep;
    }

    /**
     * @param $string
     * @return mixed|null
     */
    public static function MascaraTel($string)
    {
        $string = self::RetiraMascara($string);
        switch (strlen($string)) {
            case 10:
                return self::MascaraString('(##) ####-####', $string);
            case 11:
                return self::MascaraString('(##) #####-####', $string);
            default:
                return null;
        }
    }

    public static function geraBtnVoltar()
    {
        echo '<a href="' . PASTAADMIN . UrlAmigavel::$controller . '/Listar' . UrlAmigavel::$controller . '"
               class="btn btn-primary tooltips" data-original-title="Voltar" data-placement="top">
                Voltar <i class="clip-arrow-right-2"></i>
            </a>';
    }

    public static function geraBtnNovo()
    {
        echo '<a href="' . PASTAADMIN . UrlAmigavel::$controller . '/Cadastro' . UrlAmigavel::$controller . '"
               class="btn btn-green tooltips" data-original-title="Criar '.UrlAmigavel::$controller .'" data-placement="top">
               <i class="fa fa-plus"></i> Criar '.UrlAmigavel::$controller .'
            </a>';
    }

    /**
     * @param $mensagem
     * @param array $parametros
     * @param string $whatsapp
     */
    public static function geraLinkWhatSapp($mensagem, array $parametros = [], $whatsapp = WHATSAPP)
    {
        $pre = 'https://api.whatsapp.com/send?phone=' . $whatsapp . '&l=pt_BR&text=';
        if (!empty($parametros)) {
            for ($i = 0; $i < count($parametros); $i++) {
                $strpos = strpos(substr($mensagem, 0, strlen($mensagem)), '%');
                $msgAux = substr($mensagem, $strpos + 2, strlen($mensagem));
                $msg = substr($mensagem, 0, $strpos + 2);
                $mensagem = str_replace('%s', $parametros[$i], $msg) . $msgAux;
            }
        }
        echo $pre . $mensagem;
    }


}

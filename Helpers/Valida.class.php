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
    public static function Mensagem($msg, $typo)
    {
        Notificacoes::mesagens($msg, $typo);
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
     * @param $data ("1985-03-30");
     * @return string
     */
    public static function DataDiaDaSemana($data)
    {
        $ano = substr("$data", 0, 4);
        $mes = substr("$data", 5, -3);
        $dia = substr("$data", 8, 9);
        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
        switch ($diasemana) {
            case"0":
                self::$Data = "Domingo";
                break;
            case"1":
                self::$Data = "Segunda";
                break;
            case"2":
                self::$Data = "Terça";
                break;
            case"3":
                self::$Data = "Quarta";
                break;
            case"4":
                self::$Data = "Quinta";
                break;
            case"5":
                self::$Data = "Sexta";
                break;
            case"6":
                self::$Data = "Sábado";
                break;
        }
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
     * @param STRING $periodo = Período para a operação d = Dias, m = Mês e a = Ano
     * @return STRING $dataFinal
     */
    public static function CalculaData($data, $diferenca, $operacao, $periodo = 'd')
    {
        self::$Data = explode('/', $data);
        $dataFinal = '';
        switch ($periodo) {
            case "d":
                if ($operacao == "+"):
                    $dataFinal = date("d/m/Y", mktime(0, 0, 0, self::$Data[1], self::$Data[0] + $diferenca, self::$Data[2]));
                else:
                    $dataFinal = date("d/m/Y", mktime(0, 0, 0, self::$Data[1], self::$Data[0] - $diferenca, self::$Data[2]));
                endif;
                break;
            case "m":
                if ($operacao == "+"):
                    $dataFinal = date("d/m/Y", mktime(0, 0, 0, self::$Data[1] + $diferenca, self::$Data[0], self::$Data[2]));
                else:
                    $dataFinal = date("d/m/Y", mktime(0, 0, 0, self::$Data[1] - $diferenca, self::$Data[0], self::$Data[2]));
                endif;
                break;
            case "a":
                if ($operacao == "+"):
                    $dataFinal = date("d/m/Y", mktime(0, 0, 0, self::$Data[1], self::$Data[0], self::$Data[2] + $diferenca));
                else:
                    $dataFinal = date("d/m/Y", mktime(0, 0, 0, self::$Data[1], self::$Data[0], self::$Data[2] - $diferenca));
                endif;
                break;
            default:
                $dataFinal = null;
                break;
        }
        return $dataFinal;

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
     * <b>Calcula a Idade em Anos</b>
     * @param STRING $dtNascimento = Data Formato do banco ou Formato de Visualização (d/m/Y)
     * @param bool $label = Se quer com o Sufixo (Anos)
     * @return INT = Anos da data de nascimento ate a data atual.
     */
    public static function CalculaIdadeAtual($dtNascimento, $label = true)
    {
        $dtNascimento = implode('/', array_reverse(explode('-', $dtNascimento)));
        $Data1 = explode('/', $dtNascimento);
        $Data2 = explode('/', date('d/m/Y'));
        $Data1 = mktime(0, 0, 0, $Data1[1], $Data1[0], $Data1[2]);
        $Data2 = mktime(0, 0, 0, $Data2[1], $Data2[0], $Data2[2]);
        $Diferenca = $Data2 - $Data1; //CALCULA-SE A DIFERENÇA EM SEGUNDOS
        $anos = intval(($Diferenca / (60 * 60 * 24)) / 365);
        $anos = ($label) ? $anos . ' Anos' : $anos;
        return $anos; //CALCULA-SE A DIFERENÇA EM DIAS
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
    public static function GetMiniatura($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null, $Classe = null, $zoomCrop = 3)
    {

        $classAdd = 'center-block';
        if (UrlAmigavel::$modulo == ADMIN)
            $classAdd = '';

        self::$Data = 'uploads/' . $ImageUrl;

        if (file_exists(self::$Data) && !is_dir(self::$Data)):
            $patch = HOME;
            $tim = TIMTHUMB;
            $imagem = self::$Data;
            return "<img itemprop=\"image\" src=\"{$tim}?src={$patch}{$imagem}&w={$ImageW}&h={$ImageH}&zc={$zoomCrop}\" 
            alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" class=\"{$classAdd} {$Classe}\" />";
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
     * @param $action (Action a ser validada)
     * @return bool
     */
    public static function ValPerfil($action)
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
                $data[DS_ACTION] = $action;
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
        $ext = strtolower($ext);

        switch ($ext) {
            case 'jpg':
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

    public static function geraBtnVoltar($parametros = null)
    {
        $link = ($parametros) ? $parametros : UrlAmigavel::$controller . '/Listar' . UrlAmigavel::$controller;
        echo '<a href="' . PASTAADMIN . $link . '"
               class="btn btn-primary tooltips" data-original-title="Voltar" data-placement="top">
                Voltar <i class="clip-arrow-right-2"></i>
            </a>';
    }

    /**
     * @param null $descricao
     * @param null $action
     */
    public static function geraBtnNovo($descricao = null, $action = null)
    {
        $act = ($action) ? $action : 'Cadastro' . UrlAmigavel::$controller;
        $desc = ($descricao) ? $descricao : 'Criar ' . UrlAmigavel::$controller;
        echo '<a href="' . PASTAADMIN . UrlAmigavel::$controller . '/' . $act . '"
               class="btn btn-green tooltips" data-original-title="' . $desc . '" data-placement="top">
               <i class="fa fa-plus"></i> ' . $desc . '
            </a>';
    }

    /**
     * @param $descricao
     * @param $action
     * @param $class
     */
    public static function geraBtn($descricao, $action, $class, $id)
    {
        echo '<a href="' . $action . '" id="' . $id . '"
               class="btn ' . $class . ' tooltips" data-original-title="' . $descricao . '" data-placement="top">
               <i class="fa fa-plus"></i> ' . $descricao . '
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

    /**
     * Retorna a logo padrão do sistema pelo TimThamb
     * @param int $tamanho
     * @return string
     */
    public static function getImgSistema($tamanho = 50)
    {
        return '
        <img src="' . TIMTHUMB . '?src=' . PASTA_LIBRARY .
            '/Images/logo_padrao.jpg&w=' . $tamanho . '&h=' . $tamanho . '"
                                alt="' . DESC . '" title="' . DESC . '" class="circle-img" />
        ';
    }

    /**
     * Retorna a logo padrão do sistema pelo TimThamb
     * @param int $tamanho
     * @return string
     */
    public static function getSemImg($tamanho = 50)
    {
        return '
        <img src="' . TIMTHUMB . '?src=' . SEM_FOTO .
            '&w=' . $tamanho . '&h=' . $tamanho . '"
                                alt="Sem Imagem" title="Sem Imagem" class="circle-img" />
        ';
    }

    /**
     * @param $st
     * @return string
     */
    public static function getLabelStatusPlano($st)
    {
        switch ($st) {
            case "A":
                $op = '<span class="label label-success">Ativo</span>';
                break;
            case "E":
                $op = '<span class="label label-info">Expirando</span>';
                break;
            case "P":
                $op = '<span class="label label-warning">Pendente</span>';
                break;
            case "B":
                $op = '<span class="label label-inverse">Bloqueado</span>';
                break;
            case "R":
                $op = '<span class="label label-danger">Expirado</span>';
                break;
            default:
                $op = '';
                break;
        }
        return $op;
    }

    public static function getBadgeLabel($operacao)
    {
        switch ($operacao) {
            case AuditoriaEnum::DELETE:
                $classBadge = 'danger';
                break;
            case AuditoriaEnum::INSERT:
                $classBadge = 'green';
                break;
            case AuditoriaEnum::UPDATE:
                $classBadge = 'info';
                break;
            default:
                $classBadge = 'inverse';
                break;
        }
        return $classBadge;
    }

    public static function getDsCampoLabel($noCampo)
    {
        $campo = '';
        $tipo = strtolower(substr($noCampo, 0, 2));
        switch ($tipo) {
            case 'st':
                $campo = str_replace('st_', 'situação_', $noCampo);
                break;
            case 'tp':
                $campo = str_replace('tp_', 'tipo_', $noCampo);
                break;
            case 'dt':
                $campo = str_replace('dt_', 'data_', $noCampo);
                break;
            case 'co':
                $campo = str_replace('co_', 'código_', $noCampo);
                break;
            case 'sg':
                $campo = str_replace('sg_', 'sigla_', $noCampo);
                break;
            case 'no':
                $campo = str_replace('no_', 'nome_', $noCampo);
                break;
            case 'ds':
                $campo = str_replace('ds_', 'descrição_', $noCampo);
                break;
            case 'nu':
                $campo = str_replace('nu_', 'número_', $noCampo);
                break;
            default:
                break;
        }

        $campo = str_replace('_', ' ', $campo);
        $campo = ucwords($campo);

        return $campo;
    }

    /**
     * Retorna as cores das classes para os boxes dos histórico
     * @return array
     */
    public static function getCoresHistorico()
    {
        $cores = array('green', 'teal', 'bricky', 'purple', '');
        return $cores;
    }

    /**
     * Retorna Array de meses
     * @return array
     */
    public static function getMesesHistorico()
    {
        $mes_extenso = array(
            'Jan' => 'Janeiro',
            'Feb' => 'Fevereiro',
            'Mar' => 'Março',
            'Apr' => 'Abril',
            'May' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug' => 'Agosto',
            'Nov' => 'Novembro',
            'Sep' => 'Setembro',
            'Oct' => 'Outubro',
            'Dec' => 'Dezembro'
        );

        return $mes_extenso;
    }

    public static function StatusLabel($status)
    {
        switch ($status) {
            case "A":
                $op = '<span class="label label-success">Ativo</span>';
                break;
            default:
                $op = '<span class="label label-danger">Inativo</span>';
                break;
        }

        return $op;
    }

    public static function retornoCheckbox($dados, $check)
    {
        $check = (isset($dados[$check])) ? $dados[$check] : null;
        if ($check):
            return "S";
        else:
            return "N";
        endif;
    }

    public static function retornoSexo($sexo)
    {
        switch ($sexo) {
            case "M":
                $op = 'Masculino';
                break;
            case "F":
                $op = 'Feminino';
                break;
            default:
                $op = null;
                break;
        }

        return $op;
    }

    public static function OperacaoAuditoria($operacao)
    {

        switch ($operacao) {
            case "I":
                $op = '<span class="label label-success">INSERIU</span>';
                break;
            case "D":
                $op = '<span class="label label-danger">DELETOU</span>';
                break;
            case "U":
                $op = '<span class="label label-warning">ATUALIZOU</span>';
                break;
        }

        return $op;
    }

    public static function GeraCodigo($blocosLetrasEnumeros = 2, $sequenciaNumeros = 1, $sequenciaLetras = 3)
    {
        $codigo = '';
        for ($p = 0; $p < $blocosLetrasEnumeros; $p++) {
            for ($m = 0; $m < $sequenciaLetras; $m++) {
                $numero = rand(1, 26);
                switch ($numero) {
                    case '1':
                        $letra = 'A';
                        break;
                    case '2':
                        $letra = 'B';
                        break;
                    case '3':
                        $letra = 'C';
                        break;
                    case '4':
                        $letra = 'D';
                        break;
                    case '5':
                        $letra = 'E';
                        break;
                    case '6':
                        $letra = 'F';
                        break;
                    case '7':
                        $letra = 'G';
                        break;
                    case '8':
                        $letra = 'H';
                        break;
                    case '9':
                        $letra = 'K';
                        break;
                    case '10':
                        $letra = 'I';
                        break;
                    case '11':
                        $letra = 'J';
                        break;
                    case '12':
                        $letra = 'L';
                        break;
                    case '13':
                        $letra = 'M';
                        break;
                    case '14':
                        $letra = 'N';
                        break;
                    case '15':
                        $letra = 'O';
                        break;
                    case '16':
                        $letra = 'P';
                        break;
                    case '17':
                        $letra = 'Q';
                        break;
                    case '18':
                        $letra = 'R';
                        break;
                    case '19':
                        $letra = 'S';
                        break;
                    case '20':
                        $letra = 'T';
                        break;
                    case '21':
                        $letra = 'U';
                        break;
                    case '22':
                        $letra = 'V';
                        break;
                    case '23':
                        $letra = 'Y';
                        break;
                    case '24':
                        $letra = 'X';
                        break;
                    case '25':
                        $letra = 'W';
                        break;
                    case '26':
                        $letra = 'Z';
                        break;
                }
                $codigo .= $letra;
            }

            for ($n = 0; $n < $sequenciaNumeros; $n++) {
                $numero = rand(0, 9);
                $codigo .= $numero;
            }
        }
        return $codigo;
    }

    public static function SituacaoUsuario($st)
    {

        switch ($st) {
            case "A":
                $op = '<span class="label label-success">ATIVO</span>';
                break;
            case "I":
                $op = '<span class="label label-danger">INATIVO</span>';
                break;
        }

        return $op;
    }

    public static function StatusAcesso($st)
    {
        switch ($st) {
            case "A":
                $op = '<span class="label label-success">ATIVO</span>';
                break;
            case "F":
                $op = '<span class="label label-primary">FINALIZADO</span>';
                break;
        }

        return $op;
    }

    public static function SituacaoUsuarioLabel($st)
    {
        switch ($st) {
            case "A":
                $op = 'ATIVO';
                break;
            case "I":
                $op = 'INATIVO';
                break;
        }

        return $op;
    }

    public static function SituacaoSimNao($st)
    {
        switch ($st) {
            case "S":
                $op = '<span class="label label-success">SIM</span>';
                break;
            default:
                $op = '<span class="label label-danger">NÃO</span>';
                break;
        }

        return $op;
    }

    public static function Pagamento($st)
    {
        switch ($st) {
            case "C":
                $op = '<span class="label label-success">Concluído</span>';
                break;
            case "N":
                $op = '<span class="label label-danger">Não Pago</span>';
                break;
            case "I":
                $op = '<span class="label label-info">Parcial</span>';
                break;
            default:
                $op = '';
                break;
        }

        return $op;
    }

    public static function SituacaoHistoria($st)
    {

        switch ($st) {
            case "C":
                $op = '<span class="label label-success">Concluída</span>';
                break;
            case "N":
                $op = '<span class="label label-danger">Não Iniciada</span>';
                break;
            case "I":
                $op = '<span class="label label-warning">Iniciada</span>';
                break;
        }

        return $op;
    }

    public static function getDadosEstatistica($dados)
    {
        $dado = self::getBarraProgresso($dados);
        $horas = ($dados['esforcoRestante'] * 20) / 60; // 20 Minutos por ponto de esforço
        $linhas = fopen('versao.txt', "a+");
        $versoes = fgets($linhas);
        $versao = explode('//', $versoes);
        $mediaDia = $versao[5];
        $dias = ($dados['esforcoRestante'] / $mediaDia);
        $semanas = $dias / 7;
        $dataPrevista = Valida::CalculaData(Date('d/m/Y'), $dias, '+');

        $estatisticas['barra'] = $dado['barra'];
        $estatisticas['percentual'] = $dado['percentual'];
        $estatisticas['dias'] = Valida::FormataMoeda($dias);
        $estatisticas['horas'] = Valida::FormataMoeda($horas);
        $estatisticas['semanas'] = Valida::FormataMoeda($semanas);
        $estatisticas['dataPrevista'] = $dataPrevista;
        $estatisticas['pontosDia'] = Valida::FormataMoeda($mediaDia);

        return $estatisticas;
    }

    public static function getBarraProgresso($dados)
    {
        if ($dados['esforco'] == 0) {
            $progresso = 0;
        } else {
            $progresso = ((($dados['esforco'] - $dados['esforcoRestante']))
                    / $dados['esforco']) * 100;
        }

        $cor = 'success';
        if ($progresso < 35) {
            $cor = 'danger';
        } elseif ($progresso < 60) {
            $cor = 'warning';
        } elseif ($progresso < 95) {
            $cor = 'info';
        }

        $barra = '<div class="progress progress-striped active progress-sm tooltips" 
                            data-original-title="' . Valida::FormataMoeda($progresso) . '%" data-placement="top"
                            style="height: 18px;">
                                            <div class="progress-bar progress-bar-' . $cor . '" role="progressbar" 
                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" 
                                            style="width: ' . $progresso . '%"></div>
                                    </div>';
        $dado['barra'] = $barra;
        $dado['percentual'] = Valida::FormataMoeda($progresso);
        return $dado;
    }
}

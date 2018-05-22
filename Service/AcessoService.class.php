<?php

/**
 * AcessoService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  AcessoService extends AbstractService
{
    private $ObjetoModel;
    private $PDO;

    /**
     * AcessoService constructor.
     */
    public function __construct()
    {
        parent::__construct(AcessoEntidade::ENTIDADE);
        $this->ObjetoModel = New AcessoModel();
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

    /**
     * @param $coUsuario
     */
    public function salvarAcesso($coUsuario)
    {
        $acesso[DS_SESSION_ID] = session_id();
        $acesso[CO_USUARIO] = $coUsuario;
        $acesso[TP_SITUACAO] = StatusAcessoEnum::ATIVO;

        /** @var AcessoEntidade $meuAcesso */
        $meuAcesso = $this->PesquisaUmQuando($acesso);
        if ($meuAcesso) {
            $novoAcesso[DT_FIM_ACESSO] = $this->geraDataFimAcesso();
            $this->Salva($novoAcesso, $meuAcesso->getCoAcesso());
        } else {
            $acesso[DS_NAVEGADOR] = $this->getBrowser();
            $acesso[DS_SISTEMA_OPERACIONAL] = $this->getOS();
            $acesso[DS_DISPOSITIVO] = $this->getDispositivo();
            $acesso[DT_FIM_ACESSO] = $this->geraDataFimAcesso();
            $acesso[DT_INICIO_ACESSO] = Valida::DataHoraAtualBanco();
            $this->Salva($acesso);
        }
    }

    /**
     * @return false|string
     */
    public function geraDataFimAcesso()
    {
        return date("Y-m-d H:i:s", strtotime(Valida::DataHoraAtualBanco() . " + " . INATIVO . " minutes"));
    }

    /**
     * @param $coUsuario
     */
    public function terminaAcesso($coUsuario)
    {
        $acesso[DS_SESSION_ID] = session_id();
        $acesso[CO_USUARIO] = $coUsuario;
        $acesso[TP_SITUACAO] = StatusAcessoEnum::ATIVO;

        /** @var AcessoEntidade $meuAcesso */
        $meuAcesso = $this->PesquisaUmQuando($acesso);

        if ($meuAcesso) {
            $terminaAcesso[TP_SITUACAO] = StatusAcessoEnum::FINALIZADO;
            $terminaAcesso[DT_FIM_ACESSO] = Valida::DataHoraAtualBanco();
            $this->Salva($terminaAcesso, $meuAcesso->getCoAcesso());
        }
    }

    /**
     * @param $coUsuario
     * @return bool
     */
    public function verificaAcesso($coUsuario)
    {
        $permitido = false;
        $acesso[DS_SESSION_ID] = session_id();
        $acesso[CO_USUARIO] = $coUsuario;
        $acesso[TP_SITUACAO] = StatusAcessoEnum::ATIVO;

        /** @var AcessoEntidade $meuAcesso */
        $meuAcesso = $this->PesquisaUmQuando($acesso);

        if ($meuAcesso) {
            $ultimo_acesso = strtotime($meuAcesso->getDtFimAcesso());
            $agora = strtotime(Valida::DataHoraAtualBanco());
            if ($ultimo_acesso > $agora) {
                $novoAcesso[DT_FIM_ACESSO] = $this->geraDataFimAcesso();
                $this->Salva($novoAcesso, $meuAcesso->getCoAcesso());
                $permitido = true;
            }
        }
        return $permitido;
    }

    /**
     *
     */
    public function finalizaAcessos()
    {
        return $this->ObjetoModel->finalizaAcessos();
    }

    /**
     * @return int
     */
    public function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser_array = array(
            'Firefox' => 'Firefox',
            'Chrome' => 'Chrome',
            'MSIE' => 'Internet Explorer',
            'Internet Explorer' => 'Internet Explorer',
            'Edge' => 'Edge',
            'Opera' => 'Opera',
            'Mozilla' => 'Mozilla',
            'Netscape' => 'Netscape',
            'OPR' => 'Opera',
            'Lynx' => 'Lynx',
            'Safari' => 'Safari',
            'Trident.* rv' => 'Internet Explorer',
            'Ubuntu' => 'Ubuntu Web Browser',
            'mobile' => 'Handheld Browser'
        );

        foreach ($browser_array as $key => $value):
            if (preg_match('|' . $key . '.*?([0-9\.]+)|i', $user_agent)):
                return $value;
            endif;
        endforeach;

        return 'Outro';
    }

    public function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_array = array(
            'blackberry' => 'BlackBerry',
            'iphone' => 'iOS',
            'ipad' => 'iOS',
            'ipod' => 'iOS',
            'os x' => 'Mac OS X',
            'ppc mac' => 'Power PC Mac',
            'freebsd' => 'FreeBSD',
            'ppc' => 'Macintosh',
            'linux' => 'Linux',
            'debian' => 'Debian',
            'sunos' => 'Sun Solaris',
            'beos' => 'BeOS',
            'apachebench' => 'ApacheBench',
            'aix' => 'AIX',
            'irix' => 'Irix',
            'osf' => 'DEC OSF',
            'hp-ux' => 'HP-UX',
            'netbsd' => 'NetBSD',
            'bsdi' => 'BSDi',
            'openbsd' => 'OpenBSD',
            'gnu' => 'GNU/Linux',
            'unix' => 'Unknown Unix OS',
            'android' => 'Android',
            'Android' => 'Android',
            'symbian' => 'Symbian OS',
            'winnt' => 'Windows',
            'win98' => 'Windows',
            'win95' => 'Windows',
            'windows phone' => 'Windows Phone',
            'windows nt 10' => 'Windows 10',
            'windows nt 6\.3' => 'Windows 8.1',
            'windows nt 6\.2' => 'Windows 8',
            'windows nt 6\.1' => 'Windows 7',
            'windows nt 6\.0' => 'Windows Vista',
            'windows nt 5\.2' => 'Windows Server 2003/XP x64',
            'windows nt 5\.1' => 'Windows XP',
            'windows xp' => 'Windows XP',
            'windows nt 5\.0' => 'Windows 2000',
            'windows me' => 'Windows ME',
            'win16' => 'Windows 3.11',
            'macintosh|mac os x' => 'Mac OS X',
            'mac_powerpc' => 'Mac OS 9',
            'webos' => 'Mobile',
            'ubuntu' => 'Ubuntu',
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match('/' . $regex . '/i', $user_agent)) {
                return $value;
            }
        }

        return 'Outro';
    }

    public function getDispositivo()
    {
        $device = filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT);
        $user_agents = array("iPhone", "iPad", "Android", "android", "webOS", "BlackBerry", "iPod", "Symbian", "IsGeneric");

        $deviceDetect = null;
        foreach ($user_agents as $user_agent) {
            if (strpos($device, $user_agent) !== false):
                $deviceDetect = true;
            endif;
        }

        if ($deviceDetect):
            return 'Mobile';
        else:
            return 'Desktop';
        endif;
    }

}
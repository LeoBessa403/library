<?php

/**
 * TrafegoService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class TrafegoService extends AbstractService
{

    private $ObjetoModel;
    private $nu_ip;
    private $ds_pais;
    private $ds_code_pais;
    private $ds_uf;
    private $ds_estado;
    private $ds_cidade;
    private $ds_agente;

    public function __construct()
    {
        parent::__construct(TrafegoEntidade::ENTIDADE);
        $this->ObjetoModel = New TrafegoModel();

        $ip = $_SERVER['REMOTE_ADDR'];
        $url = "http://ip-api.com/json/".$ip;

        $timeout = 3;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $rq = curl_exec($ch);
        curl_close($ch);
        $geo = array();
        if ($rq !== false) {
            $geo = json_decode($rq);
        }

        $this->nu_ip = $ip;
        $this->ds_pais = (isset($geo->country)) ? $geo->country : 'Desconhecido';
        $this->ds_code_pais = (isset($geo->countryCode)) ? $geo->countryCode : 'Desconhecida';
        $this->ds_estado = (isset($geo->regionName)) ? $geo->regionName : 'Desconhecida';
        $this->ds_uf = (isset($geo->region)) ? $geo->region : 'Desconhecida';
        $this->ds_cidade = (isset($geo->city)) ? $geo->city : 'Desconhecida';
        $this->ds_agente = $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return int
     */
    private function getBrowser()
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

    private function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_array = array(
            'blackberry' => 'BlackBerry',
            'android' => 'Android',
            'Android' => 'Android',
            'iphone' => 'iOS',
            'ipad' => 'iOS',
            'ipod' => 'iOS',
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
            'webos' => 'Mobile',
            'ubuntu' => 'Ubuntu',
            'macintosh|mac os x' => 'Mac OS X',
            'mac_powerpc' => 'Mac OS 9',
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
            'symbian' => 'Symbian OS',
            'winnt' => 'Windows',
            'win98' => 'Windows',
            'win95' => 'Windows',
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match('/' . $regex . '/i', $user_agent)) {
                return $value;
            }
        }

        return 'Outro';
    }

    private function getDispositivo()
    {
        $device = $_SERVER['HTTP_USER_AGENT'];
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

    /** Salva na Entidade de Trafego */
    public function salvaTrafego()
    {
        if($this->ds_cidade == 'Divinopolis de Goias')
            $this->ds_cidade = 'Valparaíso de Goias';
        if($this->ds_estado == 'Federal District')
            $this->ds_estado = 'Distrito Federal';

        $trafego[DS_NAVEGADOR] = $this->getBrowser();
        $trafego[DS_SISTEMA_OPERACIONAL] = $this->getOS();
        $trafego[DS_DISPOSITIVO] = $this->getDispositivo();
        $trafego[NU_IP] = $this->nu_ip;
        $trafego[DS_PAIS] = $this->ds_pais;
        $trafego[DS_CODE_PAIS] = $this->ds_code_pais;
        $trafego[DS_ESTADO] = $this->ds_estado;
        $trafego[DS_UF] = $this->ds_uf;
        $trafego[DS_CIDADE] = $this->ds_cidade;
        $trafego[DS_AGENTE] = $this->ds_agente;

        return $this->Salva($trafego);
    }

}
<?php

class AbstractValidador
{
    private $retorno = [];

    const VALIDACAO_CPF = 1;
    const VALIDACAO_CNPJ = 2;
    const VALIDACAO_EMAIL = 3;
    const VALIDACAO_CEP = 4;
    const VALIDACAO_TEL = 5;
    const VALIDACAO_NOME = 6;
    const VALIDACAO_DATA = 7;
    const VALIDACAO_MOEDA = 8;
    const VALIDACAO_HORAS = 9;
    const VALIDACAO_0800 = 10;
    const VALIDACAO_INTERVALO_DATA = 11;
    const VALIDACAO_SENHA = 12;

    /**
     * @param $dado
     * @param $tipoValidacao
     * @param int $qtdCaracteres
     * @return bool
     */
    private function ValidaCampoMascara($dado, $tipoValidacao, $qtdCaracteres = 1)
    {
        $validador = false;
        switch ($tipoValidacao) {
            case static::VALIDACAO_CPF:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = Valida::ValCPF(Valida::RetiraMascara($dado));
                    if ($validador != 1) {
                        $validador = false;
                    }
                }
                break;
            case static::VALIDACAO_CNPJ:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = Valida::ValCNPJ(Valida::RetiraMascara($dado));
                    if ($validador != 1) {
                        $validador = false;
                    }
                }
                break;
            case static::VALIDACAO_EMAIL:
                $validador = Valida::ValEmail($dado);
                if ($validador != 1) {
                    $validador = false;
                }
                break;
            case static::VALIDACAO_CEP:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validador) == 7) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_TEL:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validador) == 10 || strlen($validador) == 11) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_NOME:
                $validador = preg_replace('/[^0-9]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                    if (strlen($validador) >= $qtdCaracteres) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_DATA:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = $this->trataData($dado);
                }
                break;
            case static::VALIDACAO_MOEDA:
                $validador = preg_replace('/[^a-zA-Z]/', '', Valida::RetiraMascara($dado));
                if (strlen($validador) == 0) {
                    $validador = true;
                }
                break;
            case static::VALIDACAO_HORAS:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validador) == 4) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_0800:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) == 0) {
                    $validador = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validador) == 11) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_SENHA:
                $validador = preg_match('/^[a-zA-Z0-9]+/', $dado);
                if (!$validador) {
                    $validador = preg_replace('/[^a-z]/', '', $dado);
                    if (strlen($validador) == 1) {
                        $validador = preg_replace('/[^A-Z]/', '', $dado);
                        if (strlen($validador) == 1) {
                            if(strlen($dado) >= $qtdCaracteres)
                            $validador = true;
                        }
                    }
                }
                break;
        }
        if ($validador) {
            return true;
        }
        return false;
    }

    private function trataData($data)
    {
        $validador = preg_replace('/[^a-zA-Z]/', '', $data);
        $data = preg_replace('/[^0-9]/', '', $data);
        if (strlen($data) != 8 || strlen($validador) > 0) {
            return false;
        }
        $dia = substr($data, 0, 2);
        $mes = substr($data, 2, 2);
        $ano = substr($data, 4, 4);
        return Valida::DataValida($dia . '/' . $mes . '/' . $ano);
    }

    private function iniciaRetorno()
    {
        $this->retorno = [
            SUCESSO => [],
            MSG => [
                VALIDOS => [],
                OBRIGATORIOS => []
            ]
        ];
    }

    /**
     * @param $dados
     * @param int $qtdCaracteres
     * @param $labelCampo
     * @return array
     */
    public function ValidaCampoObrigatorioDescricao($dados, $qtdCaracteres = 1, $labelCampo)
    {
        $this->iniciaRetorno();
        $validador = Valida::LimpaVariavel($dados);
        if (strlen($validador) >= $qtdCaracteres) {
            $this->retorno[SUCESSO][] = true;
        } else {
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
        }

        return $this->retorno;
    }

    /**
     * @param $arquivo
     * @param $labelCampo
     * @return array
     */
    public function ValidaCampoArquivo($arquivo, $labelCampo)
    {
        $this->iniciaRetorno();
        if ($arquivo["tmp_name"]) {
            $this->retorno[SUCESSO][] = true;
        } else {
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
        }
        return $this->retorno;
    }

    /**
     * @param $dt1
     * @param $dt2
     * @param string $labelCampo1
     * @param string $labelCampo2
     * @return array
     */
    public function ValidaIntervaloData($dt1, $dt2, $labelCampo1 = 'Data Início', $labelCampo2 = 'Data Termino')
    {
        $controle = true;
        $this->iniciaRetorno();
        if (!$this->trataData($dt1)) {
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo1;
            $controle = false;
        }
        if (!$this->trataData($dt2)) {
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo2;
            $controle = false;
        }
        if ($controle) {
            $intervalo = Valida::CalculaDiferencaDiasData($dt1, $dt2);
            if ($intervalo > 0) {
                $this->retorno[SUCESSO][] = false;
                $this->retorno[MSG][OBRIGATORIOS][] = "Intervalo das datas";
            } else {
                $this->retorno[SUCESSO][] = true;
            }
        }
        return $this->retorno;
    }

    /**
     * @param $dados
     * @param $tipoValidacao
     * @param $labelCampo
     * @param int $qtdCaracteres
     * @return array
     */
    public function ValidaCampoObrigatorioValido($dados, $tipoValidacao, $labelCampo, $qtdCaracteres = 1)
    {
        $this->iniciaRetorno();
        $obrigatorioCpf = $this->ValidaCampoObrigatorioDescricao($dados, $qtdCaracteres, $labelCampo);
        $control = count($obrigatorioCpf[SUCESSO]) - 1;
        if (!$obrigatorioCpf) {
            $this->retorno[SUCESSO][$control] = false;
            $this->retorno[MSG][OBRIGATORIOS][$control] = $labelCampo;
        } else {
            $validadorCpf = $this->ValidaCampoMascara($dados, $tipoValidacao, $qtdCaracteres);
            if (!$validadorCpf) {
                $this->retorno[SUCESSO][$control] = false;
                $this->retorno[MSG][VALIDOS][$control] = $labelCampo;
            } else {
                $this->retorno[SUCESSO][$control] = true;
            }
        }
        return $this->retorno;
    }

    /**
     * @param $dados
     * @param $tipoValidacao
     * @param $labelCampo
     * @param int $qtdCaracteres
     * @return array
     */
    public function ValidaCampoValido($dados, $tipoValidacao, $labelCampo, $qtdCaracteres = 1)
    {
        $this->iniciaRetorno();
        if ($dados) {
            $validador = $this->ValidaCampoMascara($dados, $tipoValidacao, $qtdCaracteres);
            if (!$validador) {
                $this->retorno[SUCESSO][] = false;
                $this->retorno[MSG][] = $labelCampo;
            } else {
                $this->retorno[SUCESSO][] = true;
            }
        } else {
            $this->retorno[SUCESSO][] = true;
        }
        return $this->retorno;
    }

    /**
     * @param $dados
     * @return null|string|string[]
     */
    public function limpaCampoNumerico($dados)
    {
        return preg_filter('/[^0-9]/', '', $dados);
    }

    /**
     * @param $select
     * @param $labelCampo
     * @return array
     */
    public function ValidaCampoSelectObrigatorio($select, $labelCampo)
    {
        $this->iniciaRetorno();
        if ((is_array($select)) && !empty($select[0])) {
            $this->retorno[SUCESSO][] = true;
        } else {
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
        }
        return $this->retorno;
    }

    /**
     * @param $retorno
     * @return mixed
     */
    public function MontaRetorno($retorno)
    {
        $msgRetorno = '';
        $obrigatorios = '';
        $validos = '';
        $mensagem = '';
        $msg = [
            SUCESSO => true,
            MSG => ''
        ];;
        foreach ($retorno[DADOS] as $dado) {
            if (!$dado[SUCESSO][0]) {
                if (!empty($dado[MSG][VALIDOS][0])) {
                    $validos[] = $dado[MSG][VALIDOS][0];
                }
                if (!empty($dado[MSG][OBRIGATORIOS][0])) {
                    $obrigatorios[] = $dado[MSG][OBRIGATORIOS][0];
                }
            }
        }
        if ($obrigatorios || $validos) {
            if ($obrigatorios && $validos) {
                $msgRetorno = implode(', ', $obrigatorios) . ' é(são) Obrigatório(s) e ' .
                    implode(', ', $validos) . ' está(ão) Inválido(s)';
            } elseif ($obrigatorios) {
                $msgRetorno = implode(', ', $obrigatorios) . ' é(são) Obrigatório(s)';
            } elseif ($validos) {
                $msgRetorno = implode(', ', $validos) . ' está(ão) Inválido(s)';
            }
            $mensagem = str_replace('%s', $msgRetorno, Mensagens::MSG_ERROS_CAMPOS);
        }
        if ($mensagem != '') {
            $msg[SUCESSO] = false;
            $msg[MSG] = $mensagem;
        }
        return $msg;
    }


}
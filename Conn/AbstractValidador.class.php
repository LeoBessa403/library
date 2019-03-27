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
    const VALIDACAO_NUMERO = 13;

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
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = Valida::ValCPF(Valida::RetiraMascara($dado));
                    if ($validadorDado == 1) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_CNPJ:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = Valida::ValCNPJ(Valida::RetiraMascara($dado));
                    if ($validadorDado == 1) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_EMAIL:
                $validadorDado = Valida::ValEmail($dado);
                if ($validadorDado == 1) {
                    $validador = true;
                }
                break;
            case static::VALIDACAO_CEP:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validadorDado) == 7) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_TEL:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validadorDado) == 10 || strlen($validadorDado) == 11) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_NOME:
                $validadorDado = preg_replace('/[^0-9]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                    if (strlen($validadorDado) >= $qtdCaracteres) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_DATA:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validador = $this->trataData($dado);
                }
                break;
            case static::VALIDACAO_MOEDA:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', Valida::RetiraMascara($dado));
                if (strlen($validadorDado) == 0) {
                    $validador = true;
                }
                break;
            case static::VALIDACAO_HORAS:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validadorDado) == 4) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_NUMERO:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validadorDado) >= 1) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_0800:
                $validadorDado = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validadorDado) == 0) {
                    $validadorDado = preg_replace('/[^0-9]/', '', $dado);
                    if (strlen($validadorDado) == 11) {
                        $validador = true;
                    }
                }
                break;
            case static::VALIDACAO_SENHA:
                $tamanho = strlen($dado);
                if($tamanho >= $qtdCaracteres) {
                    $forca = 0;
                    if (($tamanho >= 4) && ($tamanho <= 7)) {
                        $forca += 10;
                    } else if ($tamanho > 7) {
                        $forca += 25;
                    }
                    if (preg_replace('/^[a-z]+/', '', $dado)) {
                        $forca += 10;
                    }
                    if (preg_replace('/^[A-Z]+/', '', $dado)) {
                        $forca += 20;
                    }
                    if (preg_replace('/^[0-9]+/', '', $dado)) {
                        $forca += 20;
                    }
                    if (preg_replace('/^[a-zA-Z0-9]+/', '', $dado)) {
                        $forca += 25;
                    }
                    if($forca >= 30)
                    $validador = true;
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
        $tamanho = strlen($validador);
        if ($tamanho >= $qtdCaracteres) {
            $this->retorno[SUCESSO][] = true;
        } else {
            if ($tamanho == 0) {
                $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
            } elseif ($tamanho < $qtdCaracteres) {
                $this->retorno[MSG][VALIDOS][] = $labelCampo;
            }
            $this->retorno[SUCESSO][] = false;
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
        if (!$obrigatorioCpf[SUCESSO][$control]) {
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
                $this->retorno[MSG][VALIDOS][] = $labelCampo;
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
     * @param $select
     * @param $labelCampo
     * @return array
     */
    public function ValidaSelectObrigatorioNotArray($select, $labelCampo)
    {
        $this->iniciaRetorno();
        if ($select) {
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
        ];
        $v = 0;
        $o = 0;
        foreach ($retorno[DADOS] as $dado) {
            if (!empty($dado[SUCESSO])) {
                if (!$dado[SUCESSO][0]) {
                    if (!empty($dado[MSG][VALIDOS][0])) {
                        $validos[] = $dado[MSG][VALIDOS][0];
                        $v++;
                    }
                    if (!empty($dado[MSG][OBRIGATORIOS][0])) {
                        $obrigatorios[] = $dado[MSG][OBRIGATORIOS][0];
                        $o++;
                    }
                }
            }
        }
        if ($obrigatorios || $validos) {
            $complementoObrig = ($o > 1) ? ' são Obrigatórios' : ' é Obrigatório';
            $complementoValido = ($v > 1) ? ' estão Inválidos' : ' está Inválido';
            if ($obrigatorios && $validos) {
                $msgRetorno = implode(', ', $obrigatorios) . $complementoObrig . ' e ' .
                    implode(', ', $validos) . $complementoValido;
            } elseif ($obrigatorios) {
                $msgRetorno = implode(', ', $obrigatorios) . $complementoObrig;
            } elseif ($validos) {
                $msgRetorno = implode(', ', $validos) . $complementoValido;
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
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

    /**
     * @param $dados
     * @param int $qtdCaracteres
     * @return bool
     */
    private function validaCampoDescricao($dados, $qtdCaracteres = 1)
    {
        $validador = Valida::LimpaVariavel($dados);
        if (strlen($validador) >= $qtdCaracteres) {
            return true;
        }
        return false;
    }

    /**
     * @param $dado
     * @param $tipoValidacao
     * @param int $qtdCaracteres
     * @return bool
     */
    private function validaCampoMascara($dado, $tipoValidacao, $qtdCaracteres = 1)
    {
        $validador = false;
        switch ($tipoValidacao) {
            case 1:
                $validador = Valida::ValCPF(Valida::RetiraMascara($dado));
                if ($validador != 1) {
                    $validador = false;
                }
                break;
            case 2:
                $validador = Valida::ValCNPJ(Valida::RetiraMascara($dado));
                if ($validador != 1) {
                    $validador = false;
                }
                break;
            case 3:
                $validador = Valida::ValEmail($dado);
                if ($validador != 1) {
                    $validador = false;
                }
                break;
            case 4:
                $validador = preg_replace('/[^0-9]/', '', $dado);
                if (strlen($validador) == 7) {
                    $validador = true;
                } else {
                    $validador = false;
                }
                break;
            case 5:
                $validador = preg_replace('/[^0-9]/', '', $dado);
                if (strlen($validador) == 10 || strlen($validador) == 11) {
                    $validador = true;
                } else {
                    $validador = false;
                }
                break;
            case 6:
                $validador = preg_replace('/[^a-zA-Z]/', '', $dado);
                if (strlen($validador) >= $qtdCaracteres) {
                    $validador = true;
                } else {
                    $validador = false;
                }
                break;
            case 7:
                $validador = $this->trataData($dado);
                break;
        }
        if ($validador) {
            return true;
        }
        return false;
    }

    private function trataData($data)
    {
        $data = preg_replace('/[^0-9]/', '', $data);
        if(strlen($data) != 8){
            return false;
        }
        $dia = substr($data, 0, 2);
        $mes = substr($data, 2, 2);
        $ano = substr($data, 4, 4);
        return Valida::DataValida($dia.'/'.$mes.'/'.$ano);
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
     * @param $arquivo
     * @param $labelCampo
     * @return array
     */
    public function validaCampoArquivo($arquivo, $labelCampo)
    {
        $this->iniciaRetorno();
        if ($arquivo["tmp_name"]) {
            $this->retorno[SUCESSO][] = true;
        }else{
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
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
        $obrigatorioCpf = $this->validaCampoDescricao($dados);
        if (!$obrigatorioCpf) {
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
        } else {
            $validadorCpf = $this->validaCampoMascara($dados, $tipoValidacao, $qtdCaracteres);
            if (!$validadorCpf) {
                $this->retorno[SUCESSO][] = false;
                $this->retorno[MSG][VALIDOS][] = $labelCampo;
            }else{
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
    public function ValidaCampoValido($dados, $tipoValidacao, $labelCampo, $qtdCaracteres = 1)
    {
        $this->iniciaRetorno();
        if($dados){
            $validadorCpf = $this->validaCampoMascara($dados, $tipoValidacao, $qtdCaracteres);
            if (!$validadorCpf) {
                $this->retorno[SUCESSO][] = false;
                $this->retorno[MSG][] = $labelCampo;
            }else{
                $this->retorno[SUCESSO][] = true;
            }
        }else{
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
    public function validaCampoSelctObrigatorio($select, $labelCampo)
    {
        $this->iniciaRetorno();
        if ((is_array($select)) && !empty($select[0])) {
            $this->retorno[SUCESSO][] = true;
        }else{
            $this->retorno[SUCESSO][] = false;
            $this->retorno[MSG][OBRIGATORIOS][] = $labelCampo;
        }
        return $this->retorno;
    }


}
<?php

/**
 * PlanoAssinanteAssinatura.Entidade [ ENTIDADE ]
 * @copyright (c) 2018, Leo Bessa
 */

class PlanoAssinanteAssinaturaEntidade extends AbstractEntidade
{
    const TABELA = 'TB_PLANO_ASSINANTE_ASSINATURA';
    const ENTIDADE = 'PlanoAssinanteAssinaturaEntidade';
    const CHAVE = CO_PLANO_ASSINANTE_ASSINATURA;

    private $co_plano_assinante_assinatura;
    private $dt_cadastro;
    private $dt_expiracao;
    private $dt_confirma_pagamento;
    private $st_pagamento;
    private $tp_pagamento;
    private $dt_modificado;
    private $nu_valor_desconto;
    private $nu_valor_real;
    private $ds_link_boleto;
    private $co_plano_assinante_assinatura_ativo;
    private $st_status;
    private $ds_code_transacao;
    private $nu_valor_assinatura;
    private $nu_profissionais;
    private $nu_filiais;
    private $co_assinante;
    private $co_plano_assinante;
    private $co_historico_pag_assinatura;

    /**
     * @return array
     */
    public static function getCampos()
    {
        return [
            CO_PLANO_ASSINANTE_ASSINATURA,
            DT_CADASTRO,
            DT_EXPIRACAO,
            DT_CONFIRMA_PAGAMENTO,
            ST_PAGAMENTO,
            DT_MODIFICADO,
            NU_VALOR_DESCONTO,
            NU_VALOR_REAL,
            DS_LINK_BOLETO,
            CO_PLANO_ASSINANTE_ASSINATURA_ATIVO,
            ST_STATUS,
            DS_CODE_TRANSACAO,
            TP_PAGAMENTO,
            NU_VALOR_ASSINATURA,
            NU_FILIAIS,
            NU_PROFISSIONAIS,
            CO_ASSINANTE,
            CO_PLANO_ASSINANTE,
        ];
    }

    /**
     * @return array $relacionamentos
     */
    public static function getRelacionamentos()
    {
        $relacionamentos = Relacionamentos::getRelacionamentos();
        return $relacionamentos[static::TABELA];
    }


    /**
     * @return int $co_plano_assinante_assinatura
     */
    public function getCoPlanoAssinanteAssinatura()
    {
        return $this->co_plano_assinante_assinatura;
    }

    /**
     * @param $co_plano_assinante_assinatura
     * @return mixed
     */
    public function setCoPlanoAssinanteAssinatura($co_plano_assinante_assinatura)
    {
        return $this->co_plano_assinante_assinatura = $co_plano_assinante_assinatura;
    }

    /**
     * @return mixed $dt_cadastro
     */
    public function getDtCadastro()
    {
        return $this->dt_cadastro;
    }

    /**
     * @param $dt_cadastro
     * @return mixed
     */
    public function setDtCadastro($dt_cadastro)
    {
        return $this->dt_cadastro = $dt_cadastro;
    }

    /**
     * @return mixed $dt_expiracao
     */
    public function getDtExpiracao()
    {
        return $this->dt_expiracao;
    }

    /**
     * @param $dt_expiracao
     * @return mixed
     */
    public function setDtExpiracao($dt_expiracao)
    {
        return $this->dt_expiracao = $dt_expiracao;
    }

    /**
     * @return mixed
     */
    public function getDtConfirmaPagamento()
    {
        return $this->dt_confirma_pagamento;
    }

    /**
     * @param mixed $dt_confirma_pagamento
     */
    public function setDtConfirmaPagamento($dt_confirma_pagamento)
    {
        $this->dt_confirma_pagamento = $dt_confirma_pagamento;
    }

    /**
     * @return mixed
     */
    public function getStPagamento()
    {
        return $this->st_pagamento;
    }

    /**
     * @param mixed $st_pagamento
     */
    public function setStPagamento($st_pagamento)
    {
        $this->st_pagamento = $st_pagamento;
    }

    /**
     * @return mixed
     */
    public function getTpPagamento()
    {
        return $this->tp_pagamento;
    }

    /**
     * @param mixed $tp_pagamento
     */
    public function setTpPagamento($tp_pagamento)
    {
        $this->tp_pagamento = $tp_pagamento;
    }

    /**
     * @return mixed
     */
    public function getDtModificado()
    {
        return $this->dt_modificado;
    }

    /**
     * @param mixed $dt_modificado
     */
    public function setDtModificado($dt_modificado)
    {
        $this->dt_modificado = $dt_modificado;
    }

    /**
     * @return mixed
     */
    public function getNuValorDesconto()
    {
        return $this->nu_valor_desconto;
    }

    /**
     * @param mixed $nu_valor_desconto
     */
    public function setNuValorDesconto($nu_valor_desconto)
    {
        $this->nu_valor_desconto = $nu_valor_desconto;
    }

    /**
     * @return mixed
     */
    public function getNuValorReal()
    {
        return $this->nu_valor_real;
    }

    /**
     * @param mixed $nu_valor_real
     */
    public function setNuValorReal($nu_valor_real)
    {
        $this->nu_valor_real = $nu_valor_real;
    }

    /**
     * @return mixed
     */
    public function getDsLinkBoleto()
    {
        return $this->ds_link_boleto;
    }

    /**
     * @param mixed $ds_link_boleto
     */
    public function setDsLinkBoleto($ds_link_boleto)
    {
        $this->ds_link_boleto = $ds_link_boleto;
    }

    /**
     * @return mixed
     */
    public function getCoPlanoAssinanteAssinaturaAtivo()
    {
        return $this->co_plano_assinante_assinatura_ativo;
    }

    /**
     * @param mixed $co_plano_assinante_assinatura_ativo
     */
    public function setCoPlanoAssinanteAssinaturaAtivo($co_plano_assinante_assinatura_ativo)
    {
        $this->co_plano_assinante_assinatura_ativo = $co_plano_assinante_assinatura_ativo;
    }

    /**
     * @return mixed
     */
    public function getStStatus()
    {
        return $this->st_status;
    }

    /**
     * @param mixed $st_status
     */
    public function setStStatus($st_status)
    {
        $this->st_status = $st_status;
    }

    /**
     * @return mixed
     */
    public function getDsCodeTransacao()
    {
        return $this->ds_code_transacao;
    }

    /**
     * @param mixed $ds_code_transacao
     */
    public function setDsCodeTransacao($ds_code_transacao)
    {
        $this->ds_code_transacao = $ds_code_transacao;
    }

    /**
     * @return mixed $nu_valor_assinatura
     */
    public function getNuValorAssinatura()
    {
        return $this->nu_valor_assinatura;
    }

    /**
     * @param $nu_valor_assinatura
     * @return mixed
     */
    public function setNuValorAssinatura($nu_valor_assinatura)
    {
        return $this->nu_valor_assinatura = $nu_valor_assinatura;
    }

    /**
     * @return mixed $nu_profissionais
     */
    public function getNuProfissionais()
    {
        return $this->nu_profissionais;
    }

    /**
     * @param $nu_profissionais
     * @return mixed
     */
    public function setNuProfissionais($nu_profissionais)
    {
        return $this->nu_profissionais = $nu_profissionais;
    }

    /**
     * @return AssinanteEntidade $co_assinante
     */
    public function getCoAssinante()
    {
        return $this->co_assinante;
    }

    /**
     * @param $co_assinante
     * @return mixed
     */
    public function setCoAssinante($co_assinante)
    {
        return $this->co_assinante = $co_assinante;
    }

    /**
     * @return PlanoAssinanteEntidade $co_plano_assinante
     */
    public function getCoPlanoAssinante()
    {
        return $this->co_plano_assinante;
    }

    /**
     * @param $co_plano_assinante
     * @return mixed
     */
    public function setCoPlanoAssinante($co_plano_assinante)
    {
        return $this->co_plano_assinante = $co_plano_assinante;
    }

    /**
     * @return mixed
     */
    public function getNuFiliais()
    {
        return $this->nu_filiais;
    }

    /**
     * @param mixed $nu_filiais
     */
    public function setNuFiliais($nu_filiais)
    {
        $this->nu_filiais = $nu_filiais;
    }

    /**
     * @return HistoricoPagAssinaturaEntidade $co_plano_assinante
     */
    public function getCoHistoricoPagAssinatura()
    {
        return $this->co_historico_pag_assinatura;
    }

    /**
     * @param mixed $co_historico_pag_assinatura
     */
    public function setCoHistoricoPagAssinatura($co_historico_pag_assinatura)
    {
        $this->co_historico_pag_assinatura = $co_historico_pag_assinatura;
    }

}
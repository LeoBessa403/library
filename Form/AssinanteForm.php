<?php

/**
 * AssinanteForm [ FORM ]
 * @copyright (c) 2018, Leo Bessa
 */
class AssinanteForm
{
    public static function Cadastrar($res = false)
    {
        $id = "cadastroAssinante";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        $formulario->setValor($res);

        $formulario
            ->setId(NO_FANTASIA)
            ->setClasses("ob")
            ->setLabel("Nome do Estabelecimento")
            ->setTamanhoInput(12)
            ->CriaInpunt();

        $formulario
            ->setId(NO_PESSOA)
            ->setClasses("ob")
            ->setLabel("Nome do Responsável")
            ->setTamanhoInput(12)
            ->CriaInpunt();

        $formulario
            ->setId(NU_TEL1)
            ->setTamanhoInput(4)
            ->setIcon("fa fa-mobile-phone")
            ->setLabel("Telefone Celular")
            ->setInfo("Com <i class=\"fa fa-whatsapp\" style='color: green;' '></i> WhatSapp")
            ->setClasses("tel ob")
            ->CriaInpunt();

        $formulario
            ->setId(DS_EMAIL)
            ->setIcon("fa-envelope fa")
            ->setClasses("email ob")
            ->setLabel("Email")
            ->setTamanhoInput(8)
            ->CriaInpunt();

        if (!empty($res[CO_ASSINANTE])):
            $formulario
                ->setType(TiposCampoEnum::HIDDEN)
                ->setId(CO_ASSINANTE)
                ->setValues($res[CO_ASSINANTE])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm();
    }

    public static function Pagamento($res = false)
    {
        $id = "RenovaPlanoAssinante";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Pagar", 6);
        $formulario->setValor($res);

        $formulario
            ->setId(DT_EXPIRACAO)
            ->setTamanhoInput(4)
            ->setClasses("disabilita")
            ->setIcon("clip-calendar-3")
            ->setInfo("Termino do plano Ativo")
            ->setLabel("Data de Expiração")
            ->CriaInpunt();

        $options = PlanoService::montaComboPlanosAtivos();
        $formulario
            ->setId(CO_PLANO)
            ->setType(TiposCampoEnum::SELECT)
            ->setLabel("Plano")
            ->setTamanhoInput(12)
            ->setClasses("ob")
            ->setOptions($options)
            ->CriaInpunt();

        $tp_pagamentos = [
            null => Mensagens::MSG_SEM_ITEM_SELECIONADO,
            TipoPagamentoEnum::CARTAO_CREDITO =>
                TipoPagamentoEnum::getDescricaoValor(TipoPagamentoEnum::CARTAO_CREDITO),
            TipoPagamentoEnum::PIX =>
                TipoPagamentoEnum::getDescricaoValor(TipoPagamentoEnum::PIX),
            TipoPagamentoEnum::BOLETO =>
                TipoPagamentoEnum::getDescricaoValor(TipoPagamentoEnum::BOLETO)
        ];
        $formulario
            ->setId(TP_PAGAMENTO)
            ->setType(TiposCampoEnum::SELECT)
            ->setLabel("Tipo de Pagamento")
            ->setTamanhoInput(12)
            ->setClasses("ob")
            ->setOptions($tp_pagamentos)
            ->CriaInpunt();

        $formulario
            ->setId(NU_TEL1)
            ->setIcon("fa fa-mobile-phone")
            ->setLabel("Celular do Comprador")
            ->setInfo("Com <i class='fa fa-whatsapp' style='color: green;'></i> WhatSapp")
            ->setClasses("tel ob")
            ->setTamanhoInput(6)
            ->CriaInpunt();


        $bancos = [
            null => Mensagens::MSG_SEM_ITEM_SELECIONADO,
        ];
        $formulario
            ->setId('chave')
            ->setLabel("Chave PIX")
            ->setPlace('contato@sistemadabeleza.com.br')
            ->setClasses("debito disabilita")
            ->setTamanhoInput(12)
            ->setOptions($bancos)
            ->CriaInpunt();

        $formulario
            ->setId('numCartao')
            ->setTamanhoInput(6)
            ->setIcon("fa fa-whatsapp", 'dir')
            ->setLabel("Número do Cartão")
            ->setInfo("Somente Números")
            ->setClasses("cartao_credito credito")
            ->CriaInpunt();

        $formulario
            ->setId('validadeCartao')
            ->setTamanhoInput(3)
            ->setLabel("Validade do Cartão")
            ->setInfo("Somente Números")
            ->setClasses("validade_cartao credito")
            ->CriaInpunt();

        $formulario
            ->setId('cvvCartao')
            ->setTamanhoInput(3)
            ->setLabel("CVV do cartão")
            ->setInfo("Somente Números")
            ->setClasses("cvv credito")
            ->CriaInpunt();

        $parcelas = [
            null => Mensagens::MSG_SEM_ITEM_SELECIONADO,
        ];
        $formulario
            ->setId('qntParcelas')
            ->setType(TiposCampoEnum::SELECT)
            ->setLabel("Número de Parcelas")
            ->setClasses("credito")
            ->setTamanhoInput(12)
            ->setOptions($parcelas)
            ->CriaInpunt();

        $formulario
            ->setId('creditCardHolderName')
            ->setTamanhoInput(12)
            ->setLabel("Nome no Cartão")
            ->setClasses("nome credito")
            ->CriaInpunt();

        $formulario
            ->setId('creditCardHolderCPF')
            ->setTamanhoInput(6)
            ->setLabel("CPF do dono do Cartão")
            ->setClasses("cpf credito")
            ->CriaInpunt();

        $formulario
            ->setId('creditCardHolderBirthDate')
            ->setTamanhoInput(6)
            ->setLabel("Nascimento do dono do Cartão")
            ->setClasses("data credito")
            ->CriaInpunt();

        $formulario
            ->setId(NU_CEP)
            ->setLabel("CEP do dono do Cartão")
            ->setClasses("cep credito")
            ->setTamanhoInput(12)
            ->CriaInpunt();

        $formulario
            ->setId(DS_ENDERECO)
            ->setIcon("clip-home-2")
            ->setClasses("credito")
            ->setTamanhoInput(12)
            ->setLabel("Endereço do dono do Cartão")
            ->CriaInpunt();

        $formulario
            ->setId(DS_COMPLEMENTO)
            ->setTamanhoInput(12)
            ->setClasses("credito")
            ->setLabel("Complemento do dono do Cartão")
            ->CriaInpunt();

        $formulario
            ->setId(DS_BAIRRO)
            ->setTamanhoInput(12)
            ->setClasses("credito")
            ->setLabel("Bairro do dono do Cartão")
            ->CriaInpunt();

        $formulario
            ->setId(NO_CIDADE)
            ->setTamanhoInput(12)
            ->setClasses("credito")
            ->setLabel("Cidade do dono do Cartão")
            ->CriaInpunt();

        $options = EnderecoService::montaComboEstadosDescricao();
        $formulario
            ->setId(SG_UF)
            ->setType(TiposCampoEnum::SELECT)
            ->setClasses("credito")
            ->setTamanhoInput(12)
            ->setLabel("Estado do dono do Cartão")
            ->setOptions($options)
            ->CriaInpunt();

        if (!empty($res[CO_ASSINANTE])):
            $formulario
                ->setType(TiposCampoEnum::HIDDEN)
                ->setId(CO_ASSINANTE)
                ->setValues($res[CO_ASSINANTE])
                ->CriaInpunt();
        endif;

        if (!empty($res[CO_PLANO_ASSINANTE_ASSINATURA])):
            $formulario
                ->setType(TiposCampoEnum::HIDDEN)
                ->setId(CO_PLANO_ASSINANTE_ASSINATURA)
                ->setValues($res[CO_PLANO_ASSINANTE_ASSINATURA])
                ->CriaInpunt();
        endif;

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId('bandeiraCartao')
            ->setValues(null)
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId('hash')
            ->setValues(null)
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId('tokenCartao')
            ->setValues(null)
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId('installmentValue')
            ->setValues(null)
            ->CriaInpunt();

        return $formulario->finalizaForm('Assinante/MeuPlanoAssinante');
    }

    public static function DadosComplementares($res = false)
    {
        $id = "DadosComplementares";

        $formulario = new FormAssistente($id, null, null, null, "Dados Complementares");
        $formulario->setValor($res);

        // Aba 1
        $formulario
            ->criaAba("Empresa", " Informações básicas");

        $formulario
            ->setId(NO_PESSOA)
            ->setClasses("ob nome")
            ->setLabel("Nome do Responsável")
            ->CriaInpunt();

        $formulario
            ->setId(NO_FANTASIA)
            ->setClasses("ob")
            ->setLabel("Nome Fantasia")
            ->CriaInpunt();

        $formulario
            ->setId(NO_EMPRESA)
            ->setLabel("Razão Social")
            ->CriaInpunt();

        $formulario
            ->setId(NU_CNPJ)
            ->setClasses("cnpj")
            ->setTamanhoInput(6)
            ->setLabel("CNPJ")
            ->CriaInpunt();

        $formulario
            ->setId(NU_INSC_ESTADUAL)
            ->setLabel("Inscrição Estadual ")
            ->setInfo("Somente Números")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::TEXTAREA)
            ->setId(DS_OBSERVACAO)
            ->setLabel("Descrição")
            ->CriaInpunt();

        $formulario
            ->finalizaAba();

        // Aba 2
        $formulario
            ->criaAba("Endereço", "Informações de Endereço");

        $formulario
            ->setId(NU_CEP)
            ->setLabel("CEP")
            ->setClasses("cep ob")
            ->CriaInpunt();

        $formulario
            ->setId(DS_ENDERECO)
            ->setIcon("clip-home-2")
            ->setClasses("ob")
            ->setLabel("Endereço")
            ->CriaInpunt();

        $formulario
            ->setId(DS_COMPLEMENTO)
            ->setLabel("Complemento")
            ->CriaInpunt();

        $formulario
            ->setId(DS_BAIRRO)
            ->setLabel("Bairro")
            ->CriaInpunt();

        $formulario
            ->setId(NO_CIDADE)
            ->setLabel("Cidade")
            ->CriaInpunt();

        $options = EnderecoService::montaComboEstadosDescricao();
        $formulario
            ->setId(SG_UF)
            ->setType(TiposCampoEnum::SELECT)
            ->setClasses("ob")
            ->setLabel("Estado")
            ->setOptions($options)
            ->CriaInpunt();

        $formulario
            ->finalizaAba();

        // Aba 3
        $formulario
            ->criaAba("Contatos", "Informações de Contatos");

        $formulario
            ->setId(NU_TEL1)
            ->setIcon("fa fa-mobile-phone")
            ->setLabel("Telefone")
            ->setInfo("Com <i class='fa fa-whatsapp' style='color: green;'></i> WhatSapp")
            ->setClasses("tel ob")
            ->CriaInpunt();

        $formulario
            ->setId(NU_TEL2)
            ->setTamanhoInput(6)
            ->setIcon("fa fa-mobile-phone")
            ->setLabel("Telefone Celular 2")
            ->setClasses("tel")
            ->CriaInpunt();

        $formulario
            ->setId(DS_EMAIL)
            ->setIcon("fa-envelope fa")
            ->setClasses("email ob")
            ->setLabel("Email")
            ->CriaInpunt();

        $formulario
            ->setId(DS_SITE)
            ->setLabel("Site")
            ->CriaInpunt();

        $formulario
            ->setId(DS_FACEBOOK)
            ->setIcon("fa-facebook fa")
            ->setLabel("Facebook")
            ->CriaInpunt();

        $formulario
            ->setId(DS_INSTAGRAM)
            ->setIcon("fa-instagram fa")
            ->setLabel("Instagram")
            ->CriaInpunt();

        $formulario
            ->setId(DS_TWITTER)
            ->setIcon("fa-twitter fa")
            ->setLabel("Twitter")
            ->CriaInpunt();

        $formulario
            ->finalizaAba();


        // Aba 4
        $formulario
            ->criaAba("Fotos", "Fotos do Estabelecimento");

        $formulario
            ->setId(DS_CAMINHO)
            ->setType(TiposCampoEnum::SINGLEFILE)
            ->setInfo("Foto da fachada do estabelecimento")
            ->setLabel("Foto Principal / Logo")
            ->CriaInpunt();

        $formulario
            ->setId(CO_IMAGEM_ASSINANTE)
            ->setLabel("Galeria de Fotos do Estabelecimento")
            ->setType(TiposCampoEnum::FILE)
            ->setClasses("multipla")
            ->setLimite(5)
            ->setInfo("Pode enviar até 5 Fotos")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId('imagem_logo')
            ->setValues($res['imagem_logo'])
            ->CriaInpunt();

        $formulario
            ->finalizaAba(true);

        return $formulario->finalizaFormAssistente();
    }


    public static function Pesquisar($resultPreco)
    {
        $id = "pesquisaServico";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action, "Pesquisa", 12);

        $formulario
            ->setId(NU_CNPJ)
            ->setClasses("cnpj")
            ->setTamanhoInput(6)
            ->setLabel("CNPJ")
            ->CriaInpunt();

        $formulario
            ->setId(NO_FANTASIA)
            ->setTamanhoInput(6)
            ->setLabel("Nome Fantasia")
            ->CriaInpunt();

        $formulario
            ->setId(NO_EMPRESA)
            ->setTamanhoInput(6)
            ->setLabel("Razão Social")
            ->CriaInpunt();

        $formulario
            ->setId(NO_PESSOA)
            ->setTamanhoInput(6)
            ->setClasses("nome")
            ->setLabel("Nome do Responsável")
            ->CriaInpunt();

        $formulario
            ->setId(NO_CIDADE)
            ->setTamanhoInput(6)
            ->setLabel("Cidade")
            ->CriaInpunt();

        $options = EnderecoService::montaComboEstadosDescricao();
        $formulario
            ->setId(SG_UF)
            ->setType(TiposCampoEnum::SELECT)
            ->setTamanhoInput(6)
            ->setLabel("Estado")
            ->setOptions($options)
            ->CriaInpunt();

        $formulario
            ->setId(NU_VALOR_ASSINATURA)
            ->setTamanhoInput(12)
            ->setIntervalo($resultPreco)
            ->setType(TiposCampoEnum::SLIDER)
            ->setLabel("Valor R$")
            ->CriaInpunt();


        return $formulario->finalizaFormPesquisaAvancada();
    }

    public static function CadastrarNotificaacao()
    {
        $id = "CadastrarNotificaacao";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Notificar", 6);

        $formulario
            ->setId('notificationCode')
            ->setClasses("ob")
            ->setLabel("Código de Notificação")
            ->CriaInpunt();

        return $formulario->finalizaForm();
    }

}

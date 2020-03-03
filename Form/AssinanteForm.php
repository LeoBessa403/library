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
        $id = "cadastroAssinante";

        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action,
            "Cadastrar", 6);
        $formulario->setValor($res);

        $formulario
            ->setId(DT_EXPIRACAO)
            ->setTamanhoInput(4)
            ->setClasses("disabilita")
            ->setIcon("clip-calendar-3")
            ->setInfo("Data de termino")
            ->setLabel("Data de Expiração")
            ->CriaInpunt();

        $formulario
            ->setId(NU_FILIAIS)
            ->setClasses("ob numero")
            ->setLabel("Número de Filiais")
            ->setTamanhoInput(4)
            ->CriaInpunt();

        $formulario
            ->setId(NU_PROFISSIONAIS)
            ->setClasses("ob numero")
            ->setLabel("Número de Profissionais")
            ->setInfo("Prof. total com filiais")
            ->setTamanhoInput(4)
            ->CriaInpunt();

        $options = PlanoService::montaComboPlanosAtivos();
        $formulario
            ->setId(CO_PLANO)
            ->setType(TiposCampoEnum::SELECT)
            ->setLabel("Plano")
            ->setClasses("ob")
            ->setOptions($options)
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

}

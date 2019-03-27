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

        $coAssinante = (!empty($res[CO_ASSINANTE])) ? $res[CO_ASSINANTE] : null;

        $options = AssinanteService::montaComboMatriz($coAssinante);
        $formulario
            ->setId(CO_ASSINANTE_MATRIZ)
            ->setType("select")
            ->setLabel("Matriz")
            ->setOptions($options)
            ->CriaInpunt();


        if (!empty($res[CO_ASSINANTE])):
            $formulario
                ->setType("hidden")
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
            ->setType("select")
            ->setLabel("Plano")
            ->setClasses("ob")
            ->setOptions($options)
            ->CriaInpunt();


        if (!empty($res[CO_ASSINANTE])):
            $formulario
                ->setType("hidden")
                ->setId(CO_ASSINANTE)
                ->setValues($res[CO_ASSINANTE])
                ->CriaInpunt();
        endif;

        return $formulario->finalizaForm();
    }

    public static function DadosComplementares($res = false)
    {
        $id = "DadosComplementares";

        $formulario = new FormAssistente($id, null, null, null , "Dados Complementares");
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
            ->setType("textarea")
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
            ->setClasses("cep")
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
            ->setType("select")
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
            ->setLabel("Telefone (WhatsApp)")
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
            ->finalizaAba();

        // Aba 4
        $formulario
            ->criaAba("Facilidades e Benefícios", "Informações das Facilidades e Benefícios");

        $options = TipoEstabelecimentoEnum::$descricao;
        $formulario
            ->setId(TP_ESTABELECIMENTO)
            ->setType("select")
            ->setLabel("Tipo de estabelecimento")
            ->setOptions($options)
            ->CriaInpunt();

        $options = TipoAtendimentoEnum::$descricao;
        $formulario
            ->setId(TP_ATENDIMENTO)
            ->setType("select")
            ->setLabel("Atendimento")
            ->setOptions($options)
            ->CriaInpunt();

        $options = TipoGeneroEspecializadoEnum::$descricao;
        $formulario
            ->setId(TP_GENERO_ESPECIALIZADO)
            ->setType("select")
            ->setLabel("Genero Especializado")
            ->setOptions($options)
            ->CriaInpunt();

        $options = TipoEstacionamentoEnum::$descricao;
        $formulario
            ->setId(TP_ESTACIONAMENTO)
            ->setType("select")
            ->setLabel("Estacionamento")
            ->setOptions($options)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Lanchonete")
            ->setClasses($res[ST_LANCHONETE])
            ->setId(ST_LANCHONETE)
            ->setType("checkbox")
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Televisão")
            ->setClasses($res[ST_TELEVISAO])
            ->setId(ST_TELEVISAO)
            ->setType("checkbox")
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Wi-Fi")
            ->setClasses($res[ST_WIFI])
            ->setId(ST_WIFI)
            ->setType("checkbox")
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Acesso Deficiente")
            ->setClasses($res[ST_ACESSO_DEFICIENTE])
            ->setId(ST_ACESSO_DEFICIENTE)
            ->setType("checkbox")
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Jogos")
            ->setClasses($res[ST_JOGOS])
            ->setId(ST_JOGOS)
            ->setType("checkbox")
            ->setOptions($label_options2)
            ->CriaInpunt();

        $formulario
            ->finalizaAba();


        // Aba 5
        $formulario
            ->criaAba("Funcionamento", "Informações do horário de funcionamento", 10);


        $grid = new GridAssistente();
        $arrColunas = array('Atende', 'Dia da Semana', 'Abertura', 'Fechamento');
        $grid->setColunasIndeces($arrColunas);
        $grid->criaGrid('nova');

        $funcionamentoEdit = $res['funcionamento'];
        foreach (DiasEnum::$descricao as $numero => $dia) {
            $check = null;
            $abertura = null;
            $fechamento = null;
            if (!empty($funcionamentoEdit[$numero - 1])) {
                $check = ' checked="checked"';
                $abertura = $funcionamentoEdit[$numero - 1]->getNuHoraAbertura();
                $fechamento = $funcionamentoEdit[$numero - 1]->getNuHoraFechamento();
            }
            $campoAtende = '<input type="checkbox" ' . $check . '
                           class="square-purple"
                           value="" id="' . NU_DIA_SEMANA . $numero . '"
                           name="' . NU_DIA_SEMANA . '[' . $numero . ']"/>';


            $campoAbertura = '<input type="text" class="form-control horas"
                           id="' . NU_HORA_ABERTURA . $numero . '"
                           name="' . NU_HORA_ABERTURA . '[' . $numero . ']"
                           value="' . $abertura . '"
                           placeholder="Horário de Abertura do dia">';

            $campoFechamento = '<input type="text" class="form-control horas"
               id="' . NU_HORA_FECHAMENTO . $numero . '"
               name="' . NU_HORA_FECHAMENTO . '[' . $numero . ']"
               value="' . $fechamento . '"
               placeholder="Horário de Fechamento do dia">';

            $grid->setColunas($campoAtende);
            $grid->setColunas($dia);
            $grid->setColunas($campoAbertura);
            $grid->setColunas($campoFechamento);
            $grid->criaLinha($numero);
        }
        $gridAssitente = $grid->finalizaGrid();

        $formulario
            ->finalizaAba(false, $gridAssitente);

        // Aba 6
        $formulario
            ->criaAba("Fotos", "Fotos do Estabelecimento");

        $formulario
            ->setId(DS_CAMINHO)
            ->setType("singlefile")
            ->setInfo("Foto da fachada do estabelecimento")
            ->setLabel("Foto Principal / Logo")
            ->CriaInpunt();

        $formulario
            ->setId(CO_IMAGEM_ASSINANTE)
            ->setLabel("Galeria de Fotos do Estabelecimento")
            ->setType("file")
            ->setClasses("multipla")
            ->setLimite(5)
            ->setInfo("Pode enviar até 5 Fotos")
            ->CriaInpunt();

        $formulario
            ->setType("hidden")
            ->setId('imagem_logo')
            ->setValues($res['imagem_logo'])
            ->CriaInpunt();

        $formulario
            ->finalizaAba(true);

        return $formulario->finalizaForm();
    }

}

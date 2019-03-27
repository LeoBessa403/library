<?php

class GestaoForm
{

    public static function Gerar()
    {
        $id = "gestaoGerarEntidades";

        $formulario = new Form($id, null, 'Gerar');

        $tabelas = AuditoriaService::PesquisaTabelasCombo();
        $formulario
            ->setId(NO_TABELA)
            ->setLabel("Entidades")
            ->setClasses("multipla")
            ->setInfo("Pode selecionar várias TABELAS.")
            ->setType("select")
            ->setOptions($tabelas)
            ->CriaInpunt();

        return $formulario->finalizaForm();
    }

    public static function GerarBackup()
    {
        $id = "GerarBackup";

        $formulario = new Form($id, null, 'Gerar',3);

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Gerar Backup")
            ->setId(ST_STATUS)
            ->setType("checkbox")
            ->setTamanhoInput(12)
            ->setOptions($label_options2)
            ->CriaInpunt();

        return $formulario->finalizaForm();
    }

    public static function Config($res)
    {
        $id = "GerarBackup";

        $formulario = new Form($id, null, 'Gerar');
        $formulario->setValor($res);

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Projeto possui site?")
            ->setId('TEM_SITE')
            ->setClasses($res['TEM_SITE'])
            ->setType("checkbox")
            ->setTamanhoInput(3)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Modulo assinante?")
            ->setId('MODULO_ASSINANTE')
            ->setClasses($res['MODULO_ASSINANTE'])
            ->setType("checkbox")
            ->setTamanhoInput(3)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Logar com email?")
            ->setId('LOGAR_EMAIL')
            ->setClasses($res['LOGAR_EMAIL'])
            ->setType("checkbox")
            ->setTamanhoInput(3)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $label_options2 = array("<i class='fa fa-check fa-white'></i>", "<i class='fa fa-times fa-white'></i>", "verde", "vermelho");
        $formulario
            ->setLabel("Tabela para auditoria?")
            ->setId('TABELA_AUDITORIA')
            ->setClasses($res['TABELA_AUDITORIA'])
            ->setType("checkbox")
            ->setTamanhoInput(3)
            ->setOptions($label_options2)
            ->CriaInpunt();

        $formulario
            ->setId('DESC')
            ->setLabel("Nome do Sistema")
            ->setTamanhoInput(3)
            ->CriaInpunt();

        $formulario
            ->setId('DESC_SIS')
            ->setClasses('ob')
            ->setLabel("Sigla do Sistema")
            ->setTamanhoInput(3)
            ->CriaInpunt();

        $formulario
            ->setId('TITULO_SITE')
            ->setClasses('ob')
            ->setLabel("Título padrão do site")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setType('textarea')
            ->setId('DESC_SITE')
            ->setClasses('ob')
            ->setLabel("Descrição padrão do site")
            ->CriaInpunt();

        $formulario
            ->setId('CONTROLLER_INICIAL_ADMIN')
            ->setClasses('ob')
            ->setLabel("Controller inicial do admin")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('ACTION_INICIAL_ADMIN')
            ->setClasses('ob')
            ->setLabel("Ação inicial do admin")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('CONTROLLER_INICIAL_SITE')
            ->setClasses('ob')
            ->setLabel("Controller inicial do site")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('ACTION_INICIAL_SITE')
            ->setClasses('ob')
            ->setLabel("Ação inicial do site")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('TABLE_USER')
            ->setClasses('ob')
            ->setLabel("Tabela de usuário para validação")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('CAMPO_PASS')
            ->setClasses('ob')
            ->setLabel("Campo da senha na Tabela")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('CAMPO_ID')
            ->setClasses('ob')
            ->setLabel("Chave Primaria na Tabela de usuário")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('CAMPO_PERFIL')
            ->setClasses('ob')
            ->setLabel("Campo do Perfil na Tabela de usuário")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('SESSION_USER')
            ->setClasses('ob')
            ->setLabel("Nome da Sessão do usuário Logado")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('INATIVO')
            ->setClasses('ob')
            ->setClasses('numero')
            ->setLabel("Tempo de Inativadade Máximo em Minutos")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('BACKUP')
            ->setClasses('ob')
            ->setClasses('numero')
            ->setLabel("Dias para realizar o BACKUP NO BANCO")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('TAMANHO')
            ->setClasses('ob')
            ->setClasses('numero')
            ->setLabel("Tamanho padrão do width das iamgens")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('WHATSAPP')
            ->setClasses('ob')
            ->setClasses('tel')
            ->setLabel("Número padrão de envio do WhatsApp")
            ->setTamanhoInput(6)
            ->CriaInpunt();

        $formulario
            ->setId('NUM_BG_IMAGENS')
            ->setClasses('ob')
            ->setLabel("Número de imagens")
            ->setClasses('numero')
            ->setTamanhoInput(6)
            ->setInfo("backgrounds da tela inicial do sistema")
            ->CriaInpunt();

        $formulario
            ->setId('CONTROLLER_SEO')
            ->setLabel("Controllers para gerar o seo diferenciado")
            ->setInfo('Separador por vírguila')
            ->CriaInpunt();

        $formulario
            ->setId('USER_EMAIL')
            ->setLabel("Email")
            ->setClasses('email')
            ->setTamanhoInput(8)
            ->setInfo('E-mail padrão para envio do sistema')
            ->CriaInpunt();

        $formulario
            ->setId('PASS_EMAIL')
            ->setLabel("Senha")
            ->setTamanhoInput(4)
            ->setInfo('Senha do email')
            ->CriaInpunt();

        $formulario
            ->setId('HOST_EMAIL')
            ->setLabel("Host E-mail")
            ->setInfo('Host de configuração do email')
            ->CriaInpunt();

        $formulario
            ->setId('PORTA_EMAIL')
            ->setLabel("Porta E-mail")
            ->setClasses('numero')
            ->setTamanhoInput(6)
            ->setInfo('Porta de configuração do email')
            ->CriaInpunt();

        $formulario
            ->setId('ID_ANALITCS')
            ->setTamanhoInput(6)
            ->setLabel("Id Analitcs")
            ->setInfo('Código identificador do analitics')
            ->CriaInpunt();

        return $formulario->finalizaForm();
    }

    public static function LimparBanco()
    {
        $id = "LimparBanco";

        $formulario = new Form($id, null, 'Limpar Banco',6);

        $tabelas = [
            1 => 'Acesso',
            2 => 'Auditoria',
//            3 => 'Visita e trafego'
        ];
        $formulario
            ->setId('tp_dados')
            ->setLabel("Tabelas do Banco")
            ->setClasses("multipla")
            ->setInfo("Pode selecionar várias TABELAS.")
            ->setType("select")
            ->setOptions($tabelas)
            ->CriaInpunt();

        $formulario
            ->setId('dt_fim')
            ->setIcon("clip-calendar-3")
            ->setTamanhoInput(3)
            ->setClasses("data ob")
            ->setLabel("Até o dia")
            ->setValor(date('d/m/Y'))
            ->CriaInpunt();

        return $formulario->finalizaForm();
    }
}
?>
   
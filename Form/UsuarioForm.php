<?php

class UsuarioForm extends AbstractController
{

    public static function Cadastrar($res = false, $resgistrar = false, $tamanho = 6)
    {
        $id = "CadastroUsuario";
        $meusPerfis = array();
        $link = UrlAmigavel::$controller . '/Listar' . UrlAmigavel::$controller;

        /** @var Form $formulario */
        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller
            . "/" . UrlAmigavel::$action, 'Cadastrar', $tamanho);
        if (!empty($res[CO_USUARIO])):
            /** @var Session $us */
            $us = $_SESSION[SESSION_USER];
            $user = $us->getUser();
            $meusPerfis = $user[md5(CAMPO_PERFIL)];
            $meusPerfis = explode(',', $meusPerfis);

            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->PesquisaUmQuando([CO_USUARIO => $res[CO_USUARIO]]);

            if ((in_array(1, $meusPerfis) || in_array(2, $meusPerfis)) &&
                (!empty($res[CO_USUARIO])) && ($res[CO_USUARIO] != UsuarioService::getCoUsuarioLogado())) {
                $res[CAMPO_PERFIL] = PerfilService::montaArrayPerfil($usuario);
            } else {
                $res["ST_STATUS2"] = Valida::SituacaoUsuarioLabel($res[ST_STATUS]);
                $res[CAMPO_PERFIL] = implode(', ', PerfilService::montaComboPerfil($usuario));
            }
        endif;
        $res['cpf'] = $res[NU_CPF];
        $formulario->setValor($res);

        $formulario
            ->setId(NU_CPF)
            ->setClasses("cpf")
            ->setTamanhoInput(6)
            ->setLabel("CPF")
            ->CriaInpunt();

        $formulario
            ->setId(NU_RG)
            ->setTamanhoInput(6)
            ->setClasses("numero")
            ->setLabel("RG")
            ->CriaInpunt();

        $formulario
            ->setId(NO_PESSOA)
            ->setClasses("ob nome")
            ->setInfo("O Nome deve ser Completo Mínimo de 10 Caracteres")
            ->setLabel("Nome Completo")
            ->CriaInpunt();

        $formulario
            ->setId(DT_NASCIMENTO)
            ->setTamanhoInput(6)
            ->setClasses("data")
            ->setLabel("Nascimento")
            ->setInfo("Data de Nascimento")
            ->CriaInpunt();

        $label_options = array("" => "Selecione um", "M" => "Masculino", "F" => "Feminino");
        $formulario
            ->setLabel("Sexo")
            ->setId(ST_SEXO)
            ->setType(TiposCampoEnum::SELECT)
            ->setTamanhoInput(6)
            ->setOptions($label_options)
            ->CriaInpunt();

        $formulario
            ->setId(DS_EMAIL)
            ->setIcon("fa-envelope fa")
            ->setClasses("email ob")
            ->setLabel("Email")
            ->CriaInpunt();

        $formulario
            ->setId(NU_TEL1)
            ->setTamanhoInput(6)
            ->setIcon("fa fa-mobile-phone")
            ->setLabel("Telefone Celular")
            ->setInfo("Com <i class=\"fa fa-whatsapp\" style='color: green;'></i> WhatSapp")
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
            ->setId(NU_CEP)
            ->setLabel("CEP")
            ->setClasses("cep")
            ->CriaInpunt();

        $formulario
            ->setId(DS_ENDERECO)
            ->setIcon("clip-home-2")
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
            ->setLabel("Estado")
            ->setOptions($options)
            ->CriaInpunt();

        $formulario
            ->setId(DS_SENHA)
            ->setClasses("ob senha")
            ->setTamanhoInput(6)
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Senha")
            ->CriaInpunt();

        $formulario
            ->setId("ds_senha_confirma")
            ->setClasses("ob confirma-senha")
            ->setTamanhoInput(6)
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Confirmação da Senha")
            ->CriaInpunt();

        if (!$resgistrar) {
            if ((PerfilService::perfilMaster() && ($res[CO_USUARIO] != UsuarioService::getCoUsuarioLogado()))
                || ((in_array(2, $meusPerfis)) &&
                    (!empty($res[CO_USUARIO])) && ($res[CO_USUARIO] != UsuarioService::getCoUsuarioLogado())) ||
                (empty($res[CO_USUARIO]))) :
                $label_options_perfis = PerfilService::montaComboTodosPerfis();
                $formulario
                    ->setLabel("Perfis")
                    ->setId(CAMPO_PERFIL)
                    ->setClasses("multipla")
                    ->setTamanhoInput(8)
                    ->setInfo("Pode selecionar vários perfis.")
                    ->setType(TiposCampoEnum::SELECT)
                    ->setOptions($label_options_perfis)
                    ->CriaInpunt();

                $checked = "";
                if (!empty($res[ST_STATUS])):
                    if ($res[ST_STATUS] == "A"):
                        $checked = "checked";
                    endif;
                endif;

                $label_options2 = array("Ativo", "Inativo", "verde", "vermelho");
                $formulario
                    ->setLabel("Status do Usuário")
                    ->setClasses($checked)
                    ->setId(ST_STATUS)
                    ->setInfo("Para Ativar e Desativar Usuários do Sistema.")
                    ->setType(TiposCampoEnum::CHECKBOX)
                    ->setTamanhoInput(4)
                    ->setOptions($label_options2)
                    ->CriaInpunt();
            else:
                $formulario
                    ->setId(CAMPO_PERFIL)
                    ->setClasses("disabilita")
                    ->setTamanhoInput(9)
                    ->setLabel("Perfis")
                    ->CriaInpunt();

                $formulario
                    ->setId("ST_STATUS2")
                    ->setClasses("disabilita")
                    ->setTamanhoInput(3)
                    ->setLabel("Status do Usuário")
                    ->CriaInpunt();

                $formulario
                    ->setType(TiposCampoEnum::HIDDEN)
                    ->setId(ST_STATUS)
                    ->setValues($res[ST_STATUS])
                    ->CriaInpunt();


            endif;
        } else {
            $link = 'Index/Acessar';
        }

        $formulario
            ->setId(DS_CAMINHO)
            ->setType(TiposCampoEnum::SINGLEFILE)
            ->setInfo("Caso queira troca de foto")
            ->setLabel("Foto de Perfil")
            ->CriaInpunt();

        if (PerfilService::perfilMaster() && ($res[CO_USUARIO] != UsuarioService::getCoUsuarioLogado())):
            $label_options_assinantes = AssinanteService::montaComboAssinantes();
            $formulario
                ->setLabel("Assinante")
                ->setId(CO_ASSINANTE)
                ->setClasses("ob")
                ->setType(TiposCampoEnum::SELECT)
                ->setOptions($label_options_assinantes)
                ->CriaInpunt();
        elseif (!empty($res[CO_ASSINANTE])):
            $formulario
                ->setType(TiposCampoEnum::HIDDEN)
                ->setId(CO_ASSINANTE)
                ->setValues($res[CO_ASSINANTE])
                ->CriaInpunt();
        endif;


         Form::CriaInputHidden($formulario, $res, [CO_PESSOA, CO_IMAGEM, CO_CONTATO, CO_ENDERECO, CO_USUARIO]);

        return $formulario->finalizaForm($link);
    }

    public static function CadastroUsuario($res = false, $tamanho = 6)
    {
        $id = "CadastroUsuario";

        /** @var FormAssistente $formulario */
        $formulario = new FormAssistente($id, UrlAmigavel::$modulo . "/" . UrlAmigavel::$controller
            . "/" . UrlAmigavel::$action, 'Cadastrar', $tamanho);
        $res['cpf'] = $res[NU_CPF];
        $formulario->setValor($res);

        // Aba 1
        $formulario
            ->criaAba("Pessoa", "Informações Pessoais", 12);

        $formulario
            ->setId('cpf')
            ->setClasses("cpf disabilita")
            ->setTamanhoInput(6)
            ->setLabel("CPF")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId(NU_CPF)
            ->setValues($res[NU_CPF])
            ->CriaInpunt();

        $formulario
            ->setId(NU_RG)
            ->setTamanhoInput(6)
            ->setClasses("numero")
            ->setLabel("RG")
            ->CriaInpunt();

        $formulario
            ->setId(NO_PESSOA)
            ->setClasses("ob nome")
            ->setInfo("O Nome deve ser Completo Mínimo de 10 Caracteres")
            ->setLabel("Nome Completo")
            ->CriaInpunt();

        $formulario
            ->setId(DT_NASCIMENTO)
            ->setClasses("data")
            ->setLabel("Nascimento")
            ->setInfo("Data de Nascimento")
            ->CriaInpunt();

        $label_options = array("" => "Selecione um", "M" => "Masculino", "F" => "Feminino");
        $formulario
            ->setLabel("Sexo")
            ->setId(ST_SEXO)
            ->setType(TiposCampoEnum::SELECT)
            ->setOptions($label_options)
            ->CriaInpunt();

        $formulario
            ->finalizaAba();

        // Aba 2
        $formulario
            ->criaAba("Endereço", "Informações de Endereço", 12);

        $formulario
            ->setId(NU_CEP)
            ->setLabel("CEP")
            ->setClasses("cep")
            ->CriaInpunt();

        $formulario
            ->setId(DS_ENDERECO)
            ->setIcon("clip-home-2")
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
            ->setLabel("Estado")
            ->setOptions($options)
            ->CriaInpunt();

        $formulario
            ->finalizaAba();

        // Aba 3
        $formulario
            ->criaAba("Contatos", "Informações de Contatos", 12);

        $formulario
            ->setId(NU_TEL1)
            ->setIcon("fa fa-mobile-phone")
            ->setLabel("Telefone (WhatsApp)")
            ->setClasses("tel ob")
            ->CriaInpunt();

        $formulario
            ->setId(NU_TEL2)
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

        // Aba 2
        $formulario
            ->criaAba("Usuário", "Dados do Usuário", 12);

        $formulario
            ->setId(DS_SENHA)
            ->setClasses("ob senha")
            ->setTamanhoInput(6)
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Senha")
            ->CriaInpunt();

        $formulario
            ->setId("ds_senha_confirma")
            ->setClasses("ob confirma-senha")
            ->setTamanhoInput(6)
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Confirmação da Senha")
            ->CriaInpunt();

        $formulario
            ->setId(DS_CAMINHO)
            ->setType(TiposCampoEnum::SINGLEFILE)
            ->setLabel("Foto de Perfil")
            ->CriaInpunt();

        $formulario
            ->finalizaAba(true);

        return $formulario->finalizaFormAssistente();
    }

    public static function TrocaSenha($idUsuario)
    {
        $id = "TrocaSenha";

        /** @var Form $formulario */
        $formulario = new Form($id, ADMIN . "/" . UrlAmigavel::$controller
            . "/" . UrlAmigavel::$action, 'Trocar', 6);

        $formulario
            ->setId("ds_senha_antiga")
            ->setClasses("ob")
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Senha Antiga")
            ->CriaInpunt();

        $formulario
            ->setId(DS_SENHA)
            ->setClasses("ob senha")
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Nova Senha")
            ->CriaInpunt();

        $formulario
            ->setId("ds_senha_confirma")
            ->setClasses("ob confirma-senha")
            ->setType(TiposCampoEnum::PASSWORD)
            ->setLabel("Confirmação da Senha")
            ->CriaInpunt();

        $formulario
            ->setType(TiposCampoEnum::HIDDEN)
            ->setId(CO_USUARIO)
            ->setValues($idUsuario)
            ->CriaInpunt();

        return $formulario->finalizaForm();
    }

    public static function Pesquisar()
    {
        $id = "pesquisaUsuario";

        $formulario = new Form($id, "admin/Usuario/ListarUsuario", "Pesquisa", 12);

        $formulario
            ->setId(NO_PESSOA)
            ->setIcon("clip-user-6")
            ->setLabel("Nome do Usuario")
            ->setInfo("Pode ser Parte do nome")
            ->CriaInpunt();

        $formulario
            ->setId(NU_CPF)
            ->setClasses("cpf")
            ->setTamanhoInput(6)
            ->setLabel("CPF")
            ->CriaInpunt();

        return $formulario->finalizaFormPesquisaAvancada();
    }
}

?>
   
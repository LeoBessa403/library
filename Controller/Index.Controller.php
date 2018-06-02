<?php

class Index extends AbstractController
{
    public function Index()
    {
        $index =  new IndexController();
        $this->dados = $index->Index();
    }

    public function Registrar()
    {
        $id = "CadastroUsuario";
        $id2 = "ValidacaoPessoa";
        if (!empty($_POST[$id])) {
            /** @var UsuarioService $usuarioService */
            $usuarioService = static::getService(USUARIO_SERVICE);
            $usuarioService->salvaUsuario($_POST, $_FILES, true);
        } elseif (!empty($_POST[$id2])) {
            $PessoaValidador = new PessoaValidador();
            /** @var PessoaValidador $validador */
            $validador = $PessoaValidador->validarCPF($_POST);
            if ($validador[SUCESSO]) {
                /** @var PessoaService $pessoaService */
                $pessoaService = static::getService(PESSOA_SERVICE);
                /** @var PessoaEntidade $pessoa */
                $pessoa = $pessoaService->PesquisaUmQuando([
                    NU_CPF => Valida::RetiraMascara($_POST[NU_CPF])
                ]);
                $res = [];
                if (!empty($pessoa)) {
                    if ($pessoa->getCoUsuario()) {
                        Redireciona('admin/Index/Acessar/' . Valida::GeraParametro('acesso/U'));
                    } else {
                        $res = $pessoaService->getArrayDadosPessoa($pessoa, $res);

                        /** @var EnderecoService $enderecoService */
                        $enderecoService = $this->getService(ENDERECO_SERVICE);
                        $res = $enderecoService->getArrayDadosEndereco($pessoa->getCoEndereco(), $res);

                        /** @var ContatoService $contatoService */
                        $contatoService = $this->getService(CONTATO_SERVICE);
                        $res = $contatoService->getArrayDadosContato($pessoa->getCoContato(), $res);
                        if ($pessoa->getCoInscricao()) {
                            if ($pessoa->getUltimaCoInscricao()->getCoImagem()->getDsCaminho()):
                                $res[DS_CAMINHO] = "inscricoes/" . $pessoa->getUltimaCoInscricao()->getCoImagem()->getDsCaminho();
                                $res[CO_IMAGEM] = $pessoa->getUltimaCoInscricao()->getCoImagem()->getCoImagem();
                            endif;
                        }
                    }
                } else {
                    $res[NU_CPF] = $_POST[NU_CPF];
                }
                $this->form = UsuarioForm::Cadastrar($res, true, 12);
            } else {
                $session = new Session();
                $session->setSession(MENSAGEM, $validador[MSG]);
                $this->form = PessoaForm::ValidarCPF('Index/Acessar');
            }
        } else {
            $this->form = PessoaForm::ValidarCPF('Index/Acessar');
        }
    }

    public function PrimeiroAcesso()
    {
        /** @var Session $session */
        $session = new Session();
        if ($session->CheckSession(SESSION_USER)) {
            Redireciona(ADMIN . LOGADO);
        }
    }

    public function RecuperarSenha()
    {
        $visivel = false;
        $msg = '';
        $class = '';
        if (!empty($_POST)) {
            $visivel = true;
            $PessoaValidador = new PessoaValidador();
            /** @var PessoaValidador $validador */
            $validador = $PessoaValidador->validarCPF($_POST);
            if ($validador[SUCESSO]) {
                /** @var PessoaService $pessoaService */
                $pessoaService = static::getService(PESSOA_SERVICE);
                /** @var PessoaEntidade $pessoa */
                $pessoa = $pessoaService->PesquisaUmQuando([
                    NU_CPF => Valida::RetiraMascara($_POST[NU_CPF])
                ]);
                if (count($pessoa)) {
                    if ($pessoa->getCoUsuario()) {
                        $email = new Email();

                        // Índice = Nome, e Valor = Email.
                        $emails = array(
                            $pessoa->getNoPessoa() => $pessoa->getCoContato()->getDsEmail()
                        );
                        $Mensagem = "<h4>Oi " . $pessoa->getNoPessoa() . ".</h4>";
                        $Mensagem .= "<p>Sua senha de acesso ao sistema " . DESC . " é: <b>" . $pessoa->getCoUsuario()->getDsSenha() .
                            ".</b></p>";

                        $email->setEmailDestinatario($emails)
                            ->setTitulo("[Sistema " . DESC . "] - Recuperação de senha")
                            ->setMensagem($Mensagem);

                        // Variável para validação de Emails Enviados com Sucesso.
                        $retorno = $email->Enviar();
                        if ($retorno == true) {
                            $msg = 'Sua senha foi enviada para seu email: ' . $pessoa->getCoContato()->getDsEmail();
                            $class = 1;
                        }
                    } else {
                        $msg = 'Usuário não cadastrado.';
                        $class = 4;
                    }
                } else {
                    $msg = 'Pessoa não cadastrada.';
                    $class = 2;
                }
            } else {
                $msg = $validador[MSG];
                $class = 3;
            }
        } else {
            $msg = 'O Campo CPF é obrigatório';
            $class = 3;
        }
        $this->msg = $msg;
        $this->class = $class;
        $this->visivel = $visivel;
    }

    public function Acessar()
    {
        $acesso = UrlAmigavel::PegaParametro('acesso');
        $class = 0;
        $msg = "";
        $visivel = true;

        switch ($acesso) {
            case 'B':
                $msg = "Por Favor, Preencha o Usuário e senha!";
                $class = 2;
                break;
            case 'R':
                $msg = "Acesso Restrito, Você não tem permição para acessar!";
                $class = 4;
                break;
            case 'A':
                $msg = "CPF ou senha Inválido!";
                $class = 3;
                break;
            case 'I':
                $msg = "Usuário Inativo!";
                $class = 3;
                break;
            case 'D':
                $msg = "Usuário deslogado com sucesso!";
                $class = 1;
                break;
            case 'E':
                $msg = "Sua Sessão foi Expirada!";
                $class = 2;
                break;
            case 'C':
                $msg = Mensagens::USUARIO_CADASTRADO_SUCESSO;
                $class = 1;
                break;
            case 'U':
                $msg = Mensagens::USUARIO_JA_CADASTRADO;
                $class = 2;
                break;
            default:
                $visivel = false;
                break;

        }
        $this->class = " " . $class;
        $this->visivel = $visivel;
        $this->msg = $msg;
    }

    public function Logar()
    {
        // CLASSE DE LOGAR
        $cpf = Valida::RetiraMascara(Valida::LimpaVariavel($_POST[NU_CPF]));
        $senha = Valida::LimpaVariavel($_POST[DS_SENHA]);
        if (($cpf != "") && ($senha != "")):

            /** @var UsuarioService $usuariaService */
            $usuariaService = $this->getService(USUARIO_SERVICE);
            $usuarios = $usuariaService->PesquisaTodos();

            $user = "";
            // Codifica a senha
            $senha = base64_encode(base64_encode($senha));
            /** @var UsuarioEntidade $usuario */
            foreach ($usuarios as $usuario):
                if (($usuario->getCoPessoa()->getNuCpf() == $cpf)
                    && (strtoupper($usuario->getDsCode()) == strtoupper($senha))
                ) {
                    if ($usuario->getStStatus() == "I"):
                        Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/I"));
                        exit();
                    endif;
                    /** @var UsuarioEntidade $user */
                    $user = $usuario;
                    break;
                }
            endforeach;
            if ($user != ""):
                /** @var AcessoService $acessoService */
                $acessoService = $this->getService(ACESSO_SERVICE);
                $acessoService->finalizaAcessos();
                $acessoService->salvarAcesso($user->getCoUsuario());

                $perfis = array();
                $no_perfis = array();
                /** @var UsuarioPerfilEntidade $perfil */
                foreach ($user->getCoUsuarioPerfil() as $perfil) {
                    $perfis[] = $perfil->getCoPerfil()->getCoPerfil();
                    $no_perfis[] = $perfil->getCoPerfil()->getNoPerfil();
                }
                $usuarioAcesso[CO_USUARIO] = $user->getCoUsuario();
                $usuarioAcesso[DS_CAMINHO] = $user->getCoImagem()->getDsCaminho();
                $usuarioAcesso[NU_CPF] = $user->getCoPessoa()->getNuCpf();
                $usuarioAcesso[NO_PESSOA] = $user->getCoPessoa()->getNoPessoa();
                $usuarioAcesso[ST_SEXO] = $user->getCoPessoa()->getStSexo();
                $usuarioAcesso[DT_FIM_ACESSO] = $acessoService->geraDataFimAcesso();
                $usuarioAcesso[CAMPO_PERFIL] = implode(',', $perfis);
                $usuarioAcesso['no_perfis'] = implode(', ', $no_perfis);

                $session = new Session();
                $session->setUser($usuarioAcesso);
                Redireciona(ADMIN . PRIMEIRO_ACESSO);
            else:
                Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/A"));
            endif;
        else:
            Redireciona(ADMIN . LOGIN . Valida::GeraParametro("acesso/B"));
        endif;
    }

    //*************************************************************//
    //************ EXEMPLOS DE ACTION ****************************//
    //*************************************************************//

//    private function trafficStart() {
//        $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
//
//        $url = "http://ip-api.com/json/{$ip}";
//        $timeout = 3;
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
//        $rq = curl_exec($ch);
//        curl_close($ch);
//        $geo = array();
//        if ($rq !== false) {
//            $geo = json_decode($rq);
//        }
//        $this->Traffic['trafego_data'] = date('Y-m-d');
//        $this->Traffic['trafego_data_hora'] = date('Y-m-d H:i:s');
//        $this->Traffic['trafego_IP'] = $this->Session['online_ip'];
//        $this->Traffic['trafego_pais'] = (isset($geo->country)) ? $geo->country : 'Desconhecido';
//        $this->Traffic['trafego_pais_code'] = (isset($geo->countryCode)) ? $geo->countryCode : 'Desconhecida';
//        $this->Traffic['trafego_estado'] = (isset($geo->regionName)) ? $geo->regionName : 'Desconhecida';
//        $this->Traffic['trafego_uf'] = (isset($geo->region)) ? $geo->region : 'Desconhecida';
//        $this->Traffic['trafego_cidade'] = (isset($geo->city)) ? $geo->city : 'Desconhecida';
//        $this->Traffic['trafego_navegador'] = $this->getBrowser();
//        $this->Traffic['trafego_plataforma'] = $this->getPlatform();
//        $this->Traffic['trafego_device'] = $this->getDevice();
//        $this->Traffic['trafego_reference'] = $this->getreferer();
//        $this->Traffic['trafego_pagina'] = $this->Session['online_url'];
//        $this->Traffic['trafego_useragent'] = $this->Session['online_agent'];
//
//        $Create = new Create();
//        $Create->ExeCreate(DB_VIEWS_TRAFEGO, $this->Traffic);
//    }



    // EXEMPLO DE ENVIO DE EMAIL
    public function VerGraficos()
    {
//        $grafico = new Grafico(Grafico::PORCENTAGEM, "Teste Porcentagem", "div_porcentagem");
//        $grafico->SetDados(array("Teórica" => 80, "Prática e Teórica" => 12));
//        $grafico->GeraGrafico();
//
//        $grafico = new Grafico(Grafico::MAPA, "Teste Mapa", "div_mapa");
//        $grafico->SetDados(array(
//                "['Cidade','Acessos','Visitas']",
//                "['Natal',2761477,1285.31]",
//                "['Brasília',1324110,181.76]",
//                "['São Paulo',959574,117.27]",
//                "['Rio de Janeiro',67370,213.44]",
//                "['Belo Horizonte',52192,43.43]",
//                "['Maceio',38262,11]"
//            )
//        );
//        $grafico->GeraGrafico();
//
//        $grafico = new Grafico(Grafico::COLUNA, "Teste coluna", "div_coluna");
//        $grafico->SetDados(array(
//            "['Ano','Gordos','Obesos','Magros']",
//            "['Jan',1080,1780,180]",
//            "['Fev',1170,670,180]",
//            "['Mar',660,960,180]",
//            "['Abr',1030,130,540]"
//        ));
//        $grafico->GeraGrafico();
//
//        $grafico = new Grafico(Grafico::LINHA, "Teste Linha", "div_linha");
//        $grafico->SetDados(array(
//            "['Ano','Gordos','Obesos','Magros']",
//            "['2004',1080,1780,180]",
//            "['2005',1170,670,10]",
//            "['2006',660,960,10]",
//            "['2007',1030,130,540]"
//        ));
//        $grafico->GeraGrafico();
//
//        $grafico = new Grafico(Grafico::PIZZA, "Total do programa (Teórica)", "div_pizza");
//        $grafico->SetDados(array(
//            "['Categorias','Procedimentos/Mês']",
//            "['Meta Atingida',800]",
//            "['Meta Restante',356]",
//        ));
//        $grafico->GeraGrafico();
//
//        $grafico = new Grafico(Grafico::COLUNA, "1º Semestre", "div_coluna");
//        $grafico->SetDados(array(
//            "['Horas','Teórica','Teórico-Prática','Prática']",
//            "['Horas',256, 128 , 96]"
//        ));
//        $grafico->SetDados(array(
//            "['Horas','Horas',{ role: 'annotation' }, { role: 'style' }]",
//            "['Teórica',256, 256, 'blue']",
//            "['Teórico-Prática',128, 128, 'red']",
//            "['Prática',96, 96, 'green']",
//        ));
//        $grafico->GeraGrafico();

    }

    // EXEMPLO DE ENVIO DE EMAIL
    public function EmailCliente()
    {
        /** @var Email $email */
        $email = new Email();

        // Índice = Nome, e Valor = Email.
        $emails = array(
            "Leo Bessa Hot" => "leodjx@hotmail.com",
            "Lili Gmail" => "lililasp@gmail.com",
            "Lele Hot" => "lele.403@hotmail.com",
            "Leo Bessa Gmail" => "leonardomcbessa@gmail.com"
        );
        $Mensagem = "<h2>Olá vc ganhou um Bônus de 5 Milhões.... que piada</h2>";

        $email->setEmailDestinatario($emails)
            ->setTitulo("Email de  Teste Pra Todos")
            ->setMensagem($Mensagem);

        // Variável para validação de Emails Enviados com Sucesso.
        $this->Email = $email->Enviar();
    }


    // AÇÃO DA TELA DE PESQUISA AVANÇADA
    public function ListarMembrosPesquisaAvancada()
    {

        $id = "pesquisaMembros";

        $formulario = new Form($id, "admin/Membros/ListarMembros", "Pesquisa", 12);


        $label_options = array("" => "Todos", "S" => "Ativo", "N" => "Inativo");
        $formulario
            ->setLabel("Status do Membro")
            ->setId("st_status")
            ->setType("select")
            ->setOptions($label_options)
            ->CriaInpunt();

        $formulario
            ->setId("no_membro")
            ->setIcon("clip-user-6")
            ->setLabel("Nome do Membro")
            ->setInfo("Pode ser Parte do nome")
            ->CriaInpunt();

        echo $formulario->finalizaFormPesquisaAvancada();

    }

}
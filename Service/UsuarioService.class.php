<?php

/**
 * UsuarioService.class [ SEVICE ]
 * @copyright (c) 2017, Leo Bessa
 */
class  UsuarioService extends AbstractService
{
    private $ObjetoModel;
    private $Email;

    public function __construct()
    {
        parent::__construct(UsuarioEntidade::ENTIDADE);
        $this->ObjetoModel = New UsuarioModel();
    }

    public static function getNoPerfilUsuarioLogado()
    {
        /** @var Session $us */
        $us = $_SESSION[SESSION_USER];
        $user = $us->getUser();
        return (!empty($user[md5('no_perfis')])) ? $user[md5('no_perfis')] : null;
    }

    public static function getCoUsuarioLogado()
    {
        /** @var Session $us */
        $us = $_SESSION[SESSION_USER];
        $user = $us->getUser();
        return (!empty($user[md5(CO_USUARIO)])) ? $user[md5(CO_USUARIO)] : null;
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

    public static function PesquisaUsuariosCombo($Condicoes)
    {
        /** @var UsuarioService $usuarioService */
        $usuarioService = new UsuarioService();
        $comboUsuarios = [];
        $usuarios = $usuarioService->PesquisaAvancada($Condicoes);
        /** @var UsuarioEntidade $usuario */
        foreach ($usuarios as $usuario) {
            if ($usuario->getStStatus() == StatusUsuarioEnum::ATIVO) {
                $comboUsuarios[$usuario->getCoUsuario()]
                    = Valida::Resumi(strtoupper($usuario->getCoPessoa()->getNoPessoa()), 25);
            }
        }
        return $comboUsuarios;
    }

    public function salvaUsuario($dados, $foto, $resgistrar = false)
    {
        $usuarioValidador = new UsuarioValidador();
        /** @var PessoaValidador $validador */
        $validador = $usuarioValidador->validarUsuario($dados);
        if ($validador[SUCESSO]) {
            /** @var EnderecoService $enderecoService */
            $enderecoService = $this->getService(ENDERECO_SERVICE);
            /** @var ContatoService $contatoService */
            $contatoService = $this->getService(CONTATO_SERVICE);
            /** @var UsuarioService $usuarioService */
            $usuarioService = $this->getService(USUARIO_SERVICE);
            /** @var PessoaService $pessoaService */
            $pessoaService = $this->getService(PESSOA_SERVICE);
            /** @var ImagemService $imagemService */
            $imagemService = $this->getService(IMAGEM_SERVICE);
            /** @var UsuarioPerfilService $usuarioPerfilService */
            $usuarioPerfilService = $this->getService(USUARIO_PERFIL_SERVICE);
            /** @var PDO $PDO */
            $PDO = $this->getPDO();
            $retorno = [
                SUCESSO => true,
                MSG => null
            ];

            $session = new Session();
            if ($session->CheckSession(SESSION_USER)) {
                /** @var Session $us */
                $us = $_SESSION[SESSION_USER];
                $user = $us->getUser();
                $meusPerfis = $user[md5(CAMPO_PERFIL)];
                $meusPerfis = explode(',', $meusPerfis);
            } else {
                $meusPerfis = array();
            }
            $idCoUsuario = (isset($dados[CO_USUARIO]) ? $dados[CO_USUARIO] : null);

            $endereco = $enderecoService->getDados($dados, EnderecoEntidade::ENTIDADE);
            $contato = $contatoService->getDados($dados, ContatoEntidade::ENTIDADE);
            $pessoa = $pessoaService->getDados($dados, PessoaEntidade::ENTIDADE);
            $pessoa[NO_PESSOA] = strtoupper(trim($dados[NO_PESSOA]));
            $pessoa[DT_NASCIMENTO] = Valida::DataDBDate($dados[DT_NASCIMENTO]);
            $pessoa[ST_SEXO] = $dados[ST_SEXO][0];

            $erro = false;
            $Campo = array();
            /** @var UsuarioEntidade $usuario */
            $usuarios = $usuarioService->PesquisaTodos();

            /** @var UsuarioEntidade $usuario */
            foreach ($usuarios as $usuario) {
                if ($usuario->getCoUsuario() != $idCoUsuario) {
                    if ($usuario->getCoPessoa()->getNoPessoa() == strtoupper($pessoa[NO_PESSOA])) {
                        $Campo[] = "Nome do Usuário";
                        $erro = true;
                    }
                    if ($usuario->getCoPessoa()->getCoContato()->getDsEmail() == $contato[DS_EMAIL]) {
                        $Campo[] = "E-mail";
                        $erro = true;
                    }
                    if ($usuario->getCoPessoa()->getNuCpf() == $pessoa[NU_CPF]) {
                        $Campo[] = "CPF";
                        $erro = true;
                    }
                }
                if ($erro) {
                    break;
                }
            }

            if ($erro):
                $session->setSession(MENSAGEM, "Já exite usuário cadastro com o mesmo "
                    . implode(", ", $Campo) . ", Favor Verificar.");
            else:
                $imagem[DS_CAMINHO] = "";
                if ($foto[DS_CAMINHO]["tmp_name"]):
                    $foto = $_FILES[DS_CAMINHO];
                    $nome = Valida::ValNome($dados[NO_PESSOA]);
                    $up = new Upload();
                    $up->UploadImagens($foto, $nome, "usuarios");
                    $imagem[DS_CAMINHO] = $up->getNameImage();
                endif;

                $usu[DS_CODE] = base64_encode(base64_encode($dados[DS_SENHA]));
                $usu[DS_SENHA] = trim($dados[DS_SENHA]);
                if (!empty($dados[ST_STATUS])):
                    $usu[ST_STATUS] = StatusUsuarioEnum::ATIVO;
                else:
                    if (in_array(1, $meusPerfis) || in_array(2, $meusPerfis)):
                        $usu[ST_STATUS] = StatusUsuarioEnum::INATIVO;
                    endif;
                endif;

                $PDO->beginTransaction();
                if ($idCoUsuario):
                    /** @var UsuarioEntidade $usuario */
                    $usuario = $usuarioService->PesquisaUmRegistro($idCoUsuario);

                    if ($usuario->getCoImagem()->getDsCaminho()):
                        if (is_file(Upload::$BaseDir . "usuarios/" . $usuario->getCoImagem()->getDsCaminho())):
                            unlink(Upload::$BaseDir . "usuarios/" . $usuario->getCoImagem()->getDsCaminho());
                        endif;
                    endif;

                    if ($imagem[DS_CAMINHO]):
                        $imagemService->Salva($imagem, $usuario->getCoImagem()->getCoImagem());
                    endif;
                    $contatoService->Salva($contato, $usuario->getCoPessoa()->getCoContato()->getCoContato());
                    $enderecoService->Salva($endereco, $usuario->getCoPessoa()->getCoEndereco()->getCoEndereco());
                    $pessoaService->Salva($pessoa, $usuario->getCoPessoa()->getCoPessoa());
                    $retorno = $usuarioService->Salva($usu, $idCoUsuario);
                    $usuarioPerfil[CO_USUARIO] = $idCoUsuario;
                    $ok = $usuarioPerfilService->DeletaQuando($usuarioPerfil);
                    if ($ok):
                        if (!empty($dados['ds_perfil'])) {
                            foreach ($dados['ds_perfil'] as $perfil) {
                                $usuarioPerfil[CO_PERFIL_ASSINANTE] = $perfil;
                                $usuarioPerfilService->Salva($usuarioPerfil);
                            }
                        }

                        $usuarioPerfil[CO_PERFIL] = 3;
                        $retorno = $usuarioPerfilService->Salva($usuarioPerfil);
                    endif;

                    $session->setSession(ATUALIZADO, "OK");
                else:
                    $idCoUsuario = (isset($dados[CO_USUARIO])
                        ? $dados[CO_USUARIO]
                        : null);
                    $idCoEndereco = (isset($dados[CO_ENDERECO])
                        ? $dados[CO_ENDERECO]
                        : null);
                    $idCoContato = (isset($dados[CO_CONTATO])
                        ? $dados[CO_CONTATO]
                        : null);
                    $idCoImagem = (isset($dados[CO_IMAGEM])
                        ? $dados[CO_IMAGEM]
                        : null);
                    $idCoPessoa = (isset($dados[CO_PESSOA])
                        ? $dados[CO_PESSOA]
                        : null);

                    if (!$idCoEndereco) {
                        $pessoa[CO_ENDERECO] = $enderecoService->Salva($endereco);
                    } else {
                        $enderecoService->Salva($endereco, $idCoEndereco);
                    }
                    if (!$idCoContato) {
                        $pessoa[CO_CONTATO] = $contatoService->Salva($contato);
                    } else {
                        $contatoService->Salva($contato, $idCoContato);
                    }
                    if (!$idCoImagem) {
                        $usu[CO_IMAGEM] = $imagemService->Salva($imagem);
                    } else {
                        $usu[CO_IMAGEM] = $idCoImagem;
                        $imagemService->Salva($imagem, $idCoImagem);
                    }
                    if (!$idCoPessoa) {
                        $pessoa[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                        $usu[CO_PESSOA] = $pessoaService->Salva($pessoa);
                    } else {
                        $usu[CO_PESSOA] = $idCoPessoa;
                        $pessoaService->Salva($pessoa, $idCoPessoa);
                    }
                    if (!$idCoUsuario) {
                        $usu[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                        $usuarioPerfil[CO_USUARIO] = $usuarioService->Salva($usu);
                    } else {
                        $usuarioService->Salva($usu, $idCoUsuario);
                    }

                    // REGISTRAR ///
                    if (!$resgistrar):
                        if (!empty($dados['ds_perfil'])) {
                            foreach ($dados['ds_perfil'] as $perfil) {
                                $usuarioPerfil[CO_PERFIL_ASSINANTE] = $perfil;
                                $usuarioPerfilService->Salva($usuarioPerfil);
                            }
                        }
                    endif;
                    $usuarioPerfil[CO_PERFIL] = 3;
                    $retorno = $usuarioPerfilService->Salva($usuarioPerfil);
                endif;
                if ($retorno) {
                    $PDO->commit();
                } else {
                    $retorno[MSG] = 'Não foi possível Salvar o Usuário';
                    $PDO->rollBack();
                }

                if (!$resgistrar) {
                    if (in_array(1, $meusPerfis) || in_array(2, $meusPerfis)) {
                        Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/ListarUsuario/');
                    } else {
                        Redireciona(UrlAmigavel::$modulo . '/Index/Index/');
                    }
                } else {
                    Redireciona('admin/Index/Acessar/' . Valida::GeraParametro('acesso/C'));
                }
            endif;
        } else {
            $session = new Session();
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }

        return $retorno;
    }

    public function TrocaSenha($dados)
    {
        /** @var PessoaValidador $validador */
        $retorno = [
            SUCESSO => true,
            MSG => null
        ];
        $session = new Session();
        $usuarioValidador = new UsuarioValidador();
        $validador = $usuarioValidador->validarTrocaSenha($dados);
        if ($validador[SUCESSO]) {

            $idCoUsuario = (isset($dados[CO_USUARIO]) ? $dados[CO_USUARIO] : null);
            $usuario[DS_CODE] = base64_encode(base64_encode(trim($dados[DS_SENHA])));
            $usuario[DS_SENHA] = trim($dados[DS_SENHA]);
            $usuario[ST_TROCA_SENHA] = SimNaoEnum::SIM;

            $session->setSession(MENSAGEM, ATUALIZADO);
            $session->setSession(ST_TROCA_SENHA, "OK");
            $this->Salva($usuario, $idCoUsuario);
        } else {
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }

        return $retorno;
    }

    /**
     * @param $dados
     * @return int
     */
    public function PesquisaUsuarioLogar($dados)
    {
        return $this->ObjetoModel->PesquisaUsuarioLogar($dados);
    }

    /**
     * Salva o Usuário para logar inicialmente no sistema
     * @param $coPessoa
     * @param $dadosEmail
     * @param null $coAssinante
     * @return bool|INT CoUsuario
     */
    public function salvaUsuarioInicial($coPessoa, $dadosEmail, $coAssinante = null)
    {
        $usuario[CO_ASSINANTE] = ($coAssinante) ? $coAssinante : AssinanteService::getCoAssinanteLogado();
        $usuario[CO_PESSOA] = $coPessoa;
        $usuario[DS_SENHA] = trim(Valida::GeraCodigo());
        $usuario[DS_CODE] = base64_encode(base64_encode($usuario[DS_SENHA]));
        $usuario[ST_STATUS] = StatusUsuarioEnum::INATIVO;
        $usuario[DT_CADASTRO] = Valida::DataHoraAtualBanco();

        $coUsuario = $this->Salva($usuario);
        if ($coUsuario) {
            /** @var Email $email */
            $email = new Email();

            // Índice = Nome, e Valor = Email.
            $emails = array(
                $dadosEmail[NO_PESSOA] => $dadosEmail[DS_EMAIL],
            );
            $Mensagem = "<h3>Olá " . $dadosEmail[NO_PESSOA] . ", Seu cadastro no " . DESC . " foi realizado com sucesso.</h3>";
            $Mensagem .= "<p>Sua senha é: <b>" . $usuario[DS_SENHA] . ".</b></p>";
            $Mensagem .= "<p>Acesso o link para a <a href='" . HOME . "admin/Index/AtivacaoUsuario/" .
                Valida::GeraParametro(CO_USUARIO . "/" . $coUsuario) . "'>ATIVAÇÃO DO CADASTRO</a></p><br>";

            $email->setEmailDestinatario($emails)
                ->setTitulo(DESC . " - Ativação do seu cadastro")
                ->setMensagem($Mensagem);

            // Variável para validação de Emails Enviados com Sucesso.
            $this->Email = $email->Enviar();
        }

        return $coUsuario;
    }
}
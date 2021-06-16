<?php

/**
 * AssinanteService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  AssinanteService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(AssinanteEntidade::ENTIDADE);
        $this->ObjetoModel = new AssinanteModel();
    }

    public function salvaAssinante($dados)
    {
        /** @var ContatoService $contatoService */
        $contatoService = $this->getService(CONTATO_SERVICE);
        /** @var PessoaService $pessoaService */
        $pessoaService = $this->getService(PESSOA_SERVICE);
        /** @var EmpresaService $empresaService */
        $empresaService = $this->getService(EMPRESA_SERVICE);
        /** @var PlanoAssinanteAssinaturaService $PlanoAssinanteAssinaturaService */
        $PlanoAssinanteAssinaturaService = $this->getService(PLANO_ASSINANTE_ASSINATURA_SERVICE);
        /** @var PlanoService $PlanoService */
        $PlanoService = $this->getService(PLANO_SERVICE);
        /** @var UsuarioService $usuarioService */
        $usuarioService = $this->getService(USUARIO_SERVICE);
        /** @var UsuarioPerfilService $usuarioPerfilService */
        $usuarioPerfilService = $this->getService(USUARIO_PERFIL_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $session = new Session();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $assinanteValidador = new AssinanteValidador();
        /** @var AssinanteValidador $validador */
        $validador = $assinanteValidador->validarAssinante($dados);
        if ($validador[SUCESSO]) {
            $contato[DS_EMAIL] = trim($dados[DS_EMAIL]);
            $contato[NU_TEL1] = Valida::RetiraMascara($dados[NU_TEL1]);
            $pessoa[NO_PESSOA] = trim($dados[NO_PESSOA]);
            $empresa[NO_FANTASIA] = trim($dados[NO_FANTASIA]);
            $assinante[TP_ASSINANTE] = AssinanteEnum::MATRIZ;

            $PDO->beginTransaction();

            if (!empty($_POST[CO_ASSINANTE])) {
                /** @var AssinanteService $assinanteService */
                $assinanteService = $this->getService(ASSINANTE_SERVICE);
                /** @var AssinanteEntidade $assinanteEdic */
                $assinanteEdic = $assinanteService->PesquisaUmRegistro($_POST[CO_ASSINANTE]);
                $contatoService->Salva($contato, $assinanteEdic->getCoPessoa()->getCoContato()->getCoContato());
                $empresaService->Salva($empresa, $assinanteEdic->getCoEmpresa()->getCoEmpresa());
                $pessoaService->Salva($pessoa, $assinanteEdic->getCoPessoa()->getCoPessoa());
                $this->Salva($assinante, $assinanteEdic->getCoAssinante());
                $retorno[SUCESSO] = $assinanteEdic->getCoAssinante();
                $session->setSession(MENSAGEM, ATUALIZADO);
            } else {
                /** @var PlanoEntidade $plano */
                $plano = $PlanoService->PesquisaUmRegistro($dados[CO_PLANO]);

                $pessoa[CO_CONTATO] = $contatoService->Salva($contato);
                $pessoa[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $empresa[DT_CADASTRO] = Valida::DataHoraAtualBanco();

                $assinante[CO_PESSOA] = $pessoaService->Salva($pessoa);
                $assinante[CO_EMPRESA] = $empresaService->Salva($empresa);

                $assinante[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $assinante[DT_EXPIRACAO] = Valida::DataDBDate(Valida::CalculaData(date('d/m/Y'),
                    $plano->getNuMesAtivo(), "+", 'm'));

                $dadosEmail[NO_PESSOA] = $pessoa[NO_PESSOA];
                $dadosEmail[DS_EMAIL] = $contato[DS_EMAIL];
                $dadosEmail[NU_TEL1] = $contato[NU_TEL1];

                $coAssinante = $this->Salva($assinante);
                $coUsuario = $usuarioService->salvaUsuarioInicial($assinante[CO_PESSOA], $dadosEmail, $coAssinante);

                $retorno = $PlanoAssinanteAssinaturaService->salvaPagamentoAssinanteSite($dados, $coAssinante, $plano);

                if ($retorno[SUCESSO]) {
                    $usuarioPerfil[CO_PERFIL] = 2;
                    $usuarioPerfil[CO_USUARIO] = $coUsuario;
                    $retorno[SUCESSO] = $usuarioPerfilService->Salva($usuarioPerfil);
                } else {
                    Notificacoes::geraMensagem(
                        'Não foi possível realizar a ação',
                        TiposMensagemEnum::ERRO
                    );
                    $retorno[SUCESSO] = false;
                    $PDO->rollBack();
                }

            }
            if ($retorno[SUCESSO]) {
                $retorno[SUCESSO] = true;
                $PDO->commit();
            } else {
                Notificacoes::geraMensagem(
                    'Não foi possível realizar a ação',
                    TiposMensagemEnum::ERRO
                );
                $retorno[SUCESSO] = false;
                $PDO->rollBack();
            }
        } else {
            Notificacoes::geraMensagem(
                $validador[MSG],
                TiposMensagemEnum::ALERTA
            );
            $retorno = $validador;
        }

        return $retorno;
    }

    /**
     * @param $dados
     * @param $arquivos
     * @return array|AssinanteValidador
     */
    public function salvaDadosComplementaresAssinante($dados, $arquivos)
    {
        /** @var EnderecoService $enderecoService */
        $enderecoService = $this->getService(ENDERECO_SERVICE);
        /** @var ContatoService $contatoService */
        $contatoService = $this->getService(CONTATO_SERVICE);
        /** @var PessoaService $pessoaService */
        $pessoaService = $this->getService(PESSOA_SERVICE);
        /** @var EmpresaService $empresaService */
        $empresaService = $this->getService(EMPRESA_SERVICE);
        /** @var ImagemAssinanteService $imagemAssinanteService */
        $imagemAssinanteService = $this->getService(IMAGEM_ASSINANTE_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $session = new Session();

        $PDO->beginTransaction();

        $assinanteValidador = new AssinanteValidador();
        /** @var PessoaValidador $validador */
        $validador = $assinanteValidador->validarDadosComplementaresAssinante($dados, $arquivos);
        if ($validador[SUCESSO]) {
            $retorno = $pessoaService->salvaPessoaAssinante($dados);
            if ($retorno[SUCESSO]) {
                $retorno = $empresaService->salvaEmpressaAssinante($dados);
                if ($retorno[SUCESSO]) {
                    $retorno = $enderecoService->salvaEnderecoAssinante($dados);
                    if ($retorno[SUCESSO]) {
                        $retorno = $contatoService->salvaContatoAssinante($dados);
                        if ($retorno[SUCESSO]) {
                            $retorno = $imagemAssinanteService->salvaImagemAssinante(
                                $arquivos, $dados[NO_FANTASIA], $dados['imagem_logo']
                            );
                        }
                    }
                }
            }
        } else {
            $retorno = $validador;
        }
        if ($retorno[SUCESSO]) {
            /** @var AssinanteService $assinanteService */
            $assinanteService = $this->getService(ASSINANTE_SERVICE);
            /** @var AssinanteEntidade $assinante */
            $assinante = $assinanteService->getAssinanteLogado();
            $assinanteService->Salva([ST_DADOS_COMPLEMENTARES => SimNaoEnum::SIM], $assinante->getCoAssinante());

            /** @var Session $us */
            $us = $_SESSION[SESSION_USER];
            $user = $us->getUser();

            /** @var UsuarioService $usuariaService */
            $usuariaService = $this->getService(USUARIO_SERVICE);

            /** @var UsuarioEntidade $user */
            $user = $usuariaService->PesquisaUmRegistro($user[md5(CO_USUARIO)]);
            $index = new Index();
            $index->geraDadosSessao($user, $user->getCoUsuario());

            $retorno[SUCESSO] = true;
            $session->setSession(MENSAGEM, ATUALIZADO);
            $PDO->commit();
        } else {
            $session->setSession(MENSAGEM, $retorno[MSG]);
            $retorno[SUCESSO] = false;
            $PDO->rollBack();
        }

        return $retorno;
    }

    public static function montaComboMatriz($coAssinante)
    {
        $dados = [
            '' => Mensagens::MSG_SEM_ITEM_SELECIONADO
        ];
        /** @var AssinanteService $assinanteService */
        $assinanteService = new AssinanteService();
        $assinantes = $assinanteService->PesquisaTodos([
            TP_ASSINANTE => AssinanteEnum::MATRIZ,
            '<>#' . CO_ASSINANTE => $coAssinante,
        ]);
        /** @var AssinanteEntidade $assinante */
        foreach ($assinantes as $assinante) {
            $dados[$assinante->getCoAssinante()] = $assinante->getCoEmpresa()->getNoFantasia();
        }
        return $dados;
    }

    /**
     * @param mixed $coAssinante
     * @return array|mixed
     */
    public function getAssinanteLogado($coAssinante = null)
    {
        if (!$coAssinante) {
            $coAssinante = static::getCoAssinanteLogado();
        }
        if (AssinanteService::assianteNaoEncontrado($coAssinante)) {
            return $this->PesquisaUmRegistro($coAssinante);
        }
        return null;
    }

    /**
     * @return mixed
     */
    public static function getCoAssinanteLogado()
    {
        /** @var Session $us */
        $us = $_SESSION[SESSION_USER];
        $user = $us->getUser();
        return (!empty($user[md5(CO_ASSINANTE)])) ? $user[md5(CO_ASSINANTE)] : null;
    }

    /**
     * @return mixed
     */
    public static function getStatusAssinante($data)
    {
        $difDatas = Valida::CalculaDiferencaDiasData(date('d/m/Y'), $data);
        if ($difDatas > ConfiguracoesEnum::DIAS_EXPIRANDO) {
            $statusSis = StatusSistemaEnum::ATIVO;
        } elseif ($difDatas <= ConfiguracoesEnum::DIAS_EXPIRANDO && $difDatas >= 0) {
            $statusSis = StatusSistemaEnum::EXPIRANDO;
        } elseif ($difDatas < 0 && ($difDatas * -1) <= ConfiguracoesEnum::DIAS_EXPIRADO) {
            $statusSis = StatusSistemaEnum::PENDENTE;
        } else {
            $statusSis = StatusSistemaEnum::EXPIRADO;
        }
        return $statusSis;
    }

    public static function montaComboAssinantes()
    {
        $dados = [
            '' => Mensagens::MSG_SEM_ITEM_SELECIONADO
        ];
        /** @var AssinanteService $assinanteService */
        $assinanteService = new AssinanteService();
        $assinantes = $assinanteService->PesquisaTodos([
            TP_ASSINANTE => AssinanteEnum::MATRIZ
        ]);
        /** @var AssinanteEntidade $assinante */
        foreach ($assinantes as $assinante) {
            $dados[$assinante->getCoAssinante()] = $assinante->getCoEmpresa()->getNoFantasia();
        }
        return $dados;
    }

    public static function assianteNaoEncontrado($coAssinante)
    {
        if (!$coAssinante) {
            Notificacoes::geraMensagem(
                'Assinante Não encontrado',
                TiposMensagemEnum::ALERTA
            );
            Redireciona(UrlAmigavel::$modulo . '/' . CONTROLLER_INICIAL_ADMIN . '/' . ACTION_INICIAL_ADMIN);
        }
        return true;
    }

    public function PesquisaAvancadaAssinatura($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancadaAssinatura($Condicoes);
    }

    public function PesquisaAvancada($Condicoes)
    {
        return $this->ObjetoModel->PesquisaAvancada($Condicoes);
    }

    public static function verificaStatusSistema()
    {
        /** @var Session $us */
        $us = $_SESSION[SESSION_USER];
        $user = $us->getUser();
        $retorno = [
            "status_sistema" => StatusSistemaEnum::ATIVO,
            "dias" => null,
            "dtExpiracao" => null
        ];

        if (isset($user[md5(DT_EXPIRACAO)])) {
            $dtExpiracao = $user[md5(DT_EXPIRACAO)];
            $status_sistema = $user[md5('status_sistema')];
            $difDatas = Valida::CalculaDiferencaDiasData(date('d/m/Y'), $dtExpiracao);
            if ($status_sistema == StatusSistemaEnum::EXPIRANDO ||
                $status_sistema == StatusSistemaEnum::PENDENTE) {
                $retorno = [
                    "status_sistema" => $status_sistema,
                    "dias" => $difDatas,
                    "dtExpiracao" => $dtExpiracao,
                ];
            }
        }

        return $retorno;
    }

    public static function getNoEmpresaCoAssinante($coAssinante)
    {
        /** @var AssinanteModel $AssinanteModel */
        $AssinanteModel = new AssinanteModel();
        return $AssinanteModel->getNoEmpresaCoAssinante($coAssinante);
    }

    public static function verificaStatusAssiante()
    {
        /** @var Session $us */
        $us = $_SESSION[SESSION_USER];
        $user = $us->getUser();

        if (isset($user[md5(DT_EXPIRACAO)])) {
            $dtExpiracao = $user[md5(DT_EXPIRACAO)];

            $difDatas = Valida::CalculaDiferencaDiasData(date('d/m/Y'), $dtExpiracao);
            if ($difDatas > ConfiguracoesEnum::DIAS_EXPIRANDO) {
                $statusSis = StatusSistemaEnum::ATIVO;
            } elseif ($difDatas <= ConfiguracoesEnum::DIAS_EXPIRANDO && $difDatas >= 0) {
                $statusSis = StatusSistemaEnum::EXPIRANDO;
            } elseif ($difDatas < 0 && ($difDatas * -1) <= ConfiguracoesEnum::DIAS_EXPIRADO) {
                $statusSis = StatusSistemaEnum::PENDENTE;
            } else {
                $statusSis = StatusSistemaEnum::EXPIRADO;
            }
            return $statusSis;
        }
        return true;
    }

}
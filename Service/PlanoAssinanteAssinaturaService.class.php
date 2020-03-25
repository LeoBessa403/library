<?php

/**
 * PlanoAssinanteAssinaturaService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  PlanoAssinanteAssinaturaService extends AbstractService
{

    private $ObjetoModel;


    public function __construct()
    {
        parent::__construct(PlanoAssinanteAssinaturaEntidade::ENTIDADE);
        $this->ObjetoModel = New PlanoAssinanteAssinaturaModel();
    }

    public function salvaPagamentoAssinante($dados)
    {
        /** @var PlanoService $PlanoService */
        $PlanoService = $this->getService(PLANO_SERVICE);
        /** @var AssinanteService $AssinanteService */
        $AssinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var PlanoAssinanteAssinaturaService $planoAssinanteAssinaturaService */
        $planoAssinanteAssinaturaService = $this->getService(PLANO_ASSINANTE_ASSINATURA_SERVICE);
        /** @var HistoricoPagAssinaturaService $HistPagAssService */
        $HistPagAssService = $this->getService(HISTORICO_PAG_ASSINATURA_SERVICE);
        /** @var PessoaService $pessoaService */
        $pessoaService = $this->getService(PESSOA_SERVICE);
        /** @var ContatoService $contatoService */
        $contatoService = $this->getService(CONTATO_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $session = new Session();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        /** @var PlanoAssinanteAssinaturaValidador $planoAssinanteAssinaturaValidador */
        $planoAssinanteAssinaturaValidador = new PlanoAssinanteAssinaturaValidador();
        $validador = $planoAssinanteAssinaturaValidador->validarPlanoAssinanteAssinatura($dados);
        if ($validador[SUCESSO]) {

            $PDO->beginTransaction();
            /** @var PlanoEntidade $plano */
            $plano = $PlanoService->PesquisaUmRegistro($dados[CO_PLANO][0]);
            /** @var AssinanteEntidade $assinante */
            $assinante = $AssinanteService->PesquisaUmRegistro($dados[CO_ASSINANTE]);


            $pessoa[NU_CPF] = Valida::RetiraMascara($dados[NU_CPF]);
            $pessoaService->Salva($pessoa, $assinante->getCoPessoa()->getCoPessoa());
            $contato[NU_TEL1] = Valida::RetiraMascara($dados[NU_TEL1]);
            $contatoService->Salva($contato, $assinante->getCoPessoa()->getCoContato()->getCoContato());


            if (!empty($dados[CO_PLANO_ASSINANTE_ASSINATURA])) {
                $retorno[SUCESSO] = $dados[CO_PLANO_ASSINANTE_ASSINATURA];
                $retorno[MSG] = ATUALIZADO;
            } else {
                $planoAssinanteAssinatura[CO_PLANO_ASSINANTE] = $plano->getCoUltimoPlanoAssinante()->getCoPlanoAssinante();
                $planoAssinanteAssinatura[CO_ASSINANTE] = $dados[CO_ASSINANTE];
                $planoAssinanteAssinatura[NU_PROFISSIONAIS] = PlanoService::getNuProfissionais($plano->getNuMesAtivo());
                $planoAssinanteAssinatura[NU_FILIAIS] = 0;
                $planoAssinanteAssinatura[NU_VALOR_ASSINATURA] = $plano->getCoUltimoPlanoAssinante()->getNuValor();
                $planoAssinanteAssinatura[TP_PAGAMENTO] = $dados[TP_PAGAMENTO][0];
                $planoAssinanteAssinatura[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $planoAssinanteAssinatura[DT_EXPIRACAO] = Valida::DataDBDate(Valida::CalculaData(
                    Valida::DataShow($assinante->getDtExpiracao()),
                    $plano->getNuMesAtivo(),
                    "+",
                    'm'
                ));
                $planoAssinanteAssinatura[CO_PLANO_ASSINANTE_ASSINATURA_ATIVO] =
                    PlanoAssinanteAssinaturaService::getCoPlanoAssinaturaAtivo(
                        AssinanteService::getCoAssinanteLogado()
                    );
                $retorno[SUCESSO] = $planoAssinanteAssinaturaService->Salva($planoAssinanteAssinatura);
                $retorno[MSG] = CADASTRADO;
            }

            // HISTORICO DO PAGAMENTO INICIADO
            $histPagAss[CO_PLANO_ASSINANTE_ASSINATURA] = $retorno[SUCESSO];
            $histPagAss[DT_CADASTRO] = Valida::DataHoraAtualBanco();
            $histPagAss[DS_ACAO] = 'Inicia o pagamento';
            $histPagAss[DS_USUARIO] = UsuarioService::getNoPessoaCoUsuario(UsuarioService::getCoUsuarioLogado())
                . ' Iniciou o pagamento';
            $histPagAss[ST_PAGAMENTO] = StatusPagamentoEnum::PENDENTE;

            $HistPagAssService->Salva($histPagAss);

            if ($retorno[SUCESSO]) {

                $plano = $PlanoService->PesquisaUmRegistro($dados[CO_PLANO][0]);
                /** @var AssinanteEntidade $assinante */
                $assinante = $AssinanteService->PesquisaUmRegistro($dados[CO_ASSINANTE]);
                $retorno = $this->processaPagamento($plano, $assinante);

                if ($retorno["dados"]->error) {
                    Notificacoes::geraMensagem(
                        'Não foi possível realizar o Pagamento!',
                        TiposMensagemEnum::ALERTA
                    );
                    $retorno[SUCESSO] = false;
                    $PDO->rollBack();
                } else {
                    $retornoPagSeguro = $retorno['dados'];

                    $retPagSeg[ST_PAGAMENTO] = (string)$retornoPagSeguro->status;
                    $retPagSeg[DT_MODIFICADO] = (string)$retornoPagSeguro->lastEventDate;
                    $retPagSeg[NU_VALOR_DESCONTO] = (string)$retornoPagSeguro->feeAmount;
                    $retPagSeg[NU_VALOR_REAL] = (string)$retornoPagSeguro->netAmount;
                    $retPagSeg[DS_LINK_BOLETO] = (string)$retornoPagSeguro->paymentLink;
                    $retPagSeg[DS_CODE_TRANSACAO] = (string)$retornoPagSeguro->code;
                    $retPagSeg[CO_PLANO_ASSINANTE] = $plano->getCoUltimoPlanoAssinante()->getCoPlanoAssinante();

                    $retorno[SUCESSO] = $planoAssinanteAssinaturaService->Salva(
                        $retPagSeg, (int)$retornoPagSeguro->reference);

                    // HISTORICO DO PAGAMENTO RETORNO PAGSEGURO
                    $histPagAss[CO_PLANO_ASSINANTE_ASSINATURA] = (int)$retornoPagSeguro->reference;
                    $histPagAss[DT_CADASTRO] = (string)$retornoPagSeguro->lastEventDate;
                    $histPagAss[DS_ACAO] = 'Mudou para o Status do pagamento de ' .
                        StatusPagamentoEnum::getDescricaoValor((string)$retornoPagSeguro->status);
                    $histPagAss[DS_USUARIO] = 'Retorno da operadora do pagamento';
                    $histPagAss[ST_PAGAMENTO] = (string)$retornoPagSeguro->status;

                    $HistPagAssService->Salva($histPagAss);

                    if ($retorno[SUCESSO]) {
                        $retorno[SUCESSO] = true;
                        Notificacoes::geraMensagem(
                            'Renovação Cadastrada com Sucesso!',
                            TiposMensagemEnum::SUCESSO
                        );
                        $PDO->commit();
                    } else {
                        Notificacoes::geraMensagem(
                            'Error ao salvar o pagamento',
                            TiposMensagemEnum::ALERTA
                        );
                        $retorno[SUCESSO] = false;
                        $PDO->rollBack();
                    }
                }
            } else {
                Notificacoes::geraMensagem(
                    'Não foi possível realizar a ação',
                    TiposMensagemEnum::ALERTA
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

    public function salvaPlanoPadrao($coAssinante)
    {
        /** @var HistoricoPagAssinaturaService $HistoricoPagAssinaturaService */
        $HistoricoPagAssinaturaService = $this->getService(HISTORICO_PAG_ASSINATURA_SERVICE);

        $planoAssinanteAssinatura[CO_PLANO_ASSINANTE] = 1;
        $planoAssinanteAssinatura[CO_ASSINANTE] = $coAssinante;
        $planoAssinanteAssinatura[NU_PROFISSIONAIS] = 3;
        $planoAssinanteAssinatura[NU_FILIAIS] = 0;
        $planoAssinanteAssinatura[ST_STATUS] = StatusAcessoEnum::ATIVO;
        $planoAssinanteAssinatura[ST_PAGAMENTO] = StatusPagamentoEnum::PAGO;
        $planoAssinanteAssinatura[DT_CADASTRO] = Valida::DataHoraAtualBanco();
        $planoAssinanteAssinatura[DT_MODIFICADO] = Valida::DataHoraAtualBanco();
        $planoAssinanteAssinatura[DT_EXPIRACAO] = Valida::DataDBDate(Valida::CalculaData(date('d/m/Y'),
            ConfiguracoesEnum::DIAS_EXPERIMENTAR, "+"));
        $planoAssinanteAssinatura[NU_VALOR_ASSINATURA] = '0.00';

        $histPagAss[CO_PLANO_ASSINANTE_ASSINATURA] = $this->Salva($planoAssinanteAssinatura);
        $histPagAss[DT_CADASTRO] = Valida::DataHoraAtualBanco();
        $histPagAss[DS_ACAO] = 'Plano Grátis';
        $histPagAss[DS_USUARIO] = NO_USUARIO_PADRAO . ' Iniciou o plano de experiência';
        $histPagAss[ST_PAGAMENTO] = StatusPagamentoEnum::PAGO;

        return $HistoricoPagAssinaturaService->Salva($histPagAss);
    }

    public function getReferenciaPagamentoAssinante()
    {
        $url = URL_PAGSEGURO . "sessions?email=" . EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $retorno = curl_exec($curl);
        curl_close($curl);

        $xml = simplexml_load_string($retorno);
        return $xml;
    }

    private function processaPagamento(PlanoEntidade $plano, AssinanteEntidade $assinante)
    {
        $Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $tpPagamento = $Dados[TP_PAGAMENTO][0];
        $DadosArray["email"] = EMAIL_PAGSEGURO;
        $DadosArray["token"] = TOKEN_PAGSEGURO;

        $tel = $assinante->getCoPessoa()->getCoContato()->getNuTel1();
        $ddd = substr($tel, 0, 2);
        $numero = substr($tel, 2);

        if ($tpPagamento == TipoPagamentoEnum::CARTAO_CREDITO) {
            $DadosArray['creditCardToken'] = $Dados['tokenCartao'];
            $DadosArray['installmentQuantity'] = $Dados['qntParcelas'][0];
            $DadosArray['installmentValue'] = (string)Valida::FormataMoedaBanco($Dados['installmentValue']);
            $DadosArray['noInterestInstallmentQuantity'] = 3;//Quantidade de parcelas sem juro
            $DadosArray['creditCardHolderName'] = $Dados['creditCardHolderName'];
            $DadosArray['creditCardHolderCPF'] = Valida::RetiraMascara($Dados['creditCardHolderCPF']);
            $DadosArray['creditCardHolderBirthDate'] = $Dados['creditCardHolderBirthDate'];
            $DadosArray['creditCardHolderAreaCode'] = $ddd;
            $DadosArray['creditCardHolderPhone'] = $numero;
            $DadosArray['billingAddressStreet'] = $Dados[DS_ENDERECO];
            $DadosArray['billingAddressNumber'] = 10;
            $DadosArray['billingAddressComplement'] = $Dados[DS_COMPLEMENTO];
            $DadosArray['billingAddressDistrict'] = $Dados[DS_BAIRRO];
            $DadosArray['billingAddressPostalCode'] = Valida::RetiraMascara($Dados[NU_CEP]);
            $DadosArray['billingAddressCity'] = $Dados[NO_CIDADE];
            $DadosArray['billingAddressState'] = $Dados[SG_UF][0];
            $DadosArray['billingAddressCountry'] = 'BRA';
            $DadosArray['paymentMethod'] = 'creditCard';
        } elseif ($tpPagamento == TipoPagamentoEnum::BOLETO) {
            $DadosArray['paymentMethod'] = 'boleto';
        } elseif ($tpPagamento == TipoPagamentoEnum::DEPOSITO_TRANSFERENCIA) {
            $DadosArray['bankName'] = $Dados['bankName'][0];
            $DadosArray['paymentMethod'] = 'eft';
        }

        $DadosArray['paymentMode'] = 'default';

        $DadosArray['receiverEmail'] = EMAIL_LOJA;
        $DadosArray['currency'] = 'BRL';
        $DadosArray['extraAmount'] = '0.00';

        $DadosArray["itemId1"] = $plano->getCoPlano();
        $DadosArray["itemDescription1"] = $plano->getNoPlano();
        $total_venda = number_format($plano->getCoUltimoPlanoAssinante()->getNuValor(), 2, '.', '');
        $DadosArray["itemAmount1"] = $total_venda;
        $DadosArray["itemQuantity1"] = 1;

        $DadosArray['notificationURL'] = URL_NOTIFICACAO;
        $DadosArray['reference'] = (!empty($Dados[CO_PLANO_ASSINANTE_ASSINATURA])) ? $Dados[CO_PLANO_ASSINANTE_ASSINATURA] :
            $plano->getCoUltimoPlanoAssinante()->getCoUltimoPlanoAssinanteAssinatura()->getCoPlanoAssinanteAssinatura();
        $DadosArray['senderName'] = $assinante->getCoPessoa()->getNoPessoa();
        $DadosArray['senderCPF'] = $assinante->getCoPessoa()->getNuCpf();

        $tel = $assinante->getCoPessoa()->getCoContato()->getNuTel1();
        $ddd = substr($tel, 0, 2);
        $numero = substr($tel, 2);

        $email = $assinante->getCoPessoa()->getCoContato()->getDsEmail();
        if (!PROD) {
            $email = explode('@', $email);
            $email = $email[0] . '@sandbox.pagseguro.com.br';
        }

        $DadosArray['senderAreaCode'] = $ddd;
        $DadosArray['senderPhone'] = $numero;
        $DadosArray['senderEmail'] = $email;
        $DadosArray['senderHash'] = $Dados['hash'];
        $DadosArray['shippingAddressRequired'] = false;

        $buildQuery = http_build_query($DadosArray);
        $url = URL_PAGSEGURO . "transactions";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
        $retorno = curl_exec($curl);
        curl_close($curl);
        $xml = simplexml_load_string($retorno);

        $retorna = ['dados' => $xml, 'DadosArray' => $DadosArray];
        return $retorna;
    }

    public function notificacaoPagSeguro($aplicacao = false)
    {
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        /** @var PlanoAssinanteAssinaturaService $planoAssinanteAssinaturaService */
        $planoAssinanteAssinaturaService = new PlanoAssinanteAssinaturaService();
        /** @var HistoricoPagAssinaturaService $HistPagAssService */
        $HistPagAssService = new HistoricoPagAssinaturaService();
        /** @var AssinanteService $AssinanteService */
        $AssinanteService = $this->getService(ASSINANTE_SERVICE);

        if ($aplicacao) {
            $Url = URL_PAGSEGURO . "transactions/{$_POST['notificationCode']}?email=" . EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO;
        } else {
            $Url = URL_PAGSEGURO . "transactions/notifications/{$_POST['notificationCode']}?email=" . EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO;
        }

        $Curl = curl_init($Url);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        $Retorno = curl_exec($Curl);
        curl_close($Curl);

        $Xml = simplexml_load_string($Retorno);
        $coPlanoAssinanteAssinatura = (string)$Xml->reference;
        $dados[ST_PAGAMENTO] = (string)$Xml->status;
        $dados[DT_MODIFICADO] = (string)$Xml->lastEventDate;
        if ($dados[ST_PAGAMENTO] == StatusPagamentoEnum::PAGO)
            $dados[DT_CONFIRMA_PAGAMENTO] = (string)$Xml->lastEventDate;

        /** @var PlanoAssinanteAssinaturaEntidade $plan */
        $plan = $planoAssinanteAssinaturaService->PesquisaUmRegistro($coPlanoAssinanteAssinatura);

        $PDO->beginTransaction();
        if ((string)$Xml->status == StatusPagamentoEnum::PAGO ||
            (string)$Xml->status == StatusPagamentoEnum::DISPONIVEL ||
            (string)$Xml->status == StatusPagamentoEnum::EM_DISPUTA) {
            $dados[ST_STATUS] = StatusAcessoEnum::ATIVO;

            // DESATIVA O PLANO ANTERIOR
            $planAss[ST_STATUS] = StatusAcessoEnum::INATIVO;

            $planoAssinanteAssinaturaService->Salva($planAss, $plan->getCoPlanoAssinanteAssinaturaAtivo());

            // ATUALIZA A DATA DE EXPIRAÇÃO DO ASSINANTE
            $ass[DT_EXPIRACAO] = $plan->getDtExpiracao();
            $AssinanteService->Salva($ass, $plan->getCoAssinante()->getCoAssinante());
        } elseif ((string)$Xml->status == StatusPagamentoEnum::DEVOLVIDA ||
            (string)$Xml->status == StatusPagamentoEnum::CANCELADA) {
            $dados[ST_STATUS] = StatusAcessoEnum::INATIVO;

            // DESATIVA A ASSINATURA CANCELADO OU ESTORNADA
            $planoAssinanteAssinaturaService->Salva([
                ST_STATUS => StatusAcessoEnum::INATIVO
            ], $coPlanoAssinanteAssinatura);

            // ATIVA A ASSINATURA ANTERIOR
            $planoAssinanteAssinaturaService->Salva([
                ST_STATUS => StatusAcessoEnum::ATIVO
            ], $plan->getCoPlanoAssinanteAssinaturaAtivo());

            //  ATUALIZA A DATA DE EXPIRAÇÃO DO ASSINANTE
            /** @var PlanoAssinanteAssinaturaEntidade $planAnterior */
            $planAnterior = $planoAssinanteAssinaturaService->PesquisaUmRegistro(
                $plan->getCoPlanoAssinanteAssinaturaAtivo()
            );

            // ATUALIZA A DATA DE EXPIRAÇÃO DO ASSINANTE
            $ass[DT_EXPIRACAO] = $planAnterior->getDtExpiracao();
            $retorno[SUCESSO] = $AssinanteService->Salva($ass, $plan->getCoAssinante()->getCoAssinante());
        }

        if ($plan->getStPagamento() != (string)$Xml->status) {
            // HISTORICO DO PAGAMENTO RETORNO PAGSEGURO
            $histPagAss[CO_PLANO_ASSINANTE_ASSINATURA] = $coPlanoAssinanteAssinatura;
            $histPagAss[DT_CADASTRO] = (string)$Xml->lastEventDate;
            $histPagAss[DS_ACAO] = 'Mudou para o Status do pagamento de ' .
                StatusPagamentoEnum::getDescricaoValor((string)$Xml->status);
            $histPagAss[DS_USUARIO] = 'Retorno da operadora do pagamento';
            $histPagAss[ST_PAGAMENTO] = (string)$Xml->status;

            $HistPagAssService->Salva($histPagAss);
        }

        $retorno[SUCESSO] = $planoAssinanteAssinaturaService->Salva($dados, $coPlanoAssinanteAssinatura);

        if ($retorno[SUCESSO]) {
            $retorno[SUCESSO] = true;
            $PDO->commit();
        } else {
            $retorno[SUCESSO] = false;
            $PDO->rollBack();
        }
        return $retorno;
    }

    public function CancelarAssinaturaAssinante($code)
    {
        /** @var PlanoAssinanteAssinaturaService $planoAssinanteAssinaturaService */
        $planoAssinanteAssinaturaService = new PlanoAssinanteAssinaturaService();
        /** @var HistoricoPagAssinaturaService $HistPagAssService */
        $HistPagAssService = new HistoricoPagAssinaturaService();
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $session = new Session();
        $Url = URL_PAGSEGURO . "transactions/cancels?email=" .
            EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO . "&transactionCode={$code}";

        $Curl = curl_init($Url);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($Curl, CURLOPT_POST, true);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        $Retorno = curl_exec($Curl);
        curl_close($Curl);

        $Xml = simplexml_load_string($Retorno);

        if (!(string)$Xml->error->message) {
            $PDO->beginTransaction();

            /** @var PlanoAssinanteAssinaturaEntidade $plan */
            $plan = $planoAssinanteAssinaturaService->PesquisaUmQuando([
                DS_CODE_TRANSACAO => $code
            ]);

            // HISTORICO DO PAGAMENTO RETORNO PAGSEGURO
            $histPagAss[CO_PLANO_ASSINANTE_ASSINATURA] = $plan->getCoPlanoAssinanteAssinatura();
            $histPagAss[DT_CADASTRO] = Valida::DataHoraAtualBanco();
            $histPagAss[DS_ACAO] = 'Mudou para o Status do pagamento de ' .
                StatusPagamentoEnum::getDescricaoValor(StatusPagamentoEnum::CANCELADA);
            $histPagAss[DS_USUARIO] = 'Suporte Efetuou o cancelamento.';
            $histPagAss[ST_PAGAMENTO] = StatusPagamentoEnum::CANCELADA;

            $HistPagAssService->Salva($histPagAss);

            // DESATIVA O PLANO CANCELADO
            $dados[DT_MODIFICADO] = Valida::DataHoraAtualBanco();
            $dados[ST_STATUS] = StatusAcessoEnum::INATIVO;
            $dados[ST_PAGAMENTO] = StatusPagamentoEnum::CANCELADA;
            $retorno[SUCESSO] = $planoAssinanteAssinaturaService->Salva($dados, $plan->getCoPlanoAssinanteAssinatura());

            if ($retorno[SUCESSO]) {
                $retorno[SUCESSO] = true;
                $session->setSession(MENSAGEM, ATUALIZADO);
                $PDO->commit();
            } else {
                $retorno[SUCESSO] = false;
                Notificacoes::geraMensagem(
                    'Error ao Cancela essa Transação.',
                    TiposMensagemEnum::ALERTA
                );
                $PDO->rollBack();
            }

        } else {
            Notificacoes::geraMensagem(
                'Error: Essa Transação não pode ser Cancelada.',
                TiposMensagemEnum::INFORMATIVO
            );
            $retorno[SUCESSO] = false;
        }
        return $retorno;
    }

    public function EstornarAssinaturaAssinante($code)
    {
        /** @var PlanoAssinanteAssinaturaService $planoAssinanteAssinaturaService */
        $planoAssinanteAssinaturaService = new PlanoAssinanteAssinaturaService();
        /** @var HistoricoPagAssinaturaService $HistPagAssService */
        $HistPagAssService = new HistoricoPagAssinaturaService();
        /** @var AssinanteService $AssinanteService */
        $AssinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var PDO $PDO */
        $PDO = $this->getPDO();
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $session = new Session();
        $Url = URL_PAGSEGURO . "transactions/refunds?email=" .
            EMAIL_PAGSEGURO . "&token=" . TOKEN_PAGSEGURO . "&transactionCode={$code}";

        $Curl = curl_init($Url);
        curl_setopt($Curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($Curl, CURLOPT_POST, true);
        curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        $Retorno = curl_exec($Curl);
        curl_close($Curl);

        $Xml = simplexml_load_string($Retorno);
        if (!(string)$Xml->error->message) {
            $PDO->beginTransaction();

            /** @var PlanoAssinanteAssinaturaEntidade $plan */
            $plan = $planoAssinanteAssinaturaService->PesquisaUmQuando([
                DS_CODE_TRANSACAO => $code
            ]);

            // HISTORICO DO PAGAMENTO RETORNO PAGSEGURO
            $histPagAss[CO_PLANO_ASSINANTE_ASSINATURA] = $plan->getCoPlanoAssinanteAssinatura();
            $histPagAss[DT_CADASTRO] = Valida::DataHoraAtualBanco();
            $histPagAss[DS_ACAO] = 'Mudou para o Status do pagamento de ' .
                StatusPagamentoEnum::getDescricaoValor(StatusPagamentoEnum::DEVOLVIDA);
            $histPagAss[DS_USUARIO] = 'Suporte Efetuou o estorno.';
            $histPagAss[ST_PAGAMENTO] = StatusPagamentoEnum::DEVOLVIDA;

            $HistPagAssService->Salva($histPagAss);

            // ATIVA O PLANO ANTERIOR
            $planAssAtivar[ST_STATUS] = StatusAcessoEnum::ATIVO;
            $planoAssinanteAssinaturaService->Salva($planAssAtivar, $plan->getCoPlanoAssinanteAssinaturaAtivo());

            // DESATIVA O PLANO ESTORNADO
            $dados[DT_MODIFICADO] = Valida::DataHoraAtualBanco();
            $dados[ST_STATUS] = StatusAcessoEnum::INATIVO;
            $dados[ST_PAGAMENTO] = StatusPagamentoEnum::DEVOLVIDA;
            $planoAssinanteAssinaturaService->Salva($dados, $plan->getCoPlanoAssinanteAssinatura());


            //  ATUALIZA A DATA DE EXPIRAÇÃO DO ASSINANTE
            /** @var PlanoAssinanteAssinaturaEntidade $planAnterior */
            $planAnterior = $planoAssinanteAssinaturaService->PesquisaUmRegistro(
                $plan->getCoPlanoAssinanteAssinaturaAtivo()
            );

            // ATUALIZA A DATA DE EXPIRAÇÃO DO ASSINANTE
            $ass[DT_EXPIRACAO] = $planAnterior->getDtExpiracao();
            $retorno[SUCESSO] = $AssinanteService->Salva($ass, $plan->getCoAssinante()->getCoAssinante());

            if ($retorno[SUCESSO]) {
                $retorno[SUCESSO] = true;
                $session->setSession(MENSAGEM, ATUALIZADO);
                $PDO->commit();
            } else {
                $retorno[SUCESSO] = false;
                Notificacoes::geraMensagem(
                    'Error ao Estorna essa Transação.',
                    TiposMensagemEnum::ALERTA
                );
                $PDO->rollBack();
            }
        } else {
            Notificacoes::geraMensagem(
                'Error: Essa Transação não pode ser Estornada.',
                TiposMensagemEnum::INFORMATIVO
            );
            $retorno[SUCESSO] = false;
        }
        return $retorno;
    }

    public static function getCoPlanoAssinaturaAtivo($coAssinante)
    {
        /** @var PlanoAssinanteAssinaturaService $planoAssinanteAssinaturaService */
        $planoAssinanteAssinaturaService = new PlanoAssinanteAssinaturaService();
        /** @var PlanoAssinanteAssinaturaEntidade $planoAssinante */
        $planoAssinante = $planoAssinanteAssinaturaService->PesquisaUmQuando([
            CO_ASSINANTE => $coAssinante,
            ST_STATUS => StatusSistemaEnum::ATIVO
        ]);

        return $planoAssinante->getCoPlanoAssinanteAssinatura();
    }

    public function DetalharPagamentoAjax($coPlanoAssAss)
    {
        /** @var PlanoAssinanteAssinaturaService $planoAssinanteAssinaturaService */
        $planoAssinanteAssinaturaService = new PlanoAssinanteAssinaturaService();
        /** @var PlanoAssinanteAssinaturaEntidade $planoAssinante */
        $planoAssinante = $planoAssinanteAssinaturaService->PesquisaUmRegistro($coPlanoAssAss);

        $dados = [];
        $dados[CO_HISTORICO_PAG_ASSINATURA] = [];
        if ($planoAssinante->getCoHistoricoPagAssinatura()) {
            /** @var HistoricoPagAssinaturaEntidade $histAss */
            foreach ($planoAssinante->getCoHistoricoPagAssinatura() as $histAss) {
                $dados[CO_HISTORICO_PAG_ASSINATURA][] = Valida::DataShow($histAss->getDtCadastro(), 'd/m/Y H:i:s') .
                    ' - Status: ' . StatusPagamentoEnum::getDescricaoValor($histAss->getStPagamento()) .
                    ', ' . $histAss->getDsAcao() . ' - ' . $histAss->getDsUsuario();
            }
            $dados[CO_HISTORICO_PAG_ASSINATURA] = array_reverse($dados[CO_HISTORICO_PAG_ASSINATURA]);
        }

        $dtPagamento = ($planoAssinante->getDtConfirmaPagamento()) ?
            Valida::DataShow($planoAssinante->getDtConfirmaPagamento(), 'd/m/Y H:i:s') : '';

        $tpPagamento = ($planoAssinante->getTpPagamento()) ?
            TipoPagamentoEnum::getDescricaoValor($planoAssinante->getTpPagamento()) : '';

        $codePagamento = ($planoAssinante->getDsCodeTransacao() != 'null') ?
            $planoAssinante->getDsCodeTransacao() : '';

        $dados[ST_STATUS] = Valida::StatusLabel($planoAssinante->getStStatus());
        $dados[DS_CODE_TRANSACAO] = $codePagamento;
        $dados[NO_PLANO] = $planoAssinante->getCoPlanoAssinante()->getCoPlano()->getNoPlano();
        $dados[DT_CONFIRMA_PAGAMENTO] = $dtPagamento;
        $dados[ST_PAGAMENTO] = StatusPagamentoEnum::getDescricaoValor($planoAssinante->getStPagamento());
        $dados[TP_PAGAMENTO] = $tpPagamento;
        $dados[NU_VALOR_ASSINATURA] = Valida::FormataMoeda($planoAssinante->getCoPlanoAssinante()->getNuValor(), 'R$');
        if (PerfilService::perfilMaster()) {
            $dados[NU_VALOR_DESCONTO] = Valida::FormataMoeda($planoAssinante->getNuValorDesconto(), 'R$');
            $dados[NU_VALOR_REAL] = Valida::FormataMoeda($planoAssinante->getNuValorReal(), 'R$');
        }
        $dados[NU_PROFISSIONAIS] = $planoAssinante->getNuProfissionais();
        return $dados;
    }
}
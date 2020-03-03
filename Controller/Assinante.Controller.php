<?php

class Assinante extends AbstractController
{
    public $result;
    public $assinante;
    public $form;

    public function ListarAssinante()
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);
        $this->result = $assinanteService->PesquisaTodos([
            TP_ASSINANTE => AssinanteEnum::MATRIZ,
        ]);
    }

    public function CadastroAssinante()
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);
        $id = "cadastroAssinante";

        if (!empty($_POST[$id])):
            $retorno = $assinanteService->salvaAssinante($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/ListarAssinante/');
            }
        endif;

        $coAssinante = UrlAmigavel::PegaParametro(CO_ASSINANTE);
        $res = [];
        if ($coAssinante) {
            /** @var AssinanteEntidade $assinante */
            $assinante = $assinanteService->PesquisaUmRegistro($coAssinante);
            $res[NO_PESSOA] = $assinante->getCoPessoa()->getNoPessoa();
            $res[NO_FANTASIA] = $assinante->getCoEmpresa()->getNoFantasia();
            $res[NU_TEL1] = $assinante->getCoPessoa()->getCoContato()->getNuTel1();
            $res[DS_EMAIL] = $assinante->getCoPessoa()->getCoContato()->getDsEmail();
            $res[CO_ASSINANTE] = $assinante->getCoAssinante();

        }
        $this->form = AssinanteForm::Cadastrar($res);
    }

    public function HistoricoAssinante()
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);

        $coAssinante = UrlAmigavel::PegaParametro(CO_ASSINANTE);
        if ($coAssinante) {
            /** @var AssinanteEntidade $assinante */
            $this->assinante = $assinanteService->PesquisaUmRegistro($coAssinante);
        } else {
            Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/AssinanteNaoEncontrado/');
        }
    }

    public static function getReferenciaPagamentoAssinante($coPlano)
    {
        /** @var PlanoService $planoService */
        $planoService = static::getServiceStatic(PLANO_SERVICE);
        if ($coPlano) {
            /** @var PlanoEntidade $plano */
            $plano = $planoService->PesquisaUmRegistro($coPlano);
        } else {
            return null;
        }
//        /** @var PagSeguro $pag */
//        $pag = new PagSeguro();
//        $dados = [
//            CO_PLANO => $plano->getCoPlano(),
//            NU_VALOR => $plano->getCoUltimoPlanoAssinante()->getNuValor(),
//            DS_DESCRICAO => $plano->getNoPlano()
//        ];
//        return $pag->solicitarPagamento($dados);
    }

    public function MeuPlanoAssinante()
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var PlanoAssinanteAssinaturaService $PlanoAssinanteAssinaturaService */
        $PlanoAssinanteAssinaturaService = $this->getService(PLANO_ASSINANTE_ASSINATURA_SERVICE);
        $id = "cadastroAssinante";

//        if (!empty($_POST[$id])):
//            $retorno = $PlanoAssinanteAssinaturaService->salvaPagamentoAssinante($_POST);
//            if ($retorno[SUCESSO]) {
//                Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/ListarAssinante/');
//            }
//        endif;

        $coAssinante = AssinanteService::getCoAssinanteLogado();
        $res = [];
        if ($coAssinante) {
            /** @var AssinanteEntidade $assinante */
            $assinante = $assinanteService->PesquisaUmRegistro($coAssinante);
            $res[CO_ASSINANTE] = $coAssinante;
            $res[DT_EXPIRACAO] = Valida::DataShow($assinante->getDtExpiracao());
        } else {
            Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/AssinanteNaoEncontrado/');
        }
        $this->form = AssinanteForm::Pagamento($res);
    }

    public function PagamentoAssinante()
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);
        /** @var PlanoAssinanteAssinaturaService $PlanoAssinanteAssinaturaService */
        $PlanoAssinanteAssinaturaService = $this->getService(PLANO_ASSINANTE_ASSINATURA_SERVICE);
        $id = "cadastroAssinante";

        if (!empty($_POST[$id])):
            $retorno = $PlanoAssinanteAssinaturaService->salvaPagamentoAssinante($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/ListarAssinante/');
            }
        endif;

        $coAssinante = UrlAmigavel::PegaParametro(CO_ASSINANTE);
        $res = [];
        if ($coAssinante) {
            /** @var AssinanteEntidade $assinante */
            $assinante = $assinanteService->PesquisaUmRegistro($coAssinante);
            $res[CO_ASSINANTE] = $coAssinante;
            $res[DT_EXPIRACAO] = Valida::DataShow($assinante->getDtExpiracao());
        } else {
            Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller . '/AssinanteNaoEncontrado/');
        }
        $this->form = AssinanteForm::Pagamento($res);
    }

    public function DadosComplementaresAssinante()
    {
        /** @var AssinanteService $assinanteService */
        $assinanteService = $this->getService(ASSINANTE_SERVICE);

        if (!empty($_POST)):
            $retorno = $assinanteService->salvaDadosComplementaresAssinante($_POST, $_FILES);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/' . CONTROLLER_INICIAL_ADMIN . '/' . ACTION_INICIAL_ADMIN);
            }
        endif;

        /** @var EnderecoService $enderecoService */
        $enderecoService = $this->getService(ENDERECO_SERVICE);
        /** @var ContatoService $contatoService */
        $contatoService = $this->getService(CONTATO_SERVICE);
        /** @var EmpresaService $empresaService */
        $empresaService = $this->getService(EMPRESA_SERVICE);
        /** @var AssinanteEntidade $assinante */
        $assinante = $assinanteService->getAssinanteLogado();


        // Aba 1
        $res[NO_PESSOA] = $assinante->getCoPessoa()->getNoPessoa();
        $res[NO_FANTASIA] = $assinante->getCoEmpresa()->getNoFantasia();
        $res[NO_EMPRESA] = $assinante->getCoEmpresa()->getNoEmpresa();
        $res[NU_CNPJ] = $assinante->getCoEmpresa()->getNuCnpj();
        $res[NU_INSC_ESTADUAL] = $assinante->getCoEmpresa()->getNuInscEstadual();
        $res[DS_OBSERVACAO] = $assinante->getCoEmpresa()->getDsObservacao();


        // Aba 2
        /** @var EnderecoEntidade $endereco */
        $endereco = $enderecoService->PesquisaUmRegistro($assinante->getCoEmpresa()->getCoEndereco());
        if (!$endereco) {
            $end[DS_ENDERECO] = '';
            $coEndereco = $enderecoService->Salva($end);
            /** @var EnderecoEntidade $endereco */
            $endereco = $enderecoService->PesquisaUmRegistro($coEndereco);
            $empresa[CO_ENDERECO] = $coEndereco;
            $empresaService->Salva($empresa, $assinante->getCoEmpresa()->getCoEmpresa());
        }
        $res = $enderecoService->getArrayDadosEndereco($endereco, $res);


        // Aba 3
        /** @var ContatoEntidade $contato */
        $contato = $assinante->getCoPessoa()->getCoContato();
        if ($contato) {
            $res = $contatoService->getArrayDadosContato($contato, $res);
        }

        // Aba 4
        $logo = '';
        $imagem_logo = '';

        if (!empty($assinante->getCoImagemAssinante())) {
            $imagem_logo = $assinante->getLogoImagemAssinante()->getCoImagem()->getCoImagem();
            $logo = "Assinante/Assinante-" . AssinanteService::getCoAssinanteLogado() . "/" .
                $assinante->getLogoImagemAssinante()->getCoImagem()->getDsCaminho();
        }
        $res[DS_CAMINHO] = $logo;
        $res['imagem_logo'] = $imagem_logo;

        $this->form = AssinanteForm::DadosComplementares($res);
    }

}
   
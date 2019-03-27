<?php

class Sessao extends AbstractController
{
    public $result;
    public $coModulo;
    public $coProjeto;
    public $noSessao;
    public $dados;

    public function ListarSessao()
    {
        $this->coModulo = UrlAmigavel::PegaParametro(CO_MODULO);
        /** @var SessaoService $sessaoService */
        $sessaoService = $this->getService(SESSAO_SERVICE);
        /** @var ModuloService $moduloService */
        $moduloService = $this->getService(MODULO_SERVICE);

        /** @var ModuloEntidade $modulo */
        $modulo = $moduloService->PesquisaUmRegistro($this->coModulo);

        $this->result = $sessaoService->PesquisaTodos([
            CO_MODULO => $this->coModulo
        ]);
        $this->coProjeto = $modulo->getCoProjeto()->getCoProjeto();
    }

    public function CadastroSessao()
    {
        /** @var SessaoService $sessaoService */
        $sessaoService = $this->getService(SESSAO_SERVICE);

        $id = "cadastroSessao";

        if (!empty($_POST[$id])):
            $retorno = $sessaoService->salvaSessao($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller .
                    '/ListarSessao/' . Valida::GeraParametro(CO_MODULO . "/" . $_POST[CO_MODULO]));
            }
        endif;

        $coSessao = UrlAmigavel::PegaParametro(CO_SESSAO);
        $res = [];
        if ($coSessao) {
            /** @var SessaoEntidade $sessao */
            $sessao = $sessaoService->PesquisaUmRegistro($coSessao);
            $res[CO_SESSAO] = $sessao->getCoSessao();
            $res[NO_SESSAO] = $sessao->getNoSessao();
            $res[CO_MODULO] = $sessao->getCoModulo()->getCoModulo();
            $res[NO_MODULO] = $sessao->getCoModulo()->getNoModulo();
        } else {
            /** @var ModuloService $moduloService */
            $moduloService = $this->getService(MODULO_SERVICE);

            $coModulo = UrlAmigavel::PegaParametro(CO_MODULO);
            /** @var ModuloEntidade $modulo */
            $modulo = $moduloService->PesquisaUmRegistro($coModulo);
            $res[CO_MODULO] = $modulo->getCoModulo();
            $res[NO_MODULO] = $modulo->getNoModulo();
        }
        $this->form = SessaoForm::Cadastrar($res);
    }

    public function EstatisticaSessao()
    {
        $dados['esforco'] = 0;
        $dados['esforcoRestante'] = 0;
        /** @var HistoriaService $historiaService */
        $historiaService = $this->getService(HISTORIA_SERVICE);
        /** @var SessaoService $sessaoService */
        $sessaoService = $this->getService(SESSAO_SERVICE);
        /** @var HistoricoHistoriaService $historicoHistoriaService */
        $historicoHistoriaService = $this->getService(HISTORICO_HISTORIA_SERVICE);
        $coSessao = UrlAmigavel::PegaParametro(CO_SESSAO);
        /** @var SessaoEntidade $sessao */
        $sessao = $sessaoService->PesquisaUmRegistro($coSessao);

        $histHistorias = $historicoHistoriaService->PesquisaAvancada([
            CO_SESSAO => $coSessao
        ]);

        $historiaService->motaGraficoEvolucao($histHistorias);

        $this->dados = $historiaService::$dados;
        $this->coModulo = $sessao->getCoModulo()->getCoModulo();
        $this->noSessao = $sessao->getNoSessao();

    }

}
   
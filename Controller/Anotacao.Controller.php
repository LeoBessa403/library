<?php

class Anotacao extends AbstractController
{
    public $result;
    public $coHistoria;
    public $coSessao;

    public function ListarAnotacao()
    {
        $this->coHistoria = UrlAmigavel::PegaParametro(CO_HISTORIA);
        /** @var AnotacaoService $anotacaoService */
        $anotacaoService = $this->getService(ANOTACAO_SERVICE);
        /** @var HistoriaService $historiaService */
        $historiaService = $this->getService(HISTORIA_SERVICE);

        /** @var HistoriaEntidade $historia */
        $historia = $historiaService->PesquisaUmRegistro($this->coHistoria);
        $this->result = $anotacaoService->PesquisaTodos([
            CO_HISTORIA => $this->coHistoria
        ]);
        $this->coSessao = $historia->getCoSessao()->getCoSessao();
    }

    public function CadastroAnotacao()
    {
        /** @var AnotacaoService $anotacaoService */
        $anotacaoService = $this->getService(ANOTACAO_SERVICE);

        $id = "cadastroAnotacao";

        if (!empty($_POST[$id])):
            $retorno = $anotacaoService->salvaAnotacao($_POST);
            if ($retorno[SUCESSO]) {
                Redireciona(UrlAmigavel::$modulo . '/' . UrlAmigavel::$controller .
                    '/ListarAnotacao/' . Valida::GeraParametro(CO_HISTORIA . "/" . $_POST[CO_HISTORIA]));
            }
        endif;

        $coAnotacao = UrlAmigavel::PegaParametro(CO_ANOTACAO);
        $res = [];
        if ($coAnotacao) {
            /** @var AnotacaoEntidade $anotacao */
            $anotacao = $anotacaoService->PesquisaUmRegistro($coAnotacao);
            $res[CO_ANOTACAO] = $anotacao->getCoAnotacao();
            $res[DS_TITULO] = $anotacao->getDsTitulo();
            $res['ds_titulo_hist'] = $anotacao->getCoHistoria()->getDsTitulo();
            $res[CO_HISTORIA] = $anotacao->getCoHistoria()->getCoHistoria();
            $res[DS_OBSERVACAO] = $anotacao->getDsObservacao();
        } else {
            /** @var HistoriaService $historiaService */
            $historiaService = $this->getService(HISTORIA_SERVICE);

            $coHistoria = UrlAmigavel::PegaParametro(CO_HISTORIA);
            /** @var HistoriaEntidade $historia */
            $historia = $historiaService->PesquisaUmRegistro($coHistoria);
            $res[CO_HISTORIA] = $historia->getCoHistoria();
            $res['ds_titulo_hist'] = $historia->getDsTitulo();
        }
        $this->form = AnotacaoForm::Cadastrar($res);

    }

}
   
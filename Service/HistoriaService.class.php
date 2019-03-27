<?php

/**
 * HistoriaService.class [ SEVICE ]
 * @copyright (c) 2018, Leo Bessa
 */
class  HistoriaService extends AbstractService
{

    private $ObjetoModel;
    static $dados;


    public function __construct()
    {
        parent::__construct(HistoriaEntidade::ENTIDADE);
        $this->ObjetoModel = New HistoriaModel();
    }

    public static function SituacaoHistoria()
    {
        return StatusHistoriaEnum::$descricao;
    }

    public static function comboEsforco()
    {
        $ComboEstados =
            array(
                "" => "Selecione o esforço",
                "1" => "1",
                "3" => "3",
                "5" => "5",
                "8" => "8",
                "13" => "13",
                "20" => "20",
                "30" => "30",
                "40" => "40",
            );
        return $ComboEstados;
    }

    public function salvaHistoria($dados)
    {
        /** @var HistoricoHistoriaService $historicoHistoriaService */
        $historicoHistoriaService = $this->getService(HISTORICO_HISTORIA_SERVICE);
        $retorno = [
            SUCESSO => false,
            MSG => null
        ];
        $historiaValidador = new HistoriaValidador();
        /** @var HistoriaValidador $validador */
        $validador = $historiaValidador->validarHistoria($dados);
        if ($validador[SUCESSO]) {
            $historia[DS_TITULO] = trim($dados[DS_TITULO]);
            $historia[DS_OBSERVACAO] = trim($dados[DS_OBSERVACAO]);
            $historia[CO_SESSAO] = $dados[CO_SESSAO];
            $historia[ST_SITUACAO] = $this->getSituacaoHistoria($dados);
            $historia[DT_ATUALIZADO] = Valida::DataHoraAtualBanco();

            $historicoHistoria[NU_ESFORCO] = $dados[NU_ESFORCO][0];
            $historicoHistoria[NU_ESFORCO_RESTANTE] = $dados[NU_ESFORCO_RESTANTE];
            $historicoHistoria[DT_CADASTRO] = Valida::DataHoraAtualBanco();


            if (!empty($_POST[CO_HISTORIA])):
                $coHistoria = $dados[CO_HISTORIA];
                $retorno[SUCESSO] = $this->Salva($historia, $coHistoria);
            else:
                $historia[DT_CADASTRO] = Valida::DataHoraAtualBanco();
                $coHistoria = $this->Salva($historia);
                $retorno[SUCESSO] = $coHistoria;
            endif;
            $historicoHistoria[CO_HISTORIA] = $coHistoria;
            $historicoHistoriaService->Salva($historicoHistoria);

        } else {
            $session = new Session();
            $session->setSession(MENSAGEM, $validador[MSG]);
            $retorno = $validador;
        }
        return $retorno;
    }

    public function getSituacaoHistoria($dados)
    {
        $sit = StatusHistoriaEnum::INICIADA;
        if ($dados[NU_ESFORCO_RESTANTE] == 0) {
            $sit = StatusHistoriaEnum::CONCLUIDA;
        } elseif ($dados[NU_ESFORCO_RESTANTE] == $dados[NU_ESFORCO][0]) {
            $sit = StatusHistoriaEnum::NAO_INICIADA;
        }
        return $sit;
    }

    public function motaGraficoEvolucao($evolucao, $preProj = null)
    {
        $graficoEvolucao = [];
        $esforcoHistoria = [];
        $esforcoRestanteHistoria = [];
        $priEsf = true;
        $priEsfRes = true;
        $esforco = 0;
        $esforcoRestante = 0;
        foreach ($evolucao as $item) {
            if (empty($esforcoHistoria[$item[CO_HISTORIA]])) {
                $priEsf = true;
                $priEsfRes = true;
            }

            if ($priEsf) {
                $esforco = $esforco + $item[NU_ESFORCO];
                $esforcoHistoria[$item[CO_HISTORIA]] = $item[NU_ESFORCO];
                $priEsf = false;
            } elseif ($esforcoHistoria[$item[CO_HISTORIA]] != $item[NU_ESFORCO]) {
                $esforco = $esforco + $item[NU_ESFORCO] - $esforcoHistoria[$item[CO_HISTORIA]];
                $esforcoHistoria[$item[CO_HISTORIA]] = $item[NU_ESFORCO];
            }
            $graficoEvolucao[Valida::DataShow($item[DT_CADASTRO])][NU_ESFORCO] = $esforco;


            if ($priEsfRes) {
                $esforcoRestante = $esforcoRestante + $item[NU_ESFORCO_RESTANTE];
                $esforcoRestanteHistoria[$item[CO_HISTORIA]] = $item[NU_ESFORCO_RESTANTE];
                $priEsfRes = false;
            } elseif ($esforcoRestanteHistoria[$item[CO_HISTORIA]] != $item[NU_ESFORCO_RESTANTE]) {
                $esforcoRestante = $esforcoRestante + $item[NU_ESFORCO_RESTANTE] - $esforcoRestanteHistoria[$item[CO_HISTORIA]];
                $esforcoRestanteHistoria[$item[CO_HISTORIA]] = $item[NU_ESFORCO_RESTANTE];
            }
            $graficoEvolucao[Valida::DataShow($item[DT_CADASTRO])][NU_ESFORCO_RESTANTE] = $esforcoRestante;

        }
        self::$dados['esforco'] = $esforco;
        self::$dados['esforcoRestante'] = $esforcoRestante;

        if ($preProj) {
            $dataPrevistas = array_keys($graficoEvolucao);
            $diasNecessario = Valida::CalculaDiferencaDiasData(
                $dataPrevistas[0],
                $dataPrevistas[count($dataPrevistas) - 1]
            );
            $esforcoAlcancado = $esforco - $esforcoRestante;
            $mediaDia = $esforcoAlcancado / $diasNecessario;
            $linhas = fopen('versao.txt', "a+");
            $versoes = fgets($linhas);
            $versao = explode('//', $versoes);
            $versao[5] = $mediaDia;
            $versaoAtualizada = implode('//', $versao);
            $backupVersao = fopen('versao.txt', "w");
            fwrite($backupVersao, $versaoAtualizada);
            fclose($backupVersao);
        }

        $graficoEvolucaoEsforco = array("['Data','Esforço','Esforço Restante']");
        foreach ($graficoEvolucao as $data => $esforcos) {
            $graficoEvolucaoEsforco[] = "['" . $data . "'," . $esforcos[NU_ESFORCO] . "," . $esforcos[NU_ESFORCO_RESTANTE] . "]";
        }
        $grafico = new Grafico(Grafico::LINHA, "Controle de Esforços", "div_esforco");
        $grafico->SetDados($graficoEvolucaoEsforco);
        $grafico->GeraGrafico();


        $graficoEvolucaoPercentual = array("['Data','Percentual (%)']");
        foreach ($graficoEvolucao as $data => $esforcos) {
            $perc = number_format((1 - ($esforcos[NU_ESFORCO_RESTANTE] / $esforcos[NU_ESFORCO])) * 100, 2, '.', '');
            $graficoEvolucaoPercentual[] = "['" . $data . "'," . $perc . "]";
        }
        $grafico = new Grafico(Grafico::LINHA, "Evolução do Sistema", "div_percentual_evolucao");
        $grafico->SetDados($graficoEvolucaoPercentual);
        $grafico->GeraGrafico();
    }


}
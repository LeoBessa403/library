<?php

class Visita extends AbstractController
{
    public $visitasPagina;
    public $totalVisitasPagina;

    public function ListarVisita()
    {
        /** @var VisitaService $visitaService */
        $visitaService = $this->getService(VISITA_SERVICE);
        $visitasDispositivo = $visitaService->visitasDispositivo();
        $visitasSO = $visitaService->visitasSO();
        $visitasNavegador = $visitaService->visitasNavegador();
        $visitasCidade = $visitaService->visitasCidade();
        $visitasEstado = $visitaService->visitasEstado();
        $this->visitasPagina = $visitaService->visitasPagina();
        $totalVisitasPagina['total'] = $visitaService->totalVisitas();
        $totalVisitasPagina['totalMesAtual'] = $visitaService->totalVisitasMesAtual();
        $this->totalVisitasPagina = $totalVisitasPagina;

        $color = ['green', 'black'];
        $i = 0;
        $graficoDispositivo[] = "['Nº Dispositivos','Visitas', { role: 'style' }]";
        foreach ($visitasDispositivo as $nDispositivo) {
            $graficoDispositivo[] = "['" . $nDispositivo['ds_dispositivo'] . "'," . $nDispositivo['qt_dispositivo'] .
                ", 'color: " . $color[$i] . "']";
            $i++;
        }
        $graficoSO[] = "['Visitas','Nº S.O.']";
        foreach ($visitasSO as $nDispositivo) {
            $graficoSO[] = "['" . $nDispositivo['ds_sistema_operacional'] . "'," . $nDispositivo['qt_visitas'] . "]";
        }
        $graficoNavegador[] = "['Visitas','Navegador']";
        foreach ($visitasNavegador as $nDispositivo) {
            $graficoNavegador[] = "['" . $nDispositivo['ds_navegador'] . "'," . $nDispositivo['qt_visitas'] . "]";
        }
        $color = ['gray', 'orange', 'red', 'pink', 'gray', 'green', 'yellow', 'red', 'pink'];
        $i = 0;
        $graficoCidade[] = "['Cidade','Visitas', { role: 'style' }]";
        foreach ($visitasCidade as $nDispositivo) {
            $graficoCidade[] = "['" . $nDispositivo['ds_cidade'] . "'," . $nDispositivo['qt_visitas'] .
                ", 'color: " . $color[$i] . "']";
            $i++;
            if($i > 8)
                $i = 0;
        }
        $graficoEstado[] = "['Estado','Visitas']";
        foreach ($visitasEstado as $nDispositivo) {
            $graficoEstado[] = "['" . $nDispositivo['ds_estado'] . "'," . $nDispositivo['qt_visitas'] . "]";
        }

//        // GRAFICO PIZZA
        $grafico = new Grafico(Grafico::PIZZA, "Visitas/S.O.", "div_so");
        $grafico->SetDados($graficoSO);
        $grafico->GeraGrafico();

        $grafico = new Grafico(Grafico::COLUNA, "Visitas/Dispositivos", "div_dispositivo");
        $grafico->SetDados($graficoDispositivo);
        $grafico->GeraGrafico();

        $grafico = new Grafico(Grafico::PIZZA, "Visitas/Navegador", "div_nav");
        $grafico->SetDados($graficoNavegador);
        $grafico->GeraGrafico();


        $grafico = new Grafico(Grafico::COLUNA, "Visitas/Cidade", "div_cidade");
        $grafico->SetDados($graficoCidade);
        $grafico->GeraGrafico();

//         GRAFICO MAPA
        $grafico = new Grafico(Grafico::MAPA, "Visitas/Cidade", "div_mapa");
        $grafico->SetDados($graficoEstado);
        $grafico->GeraGrafico();
    }

}

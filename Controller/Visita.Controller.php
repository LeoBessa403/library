<?php

class Visita extends AbstractController
{

    public function ListarVisita()
    {
        /** @var VisitaService $visitaService */
        $visitaService = $this->getService(VISITA_SERVICE);
        $visitasDispositivo = $visitaService->visitasDispositivo();
        $visitasSO = $visitaService->visitasSO();
        $visitasNavegador = $visitaService->visitasNavegador();
        $visitasCidade = $visitaService->visitasCidade();

        $graficoDispositivo[] = "['Nº Dispositivos','Visitas']";
        foreach ($visitasDispositivo as $nDispositivo) {
            $graficoDispositivo[] = "['" . $nDispositivo['ds_dispositivo'] . "'," . $nDispositivo['qt_dispositivo'] . "]";
        }
        $graficoSO[] = "['Visitas','Nº S.O.']";
        foreach ($visitasSO as $nDispositivo) {
            $graficoSO[] = "['" . $nDispositivo['ds_sistema_operacional'] . "'," . $nDispositivo['qt_visitas'] . "]";
        }
        $graficoNavegador[] = "['Visitas','Navegador']";
        foreach ($visitasNavegador as $nDispositivo) {
            $graficoNavegador[] = "['" . $nDispositivo['ds_navegador'] . "'," . $nDispositivo['qt_visitas'] . "]";
        }

        // GRAFICO PIZZA
        $grafico = new Grafico(Grafico::COLUNA, "Visitas/Dispositivos", "div_dispositivo");
        $grafico->SetDados($graficoDispositivo);
        $grafico->GeraGrafico();

        $grafico = new Grafico(Grafico::PIZZA, "Visitas/S.O.", "div_so");
        $grafico->SetDados($graficoSO);
        $grafico->GeraGrafico();

        $grafico = new Grafico(Grafico::PIZZA, "Visitas/Navegador", "div_nav");
        $grafico->SetDados($graficoNavegador);
        $grafico->GeraGrafico();

        $grafico = new Grafico(Grafico::MAPA, "Visitas/Cidade", "div_mapa");
        $grafico->SetDados(array(
                "['Cidade','Visitas']",
                "['Natal',1285.31]",
                "['Brasília',181.76]",
                "['São Paulo',117.27]",
                "['Rio de Janeiro',213.44]",
                "['Belo Horizonte',43.43]",
                "['Maceio',11]"
            )
        );
        $grafico->GeraGrafico();
    }

}

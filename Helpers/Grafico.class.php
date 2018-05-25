<?php

/**
 * Grafico.class [ HELPER ]
 * Gera os GRÁFICOS de resultados do sistema!
 *
 * @copyright (c) 2014, Leo Bessa
 */
class Grafico
{

    /** DEFINE O Configurações do Gráfico */
    private $Modelo;
    private $Titulo;
    private $Largura;
    private $Altura;
    private $Div;
    private $Dados;

    const PORCENTAGEM = 1;
    const LINHA = 2;
    const MAPA = 3;
    const PIZZA = 4;
    const COLUNA = 5;


    /**
     * <b>Iniciar Gráfico:</b> Defina o Modelo para gerar o gráfico
     * @param STRING $Modelos : Pizza, Porcentagem, Coluna, Linha ou Mapa.
     * @param STRING $Título : Coloca um título para o gráfico.
     * @param STRING $Div : Seta o ID da div para gerar o gráfico.
     * @param STRING $Largura : Seta a Largura para o gráfico.
     * @param STRING $Altura : Seta a Altura para o gráfico.
     */
    function __construct($modelo, $titulo, $div, $largura = null, $altura = null)
    {
        $this->Modelo = $modelo;
        $this->Largura = ($largura != null ? $largura : 500);
        $this->Altura = ($altura != null ? $altura : 500);
        $this->Div = $div;
        $this->Titulo = $titulo;
    }

    /**
     * <b>Informa os Dados para gerar o Gráfico:</b>
     * @param ARRAY $Dados :
     * @param MODELO PORCENTAGEM array("Memória" => 80, "CPU" => 12, "Rede" => 68);
     * @param MODELO COLUNA array("['Ano','Gordos','Obesos','Magros']","['Jan',1080,1780,180]",
     * "['Fev',1170,670,180]","['Mar',660,960,180]","['Abr',1030,130,540]");
     * @param MODELO LINHA array("['Ano','Gordos','Obesos','Magros']","['2004',1080,1780,180]",
     * "['2005',1170,670,10]","['2006',660,960,10]","['2007',1030,130,540]");
     * @param MODELO MAPA array("['Cidade','Acessos','Visitas']","['Natal',2761477,1285.31]","['Brasília',1324110,181.76]",
     * "['São Paulo',959574,117.27]","['Rio de Janeiro',67370,213.44]","['Belo Horizonte',52192,43.43]","['Maceio',38262,11]");
     * @param MODELO PIZZA array("['Categorias','Procedimentos/Mês']","['Odontológico',11]","['Pediatra',5]","['Ginecologista',2]","['UTI',2]");
     */
    public function SetDados($dados)
    {
        $this->Dados = (array)$dados;
    }

    /**
     * <b>GeraGrafico</b> Executa a geração do gráfico.
     */
    public function GeraGrafico()
    {
        echo '<script type="text/javascript">';

        switch ($this->Modelo) {

            /// Gráfico Porcentagem
            case 1 :
                echo "google.load('visualization', '1', {packages: ['gauge']});
                           google.setOnLoadCallback(drawChart3);
                           function drawChart3() {
                                var data3 = google.visualization.arrayToDataTable([
                                  ['Label', 'Value'], ";
                $this->MontaDados($this->Dados, true);
                echo "]);
                    var options3 = {
                        width: $('#" . $this->Div . "').width(), 
                        height: $('#" . $this->Div . "').height(),
                        redFrom: 90, redTo: 100,
                        yellowFrom:75, yellowTo: 90,
                        title: '" . $this->Titulo . "',
                        minorTicks: 5
                    };
                    var chart3 = new google.visualization.Gauge(document.getElementById('" . $this->Div . "'));
                    chart3.draw(data3, options3);
                   }";
                break;

            /// Gráfico de Linha
            case 2 :
                echo "google.load('visualization', '1', {packages:['corechart']});
                  google.setOnLoadCallback(drawChart);

                  function drawChart() {
                        var data = google.visualization.arrayToDataTable([";
                $this->MontaDados($this->Dados);
                echo "]);
                    var options = {
                        title: '" . $this->Titulo . "'
                    };
                    var chart = new google.visualization.LineChart(document.getElementById('" . $this->Div . "'));
                    chart.draw(data, options);
                  }";
                break;

            /// Gráfico de Mapa
            case 3:
                echo "google.charts.load('current', {
                        'packages': ['geochart'],
                        // Note: you will need to get a mapsApiKey for your project.
                        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
                        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
                    });
                    google.charts.setOnLoadCallback(drawMarkersMap);
                
                    function drawMarkersMap() {
                        var data = google.visualization.arrayToDataTable([
                            ";
                            $this->MontaDados($this->Dados);
                            echo "]);
                
                        var options = {
                            region: 'BR',
                            displayMode: 'regions',
                            resolution: 'provinces',
                            colorAxis: {colors: ['yellow', 'green']}
                        };
                
                        var chart = new google.visualization.GeoChart(document.getElementById('div_mapa'));
                        chart.draw(data, options);
                    }";
                break;

            //Gráfico Pizza
            case 4:
                echo "google.charts.load('current', {'packages':['corechart']});
                      google.charts.setOnLoadCallback(drawChart2);
                
                      function drawChart2() {
                
                        var data2 = google.visualization.arrayToDataTable([";
                $this->MontaDados($this->Dados);
                echo "]);
                var options2 = {
                    title: '" . $this->Titulo . "',
                    is3D: true
                };
                var chart2 = new google.visualization.PieChart(document.getElementById('" . $this->Div . "'));
                chart2.draw(data2, options2);
              }";
                break;

            /// Gráfico de Coluna
            case 5:
                echo "google.charts.load('current', {packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                      var data5 = google.visualization.arrayToDataTable([";
                $this->MontaDados($this->Dados);
                echo "]);
                var options5 = {
                    title: '" . $this->Titulo . "',
                    width : $('#" . $this->Div . "').width(),
                    height: $('#" . $this->Div . "').height(),
                    titleTextStyle: {color: 'gray', fontSize: 20},
                    legend: { position: 'none', maxLines: 3 , textStyle: {fontSize: 10} },
                    //isStacked: true
                    //orientation: 'vertical'
                };

                  var chart5 = new google.visualization.ColumnChart(document.getElementById('" . $this->Div . "'));
                  chart5.draw(data5, options5);
                }";
                break;

        }
        echo "</script>";
    }

    private function MontaDados($dados, $TipoPorcentagem = false)
    {
        $quant = count($dados);
        $i = 1;
        $result = '';
        foreach ($dados as $key => $valor) {
            if($TipoPorcentagem){
                $result .= "['" . $key . "'," . $valor . "]";
            }else{
                $result .= $valor;
            }
            if ($i < $quant) {
                $result .= ", ";
            }
            $i++;
        }
        echo $result;
    }

}

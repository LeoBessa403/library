<?php

/**
 * Grafico.class [ HELPER ]
 * Gera os GRÁFICOS de resultados do sistema!
 * 
 * @copyright (c) 2014, Leo Bessa
 */
class Grafico {

    /** DEFINE O Configurações do Gráfico */
    private $Modelo;
    private $Titulo;
    private $Largura;
    private $Altura;
    private $Div;
    private $Dados;




    /**
     * <b>Iniciar Gráfico:</b> Defina o Modelo para gerar o gráfico
     * @param STRING $Modelos: Pizza, Porcentagem, Coluna, Linha ou Mapa.
     * @param STRING $Título: Coloca um título para o gráfico.
     * @param STRING $Div: Seta o ID da div para gerar o gráfico.
     * @param STRING $Largura: Seta a Largura para o gráfico.
     * @param STRING $Altura: Seta a Altura para o gráfico.
     */
    function __construct($modelo,$titulo, $div, $largura = null, $altura = null) {
        $this->Modelo   = $modelo;
        $this->Largura  = ($largura != null ? $largura : 500);
        $this->Altura   = ($altura != null ? $altura : 500);
        $this->Div      = $div;
        $this->Titulo   = $titulo;
    }
    
     /**
     * <b>Informa os Dados para gerar o Gráfico:</b> 
     * @param ARRAY $Dados: 
     * @param MODELO PORCENTAGEM array("Memória" => 80, "CPU" => 12, "Rede" => 68);
     * @param MODELO COLUNA array("['Ano','Gordos','Obesos','Magros']","['Jan',1080,1780,180]",
	   "['Fev',1170,670,180]","['Mar',660,960,180]","['Abr',1030,130,540]");
     * @param MODELO LINHA array("['Ano','Gordos','Obesos','Magros']","['2004',1080,1780,180]",
	   "['2005',1170,670,10]","['2006',660,960,10]","['2007',1030,130,540]");
     * @param MODELO MAPA array("['Cidade','Acessos','Visitas']","['Natal',2761477,1285.31]","['Brasília',1324110,181.76]",
      "['São Paulo',959574,117.27]","['Rio de Janeiro',67370,213.44]","['Belo Horizonte',52192,43.43]","['Maceio',38262,11]");
     * @param MODELO PIZZA array("['Categorias','Procedimentos/Mês']","['Odontológico',11]","['Pediatra',5]","['Ginecologista',2]","['UTI',2]");
     */
    public function setDados($dados) {
        $this->Dados = (array) $dados;
    }
    
    /**
     * <b>GeraGrafico</b> Executa a geração do gráfico.
     */
    public function GeraGrafico(){
         echo '<script type="text/javascript" src="'.HOME.'library/Helpers/includes/gera-grafico.js"></script>';
         echo '<script type="text/javascript">';
         
         switch($this->Modelo){

            /// Gráfico Porcentagem
            case "porcentagem" :
                    echo "google.load('visualization', '1', {packages: ['gauge']});
                           google.setOnLoadCallback(drawChart3);
                           function drawChart3() {
                                var data3 = google.visualization.arrayToDataTable([
                                  ['Label', 'Value'], ";
                                  $quant = count($this->Dados);
                                  $i = 1;
                                  foreach ($this->Dados as $key => $valor){
                                          echo "['".$key."',".$valor."]";
                                          if($i < $quant){
                                                  echo ", ";
                                          }
                                          $i++;
                                  }
                                  echo "]);
                                var options3 = {
                                  width: ".$this->Largura.", height: ".$this->Altura.",
                                  redFrom: 90, redTo: 100,
                                  yellowFrom:75, yellowTo: 90,
                                  title: '".$this->Titulo."',
                                  minorTicks: 5
                                };
                                var chart3 = new google.visualization.Gauge(document.getElementById('".$this->Div."'));
                                chart3.draw(data3, options3);
                   }";
            break;

            /// Gráfico de Linha
            case "linha" :
                  echo "google.load('visualization', '1', {packages:['corechart']});
                  google.setOnLoadCallback(drawChart);

                  function drawChart() {
                        var data = google.visualization.arrayToDataTable([";
                                         $quant = count($this->Dados);
                         $i = 1;
                         foreach ($this->Dados as $linhas){
                                echo $linhas;
                                          if($i < $quant){
                                                  echo ", ";
                                          }
                                          $i++;
                                  }
                        echo "]);

                        var options = {
                          title: '".$this->Titulo."'
                        };

                        var chart = new google.visualization.LineChart(document.getElementById('".$this->Div."'));
                        chart.draw(data, options);
                  }";
                break;

                        case "mapa":
                                echo "google.load('visualization', '1', {'packages': ['geochart']});
                        google.setOnLoadCallback(drawRegionsMap);

                        function drawRegionsMap() {
                         var data4 = google.visualization.arrayToDataTable([";
                                         $quant = count($this->Dados);
                         $i = 1;
                         foreach ($this->Dados as $linhas){
                                echo $linhas;
                                          if($i < $quant){
                                                  echo ", ";
                                          }
                                          $i++;
                                  }
                        echo "]);
                var options4 = { 
                region: 'BR',
                displayMode: 'markers',
                colorAxis: {colors: ['green', 'yellow']}
                        };

                var chart4 = new google.visualization.GeoChart(document.getElementById('".$this->Div."'));
                chart4.draw(data4, options4);
            };";
                break;
                
                //Gráfico Pizza
                case "pizza":
                echo "google.load('visualization', '1', {packages:['corechart']});
                google.setOnLoadCallback(drawChart2);
                function drawChart2() {
                var data2 = google.visualization.arrayToDataTable([
                ";
                                         $quant = count($this->Dados);
                         $i = 1;
                         foreach ($this->Dados as $linhas){
                                echo $linhas;
                                          if($i < $quant){
                                                  echo ", ";
                                          }
                                          $i++;
                                  }
                        echo "
                                        ]);

                var options2 = {
                  title: '".$this->Titulo."',
                          is3D: true
                };

                var chart2 = new google.visualization.PieChart(document.getElementById('".$this->Div."'));
                chart2.draw(data2, options2);
              }";
               break;
               
               case 'coluna':
                echo "google.load('visualization', '1', {packages:['corechart']});
                google.setOnLoadCallback(drawChart5);
                function drawChart5() {
                  var data5 = google.visualization.arrayToDataTable([";
                           $quant = count($this->Dados);
                           $i = 1;
                           foreach ($this->Dados as $linhas){
                                  echo $linhas;
                                            if($i < $quant){
                                                    echo ", ";
                                            }
                                            $i++;
                                    }
                          echo "]);

                  var options5 = {
                    title: '".$this->Titulo."',
                    width : '".$this->Largura."',
                    height: '".$this->Altura."',
                    titleTextStyle: {color: 'gray', fontSize: 20},
                    //isStacked: true
                    //orientation: 'vertical'
                  };

                  var chart5 = new google.visualization.ColumnChart(document.getElementById('".$this->Div."'));
                  chart5.draw(data5, options5);
                }";
                 break;  

             }
            echo "</script>";
            
            return '<div class="grafico" id="'.$this->Div.'" style="width: '.$this->Largura.'px; height: '.$this->Altura.'px;"></div>';
    }

    
   

}

<div class="main-content">
    <!-- end: SPANEL CONFIGURATION MODAL FORM -->
    <div class="container">
        <!-- start: PAGE HEADER -->
        <div class="row">
            <div class="col-sm-12">
                <!-- start: PAGE TITLE & BREADCRUMB -->
                <ol class="breadcrumb">
                    <li>
                        <i class="clip-home-3"></i>
                        <a href="#">
                            Início
                        </a>
                    </li>
                </ol>
                <div class="page-header">
                    <h1>Dados das Visitas</h1>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <!-- end: PAGE HEADER -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-calendar"></i>
                        Resumo das Visitas
                    </div>
                    <div class="panel-body">
                        <div class="col-md-4">
                            <div class="alert alert-warning fade in">
                                <div id="div_so"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-danger fade in">
                                <div id="div_dispositivo"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success fade in">
                                <div id="div_nav"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <div id="div_mapa"></div>
                            </div>
                        </div>
                        <!-- end: FULL CALENDAR PANEL -->
                    </div>
                    <!-- end: PAGE CONTENT-->

                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    // google.charts.load('current', {
    //     'packages': ['geochart'],
    //     // Note: you will need to get a mapsApiKey for your project.
    //     // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
    //     'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
    // });
    // google.charts.setOnLoadCallback(drawMarkersMap);
    //
    // function drawMarkersMap() {
    //     var data = google.visualization.arrayToDataTable([
    //         ['City',   'Population', 'Area'],
    //         ['Rome',      2761477,    1285.31],
    //         ['Milan',     1324110,    181.76],
    //         ['Naples',    959574,     117.27],
    //         ['Turin',     907563,     130.17],
    //         ['Palermo',   655875,     158.9],
    //         ['Genoa',     607906,     243.60],
    //         ['Bologna',   380181,     140.7],
    //         ['Florence',  371282,     102.41],
    //         ['Fiumicino', 67370,      213.44],
    //         ['Anzio',     52192,      43.43],
    //         ['Ciampino',  38262,      11]
    //     ]);
    //
    //     var options = {
    //         region: 'IT',
    //         displayMode: 'markers',
    //         colorAxis: {colors: ['green', 'blue']}
    //     };
    //
    //     var chart = new google.visualization.GeoChart(document.getElementById('div_mapa'));
    //     chart.draw(data, options);
    // }
</script>
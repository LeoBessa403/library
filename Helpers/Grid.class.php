<?php
/**
 * Grid.class [ HELPER ]
 * Classe responável por gerar as Grid do Sistema!
 * 
 * @copyright (c) 2015, Leo Bessa
 */
class Grid {

    private static $colunas;
    private static $td;
       
    public function setColunasIndeces(Array $colunas) {
        self::$colunas = $colunas;
        return $this;
    }
    
    
    public function setColunas($valor,$QtdBotoes = 0) {
        if($QtdBotoes != 0):
            self::$td .= '<td style="width: '.($QtdBotoes*46).'px">';
        else:
            self::$td .= '<td>';
        endif;
        self::$td .= $valor;
        self::$td .= '</td>';
        return $this;
    }
    
    public function pesquisaAvancada($titulo = 'Pesquisar') {
        $apps = new UrlAmigavel::$controller();
        $action = UrlAmigavel::$action."PesquisaAvancada";
        echo '<div class="row">';
        echo '<div class="col-md-6"> 
                <div class="panel panel-box" style="padding: 0 0 15px 15px; margin-top: 0;">
                        <h2><small>'.$titulo.'</small></h2>';
        if( method_exists($apps, $action) ):
            $apps->$action();
        endif;
        echo '</div></div>';
        echo '</div><hr>';
    }

    public function gerarBtnExportar() {
        $apps = new UrlAmigavel::$controller();
        $exporta = false;
        echo '<div class="row">';
        if( method_exists($apps,"Exportar".UrlAmigavel::$action) ):
         echo  '<div class="col-md-12 space10">
                <a role="button" class="btn btn-success tooltips pull-right" id="excel" 
                   href="'.PASTAADMIN.UrlAmigavel::$controller.'/Exportar'.UrlAmigavel::$action.'/'.Valida::GeraParametro('formato/excel').'" data-original-title="Exportar para Excel" data-placement="left">
                     Excel <i class="clip-file-excel"></i>
                </a>
                <a role="button" class="btn btn-bricky tooltips pull-right" id="pdf" style="margin-right: 10px;" 
                   href="'.PASTAADMIN.UrlAmigavel::$controller.'/Exportar'.UrlAmigavel::$action.'/'.Valida::GeraParametro('formato/pdf').'" data-original-title="Exportar para PDF" data-placement="left">
                     PDF <i class="clip-file-pdf"></i>
                </a>
                ';
            $exporta = true;
        endif;
        if($exporta):
            echo '</div>';
        endif;
        echo '</div>';
    }
    
    
    public function criaLinha($id_linha,$destaque = null) {
        if($destaque){
            $destaque = 'style="background : #ffcccc;"';
        }
        echo '<tr id="registro-'.$id_linha.'" class="linha-tabela" '.$destaque.'>';
        echo self::$td;
        echo '</tr>';
        self::$td = "";
        return $this;
    }
    
    
    public function criaGrid($id = 1, $dateTable = true) {
        $this->gerarBtnExportar();
        $class = ($dateTable) ? 'table ' : '';
        echo '<div class="table-responsive">
                <table class="'.$class.'table-striped table-bordered table-hover table-full-width" id="sample_'.$id.'"
                style="width: 100%">
                <thead>
                    <tr style="background-color: #99ccff; color: #000;">';
                    if(is_array(self::$colunas)):
                        foreach (self::$colunas as $value) {
                            echo '<th>'.$value.'</th>';
                        }
                    endif;
                   echo '</tr>
                </thead>
                <tbody>';
    }
    
    public function finalizaGrid() {
        echo '</tbody>
            </table>
        </div>';
    }
        

}

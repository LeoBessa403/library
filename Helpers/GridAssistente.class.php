<?php

/**
 * GridAssistente.class [ HELPER ]
 * Classe responável por gerar as Grid do Sistema!
 *
 * @copyright (c) 2018, Leo Bessa
 */
class GridAssistente
{

    private static $colunas;
    private static $td;
    private static $gridAssistente;

    public function setColunasIndeces(Array $colunas)
    {
        self::$colunas = $colunas;
        return $this;
    }


    public function setColunas($valor, $QtdBotoes = 0)
    {
        if ($QtdBotoes != 0):
            self::$td .= '<td style="width: ' . ($QtdBotoes * 46) . 'px">';
        else:
            self::$td .= '<td>';
        endif;
        self::$td .= $valor;
        self::$td .= '</td>';
        return $this;
    }

    public function criaLinha($id_linha, $destaque = null)
    {
        if ($destaque) {
            $destaque = 'style="background : #ffcccc;"';
        }
        self::$gridAssistente .= '<tr id="registro-' . $id_linha . '" class="linha-tabela" ' . $destaque . '>';
        self::$gridAssistente .= self::$td;
        self::$gridAssistente .= '</tr>';
        self::$td = "";
        return $this;
    }


    public function criaGrid($id = 1)
    {
        self::$gridAssistente .= '<div class="form-group col-sm-12">
                <div class="col-sm-12">
                    <table class="table-striped table-bordered table-hover table-full-width table-nodatable"
                           id="'.$id.'" style="width: 100%" cellpadding="5" cellspacing="5">
                        <thead>
                        <tr style="background-color: #99ccff; color: #000;" role="row">';
        if (is_array(self::$colunas)):
            foreach (self::$colunas as $value) {
                self::$gridAssistente .= '<th>' . $value . '</th>';
            }
        endif;
        self::$gridAssistente .= '</tr>
                </thead>
                <tbody>';
    }

    public function finalizaGrid()
    {
        self::$gridAssistente .= '</tbody>
            </table>
        </div>';
        return self::$gridAssistente;
    }


}

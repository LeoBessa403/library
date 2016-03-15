<?php

/**
 * Exportacao.class [ HELPER ]
 * Gera os Arquivos a serem Exportados!
 * 
 * @copyright (c) 2015, Leo Bessa
 */
class Exportacao{

    private $Conteudo;
    private $Colunas;
    private $Formato;
    private $NomeArquivo;
    private $Orientacao;

    /**
     * <b>Inicia a Exportação</b> Gera arquivos Excel ou PDF para exportação de Dados
     * @param STRING $Formato: Formato a ser exportado XLS ou PDF
     * @param STRING $NomeArquivo: Nome do arquivo a ser Exportado

     */
    function __construct($Formato,$NomeArquivo) {
        $this->Formato      = $Formato;
        $this->NomeArquivo  = $NomeArquivo;
        $this->Orientacao   = "portrait";
    }
    
    /**
     * <b>Atribui o conteudo a ser montado:</b> 
     * @param STRING $Conteudo:  Em HTML
     */
    public function setConteudo($Conteudo) {
        $this->Conteudo =  $Conteudo;
    }
    
    /**
     * <b>Atribui o conteudo a ser montado:</b> 
     * @param STRING $Orientacao: Defaulf Impressão Normal, em Paisagem passar ('paisagem','landscape')
     */
    public function setPapelOrientacao($Orientacao) {
        if($Orientacao == 'paisagem' || $Orientacao == 'landscape')
        $this->Orientacao =  'landscape';
    }
    
    /**
     * <b>Atribui o conteudo a ser montado:</b> 
     * @param STRING $Colunas: ARRAY Os indices da tabela
     */
    public function setColunas($Colunas) {
        $this->Colunas =  $Colunas;
    }
    
    /**
     * <b>GeraArquivo</b> 
     * Cria o Arquivo e Força o Download.
     */
    public function GeraArquivo(){
        $formato = strtoupper($this->Formato); 
        switch($formato){
            ///Formato Excel
            case "XLS" :
            case "XLSX" :
            case "EXCEL" :
                $strFileName = Valida::ValNome($this->NomeArquivo)."-".date("d_m_Y_H_i"). ".xls";		
                header( "Content-Disposition: attachment; filename={$strFileName}" );
                header( "Pragma: public" );
                header( "Last-Modified: " . gmdate( 'D, d M Y H:i:s' ) . " GMT");
                header( "Cache-Control: no-store, no-cache, must-revalidate" );
                header( "Cache-Control: pre-check=0, post-check=0, max-age=0" );
                header( "Content-Transfer-Encoding: binary" );
                header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
                header("Content-type: application/x-msexcel; charset=UTF-8");	

                $html = $this->geraConteudo();  
                
                echo $html;
            break;
            /// Formato PDF
            case "PDF" :
                require_once("admin/plugins/dompdf/dompdf_config.inc.php");

                $html = $this->geraConteudo();    
                
                $strFileName = Valida::ValNome($this->NomeArquivo)."-".date("d_m_Y_H_i"). ".pdf";
                $dompdf = new DOMPDF();
                $dompdf->load_html($html);
                $dompdf->set_paper('A4',$this->Orientacao);
                $dompdf->render();
                $dompdf->stream($strFileName);
            
            break;

         }
        exit;
    }
    
    private function geraConteudo() {
        $html = '<table style="background-color: #fbfbfb; margin:0 auto;">
                            <thead>
                                <tr>
                                    <td style="background-color: #fff; text-align: center;" colspan="'.count($this->Colunas).'" style="text-align: center;"><h2>'.utf8_decode(DESC).'</h2></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #fff; text-align: center;" colspan="'.count($this->Colunas).'"><h3>'.utf8_decode($this->NomeArquivo).'</h3></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #fff;" colspan="'.count($this->Colunas).'">Total de Registros: <b>'.count($this->Conteudo).'</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #fff;" colspan="'.count($this->Colunas).'">Relat&oacute;rio Gerado em: <b>'.date("d/m/Y H:i").'</b></td>
                                </tr>
                                <tr>';
                            foreach ($this->Colunas as $coluns): 
                                $html .= '<th style="background-color: #006699; color: #ffffff;">'.utf8_decode($coluns).'</th>';
                            endforeach;
                            $html .= '</tr>
                               </thead>
                           <tbody>';
                            $cor = 0;
                            foreach ($this->Conteudo as $res):   
                                if($cor%2==0):
                                   $corClass = "#fbfbfb";
                                else:
                                   $corClass = "#dedede";
                                endif;
                                $cor++;
                           
                             $html .= '<tr>';
                                     foreach ($res as $res2):   
                                            $html .= '<td style="background-color: '.$corClass.';">'.utf8_decode($res2).'</td>';                                                                                       
                                    endforeach;
                                $html .= '</tr>';
                            endforeach;
                          $html .= '</tbody>
                    </table>';
            
            return $html;
    }

}

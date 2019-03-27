<?php

/**
 * FormAssistente.class [ HELPER ]
 * Classe responável por gerar formulários Assistentes!
 *
 * @copyright (c) 2014, Leo Bessa
 */
class FormAssistente extends Form
{
    public function CriaInpunt()
    {
        // VALIDA CAMPOS OCUILTOS
        if (self::$type != "hidden"):
            // VERIFICA SE TEM OBRIGATORIEDADE O CAMPO.
            $obrigatoriedade = $this->verificaObrigatoriedade();
            // INICIA O GRUPO DO INPUT
            self::$abas .= '
                    <div id="form-group-' . self::$id . '" class="form-group">'
                . '<label for="' . self::$id . '" class="col-sm-' . self::$colEsquerda . ' control-label">'
                . ' ' . self::$label . $obrigatoriedade . ' '
                . '</label>
                <div class="col-sm-' . self::$colDireita . '">';

            self::$abas .= $this->verificaIconPlace();
            self::$abas .= $this->montaCampos();
            self::$abas .= $this->verificaIconMensagem();

            // FECHA O GRUPO DO INPUT
            self::$abas .= '</div>
                       </div>';
        else:

            // CAMPO TIPO HIDDEN
            self::$abas .= $this->getCampoHidden();
        endif;
        $this->zeraVariaveis();
    }

    /**
     * <b>Cria a Aba :</b> Aba do formulário de assistente
     * @param $titulo : título da Aba
     * @param $subTitulo : sub Título da Aba
     * @param $tamanhoForm : Tamanho da grid do formulário
     * @param $primeiraColuna : Primeira coluna da aba a da esquerda
     * @param $segundaColuna : Segunda coluna da aba a da direita
     * @return string Abas.
     */
    public function criaAba($titulo, $subTitulo, $tamanhoForm = 6, $primeiraColuna = 3, $segundaColuna = 9)
    {
        self::$colEsquerda = $primeiraColuna;
        self::$colDireita = $segundaColuna;
        $nuAba = count(self::$tituloAba) + 1;
        self::$abas .= '
                            <div id="step-' . $nuAba . '">
                                    <h2 class="StepTitle">' . $titulo . '
                                        <small>' . $subTitulo . '</small>
                                    </h2>
                                    <div class="col-sm-' . $tamanhoForm . '">
                                        <div class="form-group">';

        self::$tituloAba[$nuAba]['titulo'] = $titulo;
        self::$tituloAba[$nuAba]['subTitulo'] = $subTitulo;
        return self::$abas;
    }

    /**
     * <b>Finaliza a Aba :</b> Aba do formulário de assistente
     * @param $ultima : Indica se é a ultima aba
     * @param $gridAssistente : Se a Aba sera de uma Grid Assistente
     * @return string Abas.
     */
    public function finalizaAba($ultima = null, $gridAssistente = null)
    {
        if ($gridAssistente) {
            self::$abas .= $gridAssistente;
            self::$abas .= '</div>';
        }
        self::$abas .= '</div>
                        <div class="form-group">';
        // Caso ja tenha aba cria o botão de voltar
        if ($ultima) {
            self::$abas .= '<div class="col-sm-3 pull-right">
                                <button type="submit" class="btn  btn-success btn-block">
                                    Salvar <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>';
        } else {
            self::$abas .= '<div class="col-sm-3 pull-right">
                                <button id="1" class="btn btn-primary next-step btn-block">
                                    Próximo <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>';
        }
        if (count(self::$tituloAba) - 1) {
            self::$abas .= '<div class="col-sm-3 pull-right">
                                <button class="btn btn-light-grey back-step btn-block">
                                    <i class="fa fa-circle-arrow-left"></i> Voltar
                                </button>
                            </div>';
        }
        self::$abas .= '</div>
                    </div>
                </div>';

        return self::$abas;
    }

    /**
     * <b>finalizaForm:</b> Fecha o formulário
     * @return STRING com o fechamento do FORM.
     */
    public function finalizaForm()
    {
        self::$form .= '<div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-external-link-square"></i>
                        ' . self::$titulo . '
                    </div>
                    <div class="panel-body">
                        <form action="'. HOME . self::$action . '"
                              role="form" class="smart-wizard form-horizontal formulario"
                              method="post" enctype="multipart/form-data"
                              id="' . self::$idForm . '" name="' . self::$idForm . '">
                            <div id="wizard" class="swMain">
                                <ul>';

        foreach (self::$tituloAba as $nuAba => $aba) {
            self::$form .= '
                            <li>
                                <a href="#step-' . $nuAba . '" class="selected">
                                    <div class="stepNumber">' . $nuAba . '</div>
                                    <span class="stepDesc"> ' . $aba['titulo'] . '<br/>
                                        <small>' . $aba['subTitulo'] . '</small>
                                    </span>
                                </a>
                            </li>';
        }

        self::$form .= '</ul>
                        <div class="progress progress-striped active progress-sm">
                            <div aria-valuemax="100" aria-valuemin="0" role="progressbar"
                                 class="progress-bar progress-bar-success step-bar">
                                <span class="sr-only"> 0% Complete (success)</span>
                            </div>
                        </div>';

        self::$form .= self::$abas;

        self::$form .= '</div>
                    </form>
                </div>
             </div>
        </div>';

        return self::$form;
    }

}

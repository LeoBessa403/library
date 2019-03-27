<?php

/**
 * Form.class [ HELPER ]
 * Classe responável por gerar formulários!
 *
 * @copyright (c) 2014, Leo Bessa
 */
class Form
{
    protected static $classes;
    protected static $label;
    protected static $place;
    protected static $info;
    protected static $icon;
    protected static $lado;
    protected static $type;
    protected static $id;
    protected static $values;
    protected static $valor;
    protected static $options;
    protected static $label_options;
    protected static $style;
    private static $tamanhoForm;
    protected static $tamanho;
    protected static $action;
    public static $idForm;
    public static $form;
    public static $botao;
    protected static $titulo;
    protected static $colEsquerda;
    protected static $colDireita;
    protected static $abas;
    protected static $tituloAba;


    /**
     * <b>Form da Pesquisa Avançada:</b> ionicia o formulário e suas configurações
     * @param STRING $idform : atribui o ID para o Formulário
     * @param STRING $action : Ação a realizar a pesquisa e carregar a GRID
     * @param STRING $botao : Label do Botão
     * @param INT $tamanhoForm : Tamanho do Formulário
     * @param STRING $titulo : Título da tela
     */
    function __construct($idform, $action = null, $botao = null, $tamanhoForm = null, $titulo = null)
    {
        self::$idForm = $idform;
        self::$style = "";
        self::$type = "text";
        self::$options = array();
        self::$label_options = array();
        self::$form = "";
        self::$tamanhoForm = ($tamanhoForm) ? $tamanhoForm : 6;
        self::$tamanho = "";
        self::$action = ($action) ? $action : ADMIN . "/" . UrlAmigavel::$controller . "/" . UrlAmigavel::$action;
        self::$botao = ($botao) ? $botao : "Salvar";
        self::$tituloAba = array();
        self::$abas = '';
        self::$tamanho = "";
        self::$titulo = $titulo;
    }

    /**
     * <b>setClasses:</b> Atribui as classes para os campos.
     * @param STRING $classes : Essas classes podem ser utilizadas par formação de CSS,
     * para atribuir a eventos de JQUERY, e calsses de validações. EX: (cpf ob moeda).
     * @return $this
     */
    public function setClasses($classes)
    {
        self::$classes = $classes;
        return $this;
    }

    /**
     * <b>setLabel:</b> Atribui o label a ser apresentado para todos os tipos de campo.
     * @param STRING $label .
     * @return $this
     */
    public function setLabel($label)
    {
        self::$label = $label;
        return $this;
    }

    /**
     * <b>setValues:</b> Atribui o valor para os campos
     * @param STRING $values . pode ser utilizados para todos os inputs e textearea.
     * @return $this
     */
    public function setValues($values)
    {
        self::$values = $values;
        return $this;
    }

    /**
     * <b>setValues:</b> Atribui o valor para os campos
     * @param STRING $valor . pode ser utilizados para todos os inputs e textearea.
     * @return $this
     */
    public function setValor($valor)
    {
        self::$valor = $valor;
        return $this;
    }

    /**
     * <b>setTamanhoInput:</b> Atribui o tamanho maximo para o input
     * @param STRING $tamanho . pode ser utilizados para todos os inputs e textearea.
     * @return $this
     */
    public function setTamanhoInput($tamanho)
    {
        self::$tamanho = $tamanho;
        return $this;
    }

    /**
     * <b>setType:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $type : password, file, select, textarea, radio, checkbox, hidden e o text.
     * @return $this
     */
    public function setType($type)
    {
        self::$type = $type;
        return $this;
    }

    /**
     * <b>setPlace:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $place : password, file, select, textarea, radio, checkbox, hidden e o text.
     * @return $this
     */
    public function setPlace($place)
    {
        self::$place = $place;
        return $this;
    }

    /**
     * <b>setLimite:</b> Da um Limite máximo de itens para Inputs Multiplos
     * @param STRING setLimite: Limite de Número para Inputs Multiplos.
     * @return $this
     */
    public function setLimite($limite)
    {
        self::$place = (int)$limite;
        return $this;
    }

    /**
     * <b>setInfo:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $info : password, file, select, textarea, radio, checkbox, hidden e o text.
     * @return $this
     */
    public function setInfo($info)
    {
        self::$info = $info;
        return $this;
    }

    /**
     * <b>setIcon:</b> Atribui o tipo do Input, Valor padrão (TEXT)
     * @param STRING $icon : password, file, select, textarea, radio, checkbox, hidden e o text.
     * @param STRING $lado : password, file, select, textarea, radio, checkbox, hidden e o text.
     * @return $this
     */
    public function setIcon($icon, $lado = "esq")
    {
        self::$icon = $icon;
        self::$lado = $lado;
        return $this;
    }

    /**
     * <b>setId:</b> Atribui o ID e o NAME do input
     * @param STRING $id .
     * @return $this
     */
    public function setId($id)
    {
        self::$id = $id;
        return $this;
    }

    /**
     * <b>setStylo:</b> Atribui os Stylo (CSS) para o input
     * @param $stylo $stylo. define propriedade de CSS para stylo (Propriedade: Atributo)
     * Ex.: array ('border' => '1px solid red', 'color' => 'black')
     * @return $this
     */
    public function setStylo(array $stylo)
    {
        if (!empty($stylo)):
            foreach ($stylo as $key => $value) {
                self::$style .= "$key: $value; ";
            }
        endif;
        return $this;
    }

    /**
     * <b>setId:</b> Pega no banco de dados os registros para o autocomplete.
     * @param STRING $tabela : nome da tabela a ser consultada.
     * @param STRING $campo : nome do campo a ser consultado.
     * @param STRING $order : Ordenação.
     * @return $this script: gera o script para o autocomplete
     */
    public function setAutocomplete($tabela, $campo, $id, $order = 'ASC')
    {
        $dados = [
            '' => Mensagens::MSG_SEM_ITEM_SELECIONADO
        ];
        $autocomplete = new Pesquisa();
        $autocomplete->Pesquisar($tabela, "ORDER BY $campo $order", NULL, $id . ',' . $campo);
        if ($autocomplete->getResult()) {
            foreach ($autocomplete->getResult() as $res) {
                $dados[$res[$id]] = $res[$campo];
            }
            self::$options = $dados;
        }
        return $this;
    }

    /**
     * <b>setOptions:</b> Atribui os valores das options a montar um select
     * @param $options $options : O indece do array se torna o value da option e o valor do array se torna o label a ser apresentado..
     * @return $this
     */
    public function setOptions($options)
    {
        self::$options = (array)$options;
        return $this;
    }

    /**
     * <b>setLabelCheckRadio:</b> Atribui os valores dos label para checkbox e radiobuttom.
     * @param $label_options $label_options : Cada indice do array se torna uma opção dos  checkbox ou radiobuttom
     * @return $this
     */
    public function setLabelCheckRadio($label_options)
    {
        self::$label_options = (array)$label_options;
        return $this;
    }

    protected function verificaObrigatoriedade()
    {
        if (self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if (in_array("ob", $ob)):
                $obrigatoriedade = ' <span class="symbol required"></span>';
            else:
                $obrigatoriedade = "";
            endif;
        else:
            $obrigatoriedade = "";
        endif;

        return $obrigatoriedade;
    }

    protected function verificaInline()
    {
        $inline = array();
        if (self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if (in_array("inline", $ob)):
                $inline['inicio'] = '<label class="' . self::$type . '-inline">';
                $inline['fim'] = '</label>';
                unset($ob['inline']);
                self::$classes = implode(" ", $ob);
            else:
                $inline['inicio'] = '<div class="' . self::$type . '">'
                    . '<label>';
                $inline['fim'] = '</label>'
                    . '</div>';
            endif;
        else:
            $inline['inicio'] = '<div class="' . self::$type . '">'
                . '<label>';
            $inline['fim'] = '</label>'
                . '</div>';
        endif;

        return $inline;
    }

    protected function verificaMultiplo()
    {
        if (self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if (in_array("multipla", $ob)):
                $multiplo = "multiple='multiple'";
                unset($ob['multiplo']);
                self::$classes = implode(" ", $ob);
            else:
                $multiplo = "";
            endif;
        else:
            $multiplo = "";
        endif;

        return $multiplo;
    }


    protected function verificaChecked()
    {
        if (self::$classes != ""):
            $ob = explode(" ", self::$classes);
            if (in_array("checked", $ob)):
                $checked = 'checked="checked"';
                unset($ob['checked']);
                self::$classes = implode(" ", $ob);
            else:
                $checked = "";
            endif;
        else:
            $checked = "";
        endif;

        return $checked;
    }

    /**
     * <b>CriaInpunt:</b> Cria os inputs do formulário
     * @return STRING com o campo criado.
     */
    public function CriaInpunt()
    {
        // VALIDA CAMPOS OCUILTOS
        if (self::$type != TiposCampoEnum::HIDDEN):
            // VALIDA TAMANHO DO GRUPO DO INPUT
            if (self::$tamanho != ""):
                self::$form .= '<div class="col-sm-' . self::$tamanho . '" style="padding:0px 2px;">';
            endif;
            // VERIFICA SE TEM OBRIGATORIEDADE O CAMPO.
            $obrigatoriedade = $this->verificaObrigatoriedade();
            // INICIA O GRUPO DO INPUT
            self::$form .= '<div class="form-group">'
                . '<label for="' . self::$id . '" class="control-label">'
                . ' ' . self::$label . $obrigatoriedade . ''
                . '</label>';
            self::$form .= $this->verificaIconPlace();
            self::$form .= $this->montaCampos();
            self::$form .= $this->verificaIconMensagem();

            // FECHA O TAMANHO DO INPUT
            if (self::$tamanho != ""):
                self::$form .= '</div>';
            endif;

            // FECHA O GRUPO DO INPUT
            self::$form .= '</div>';
        else:

            // CAMPO TIPO HIDDEN
            self::$form .= $this->getCampoHidden();
        endif;
        $this->zeraVariaveis();
    }

    /**
     * Monta os campos
     */
    protected function montaCampos()
    {
        $form = '';
        switch (self::$type) {
            case TiposCampoEnum::TEXT:
            case TiposCampoEnum::PASSWORD:
                $form .= $this->getCampoText();
                break;
            case TiposCampoEnum::SELECT:
                $form .= $this->getCampoSelect();
                break;
            case TiposCampoEnum::TEXTAREA:
                $form .= $this->getCampoTextarea();
                break;
            case TiposCampoEnum::FILE:
                $form .= $this->getCampoFile();
                break;
            case TiposCampoEnum::SINGLEFILE:
                $form .= $this->getCampoSingleFile();
                break;
            case TiposCampoEnum::RADIO:
            case TiposCampoEnum::CHECKBOX:
                $form .= $this->getCampoCheckRadio();
                break;
            case TiposCampoEnum::COLOR:
                $form .= $this->getCampoColor();
                break;
        }
        return $form;
    }

    /**
     * ZERA TODOS OS ATRIBUTOS
     */
    protected function zeraVariaveis()
    {
        // ZERA TODOS OS ATRIBUTOS
        self::$type = "text";
        self::$values = "";
        self::$classes = "";
        self::$id = "";
        self::$label = "";
        self::$style = "";
        self::$place = "";
        self::$info = "";
        self::$icon = "";
        self::$tamanho = "";
        self::$label_options = array();
        self::$options = array();
    }

    /**
     * Criaos campos selects
     */
    protected function verificaIconPlace()
    {
        $form = '';
        // VERIFICA SE TEM ÍCONE
        if (self::$icon != ""):
            $form = '<div class="input-group ' . self::$id . '">';
            // VERIFICA O LADO DO ÍCONE
            if (self::$lado == "esq"):
                $form .= '<span class="input-group-addon" style="height: 34px;">'
                    . '<i class="' . self::$icon . '"></i></span>';
            endif;
        endif;
        //VERIFICA SE TEM PLACEHOLDER
        if (self::$place != ""):
            self::$place = ' placeholder="' . self::$place . '"';
        endif;
        return $form;
    }

    /**
     * Criaos campos selects
     */
    protected function verificaIconMensagem()
    {
        $form = '';
        // VERIFICA SE TEM ÍCONE
        if (self::$icon != ""):
            // VERIFICA SE O ÍCONE É DO LADO DIREITO
            if (self::$lado == "dir"):
                $form .= '<span class="input-group-addon">'
                    . '<i class="' . self::$icon . '"></i></span>';
            endif;

            // FECHA DIV DO ÍCONE
            $form .= '</div>';
        endif;

        // VERIFICA SE TEM INFORMAÃÃO
        if (self::$info != ""):
            $form .= '<span class="help-block" id="' . self::$id . '-info">
                    <i class="fa fa-info-circle"></i> ' . self::$info . '</span>';
        else:
            $form .= '<span class="help-block" id="' . self::$id . '-info">.</span>';
        endif;
        return $form;
    }

    /**
     * Criaos campos selects
     */
    protected function getCampoHidden()
    {
        return '<input id="' . self::$id . '" name="' . self::$id . '" value="' . self::$values . '" type="hidden" />';
    }

    /**
     * Criaos campos selects
     */
    protected function getCampoSelect()
    {
        $mutiplo = $this->verificaMultiplo();
        $form = "<select " . $mutiplo . self::$place . " id='" . self::$id . "' name='" .
            self::$id . "[]' class='form-control search-select " . self::$classes . "'>";
        foreach (self::$options as $key => $values):
            $checked = "";
            if (!empty(self::$valor[self::$id])):
                if ($mutiplo):
                    if (in_array($key, self::$valor[self::$id])):
                        $checked = 'selected';
                    endif;
                else:
                    if ($key == self::$valor[self::$id]):
                        $checked = 'selected';
                    endif;
                endif;
            endif;
            $form .= '<option value="' . $key . '" ' . $checked . '>' . $values . '</option>';
        endforeach;
        $form .= "</select>";
        return $form;
    }

    /**
     * Criaos campos TextArea
     */
    protected function getCampoTextarea()
    {
        $valor = '';
        if (is_array(self::$valor) && !empty(self::$valor)):
            if (!empty(self::$valor[self::$id])):
                $valor = self::$valor[self::$id];
            endif;
        else:
            if (!empty(self::$valor)):
                $valor = self::$valor;
                self::$valor = "";
            endif;
        endif;
        $form = "<textarea id='" . self::$id . "' name='" . self::$id . "'" . self::$place .
            " style='resize: none;' class='form-control " . self::$classes . "' >" . $valor . "</textarea>";
        return $form;
    }

    /**
     * Criaos campos File para (Pode ser multiplos)
     */
    protected function getCampoFile()
    {
        $mutiplo = $this->verificaMultiplo();
        $form = '<div class="fileupload fileupload-new" data-provides="fileupload" style="margin-bottom: 0px;">
                                    <div class="input-group">
                                            <div class="form-control uneditable-input">
                                                    <i class="fa fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                            </div>
                                            <div class="input-group-btn">
                                                    <div class="btn btn-dark-grey btn-file">
                                                            <span class="fileupload-new">
                                                            <i class="fa fa-folder-open-o"></i> Abrir Arquivo</span>
                                                            <span class="fileupload-exists">
                                                            <i class="fa fa-folder-open-o"></i> Trocar</span>
                                                            <input ' . $mutiplo . ' type="file" class="file-input ' .
            self::$classes . '" ' . self::$place . ' id="' .
            self::$id . '" name="' . self::$id . '[]" />
                                                    </div>
                                                    <a href="#" class="btn btn-bricky fileupload-exists" 
                                                    data-dismiss="fileupload">
                                                            <i class="fa fa-trash-o"></i> Remover
                                                    </a>
                                            </div>
                                    </div>
                            </div>';
        return $form;
    }

    /**
     * Criaos campos File (Ãnico Arquivo)
     */
    protected function getCampoSingleFile()
    {
        $form = '<div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">';
        if (isset(self::$valor[self::$id])) {
            $form .=
                Valida::getMiniatura(self::$valor[self::$id], "Pre Carregamento", 150, 150);
        } else {
            $form .=
                '<img src="' . TIMTHUMB . '?src=' . SEM_FOTO . '&w=150&h=150" 
                alt="Pre Carregamento" title="Pre Carregamento"  />';
        }
        $form .= '</div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" 
                                            style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                            <div class="user-edit-image-buttons">
                                                    <span class="btn btn-dark-grey btn-file">
                                                    <span class="fileupload-new">
                                                    <i class="fa fa-folder-open-o"></i> Abrir Arquivo</span>
                                                    <span class="fileupload-exists">
                                                    <i class="fa fa-folder-open-o"></i> Trocar</span>
                                                            <input type="file" class="file-input ' .
            self::$classes . '" id="' . self::$id . '" name="' . self::$id . '" />
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists btn-bricky" 
                                                    data-dismiss="fileupload">
                                                            <i class="fa fa-trash-o"></i> Remover
                                                    </a>
                                            </div>
                                    </div>';
        return $form;
    }

    /**
     * Criaos campos Checkbox ou Radio
     */
    protected function getCampoCheckRadio()
    {
        $form = "</label><br/>";

        if (self::$type == "checkbox" && !empty(self::$options)):
            $cor = array("branco" => "default", "azul" => "primary",
                "verde" => "success", "vermelho" => "danger", "amarelo" => "warning");
            $verifcaChecked = $this->verificaChecked();
            $form .= '<div id="change-color-switch" class="make-switch" data-on-label="' .
                self::$options[0] . '" data-off-label="' . self::$options[1] . '" data-on="' .
                $cor[self::$options[2]] . '" data-off="' . $cor[self::$options[3]] . '">
                                            <input type="checkbox" ' . $verifcaChecked . ' 
                  id="' .self::$id . '" name="' . self::$id . '"  class="' . self::$classes . '" />
                </div>';
        else:
            foreach (self::$label_options as $key => $op):
                $valor = "";
                if (is_array(self::$valor) && !empty(self::$valor)):
                    if (!empty(self::$valor[self::$id])):
                        $valor = self::$valor[self::$id];
                    endif;
                else:
                    if (!empty(self::$valor)):
                        $valor = self::$valor;
                        self::$valor = "";
                    endif;
                endif;

                $verifcaInputs = $this->verificaInline();

                $form .= $verifcaInputs['inicio'];
                if ($valor == $key):
                    $verifcaChecked = " checked='checked'";
                else:
                    $verifcaChecked = "";
                endif;
                $form .= " <input id='" . self::$id . "'" . $verifcaChecked . " name='" .
                    self::$id . "' value='" . $key . "'  class='flat-black " . self::$classes .
                    "' type='" . self::$type . "' />"
                    . $op;
                $form .= $verifcaInputs['fim'];
            endforeach;
        endif;
        return $form;
    }

    /**
     * Criaos campos Checkbox ou Radio
     */
    protected function getCampoColor()
    {
        $valor = '';
        if (!empty(self::$valor[self::$id])):
            $valor = self::$valor[self::$id];
        endif;
        $form = '<div class="input-group">
                                        <span style="background: ' . $valor .
            '" class="input-group-addon color-back"></span>';
        $form .= '<input type="text" disabled="disabled" style="' .
            self::$style . '"' . self::$place . ' 
                class="form-control color ' . self::$classes . '" id="' . self::$id .
            '-input" name="' . self::$id . '-input" value="' . $valor . '"/>';
        $form .= '<span class="btn input-group-addon" data-toggle="dropdown">Cor</span>
											<ul class="dropdown-menu pull-right center">
												<li>
													<div class="color-palette"></div>
												</li>
											</ul>
											<input class="color" id="' . self::$id . '" name="' .
            self::$id . '" value="' . $valor . '" type="hidden" />
                                        </div>';
        return $form;
    }

    /**
     * Criaos campos Checkbox ou Radio
     */
    protected function getCampoText()
    {
        //CAMPO TIPO TEXT
        $valor = '';
        if (is_array(self::$valor) && !empty(self::$valor)):
            if (!empty(self::$valor[self::$id])):
                $valor = self::$valor[self::$id];
            endif;
        else:
            if (!empty(self::$valor)):
                $valor = self::$valor;
                self::$valor = "";
            endif;
        endif;
        $form = '<input type="' . self::$type . '" style="' . self::$style . '"' . self::$place .
            ' class="form-control ' . self::$classes . '" id="' . self::$id . '" name="' .
            self::$id . '" value="' . $valor . '"/>';
        return $form;
    }


    /**
     * <b>finalizaForm:</b> Fecha o formulário
     * @param bool $link
     * @param bool $btnVoltar
     * @param null $titulo
     * @return STRING com o fechamento do FORM.
     */
    public function finalizaForm($link = false, $btnVoltar = true, $titulo = null)
    {
        self::$form = '<div class="col-md-' . self::$tamanhoForm . '">							
                <div class="panel panel-box">
                        <div class="panel-body">
                 <h2 style="margin: 0 0 15px;"><small>' . $titulo . '</small></h2>
                            <form action="' . HOME . self::$action . '" role="form" 
                            id="' . self::$idForm . '" name="' . self::$idForm . '" method="post" 
                            enctype="multipart/form-data" class="formulario">                                                         
                            <div class="col-md-12">' .
            self::$form
            . '<div class="col-md-12" style="display: block; padding: 0;">
                        <button data-style="zoom-out" class="btn btn-success pull-right ladda-button" type="submit" 
                 value="' . self::$idForm . '" name="' . self::$idForm . '" style="margin-top: 8px; margin-left: 10px;">
                            <span class="ladda-label"> ' . self::$botao . ' </span>
                            <i class="fa fa-save"></i>
                            <span class="ladda-spinner"></span>
                        </button>
                        <button data-style="expand-right" class="btn btn-danger ladda-button pull-right" type="reset" style="margin-top: 8px;">
                            <span class="ladda-label"> Limpar </span>
                            <i class="fa fa-ban"></i>
                            <span class="ladda-spinner"></span>
                        </button>';
        if ($btnVoltar) {
            if (!$link) {
                $link = UrlAmigavel::$modulo;
                $link .= (UrlAmigavel::$modulo == ADMIN)
                    ? '/' . UrlAmigavel::$controller . '/Listar' . UrlAmigavel::$controller
                    : '';
            } else {
                $link = UrlAmigavel::$modulo . '/' . $link;
            }
            self::$form .= '<a href="' . HOME . $link . '"
                           class="btn pull-left btn-primary tooltips" data-original-title="Voltar" data-placement="top"
                           style="margin-top: 10px;">
                            Voltar <i class="clip-arrow-right-2"></i>
                         </a>';
        }

        self::$form .= '</div>
                    </div>
                </form>
             </div>
             </div>
        </div>';

        return self::$form;
    }

    /**
     * <b>finalizaForm:</b> Fecha o formulário
     * @return STRING com o fechamento do FORM.
     */
    public function finalizaFormPesquisaAvancada()
    {
        self::$form = '<form action="' . HOME . self::$action . '" role="form" id="' . self::$idForm . '" name="' .
            self::$idForm . '" method="post"  enctype="multipart/form-data" class="formulario">                                                         
                            <div class="col-md-12">' .
            self::$form
            . '</div>
                                <button data-style="zoom-out" class="btn btn-success ladda-button" type="submit" value="' .
            Form::$idForm . '" name="' . Form::$idForm . '">
                                    <span class="ladda-label"> Pesquisar </span>
                                    <i class="fa fa-save"></i>
                                    <span class="ladda-spinner"></span>
                                </button>
                                <button data-style="expand-right" class="btn btn-danger ladda-button" type="reset">
                                    <span class="ladda-label"> Limpar </span>
                                    <i class="fa fa-ban"></i>
                                    <span class="ladda-spinner"></span>
                                </button>
                        </form>';

        return self::$form;
    }

}

<?php

/**
 * Modal.class [ HELPER ]
 * Classe responável por gerar as Modais!
 *
 * @copyright (c) 2014, Leo Bessa
 */
class Modal
{

    public static function load()
    {
        echo '<div class="modal in modal-overflow fade load" id="carregando" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-info">
                    <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">&nbsp;</button>
                    <h4 class="modal-title"><b>CARREGANDO... AGUARDE.</b></h4>
                </div>
                <div class="modal-body">
                        <div class="progress progress-striped active progress-sm">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        <span class="sr-only"> 100% Complete (success)</span>
                                </div>
                        </div>
                </div>
            </div>';
        echo '<a data-toggle="modal" role="button" href="#carregando" id="load"></a>';
    }

    public static function deletaRegistro($id)
    {
        echo '<div class="modal fade in modal-overflow deleta_registro" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-bricky">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Exclusão de Registro</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente excluir esse Registro?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-msg-restricao="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function desativaProduto($id)
    {
        echo '<div class="modal fade in modal-overflow produto_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-bricky">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Desativar Produto</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Desativar esse Produto?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function ativaProduto($id)
    {
        echo '<div class="modal fade in modal-overflow produto_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-success">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Ativar Produto</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Ativar esse Produto?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }


    public static function DesativarProfissional($id)
    {
        echo '<div class="modal fade in modal-overflow profissional_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-bricky">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Desativar Profissional</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Desativar esse Profissional?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function AtivarProfissional($id)
    {
        echo '<div class="modal fade in modal-overflow profissional_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-success">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Ativar Profissional</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Ativar esse Profissional?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function desativaDestaque($id)
    {
        echo '<div class="modal fade in modal-overflow produto_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-bricky">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Desativar Destaque do Produto</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Desativar o Destaque desse Produto?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function ativaDestaque($id)
    {
        echo '<div class="modal fade in modal-overflow produto_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-success">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Ativar Destaque do Produto</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Ativar o Destaque desse Produto?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }


    public static function confirmacao($id)
    {
        echo '<div class="modal in modal-overflow fade confirmacao" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header">
                        <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p id="confirmacao_msg"><b></b></p>
                </div>
                <div class="modal-footer">
                        <button class="btn btn-success" data-dismiss="modal" id="">
                                OK
                        </button>
                </div>
        </div>';
        echo '<a data-toggle="modal" role="button" href="#' . $id . '" id="confirmacao"></a>';
    }

    public static function aviso($id)
    {
        echo '<div class="modal in modal-overflow fade aviso" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header" style="width: 100%;">
                        <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p id="confirmacao_msg"> 
                    <a class="btn btn-green" id="icone">
                        <i class="fa fa-arrow-circle-down"></i>
                    </a> 
                    <b></b></p>
                </div>
                <div class="modal-footer">
                          <button aria-hidden="true" data-dismiss="modal" class="btn btn-light-grey cancelar">
                                Fechar
                        </button>
                </div>
        </div>';
        echo '<a data-toggle="modal" role="button" href="#' . $id . '" id="aviso"></a>';
    }

    public static function ConfirmacaoEmail($Email)
    {
        echo '<div class="modal in modal-overflow fade emailConfirma" id="ConfirmacaoEmail" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn btn-success" style="width: 100%;">
                        <h4 class="modal-title">SUCESSO</h4>
                </div>
                <div class="modal-body">
                    <p id="confirmacao_msg"> 
                    <a class="btn btn-green" id="icone">
                        <i class="fa fa-check"></i>
                    </a> 
                    <b>';
        if ($Email == TRUE) {
            echo Mensagens::OK_ENVIO_EMAIL;
        } else {
            echo $Email;
        }
        echo '</b></p>
                </div>
                <div class="modal-footer">
                          <button aria-hidden="true" data-dismiss="modal" class="btn btn-light-grey cancelar">
                                Fechar
                        </button>
                </div>
        </div>';
        echo '<a data-toggle="modal" role="button" href="#ConfirmacaoEmail" id="emailConfirma"></a>';
    }

    public static function Foto()
    {
        echo '<div class="modal in modal-overflow fade foto" id="foto_cliente" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff;">
                                X
                        </button>
                        <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img src="" width="100%"/>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky" title="">
                                Fechar
                        </button>
                </div>
        </div>';
        echo '<a data-toggle="modal" role="button" href="#foto_cliente" id="fotos"></a>';
    }

    public static function DesativarInscricao($id)
    {
        echo '<div class="modal fade in modal-overflow inscricao_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-bricky">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Desativar Inscrição</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Desativar essa Inscrição?</b>
                        </br></br>
                        <div class="form-group">
                            <label for="ds_observacao" class="control-label"> 
                            Motivo da Desativação <span class="symbol required"></span>
                            </label>
                            <textarea id="ds_observacao" name="ds_observacao" style="resize: none;"
                             class="form-control ob"></textarea>
                         </div>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function AtivarInscricao($id)
    {
        echo '<div class="modal fade in modal-overflow inscricao_model" id="' . $id . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-success">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Ativar Inscrição</h4>
                </div>
                <div class="modal-body">
                        <b>Deseja Realmente Ativar essa Inscrição?</b>
                </div>
                <div class="modal-footer">
                        <button aria-hidden="true" data-dismiss="modal" class="btn btn-bricky cancelar">
                                Fechar
                        </button>
                        <button class="btn btn-success" data-dismiss="modal" id="" data-url-action="">
                                OK
                        </button>
                </div>
            </div>';
    }

    public static function Cadastro($action = null)
    {
        $action = ($action) ? $action : UrlAmigavel::$action;
        $app = new UrlAmigavel::$controller();
        if (method_exists($app, $action)):
            $app->$action();
        endif;
        extract((array)$app);
        $arquivo_include = UrlAmigavel::$modulo . "/View/" . UrlAmigavel::$controller . "/" . $action . '.View.php';
        echo '<div class="modal fade in modal-overflow j_cadastro" id="' .  $action . '" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-header btn-success">
                        <button type="button" class="close cancelar" data-dismiss="modal" aria-hidden="true">
                                X
                        </button>
                        <h4 class="modal-title">Título da modal</h4>
                </div>
                <div class="modal-body" style="padding: 10px 0 0;">
                        ';
        if (file_exists($arquivo_include) && !is_dir($arquivo_include)) {
            include $arquivo_include;
        } else {
            Notificacoes::mesagens("A View <b>" . UrlAmigavel::$modulo . "/View/" . UrlAmigavel::$controller . "/" .
                $action . ".View.php</b> não foi encontrada!",
                TiposMensagemEnum::ERRO);
        }
        echo '</div>
            </div>';
    }

}
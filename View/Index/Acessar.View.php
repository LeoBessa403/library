<?php
include_once 'library/Partial/AcessoPermitido/topo_inicial.php';
?>
    <!-- start: LOGIN BOX -->
    <div class="box-login box-shadow" style="padding: 10px 20px;">
        <h3>Entre com sua Conta</h3>
        <p>
            Por Favor! Entre com login e senha.
        </p>
        <form class="form-login" action="../Logar" method="post">
            <fieldset>
                <div class="form-group">
                    <?php
                    if (LOGAR_EMAIL):
                        ?>
                        <span class="input-icon">
								<input type="text" class="form-control email" name="<?= DS_EMAIL; ?>"
                                       id="<?= DS_EMAIL; ?>"
                                       placeholder="E-Mail">
								<i class="fa fa-envelope"></i> </span>
                    <?php
                    else:
                        ?>
                        <span class="input-icon">
								<input type="text" class="form-control cpf" name="<?= NU_CPF; ?>" id="<?= NU_CPF; ?>"
                                       placeholder="CPF">
								<i class="fa fa-user"></i> </span>
                    <?php
                    endif;
                    ?>
                </div>
                <div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control password" name="<?= DS_SENHA; ?>"
                                       id="<?= DS_SENHA; ?>" placeholder="Senha">
								<i class="fa fa-lock"></i> </span>
                </div>
                <div class="form-actions">
                    <input type="hidden" name="logar_sistema" id="logar_sistema" value="logar"/>
                    <label for="remember" class="checkbox-inline">
                        <input type="checkbox" class="grey remember" id="remember" name="remember">
                        Lembrar de Mim
                    </label>
                    <button type="submit" class="btn btn-success pull-right">
                        LOGAR <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
                <div class="new-account" style="text-align: center;">
                    <?php
                    include_once 'library/Partial/Site/versao.php';
                    if (!MODULO_ASSINANTE) {
                        ?>
                        Você não tem Conta?
                        <a href="<?= PASTAADMIN; ?>Index/Registrar" class="register">
                            Criar Conta
                        </a>
                    <?php } ?>
                    <a href="<?= PASTAADMIN . ACTION_INICIAL_ADMIN; ?>/RecuperarSenha" class="register"
                       style="float: right;">
                        Recuperar Senha
                    </a>
                </div>
            </fieldset>
        </form>
    </div>
<?php
include_once 'library/Partial/AcessoPermitido/rodape_inicial.php';
//?>
<?php
/** @var HistoricoComissaoEntidade $historico */
$historico = $historico;
/** @var UsuarioService $usuarioService */
$usuarioService = new UsuarioService();
/** @var UsuarioEntidade $usuario */
$usuario = $usuarioService->PesquisaUmRegistro($historico->getCoUsuario()->getCoUsuario());
?>
<div class="content">
    Data Válida: <b><?= Valida::DataShow(
            $historico->getDtValido(), 'd/m/Y H:i'
        ); ?></b></br>
    Considerar Taxas de antecipação: <b><?= Valida::SituacaoSimNao($historico->getStTaxaAntecipacao()); ?></b></br>
    Considerar Taxas da Administradora dos cartões:
    <b><?= Valida::SituacaoSimNao($historico->getStTaxaAdministrativa()); ?></b></br>
    Considerar Taxas cartão de crédito: <b><?= Valida::SituacaoSimNao($historico->getStTaxaCartaoCredito()); ?></b></br>
    Considerar Taxas cartão de débito: <b><?= Valida::SituacaoSimNao($historico->getStTaxaCartaoDebito()); ?></b></br>
    Recebe comissão antes: <b><?= Valida::SituacaoSimNao($historico->getStRecebimentoPreVenda()); ?></b></br>
    Forma de comissão: <b><?=
        FormaComissaoEnum::getDescricaoValor($historico->getNuFormaComissao()); ?></b></br>
    <?php
    /** @var PercentualComissaoEntidade $perc */
    foreach ($historico->getCoPercentualComissao() as $perc) {
        ?>
        Comissão quando for <?= TipoComissaoEnum::getDescricaoValor($perc->getNuTipoComissao()) ?>:
        <b><?= $perc->getNuComissao(); ?> %</b></br>
    <?php } ?>
    Cadastrado em: <b><?=
        Valida::DataShow(
            $historico->getDtCadastro(), 'd/m/Y H:i'
        )
        ?></b></br>
    Cadastrado por: <b><?= Valida::Resumi($usuario->getCoPessoa()->getNoPessoa(), 30); ?></b></br>
</div>
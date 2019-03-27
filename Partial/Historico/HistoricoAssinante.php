<?php
/** @var PlanoAssinanteAssinaturaEntidade $historico */
$historico = $historico;
/** @var PlanoService $planoService */
$planoService = new PlanoService();
/** @var PlanoEntidade $plano */
$plano = $planoService->PesquisaUmRegistro($historico->getCoPlanoAssinante()->getCoPlano());
?>
<div class="content">
    Nome do Plano: <b><?= $plano->getNoPlano(); ?></b></br>
    Meses Ativos: <b><?= $plano->getNuMesAtivo(); ?></b></br>
    Valor da Assinatura R$: <b><?=
        Valida::FormataMoeda($historico->getNuValorAssinatura()); ?></b></br>
    Núm. de Profissionais: <b><?= $historico->getNuProfissionais(); ?></b></br>
    Núm. de Filiais: <b><?= $historico->getNuFiliais(); ?></b></br>
    Expiração em: <b><?=
        Valida::DataShow(
            $historico->getDtExpiracao(), 'd/m/Y'
        )
        ?></b></br>
    Cadastrado em: <b><?=
        Valida::DataShow(
            $historico->getDtCadastro(), 'd/m/Y H:i'
        )
        ?></b></br>
</div>
<?php
$linhas = fopen('versao.txt', "a+");
$versoes = fgets($linhas);
$versao = explode('//', $versoes);
?>
<?= date("Y"); ?> &copy; <?= DESC; ?>. <b>Versão: <?= $versao[4]; ?></b>
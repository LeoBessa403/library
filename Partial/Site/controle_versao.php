<?php
$linhas = fopen('versao.txt', "a+");
$versoes = fgets($linhas);
$versao = explode('//', $versoes);
?>
<?= date("Y"); ?> &copy; Sistema Da Beleza Desenvolvimento. <b>Versão: <?= $versao[4]; ?></b>
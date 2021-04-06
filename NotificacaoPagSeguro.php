<?php
require_once 'library/Config.inc.php';

$PlanoAssinanteAssinaturaService = new PlanoAssinanteAssinaturaService();
print_r($PlanoAssinanteAssinaturaService->notificacaoPagSeguro($_POST['notificationCode']));



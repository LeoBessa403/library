<?php
/* 
 * Controller résponsavel para receber e passar dados para controller responsável.
 */
include "../../library/Config.inc.php";

if (isset($_REQUEST['acao'])) {

    switch ($_REQUEST['acao']) {

////////////////////////////////////////////////////////////////////////
/////////////////// PARTICULARIDADES DO SISTEMA ////////////////////////
//////////////////////////////////////////////////////////////////////// 
        case 'Ajax':
            $codigo = (!empty($_REQUEST['codigo'])) ? $_REQUEST['codigo'] : null;
            $controller = $_REQUEST['controller'];
            $controller = explode('/', $controller);
            $acao = $controller[1];
            $controller = $controller[0];
            $objeto = new $controller();
            if ($codigo) {
                $data = $objeto->$acao($codigo);
            } else {
                $data = $objeto->$acao();
            }
            echo json_encode($data);
            break;

    }
} // FIM SWITCH
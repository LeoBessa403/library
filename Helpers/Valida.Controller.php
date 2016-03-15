<?php
/* 
 * Controla as validações dos Formuláriso
 */
if(file_exists("../Config.inc.php")):
    include "../Config.inc.php";
else:
   include "Config.inc.php";
endif;
$valida   = new Valida();

if(isset($_GET['valida'])){    
    
	switch($_GET['valida']){
/*****************************
VALIDA O CPF
*****************************/
	case 'valcpf':
            $cpf = $_GET['cpf'];    
            echo $valida->ValCPF($cpf);            
        break;
/*****************************
VALIDA CNPJ
****************************/
        case 'valcnpj':   
            $cnpj = $_GET['cnpj'];    
            echo $valida->ValCNPJ($cnpj);
         break;
/*****************************
VALIDA O EMAIL
*****************************/	
        case 'valemail':  
            $email = $_GET['email'];    
            echo $valida->ValEmail($email);
        break;
/*****************************
Deleta Registros do Banco da Grid
*****************************/	
        case 'deleta_registro': 
            $id     = $_GET['id'];    
            $metodo = "Deleta".$_GET['registro'];
            $objeto = $_GET['registro']."Model";
            $obj    = new $objeto();        
            echo $obj->$metodo($id);
        break;
    
////////////////////////////////////////////////////////////////////////
/////////////////// PARTICULARIDADES DO SISTEMA ////////////////////////
//////////////////////////////////////////////////////////////////////// 
 
}}
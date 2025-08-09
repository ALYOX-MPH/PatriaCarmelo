<?php
$URL= $_SERVER["REQUEST_URI"];
$CleanURL = parse_url($URL, PHP_URL_PATH); // Elimina query strings
$Module= strtolower(trim($CleanURL, "/"));

// echo "DEBUG: URL = $URL | Module = $Module";

switch ($Module) {
    case 'home':
        require_once "./modules/Home/index.php";
        break;

    case 'agregarseguro':
        require_once "./modules/FormSeguros/formSeguros.php";
        break;

    case 'pagoscuotas':
        require_once "modules/PagosCuotas/pagosCuotas.php";
        break;

    case 'registros':
        require_once "./modules/Registros/registros.php";
        break;

    case 'tarifas':
        require_once "./modules/Tarifas/tarifas.php";
        break;

    case 'reportes':
        require_once "./modules/Reportes/reportes.php";
        break;

    case 'error':
        require_once "./modules/Error/error.php";
        break;

    case 'login':
        require_once "./modules/Login/login.php";
        break;

    case 'mostrarregistros':
        require_once "./modules/Registros/mostrarRegistros.php";
        break;
    
    case 'editarregistros':
        require_once "./modules/Registros/editarRegistros.php";
        break;    

    case 'mostrarpagos':
        require_once "./modules/PagosCuotas/mostrarPagos.php";
        break;

    case 'descargarpdf' :
        require_once "./modules/PagosCuotas/descargarPdf.php";
        break;  
     
    case 'imprimirrecibo' :
        require_once "./modules/PagosCuotas/imprimir_recibo.php";
        break;  
        
    case 'eliminarregistro' :
        require_once "./modules/Registros/eliminar_seguro.php";
        break;    


    default:
        require_once "./modules/home/index.php";
        break;
}

